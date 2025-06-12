<?php
function settings($title) {
    session_start();
    $GLOBALS["title"] = $title;
}

function head() {
    $user = $_SESSION ?? [];
    $role = $_SESSION['role'] ?? 'perso';
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
        <a class="navbar-brand" href="../wiki.html">
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
                            <li><a class="dropdown-item" href="../../../intranet/dirs/users.php">Gestion des utilisateurs</a></li>
                            <li><a class="dropdown-item" href="../../../intranet/includes/users/modifyUser.php">Modifier un utilisateur</a></li>
                            <li><a class="dropdown-item" href="../../../intranet/includes/users/deleteUser.php">Supprimer un utilisateur</a></li>
                            <li class="nav-item"><a class="nav-link" href="../../../intranet/profile.php">Mon profil</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dirDropdown" role="button" data-bs-toggle="dropdown">Annuaire</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../../../intranet/dirs/clients.php">Clients</a></li>
                            <li><a class="dropdown-item" href="../../../intranet/dirs/providers.php">Fournisseurs</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="../../../intranet/wiki.html">Wiki</a></li>

                <?php elseif ($role === 'manager'): ?>
                    <li class="nav-item"><a class="nav-link" href="../../../intranet/dirs/clients.php">Clients</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../../intranet/dirs/providers.php">Fournisseurs</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../../intranet/profile.php">Mon profil</a></li>

                <?php elseif ($role === 'direction'): ?>
                    <li class="nav-item"><a class="nav-link" href="../../../intranet/dirs/clients.php">Clients</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../../intranet/dirs/providers.php">Fournisseurs</a></li>
                    <li class="nav-item"><a class="nav-link" href="../../../intranet/profile.php">Mon profil</a></li>

                <?php else: ?>
                    <!-- perso -->
                <?php endif; ?>
		    <li class="nav-item"><a class="nav-link" href="../../../intranet/drive.php">Drive</a></li>
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
