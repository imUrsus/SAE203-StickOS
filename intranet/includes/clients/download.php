<?php
require_once './functions.php';
$id = $_GET['id'] ?? null;
if (!$id || !($client = getClientById($id))) {
    header('Location: ../../dirs/client.php');
    exit;
}
$filename = 'fiche_client_' . $client['id'] . '.txt';
// Contenu du fichier
$contenu = "FICHE CLIENT\n";
$contenu .= "====================\n";
$contenu .= "ID         : " . $client['id'] . "\n";
$contenu .= "Nom        : " . $client['nom'] . "\n";
$contenu .= "Prénom     : " . $client['prenom'] . "\n";
$contenu .= "Email      : " . $client['email'] . "\n";
$contenu .= "Téléphone  : " . $client['tel'] . "\n";
$contenu .= "Adresse    : " . $client['adresse'] . "\n";
$contenu .= "====================\n";
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($contenu));
echo $contenu;
exit;