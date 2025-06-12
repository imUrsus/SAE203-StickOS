<?php
include_once "../includes/template.php";
settings(title:"Annuaire d'entreprise");
session_start();
head();
    $data = json_decode(file_get_contents("../data/users.json"), true);
    ?>

    <div class="container-fluid d-flex justify-content-center">
        <div class="container-fluid mx-2 my-4">
            <h1>Annuaire de l'entreprise</h1>
            <?php
            if (($_SESSION["role"] == "admin") || ($_SESSION["role"] == "manager")) {
                if (isset($_GET["message"])) {
                    echo "<p class='fs-4'>".$_GET["message"]."</p>";
                }
                ?>
                <form action="../includes/users/register.php" method="GET">
                    <button class="btn btn-success fs-3" type="submit" name="add">Ajouter un utilisateur</button>
                </form>
            <?php
            }
            ?>
            <table class="table table-striped table-hover mt-3">
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
                        <?php
                        if (($_SESSION["role"] == "admin") || ($_SESSION["role"] == "manager")) {
                        ?>
                            <td>
                                <button class="btn btn-warning" type="submit" name="modify">Modifier</button>
                            </td>
                            <td>
                                <button class="btn btn-danger" type="submit" name="delete">Supprimer</button>
                            </td>
                        <?php
                        }
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
    <?php foot(); ?>
</body>
</html>
