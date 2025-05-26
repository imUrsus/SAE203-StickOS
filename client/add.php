<?php
require_once 'function.php';
$errors = [];
$success = false;
// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation simple
    if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['email'])) {
        $errors[] = "Nom, prénom et email sont obligatoires.";
    } else {
        $data = [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'email' => $_POST['email'],
            'tel' => $_POST['tel'] ?? '',
            'adresse' => $_POST['adresse'] ?? '',
            'mot_de_passe' => $_POST['mot_de_passe'] ?? ''
        ];
        addClient($data);
        header("Location: index1.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1>Ajouter un client</h1>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nom *</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Prénom *</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Téléphone</label>
            <input type="text" name="tel" class="form-control">
        </div>
        <div class="col-12">
            <label class="form-label">Adresse</label>
            <textarea name="adresse" class="form-control" rows="2"></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">Mot de passe (obligatoire)</label>
            <input type="password" name="mot_de_passe" class="form-control">
        </div>

        <div class="col-12 text-end">
            <a href="index.php" class="btn btn-secondary">← Retour</a>
            <button type="submit" class="btn btn-success">Ajouter</button>
        </div>
    </form>
</div>
</body>
</html>
