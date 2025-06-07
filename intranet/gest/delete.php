<?php
session_start();
require_once 'includes/auth.php';

if (!is_logged_in() || !has_permission('delete')) {
    exit("Accès refusé.");
}

if (!isset($_GET['file'])) {
    exit("Fichier non spécifié.");
}
$relativePath = $_GET['file'];
// ⚠ Protection anti traversal
if (str_contains($relativePath, '..')) {
    exit("Chemin interdit.");
}
$path = 'uploads/' . $relativePath;
if (!file_exists($path)) {
    exit("Fichier introuvable.");
}
if (!unlink($path)) {
    exit("Échec de la suppression.");
}
header('Location: files.php');
exit;
