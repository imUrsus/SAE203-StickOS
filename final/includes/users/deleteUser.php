<pre>
<?php
session_start();
/*
if (isset($_SESSION["role"])) {
    if (($_SESSION["role"] != "admin") || ($_SESSION["role"] != "manager")) {
        header("Location: accueil.php");
        die();
    }
}*/

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
        unset($existingContent[$i]);
<<<<<<< HEAD
        unset($_SESSION["action"]);
        
        $updatedJsonContent = json_encode(value: $existingContent, flags: JSON_PRETTY_PRINT);
<<<<<<< HEAD
        file_put_contents("./data/annuaireEntreprises.json", $updatedJsonContent);
        //print_r($updatedJsonContent);
        unset($_SESSION["action"]);
        header(header:"Location:".explode('?', $_GET['from'])[0]."?message=L'utilisateur a bien été supprimé");
=======
        file_put_contents($FILENAME, $updatedJsonContent);
        
        header(header:"Location:../../dirs/users.php?message=L'utilisateur a bien été supprimé");
>>>>>>> 5aa363e (Modification des fichiers de configuration des users)
=======
        unset($_SESSION["action"]);
        
        $updatedJsonContent = json_encode(value: $existingContent, flags: JSON_PRETTY_PRINT);
        file_put_contents($FILENAME, $updatedJsonContent);
        
        header(header:"Location:../../dirs/users.php?message=L'utilisateur a bien été supprimé");
>>>>>>> 3a4cef9 (Modification de la configuration des utilisateurs)
        break;
    };
};

?>
</pre>
