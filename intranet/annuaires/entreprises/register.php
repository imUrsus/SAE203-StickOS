<pre>
<?php
session_start();

print_r($_SESSION);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    /*
    if (isset($_SESSION["role"])) {
        if ($_SESSION["role"] != "admin") {
            header("Location: accueil.php");
            die();
        }
    } else {
        header("Location: accueil.php");
        die();
    }
    */


    $existingContent = json_decode(json: file_get_contents(filename: "./data/annuaireEntreprises.json"), associative:true);
    // Get the highest ID
    $max_id = 1;
    foreach ($existingContent as $i => $userInfos) {
        if ($userInfos["Id"] > $max_id) {
            $max_id = intval($userInfos["Id"]);
        }
    }

    $data = [
        "Id"        => $max_id + 1,
        "Lastname"  => $_POST["newLastname"],
        "Firstname" => $_POST["newFirstname"],
        "Label"     => $_POST["newLabel"],
        "Photo"     => $_POST["newPhoto"],
        "Bio"       => $_POST["newBio"],
    ];
    // on ajoute le nouveau user à la liste de tous les users et on renvoie le résultat
    $existingContent[] = $data;
    
    $updatedJsonContent = json_encode(value: $existingContent, flags: JSON_PRETTY_PRINT);
    
    file_put_contents("./data/annuaireEntreprises.json", $updatedJsonContent);
    header(header:"Location:showEntreprises.php?message=L'utilisateur a bien été ajouteé");
}
?>
</pre>


<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "../../scripts/fonctions.php";
    parametres(title: "test");
    ?>
</head>
<body>
    <main>

        <div class="container-fluid d-flex justify-content-center">
            <div id="connexionFeedbackContainer" class="container w-75 p-1">
                <p id="connexionFeedback" class="text-danger d-none mb-0  mx-5">Veuillez réessayer!</p> 
            </div>
        </div>
        <section class="p-2">
            <div class="container">
                <div class="card border-light-subtle shadow-sm">
                <div class="row g-0">
                    <div class="col-12 col-md-6 text-bg-primary">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="col-10 col-xl-8 py-3">
                        <img class="img-fluid rounded mb-4" loading="lazy" src="" width="245" height="80" alt="Cocovoit Logo">

                        <hr class="border-primary-subtle mb-4">
                        <h2 class="h1 mb-4">We make digital products that drive you to stand out.</h2>
                        <p class="lead m-0">We write words, take photos, make videos, and interact with artificial intelligence.</p>
                        </div>
                    </div>
                    </div>

                    <div class="col-12 col-md-6">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-5">
                                <h3>Inscription</h3>
                                </div>
                            </div>
                        </div>
                        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                            <input type="text" class="form-control" name="Id" id="Id" hidden>
                            <div class="row gy-3 gy-md-4 overflow-hidden">
                                <div class="col-12">
                                    <label for="newLastname" class="form-label">Nom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="newLastname" id="newLastname" placeholder="Doe" required>
                                </div>
                                <div class="col-12">
                                    <label for="newFirstname" class="form-label">Prénom <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="newFirstname" id="newFirstname" placeholder="John" required>
                                </div>
                                <div class="col-12">
                                    <label for="newLabel" class="form-label">Label <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="newLabel" id="newLabel" placeholder="Comptable" required>
                                </div>
                                <div class="col-12">
                                    <label for="newPhoto" class="form-label">Photo <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="newPhoto" id="newPhoto">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="newBio" class="form-label">Bio <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="newBio" id="newBio" placeholder="Zoé" required>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn bsb-btn-xl btn-primary" type="submit">Inscrire</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                        <div class="col-12">
                            <hr class="mt-5 mb-4 border-secondary-subtle">
                            <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end">
                                <a href="connexion.php" class="link-secondary text-decoration-none">Déjà un compte ?</a>
                                <!-- <a href="#!" class="link-secondary text-decoration-none">Forgot password</a> -->
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <!-- SCRIPT JS COMME CONNEXION.PHP POUR INFORMER SI USER EXISTE DEJA -->
    </main>

    <footer>
        <?php
        pieddepage();
        ?>
    </footer>

    <script src="scripts/script.js">
        getConnexionFeedback();
    </script>
</body>
</html>
