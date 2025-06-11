<?php
session_start();

// autorisations locales à ce fichier
$role = strtolower($_SESSION['role'] ?? '');
$can_delete = in_array($role, ['admin', 'manager']);

if (!$can_delete) {
    exit("Accès refusé.");
}

if (!isset($_GET['file'])) {
    exit("Fichier non spécifié.");
}

$relativePath = $_GET['file'];
if (str_contains($relativePath, '..')) {
    exit("Chemin interdit.");
}

$path = __DIR__ . '/uploads/' . $relativePath;

if (!file_exists($path)) {
    exit("Fichier introuvable.");
}

if (!unlink($path)) {
    exit("Échec de la suppression.");
}

header('Location: ../../drive.php');
exit;
