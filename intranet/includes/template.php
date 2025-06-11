<?php
function settings($title) {
    $GLOBALS["title"] = $title;
}

function head() {
    $user = $_SESSION ?? [];

    $role = $_SESSION['Role'] ?? 'perso';
    $firstName = htmlspecialchars($user['Firstname'] ?? 'Utilisateur');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?= $GLOBALS["title"] ?> - StickOS</title>
    <link rel="icon" type="image/ico" href="../assets/img/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="../dashboard.php">
            <img src="../assets/logo_site.png" alt="Logo" width="100" height="100">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($role === 'admin'): ?>
                    <!-- Dropdown Utilisateurs -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">Utilisateurs</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../includes/users/action.php">Gestion des utilisateurs</a></li>
                            <li><a class="dropdown-item" href="../includes/users/modifyUser.php">Modifier un utilisateur</a></li>
                            <li><a class="dropdown-item" href="../includes/users/deleteUser.php">Supprimer un utilisateur</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dirDropdown" role="button" data-bs-toggle="dropdown">Annuaire</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../dirs/clients.php">Clients</a></li>
                            <li><a class="dropdown-item" href="../dirs/providers.php">Fournisseurs</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="wiki.php">Wiki</a></li>

                <?php elseif ($role === 'managers'): ?>
                    <li class="nav-item"><a class="nav-link" href="../dirs/clients.php">Clients</a></li>
                    <li class="nav-item"><a class="nav-link" href="../dirs/providers.php">Fournisseurs</a></li>

                <?php elseif ($role === 'direction'): ?>
                    <li class="nav-item"><a class="nav-link" href="../dirs/clients.php">Clients</a></li>
                    <li class="nav-item"><a class="nav-link" href="../dirs/providers.php">Fournisseurs</a></li>


                <?php elseif ($role === 'salariés'): ?>

                <?php else: ?>
                    <!-- perso -->
                <?php endif; ?>
            </ul>
            <div class="dropdown ms-auto">
                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                    <?= $firstName ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item disabled"><?= $firstName ?></span></li>
                    <li><a class="dropdown-item" href="../profile.php">Mon profil</a></li>
                    <li><a class="dropdown-item text-danger" href="../auth/logout.php">Se déconnecter</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<?php
}

function foot() {
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}
?>
