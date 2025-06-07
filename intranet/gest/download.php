<?php
// $filename contient le nom du fichier selectionné --
// $path contient uploads/ + le contenur de $filename

session_start();
require_once 'includes/auth.php';

if (!is_logged_in() || !has_permission('view')) {
    exit("Accès refusé.");
}
if (!isset($_GET['file'])) {
    exit("Fichier non spécifié.");
}
$filename = $_GET['file'];
$path = 'uploads/' . $filename;

if (!file_exists($path)) {
    exit("Fichier introuvable.");
}
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
readfile($path);
exit;
?>