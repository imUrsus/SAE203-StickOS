<?php
session_start();
if (!isset($_SESSION["Id"])) {
    echo "<p>Erreur : utilisateur non connecté.</p>";
    exit();
}
$jsonFile = 'data/users.json';
$utilisateurs = [];
if (file_exists($jsonFile) && filesize($jsonFile) > 0) {
    $jsonData = file_get_contents($jsonFile);
    $utilisateurs = json_decode($jsonData, true);
}
$userIndex = array_search($_SESSION["Id"], array_column($utilisateurs, "Id"));
if ($userIndex === false) {
    echo "<p>Utilisateur non trouvé.</p>";
    exit();
}
$user = $utilisateurs[$userIndex];
if (isset($_POST['update'])) {
    $user["Lastname"] = htmlspecialchars($_POST["Lastname"]);
    $user["Firstname"] = htmlspecialchars($_POST["Firstname"]);
    $user["Label"] = htmlspecialchars($_POST["Label"]);
    $user["Bio"] = htmlspecialchars($_POST["Bio"]);
    if (!empty($_FILES["Photo"]["name"])) {
        $uploadDir = 'img/';
        $ext = strtolower(pathinfo($_FILES["Photo"]["name"], PATHINFO_EXTENSION));
        $photoName = uniqid() . '.' . $ext;
        $photoPath = $uploadDir . $photoName;
        $maxSize = 2 * 1024 * 1024;
        $allowed = ['jpg', 'jpeg', 'png'];
        if ($_FILES["Photo"]["error"] === UPLOAD_ERR_OK) {
            if ($_FILES["Photo"]["size"] > $maxSize) {
                exitWithAlert("Fichier trop volumineux (max 2Mo)");
            }
            if (!in_array($ext, $allowed)) {
                exitWithAlert("Format d'image non supporté (JPG, JPEG, PNG)");
            }
            if (!getimagesize($_FILES["Photo"]["tmp_name"])) {
                exitWithAlert("Fichier invalide : ce n'est pas une image.");
            }
            // Supprime l'ancienne image
            if (!empty($user["Photo"]) && file_exists('img/' . $user["Photo"])) {
                unlink('img/' . $user["Photo"]);
            }
            if (move_uploaded_file($_FILES["Photo"]["tmp_name"], $photoPath)) {
                $user["Photo"] = basename($photoPath);
            } else {
                exitWithAlert("Erreur lors de l'upload de l'image.");
            }
        } else {
            exitWithAlert("Erreur lors de l'envoi de l'image.");
        }
    }
    $utilisateurs[$userIndex] = $user;
    file_put_contents($jsonFile, json_encode($utilisateurs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    header("Location: profile.php?success=1");
    exit();
}
function exitWithAlert($message) {
    echo "<script>alert('$message'); window.location.href = 'profile.php';</script>";
    exit();
}
function displayRoleBadge($role) {
    $colors = [
        'admin' => 'danger',
        'managers' => 'warning',
        'salaries' => 'success',
        'direction' => 'info',
        'perso' => 'secondary'
    ];
    $color = $colors[$role] ?? 'dark';
    return "<span class='badge bg-$color text-uppercase'>{$role}</span>";
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Mon profil</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="img/<?= htmlspecialchars($user["Photo"] ?? 'default.jpg') ?>" alt="Profil" class="img-thumbnail rounded-circle" style="width: 150px;">
                    </div>
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Nom :</strong> <?= htmlspecialchars($user["Lastname"]) ?></li>
                        <li class="list-group-item"><strong>Prénom :</strong> <?= htmlspecialchars($user["Firstname"]) ?></li>
                        <li class="list-group-item"><strong>Label :</strong> <?= htmlspecialchars($user["Label"]) ?></li>
                        <li class="list-group-item"><strong>Bio :</strong><br><?= nl2br(htmlspecialchars($user["Bio"])) ?></li>
                        <li class="list-group-item"><strong>Rôle :</strong> <?= displayRoleBadge($user["Role"] ?? 'perso') ?></li>
                    </ul>
                    <h5 class="mb-3">Modifier mon profil</h5>
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="Lastname" class="form-label">Nom</label>
                            <input type="text" name="Lastname" id="Lastname" class="form-control" value="<?= htmlspecialchars($user["Lastname"]) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Firstname" class="form-label">Prénom</label>
                            <input type="text" name="Firstname" id="Firstname" class="form-control" value="<?= htmlspecialchars($user["Firstname"]) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="Label" class="form-label">Label</label>
                            <input type="text" name="Label" id="Label" class="form-control" value="<?= htmlspecialchars($user["Label"]) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="Bio" class="form-label">Biographie</label>
                            <textarea name="Bio" id="Bio" class="form-control" rows="4"><?= htmlspecialchars($user["Bio"]) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="Photo" class="form-label">Photo</label>
                            <input type="file" name="Photo" id="Photo" class="form-control" accept=".jpg,.jpeg,.png">
                        </div>
                        <button type="submit" name="update" class="btn btn-success w-100">Mettre à jour</button>
                    </form>
                    <?php if (isset($_GET["success"])): ?>
                        <div class="alert alert-success mt-3">Profil mis à jour avec succès !</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
