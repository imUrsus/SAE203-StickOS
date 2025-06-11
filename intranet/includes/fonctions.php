<?php
session_start();

function parametres($title): void {
    // ICONS : https://icon-icons.com/pack/MingCute-Contact---Solid/4238
    echo "<title>$title</title>";
    ?>

    <meta charset='UTF-8'>
    <meta name='author' content='width=device-width, initial-scale=1.0'>
    <meta name='description' content='width=device-width, initial-scale=1.0'>
    <meta name='keywords' content='width=device-width, initial-scale=1.0'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
    <link rel='stylesheet' href='styles/styles.css'>
    <link rel='shortcut icon' href='images/favicon.ico' type='image/x-icon'>
    
    <script src='scripts/script.js'></script>

    <?php
}

function entete(): void {
    ?>

    <div class="container-fluid bg-light py-3">
        <div class="w-75 m-auto d-flex flex-row align-items-center">
            <div class="w-75 d-flex flex-row">
                <!-- LOGO -->
                <div class="container col-2">
                    <a href="index.php">
                        <img class="img-fluid" src="images/favicon-x128.png" style="width: 60px" alt="Logo du site">
                    </a>
                </div>
                <!-- TITRE -->
                <div class="container col-10">
                    <h1 class="h1">cocovoit</h1>
                </div>
            </div>


            <!-- PSEUDO ou LIEN -->
            <div class="w-25 d-flex flex-row justify-content-end">
                <div class="">
                    <?php
                    if (isset($_SESSION["utilisateur"])) {
                    ?>
                        <span class="fs-5"><?php echo $_SESSION["utilisateur"] ?></span>
                        <a class="ms-2 fs-5" href="deconnexion.php">Se déconnecter</a>
                    <?php                        
                    } else {
                    ?>
                        <a class="fs-5" href="connexion.php">Se connecter</a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
}

function navigation($page, $title=""): void {
    $navPages = ["accueil", "administration", "profil", "proposer", "visualiser", "rechercher", "modifier", "wiki"];
    ?>

    <div class="container-fluid w-75">
        <nav class="navbar navbar-expand-md bg-body-tertiary">
            <div class="container-fluid">
                <!-- TITRE -->
                <a class="navbar-brand" href="<?php echo $page ?>.php"><?php echo ucfirst(string: $page) ?></a>

                <!-- LOGO -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">X</span>
                </button>

                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <?php
                        /*
                         * Affichage dynamique de la page
                         * Prend en compte : la vérification pour l'affichage de la page d'administration
                         * Prend en compte : l'affichage des autres pages que celle active (qui est mis en évidence juste un peu plus en haut)
                        */
                        for ($i = 0; $i < count(value: $navPages); $i++) {
                            switch ($navPages[$i]) {
                                case $page:
                                    break;

                                case "administration":
                                    // SHOW ONLY IF USER IS ADMIN
                                    if (isset($_SESSION["role"])) {
                                        switch ($_SESSION["role"]) {
                                            case "admin":
                                                echo "<li class='nav-item'>";
                                                echo "<a class='nav-link' aria-current='page' href='". $navPages[$i] .".php'>". ucfirst(string: $navPages[$i]) ."</a>";
                                                echo "</li>";
                                                break;
                                        }
                                    };
                                    break;

                                default:
                                    echo "<li class='nav-item'>";
                                    echo "<a class='nav-link' aria-current='page' href='". $navPages[$i] .".php'>". ucfirst(string: $navPages[$i]) ."</a>";
                                    echo "</li>";
                                    break;
                            }
                        }
                        ?>
                    </ul>
                </div>

                <!-- A définir : la fonction de traitement des données -->
                <form class="d-flex" role="search" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                    <input class="form-control me-2" type="search" placeholder="Search" name="searchBar" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </div>

    <?php
}

function pieddepage(): void {
    ?>

    <div class="container-fluid bg-light py-3">
        <div class="w-75 m-auto d-flex flex-row align-items-center">
            <div class="w-100 d-flex flex-row">
                <!-- AUTHOR DESCRIPTION -->
                <div class="container col-5">
                    <p>Nicolas DEROUET</p>
                    <p>nicolas.derouet@etudiant.univ-rennes.fr</p>
                    <p>FI1A-G3</p>
                </div>

                <!-- NOTE VERY USEFUL INFOS -->
                <div class="container col-5">
                    <p><?php echo date(format: "d/m/Y h:i:s") ?></p>
                    <p>&copy; <?php echo date(format: "Y") ?></p>
                    <p>Le site WEB est hébergé : <?php echo $_SERVER['REMOTE_ADDR']; echo ":"; echo $_SERVER['SERVER_PORT'] ?></p>
                </div>

                <!-- SOCIAL MEDIAS LINKS -->
                <div class="container col-2">
                    <ul>
                        <li><a href="https://github.com/SKamRa">GitHub</a></li>
                        <li><a href="https://signal.me/#eu/idhFICOKr182OnjQJEqT1FMhHAazbWHIP_IK1mcxU39veYHsgvVNmrZFyIIcvl5o">Signal</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php
}
