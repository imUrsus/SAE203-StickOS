<?php
session_start();

if (!isset($_SESSION["id"])) {
    echo "<p>Erreur : utilisateur non connecté.</p>";
    exit();
}
$jsonFile = 'data/users.json';
$utilisateurs = [];
if (file_exists($jsonFile) && filesize($jsonFile) > 0) {
    $jsonData = file_get_contents($jsonFile);
    $utilisateurs = json_decode($jsonData, true);
}
$userIndex = array_search($_SESSION["id"], array_column($utilisateurs, "id"));
if ($userIndex === false) {
    echo "<p>Utilisateur non trouvé.</p>";
    exit();
}
$user = $utilisateurs[$userIndex];
if (isset($_POST['update'])) {
    $user["last_name"] = htmlspecialchars($_POST["last_name"]);
    $user["first_name"] = htmlspecialchars($_POST["first_name"]);
    $user["label"] = htmlspecialchars($_POST["label"]);
    $user["bio"] = htmlspecialchars($_POST["bio"]);
    if (!empty($_FILES["photo"]["name"])) {
        $uploadDir = 'img/';
        $ext = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
        $photoName = uniqid() . '.' . $ext;
        $photoPath = $uploadDir . $photoName;
        $maxSize = 2 * 1024 * 1024;
        $allowed = ['jpg', 'jpeg', 'png'];
        if ($_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
            if ($_FILES["Photo"]["size"] > $maxSize) {
                exitWithAlert("Fichier trop volumineux (max 2Mo)");
            }
            if (!in_array($ext, $allowed)) {
                exitWithAlert("Format d'image non supporté (JPG, JPEG, PNG)");
            }
            if (!getimagesize($_FILES["photo"]["tmp_name"])) {
                exitWithAlert("Fichier invalide : ce n'est pas une image.");
            }
            // Supprime l'ancienne image
            if (!empty($user["photo"]) && file_exists('img/' . $user["photo"])) {
                unlink('img/' . $user["photo"]);
            }
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath)) {
                $user["photo"] = basename($photoPath);
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
                        <img src="img/<?= htmlspecialchars($user["photo"] ?? 'default.jpg') ?>" alt="Profil" class="img-thumbnail rounded-circle" style="width: 150px;">
                    </div>
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Nom :</strong> <?= htmlspecialchars($user["last_name"]) ?></li>
                        <li class="list-group-item"><strong>Prénom :</strong> <?= htmlspecialchars($user["first_name"]) ?></li>
                        <li class="list-group-item"><strong>Label :</strong> <?= htmlspecialchars($user["label"]) ?></li>
                        <li class="list-group-item"><strong>Bio :</strong><br><?= nl2br(htmlspecialchars($user["bio"])) ?></li>
                        <li class="list-group-item"><strong>Rôle :</strong> <?= displayRoleBadge($user["role"] ?? 'perso') ?></li>
                    </ul>
                    <h5 class="mb-3">Modifier mon profil</h5>
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Nom</label>
                            <input type="text" name="last_name" id="Lastname" class="form-control" value="<?= htmlspecialchars($user["last_name"]) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Prénom</label>
                            <input type="text" name="first_name" id="Firstname" class="form-control" value="<?= htmlspecialchars($user["first_name"]) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="label" class="form-label">Label</label>
                            <input type="text" name="label" id="Label" class="form-control" value="<?= htmlspecialchars($user["label"]) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="bio" class="form-label">Biographie</label>
                            <textarea name="bio" id="Bio" class="form-control" rows="4"><?= htmlspecialchars($user["bio"]) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" name="photo" id="Photo" class="form-control" accept=".jpg,.jpeg,.png">
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
