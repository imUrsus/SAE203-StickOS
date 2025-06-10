<pre>
<?php
session_start();

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


    $FILENAME = "../../data/users.json";
    $existingContent = json_decode(file_get_contents($FILENAME), true);
    // Get the highest ID
    $max_id = 1;
    foreach ($existingContent as $i => $userInfos) {
        if ($userInfos["id"] > $max_id) {
            $max_id = intval($userInfos["id"]);
        }
    }

    /*
        "id": 1,
        "username": "admin",
        "password": "$2y$10$4BKjxUV.ulJ4Nxu9j0D6bejzUtd2oafX5o7yTh.aUK3ySj129fteO",
        "email": "admin@example.com",
        "first_name": "Admin",
        "last_name": "User",
        "role": "admin"
    */

    $data = [
        "id"        => $max_id + 1,
        "username"  => $_POST["newUsername"],
        "password"  => $_POST["newPassword"],
        "email" => $_POST["newEmail"],
        "first_name" => $_POST["newFirstname"],
        "last_name"     => $_POST["newLastname"],
        "role"       => $_POST["newRole"],
        "photo"       => $_POST["newPhoto"],
        "bio"       => $_POST["newBio"],
    ];
    // on ajoute le nouveau user à la liste de tous les users et on renvoie le résultat
    $existingContent[] = $data;
    
    $updatedJsonContent = json_encode(value: $existingContent, flags: JSON_PRETTY_PRINT);
        
    file_put_contents($FILENAME, $updatedJsonContent);
    header(header:"Location:../../dirs/users.php?message=L'utilisateur a bien été ajouté");
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
                                <h3>Créer un utilisateur</h3>
                            </div>
                        </div>
                    </div>
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                        <input type="text" class="form-control" name="Id" id="Id" hidden>
                        <div class="row gy-3 gy-md-4 overflow-hidden">
                            <div class="col-12">
                                <label for="newUsername" class="form-label">Nom d'utilisateur <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newUsername" id="newUsername" placeholder="johnDoe35" required>
                            </div>
                            <div class="col-12">
                                <label for="newPassword" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="newPassword" id="newPassword" required>
                            </div>
                            <div class="col-12">
                                <label for="newEmail" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="newEmail" id="newEmail" placeholder="exemple@exemple.com" required>
                            </div>
                            <div class="col-12">
                                <label for="newLastname" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newLastname" id="newLastname" placeholder="Doe" required>
                            </div>
                            <div class="col-12">
                                <label for="newFirstname" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newFirstname" id="newFirstname" placeholder="John" required>
                            </div>
                            <div class="col-12">
                                <label for="newRole" class="form-label">Role <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newRole" id="newRole" placeholder="direction" required>
                            </div>
                            <div class="col-12">
                                <label for="newRole" class="form-label">Photo <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" name="newPhoto" id="newPhoto">
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="newBio" class="form-label">Bio <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newBio" id="newBio" placeholder="Ceci est une biographie" required>
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn bsb-btn-xl btn-primary" type="submit">Créer</button>
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
