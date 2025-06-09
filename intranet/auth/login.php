<?php
session_start();
require_once 'config/Auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (Auth::login($username, $password)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Identifiants incorrects';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Connexion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(#4FFDBE, #188FA7);
        }
    </style>
</head>
<body>

    <!-- NAVBAR avec logo -->
    <nav class="navbar bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="logo.png" alt="Logo" class="img-fluid" width="200" height="200">
                </div>
            </div>
        </div>
    </nav>

    <div class="container d-flex vh-100">
        <div class="row justify-content-center align-self-center w-100">
            <div class="col-md-4 text-center">
                <h2 class="text-white mb-4">Connexion</h2>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="post">
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
