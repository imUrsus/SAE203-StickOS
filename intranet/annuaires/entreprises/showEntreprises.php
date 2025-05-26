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
            foreach ($data as $i => $entreprise) {
                ?>
                <tr>
                <?php
                foreach ($entreprise as $key => $value) {
                    ?>
                    <td><?php echo $value ?></td>
                    <?php
                }
                ?>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>
