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
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Fonction</th>
                        <th>Photo</th>
                        <th>Biographie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach (array_reverse($data) as $i => $entreprise) {
                        ?>
                        <tr>

                        <form action="action.php" method="POST">

                        <?php
                        foreach ($entreprise as $key => $value) {
                            if ($key != "Id") {
                            ?>
                            <td><?php echo $value ?></td>
                            <?php
                            }
                            ?>
                            <input name="<?php echo $key ?>" type="text" value="<?php echo $value ?>" hidden></input>
                            <?php
                        }   
                        ?>
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
