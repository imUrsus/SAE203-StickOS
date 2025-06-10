<?php
session_start();

// Vérifier que l'utilisateur est connecté (que $_SESSION["Id"] existe)
if (!isset($_SESSION["Id"])) {
    echo "<p>Erreur : utilisateur non connecté.</p>";
    exit();
}

$jsonFile = 'data/users.json';
$utilisateurs = [];

// Charger les utilisateurs depuis le fichier JSON
if (file_exists($jsonFile) && filesize($jsonFile) > 0) {
    $jsonData = file_get_contents($jsonFile);
    $utilisateurs = json_decode($jsonData, true);
}

$userIndex = -1;

// Chercher l'utilisateur dans le tableau
foreach ($utilisateurs as $index => $user) {
    if (isset($user["Id"]) && $user["Id"] == $_SESSION["Id"]) {  // Utiliser == pour comparer int/string
        $userIndex = $index;
        break;
    }
}

if ($userIndex === -1) {
    echo "<p>Utilisateur non trouvé.</p>";
    fc_footer();
    exit();
}

$user = $utilisateurs[$userIndex];

if (isset($_POST['update'])) {
    // Mise à jour des champs
    $user["Lastname"] = htmlspecialchars($_POST["Lastname"]);
    $user["Firstname"] = htmlspecialchars($_POST["Firstname"]);
    $user["Label"] = htmlspecialchars($_POST["Label"]);
    $user["Bio"] = htmlspecialchars($_POST["Bio"]);
    
    // Gestion de l'upload de Photo
    if (!empty($_FILES["Photo"]["name"])) {
        $uploadDir = 'img/';
        $imageFileType = strtolower(pathinfo($_FILES["Photo"]["name"], PATHINFO_EXTENSION));
        $photoName = uniqid() . "." . $imageFileType;
        $photoPath = $uploadDir . $photoName;

        $maxFileSize = 2 * 1024 * 1024;
        $allowedExtensions = ["jpg", "jpeg", "png"];

        if ($_FILES["Photo"]["error"] === UPLOAD_ERR_OK) {
            if ($_FILES["Photo"]["size"] > $maxFileSize) {
                echo "<script>alert('Fichier trop volumineux (max: 2Mo)'); window.location.href = 'profile.php';</script>";
                exit();
            } elseif (!in_array($imageFileType, $allowedExtensions)) {
                echo "<script>alert('Format d\'image incorrect (JPG, JPEG, PNG uniquement)'); window.location.href = 'profile.php';</script>";
                exit();
            } elseif (!getimagesize($_FILES["Photo"]["tmp_name"])) {
                echo "<script>alert('Le fichier n\'est pas une image valide.'); window.location.href = 'profile.php';</script>";
                exit();
            } else {
                // Supprimer l'ancienne image si elle existe
                if (!empty($user["Photo"]) && file_exists('img/' . $user["Photo"])) {
                    unlink('img/' . $user["Photo"]);
                }

                if (move_uploaded_file($_FILES["Photo"]["tmp_name"], $photoPath)) {
                    $user["Photo"] = basename($photoPath);
                } else {
                    echo "<script>alert('Erreur lors du téléchargement de l\'image.'); window.location.href = 'profile.php';</script>";
                    exit();
                }
            }
        } else {
            echo "<script>alert('Erreur lors du téléchargement de l\'image (taille max: 2Mo)'); window.location.href = 'profile.php';</script>";
            exit();
        }
    }

    // Sauvegarde dans le fichier JSON
    $utilisateurs[$userIndex] = $user;
    file_put_contents($jsonFile, json_encode($utilisateurs, JSON_PRETTY_PRINT));

    header("Location: profile.php?success=1");
    exit();
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Éditer le profil</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Informations du profil</h5>
                        <div class="row">
                            <?php if (!empty($user["Photo"])): ?>
                                <div class="col-4 text-center mb-3">
                                    <img src="img/<?php echo htmlspecialchars($user["Photo"]); ?>" alt="Photo de profil" class="img-fluid rounded-circle" style="max-width: 150px;">
                                </div>
                            <?php endif; ?>
                            <div class="col-8">
                                <p><strong>Id :</strong> <?php echo htmlspecialchars($user["Id"]); ?></p>
                                <p><strong>Nom :</strong> <?php echo htmlspecialchars($user["Lastname"]); ?></p>
                                <p><strong>Prénom :</strong> <?php echo htmlspecialchars($user["Firstname"]); ?></p>
                                <p><strong>Label :</strong> <?php echo htmlspecialchars($user["Label"]); ?></p>
                                <p><strong>Bio :</strong> <?php echo nl2br(htmlspecialchars($user["Bio"])); ?></p>
                            </div>
                        </div>
                    </div>
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="Lastname" class="form-label">Nom</label>
                            <input type="text" name="Lastname" id="Lastname" class="form-control" value="<?php echo htmlspecialchars($user["Lastname"]); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Firstname" class="form-label">Prénom</label>
                            <input type="text" name="Firstname" id="Firstname" class="form-control" value="<?php echo htmlspecialchars($user["Firstname"]); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Label" class="form-label">Label</label>
                            <input type="text" name="Label" id="Label" class="form-control" value="<?php echo htmlspecialchars($user["Label"]); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Bio" class="form-label">Biographie</label>
                            <textarea name="Bio" id="Bio" class="form-control" rows="5"><?php echo htmlspecialchars($user["Bio"]); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="Photo" class="form-label">Photo de profil</label>
                            <input type="file" id="Photo" name="Photo" class="form-control" accept="image/png, image/jpeg">
                        </div>
                        <button type="submit" name="update" class="btn btn-primary w-100">Mettre à jour</button>
                    </form>
                    <?php if (isset($_GET["success"])): ?>
                        <p class='text-success mt-3'>Profil mis à jour avec succès !</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
fc_footer();
?>
