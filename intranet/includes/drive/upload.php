<?php
//$filename	Nom du fichier original (sans chemin)
//$ext	Extension du fichier en minuscules
//$allowed	Extensions autorisées (csv, txt)
//$target	Destination sélectionnée par l'utilisateur (public, private, depts)
//$upload_dir	Répertoire final où le fichier doit être stocké
//$destination	Chemin complet vers le fichier final
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../clients/functions.php');

$role = strtolower($_SESSION['role'] ?? '');
$lastname = $_SESSION['Lastname'] ?? '';
$firstname = $_SESSION['Firstname'] ?? '';

if (!in_array($role, ['admin', 'manager', 'direction', 'salarie'])) {
    exit("Rôle non autorisé.");
}

if (!isset($_FILES['file'])) {
    exit("Aucun fichier reçu.");
}

if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    exit("Erreur PHP : " . $_FILES['file']['error']);
}

$base_dir = __DIR__ . "/uploads/";
$allowed = ['csv', 'txt'];

$original_name = basename($_FILES['file']['name']);
$ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
    exit("Type de fichier non autorisé. Extensions valides : .csv, .txt");
}

$filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($original_name, PATHINFO_FILENAME));
$filename = substr($filename, 0, 100) . '_' . date('Ymd_His') . '.' . $ext;

// Déterminer le dossier en fonction du rôle
switch ($role) {
    case 'admin':
    case 'manager':
        $upload_dir = $base_dir . "public/";
        break;
    case 'direction':
        $upload_dir = $base_dir . "depts/management/";
        break;
    case 'salarie':
        if (empty($lastname) || empty($firstname)) {
            exit("Nom/prénom manquant.");
        }
        $upload_dir = $base_dir . "private/" . strtolower($lastname . '-' . $firstname) . "/";
        break;
    default:
        exit("Rôle non reconnu.");
}

// Crée le dossier si nécessaire
if (!is_dir($upload_dir) && !mkdir($upload_dir, 0777, true)) {
    exit("Impossible de créer le dossier : $upload_dir");
}

// Déplacement final
$destination = $upload_dir . $filename;
if (!move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
    exit("Échec du déplacement du fichier.");
}

header('Location: /drive.php');
exit;
?>
