<pre>
<?php
session_start();

//print_r($_SESSION);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    /*
    if (isset($_SESSION["action"]["role"])) {
        if ($_SESSION["action"]["role"] != "admin") {
            header("Location: accueil.php");
            die();
        }
    } else {
        header("Location: accueil.php");
        die();
    }
    */


    $FILENAME = "../../data/users.json";
    $existingContent = json_decode(file_get_contents($FILENAME), true);

    foreach ($existingContent as $i => $userInfos) {
        // Vérifie chaque info et s'il y en a une différente, ce n'est pas le bon utilisateur et on ne le modifie pas
        $isUserFound = true;
        if ($userInfos["id"] != $_SESSION["action"]["id"]) {
                $isUserFound = false;
        }
        
        // Si l'utilisateur est trouvé, on le modifie
        if ($isUserFound) {
            $data = [
                "id"        => $_SESSION["action"]["id"],
                "username"  => strlen($_POST["newUsername"]) > 1 ? $_POST["newUsername"] : $_SESSION["action"]["username"],
                "password"  => strlen($_POST["newPassword"]) > 1 ? $_POST["newPassword"] : $_SESSION["action"]["email"],
                "email" => strlen($_POST["newEmail"]) > 1 ? $_POST["newEmail"] : $_SESSION["action"]["email"],
                "first_name" => strlen($_POST["newFirstname"]) > 1 ? $_POST["newFirstname"] : $_SESSION["action"]["first_name"],
                "last_name"     => strlen($_POST["newLastname"]) > 1 ? $_POST["newLastname"] : $_SESSION["action"]["last_name"],
                "role"       => strlen($_POST["newRole"]) > 1 ? $_POST["newRole"] : $_SESSION["action"]["role"],
                "photo"       => strlen($_POST["newPhoto"]) > 1 ? $_POST["newPhoto"] : $_SESSION["action"]["photo"],
                "bio"       => strlen($_POST["newBio"]) > 1 ? $_POST["newBio"] : $_SESSION["action"]["bio"],
            ];

            unset($existingContent[$i]);
            
            if ($data != null) {
                // on ajoute le nouveau user à la liste de tous les users et on renvoie le résultat
                $existingContent[] = $data;
                
                $updatedJsonContent = json_encode(value: $existingContent, flags: JSON_PRETTY_PRINT);
                
                file_put_contents(filename: $FILENAME, data: $updatedJsonContent);
                unset($_SESSION["action"]);
                header(header:"Location:../../dirs/users.php?message=L'utilisateur a bien été modifié");
            }
            break;
        };
    };
}
?>
</pre>




<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "../fonctions.php";
    parametres(title: "test");
    ?>
</head>
<body>
    <main>

        <div class="container-fluid d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card-body p-3 p-md-4 p-xl-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-5">
                                <h3>Modifier un utilisateur</h3>
                            </div>
                        </div>
                    </div>
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                        <input type="text" class="form-control" name="Id" id="Id" hidden>
                        <div class="row gy-3 gy-md-4 overflow-hidden">
                            <div class="col-12">
                                <label for="newUsername" class="form-label">Nom d'utilisateur <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newUsername" id="newUsername" value="<?php echo $_SESSION["action"]["username"] ?>"  placeholder="johnDoe35" required>
                            </div>
                            <div class="col-12">
                                <label for="newPassword" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="newPassword" id="newPassword" value="<?php echo $_SESSION["action"]["password"] ?>"  required>
                            </div>
                            <div class="col-12">
                                <label for="newEmail" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="newEmail" id="newEmail" value="<?php echo $_SESSION["action"]["email"] ?>" placeholder="exemple@exemple.com" required>
                            </div>
                            <div class="col-12">
                                <label for="newLastname" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newLastname" id="newLastname" value="<?php echo $_SESSION["action"]["last_name"] ?>"  placeholder="Doe" required>
                            </div>
                            <div class="col-12">
                                <label for="newFirstname" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newFirstname" id="newFirstname" value="<?php echo $_SESSION["action"]["first_name"] ?>"  placeholder="John" required>
                            </div>
                            <div class="col-12">
                                <label for="newRole" class="form-label">Role <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newRole" id="newRole" value="<?php echo $_SESSION["action"]["role"] ?>"  placeholder="direction">
                            </div>
                            <div class="col-12">
                                <label for="newRole" class="form-label">Photo <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="newPhoto" id="newPhoto">
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="newBio" class="form-label">Bio <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newBio" id="newBio" placeholder="Ceci est une biographie" value="<?php echo $_SESSION["action"]["bio"] ?>">
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn bsb-btn-xl btn-primary" type="submit">Modifier</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php
        pieddepage();
        ?>
    </footer>
</body>
</html>

