<pre>
<?php
session_start();

if (!isset($_SESSION["action"])) {
    header(header:"Location:".$_SERVER["HTTP_REFERER"]);
}

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
        unset($_SESSION["action"]);
        
        $updatedJsonContent = json_encode(value: $existingContent, flags: JSON_PRETTY_PRINT);
        file_put_contents($FILENAME, $updatedJsonContent);
        
        header(header:"Location:../../dirs/users.php?message=L'utilisateur a bien été supprimé");
        break;
    };
};

?>
</pre>
