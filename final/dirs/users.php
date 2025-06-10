<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "../../scripts/fonctions.php";
    parametres(title: "test");
    ?>
</head>
<body>
    <?php

    $data = json_decode(file_get_contents("./data/annuaireEntreprises.json"), true);
    ?>



    <?php
    //if (($_SESSION["role"] == "admin") || ($_SESSION["role"] == "manager")) {
    if (isset($_GET["message"])) {
        echo "<p>".$_GET["message"]."</p>";
    }
    ?>
    <form action="register.php" method="GET">
        <button class="btn btn-success" type="submit" name="add">Ajouter un utilisateur</button>
    </form>
    <?php
    //}
    ?>

    <div class="container-fluid d-flex justify-content-center">
        <div class="container-fluid mx-2">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Poste</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach (array_reverse($data) as $i => $entreprise) {
                        ?>
                        <tr>

<<<<<<< HEAD
                        <form action="action.php" method="POST">
=======
                        <form action="../includes/users/action.php" method="POST">
                            <input name="id" type="text" value="<?php echo $entreprise["id"] ?>" hidden></input>

                            <td><?php echo $entreprise["username"] ?></td>
                            <input name="username" type="text" value="<?php echo $entreprise["username"] ?>" hidden></input>

                            <td><?php echo $entreprise["email"] ?></td>
                            <input name="email" type="text" value="<?php echo $entreprise["email"] ?>" hidden></input>

                            <td><?php echo $entreprise["first_name"] ?></td>
                            <input name="first_name" type="text" value="<?php echo $entreprise["first_name"] ?>" hidden></input>

                            <td><?php echo $entreprise["last_name"] ?></td>
                            <input name="last_name" type="text" value="<?php echo $entreprise["last_name"] ?>" hidden></input>

                            <td><?php echo $entreprise["role"] ?></td>
                            <input name="role" type="text" value="<?php echo $entreprise["role"] ?>" hidden></input>
>>>>>>> 5aa363e (Modification des fichiers de configuration des users)

                            <td>
                                <button class="btn btn-warning" type="submit" name="modify">Modifier</button>
                            </td>
                            <td>
                                <button class="btn btn-danger" type="submit" name="delete">Supprimer</button>
                            </td>
                        <?php
                        /*if (($_SESSION["role"] == "admin") || ($_SESSION["role"] == "manager")) {
                            ?>
                            <td>
                                <a class="" href="modifUser.php">Modifier</a>
                                <button class="btn btn-danger" type="button" name="delete" onclick="updateUser('delete', '<?php echo $userInfos['utilisateur'] ?>')">Supprimer</button>
                            </td>
                            <td>

                            </td>
                            <?php
                        }*/
                        ?>

                        </form>

                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
