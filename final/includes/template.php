<?php

function settings($title) {
    session_start();
    $GLOBALS["title"] = $title;
    $user['first_name'] = 'lolo'
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title><?php echo("$title - StickOS"); ?></title>
        <link rel="icon" type="image/ico" href="../assets/img/favicon.ico"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    </head>

<?php
}
function head() {
    $user = $_SESSION ?? [];

    $role = $user['Role'] ?? 'perso'; // Valeur par défaut
    $firstName = htmlspecialchars($user['Firstname'] ?? 'Utilisateur');

    // Liste des éléments de navigation par rôle
    $navigation = [
        'admin' => [
            'Gestion des utilisateurs' => 'includes/users/action.php',
            'Gestion des groupes' => 'group_management.php',
            'Annuaire des clients' => 'dirs/clients.php',
            'Annuaire des fournisseurs' => 'dirs/providers.php',
            'Modification des utilisateurs' => 'includes/users/modifyUsers.php',
            'Suppression des utilisateurs' => 'includes/users/deleteUser.php',
            'Wiki' => 'wiki.php',
            'Export des données' => 'data_export.php',
            'Support' => 'support.php',
        ],
        'managers' => [
            'Annuaire des clients' => 'dirs/clients.php',
            'Annuaire des fournisseurs' => 'dirs/providers.php',
            'Projets' => 'projets.php',
            'Messages' => 'messages.php',
            'Planning' => 'planning.php',
            'Documents' => 'documents.php',
            'Support' => 'support.php',
        ],
        'direction' => [
            'Annuaire des clients' => 'dirs/clients.php',
            'Annuaire des fournisseurs' => 'dirs/providers.php',
            'Messages' => 'messages.php',
            'Planning' => 'planning.php',
            'Documents' => 'documents.php',
            'Support' => 'support.php',
        ],
        'salariés' => [
            'Documents' => 'documents.php',
            'Messages' => 'messages.php',
            'Planning' => 'planning.php',
            'Support' => 'support.php',
        ],
        'perso' => [
            'Messages' => 'messages.php',
            'Planning' => 'planning.php',
            'Support' => 'support.php',
        ],
    ];

    $menuItems = $navigation[$role] ?? $navigation['perso'];
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
                <?php foreach ($menuItems as $label => $link): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= htmlspecialchars($link) ?>"><?= htmlspecialchars($label) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="dropdown ms-auto">
                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                    <?= $firstName ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item disabled"><?= $firstName ?></span></li>
                    <li><a class="dropdown-item" href="profile.php">Mon profil</a></li>
                    <li><a class="dropdown-item text-danger" href="logout.php">Se déconnecter</a></li>
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