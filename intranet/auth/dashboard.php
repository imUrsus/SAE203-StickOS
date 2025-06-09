<?php
session_start();
require_once 'config/Auth.php';
Auth::requireLogin();
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Intranet StickOS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: linear-gradient(#4FFDBE, #188FA7); }
    .navbar { background-color: white; }
    .navbar-brand { color: white !important; }
    .dropdown-menu { background-color: white; }
    .dropdown-item { color: black !important; }
    .badge-role { background-color: #4FFDBE; color: black; }
    .card-header { background-color: #e9ecef; }
  </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="www.StickOS.com">
      <img src="logo.png" alt="Logo" class="img-fluid" width="200" height="200">
    </a>
    <div class="ms-auto">
      <div class="dropdown">
        <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
          <?= htmlspecialchars($user['first_name']) ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><span class="dropdown-item disabled"><?= htmlspecialchars($user['first_name']) ?></span></li>
          <li><a class="dropdown-item" href="profil.php">Mon profil</a></li>
          <li><a class="dropdown-item text-danger" href="logout.php">Se déconnecter</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- Contenu -->
<div class="container py-4">
  <div class="card text-center mb-4">
    <div class="card-body">
      <h2>Bienvenue <?= htmlspecialchars($user['first_name']) ?></h2>
      <p>Rôle :
        <span class="badge badge-role">
          <?= $user['role'] === 'admin' ? 'Administrateur' : 'Utilisateur' ?>
        </span>
      </p>
      <small>Dernière connexion : <?= date('d/m/Y à H:i') ?></small>
    </div>
  </div>

  <!-- Modules -->
  <div class="row g-3">
    <?php if ($user['role'] === 'admin'): ?>
      <div class="col-md-4">
        <div class="card text-center">
          <div class="card-body">
            <h5>Gestion Utilisateurs</h5>
            <a href="admin.php" class="btn btn-danger btn-sm mt-2">Accéder</a>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Documents</h5>
          <a href="documents.php" class="btn btn-success btn-sm mt-2">Ouvrir</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Messages</h5>
          <a href="messages.php" class="btn btn-primary btn-sm mt-2">Lire</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Planning</h5>
          <a href="planning.php" class="btn btn-secondary btn-sm mt-2">Voir</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Infos utilisateur -->
  <div class="card mt-4">
    <div class="card-header"><strong>Mon compte</strong></div>
    <div class="card-body">
      <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($user['username']) ?></p>
      <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
      <p><strong>Groupes :</strong>
        <?php foreach ($user['groups'] as $group): ?>
          <span class="badge bg-secondary"><?= htmlspecialchars($group) ?></span>
        <?php endforeach; ?>
      </p>
      <p><strong>Statut :</strong> <span class="badge bg-success">Actif</span></p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
