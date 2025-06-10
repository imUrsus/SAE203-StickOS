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
?>
    <body>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="../dashboard.php">
                <img src="../assets/logo_site.png" alt="Logo" class="img-fluid" width="100" height="100">
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

<?php
}

function foot() {
?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    </body>
</html>
<?php
}

?>