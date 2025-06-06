<?php
require_once 'functions.php';
$action = $_GET['action'] ?? 'add';
$id = $_GET['id'] ?? null;
$errors = [];
if ($action === 'delete' && $id !== null) {
    deleteClient($id);
    header('Location: index_client.php');
    exit;
}
if ($action === 'edit' && (!$id || !($client = getClientById($id)))) {
    header('Location: index_client.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['email'])) {
        $errors[] = "Nom, prénom et email sont obligatoires.";
    } else {
        $data = [
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'email' => $_POST['email'],
            'tel' => $_POST['tel'] ?? '',
            'adresse' => $_POST['adresse'] ?? ''
        ];
        if ($action === 'edit') {
            if (!empty($_POST['mot_de_passe'])) {
                $data['mot_de_passe'] = $_POST['mot_de_passe'];
            }
            updateClient($id, $data);
        } else {
            if (empty($_POST['mot_de_passe'])) {
                $errors[] = "Le mot de passe est obligatoire pour l'ajout.";
            } else {
                $data['mot_de_passe'] = $_POST['mot_de_passe'];
                addClient($data);
            }
        }
        if (empty($errors)) {
            header("Location: index_client.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $action === 'edit' ? 'Modifier' : 'Ajouter' ?> un client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1><?= $action === 'edit' ? 'Modifier' : 'Ajouter' ?> un client</h1>
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
            <input type="text" name="nom" class="form-control" value="<?= isset($client['nom']) ? htmlspecialchars($client['nom']) : '' ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Prénom *</label>
            <input type="text" name="prenom" class="form-control" value="<?= isset($client['prenom']) ? htmlspecialchars($client['prenom']) : '' ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control" value="<?= isset($client['email']) ? htmlspecialchars($client['email']) : '' ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Téléphone</label>
            <input type="text" name="tel" class="form-control" value="<?= isset($client['tel']) ? htmlspecialchars($client['tel']) : '' ?>">
        </div>
        <div class="col-12">
            <label class="form-label">Adresse</label>
            <textarea name="adresse" class="form-control" rows="2"><?= isset($client['adresse']) ? htmlspecialchars($client['adresse']) : '' ?></textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label"><?= $action === 'edit' ? 'Nouveau mot de passe (laisser vide pour ne pas changer)' : 'Mot de passe (obligatoire)' ?></label>
            <input type="password" name="mot_de_passe" class="form-control">
        </div>
        <div class="col-12 text-end">
            <a href="index_client.php" class="btn btn-secondary">← <?= $action === 'edit' ? 'Annuler' : 'Retour' ?></a>
            <button type="submit" class="btn btn-primary"><?= $action === 'edit' ? 'Enregistrer les modifications' : 'Ajouter' ?></button>
        </div>
    </form>
</div>
</body>
</html>
