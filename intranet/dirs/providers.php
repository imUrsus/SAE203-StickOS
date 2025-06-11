<!DOCTYPE html>
<html lang="fr">

<?php 
require_once '../includes/template.php';
settings("Partner");
head();
session_start();
?>

<body>

        <tbody>
            <?php
            $jsonFile = '../data/providers.json';
            $jsonData = file_get_contents($jsonFile);
            $utilisateurs = json_decode($jsonData, true);
            $_SESSION["role"]="admin";
            if ($_SESSION["role"]=="admin" | $_SESSION["role"]=="managers") {
                ?><table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Logo</th>
                        <th>Actions</th>
                    </tr>
                </thead> 
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $index = $_POST['index'];
                    $nom = $_POST['Nom'];
                    $description = $_POST['Description'];
    
                    if ($index >= 0 && $index < count($utilisateurs)) {
                        $utilisateurs[$index]['Nom'] = $nom;
                        $utilisateurs[$index]['Description'] = $description;
    
                        if (isset($_FILES['Logo']) && $_FILES['Logo']['error'] === UPLOAD_ERR_OK) {
                            $uploadDir = '../assets/Providers/';
                            $uploadFile = $uploadDir . basename($_FILES['Logo']['name']);
    
                            if (move_uploaded_file($_FILES['Logo']['tmp_name'], $uploadFile)) {
                                $utilisateurs[$index]['Logo'] = $uploadFile;
                            }
                        }
    
                        file_put_contents($jsonFile, json_encode($utilisateurs, JSON_PRETTY_PRINT));
                    }
                }
    
                $jsonData = file_get_contents($jsonFile);
                $utilisateurs = json_decode($jsonData, true);
    
                foreach ($utilisateurs as $index => $user): ?>
                    <tr>
                        <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <td><input type="text" name="Nom" value="<?php echo htmlspecialchars($user['Nom']); ?>" class="form-control"></td>
                            <td><input type="text" name="Description" value="<?php echo htmlspecialchars($user['Description']); ?>" class="form-control"></td>
                            <td class="text-center">
                                <img src="<?php echo htmlspecialchars($user['Logo']); ?>" alt="Logo" class="img-fluid rounded-circle mx-auto d-block" style="width: 100px; height: 100px;">
                                <input type="file" name="Logo" class="form-control-file">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
            }
            else{ ?>
                <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Logo</th>
            </tr>
        </thead>
    <tbody>
        <?php foreach ($utilisateurs as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['Nom']); ?></td>
                <td><?php echo htmlspecialchars($user['Description']); ?></td>
                <td class="text-center col-4">
                    <img src="<?php echo htmlspecialchars($user['Logo']); ?>" alt="Logo" class="img-fluid rounded-circle mx-auto d-block w-25">
                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

            <?php }
            
            foot()?>

</body>
</html>
