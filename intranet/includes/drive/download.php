<?php
// $filename contient le nom du fichier selectionné --
// $path contient uploads/ + le contenur de $filename
session_start();

// Autorisations locales basées sur le rôle
$role = strtolower($_SESSION['role'] ?? '');
$can_view = in_array($role, ['admin', 'manager', 'direction', 'salarie']);

if (!$can_view) {
    exit("Accès refusé.");
}

if (!isset($_GET['file'])) {
    exit("Fichier non spécifié.");
}

$filename = $_GET['file'];

// Protection anti path traversal
if (str_contains($filename, '..')) {
    exit("Chemin interdit.");
}

$path = __DIR__ . '/uploads/' . $filename;

if (!file_exists($path)) {
    exit("Fichier introuvable.");
}

// Forcer le téléchargement
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
readfile($path);
exit;
