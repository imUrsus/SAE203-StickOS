<pre>
<?php
session_start();

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

foreach ($existingContent as $i => $userInfos) {
    // Vérifie chaque info et s'il y en a une différente, ce n'est pas le bon utilisateur et on ne le modifie pas
    $isUserFound = true;
    if ($userInfos["Id"] != $_SESSION["action"]["Id"]) {
        $isUserFound = false;
    }
    
    // Si l'utilisateur est trouvé, on le modifie
    if ($isUserFound) {
        unset($existingContent[$i]);
        $updatedJsonContent = json_encode(value: $existingContent, flags: JSON_PRETTY_PRINT);
        file_put_contents("./data/annuaireEntreprises.json", $updatedJsonContent);
        //print_r($updatedJsonContent);
        unset($_SESSION["action"]);
        header(header:"Location:".explode('?', $_GET['from'])[0]."?message=L'utilisateur a bien été supprimé");
        break;
    };
};

?>
</pre>
