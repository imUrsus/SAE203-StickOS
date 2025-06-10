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
    footer { background-color: white; }
    .custom-btn {
      background-color:#1da5c0;
      color: white;
      border-color: #1da5c0;
    }
  </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">
      <img src="logo.png" alt="Logo" class="img-fluid" width="150" height="150">
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

  <!-- Modules pour tous les utilisateurs -->
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Documents</h5>
          <a href="documents.php" class="btn custom-btn btn-sm mt-2">Ouvrir</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Messages</h5>
          <a href="messages.php" class="btn custom-btn btn-sm mt-2">Lire</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Planning</h5>
          <a href="planning.php" class="btn custom-btn btn-sm mt-2">Voir</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Projets</h5>
          <a href="projets.php" class="btn custom-btn btn-sm mt-2">Gérer</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Support</h5>
          <a href="support.php" class="btn custom-btn btn-sm mt-2">Contacter</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card text-center">
        <div class="card-body">
          <h5>Paramètres</h5>
          <a href="settings.php" class="btn custom-btn btn-sm mt-2">Configurer</a>
        </div>
      </div>
    </div>
  </div>

  <?php if ($user['role'] === 'admin'): ?>
    <div class="row g-3 mt-2">
      <div class="col-md-4">
        <div class="card text-center h-100">
          <div class="card-body">
            <h5>Gestion des utilisateurs</h5>
            <a href="user_management.php" class="btn custom-btn btn-sm mt-2">Accéder</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <div class="card-body">
            <h5>Gestion des groupes</h5>
            <a href="group_management.php" class="btn custom-btn btn-sm mt-2">Gérer</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <div class="card-body">
            <h5>Gestionnaire de fichiers</h5>
            <a href="file_manager.php" class="btn custom-btn btn-sm mt-2">Ouvrir</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <div class="card-body">
            <h5>Annuaire de l'entreprise</h5>
            <a href="company_directory.php" class="btn custom-btn btn-sm mt-2">Consulter</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <div class="card-body">
            <h5>Annuaire des fournisseurs</h5>
            <a href="suppliers_directory.php" class="btn custom-btn btn-sm mt-2">Voir</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <div class="card-body">
            <h5>Annuaire des clients</h5>
            <a href="clients_directory.php" class="btn custom-btn btn-sm mt-2">Accéder</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <div class="card-body">
            <h5>Page Wiki</h5>
            <a href="wiki.php" class="btn custom-btn btn-sm mt-2">Éditer</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <div class="card-body">
            <h5>Visualisation des logs</h5>
            <a href="logs.php" class="btn custom-btn btn-sm mt-2">Voir</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <div class="card-body">
            <h5>Configuration système</h5>
            <a href="system_config.php" class="btn custom-btn btn-sm mt-2">Configurer</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card text-center h-100">
          <div class="card-body">
            <h5>Export des données</h5>
            <a href="data_export.php" class="btn custom-btn btn-sm mt-2">Exporter</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<!-- Footer avec les informations du compte -->
<footer class="mt-4">
  <div class="container">
    <div class="card">
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
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
