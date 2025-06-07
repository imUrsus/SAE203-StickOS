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

require_once 'includes/auth.php';

if (!is_logged_in() || !has_permission('upload')) {
    exit("Accès refusé.");
}

if (!isset($_FILES['file'])) {
    exit("Aucun fichier reçu.");
}

if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    exit("Erreur PHP : " . $_FILES['file']['error']);
}

// Variables de base
$base_dir = "uploads/";
$filename = basename($_FILES['file']['name']);
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
$allowed = ['csv', 'txt'];

if (!in_array($ext, $allowed)) {
    exit("Type de fichier non autorisé. Extensions valides : .csv, .txt");
}

// 🔄 Correction : lire le choix depuis POST, pas SESSION
$target = $_POST['upload_target'] ?? null;

if (!$target) {
    exit("Destination d’envoi invalide.");
}

// Déterminer le dossier de destination
switch ($target) {
    case 'public':
        $upload_dir = $base_dir . "public/";
        break;

    case 'private':
        if (!isset($_SESSION['nom'], $_SESSION['prenom'])) {
            exit("Informations utilisateur incomplètes.");
        }
        $nomPrenom = $_SESSION['nom'] . '-' . $_SESSION['prenom'];
        $upload_dir = $base_dir . "private/" . $nomPrenom . "/";
        break;

    case 'depts':
        if (!isset($_SESSION['role'])) {
            exit("Rôle utilisateur manquant.");
        }
        $role = strtolower($_SESSION['role']);
        $dept_map = [
            'rh' => 'hr',
            'it' => 'it',
            'management' => 'management'
        ];
        if (!isset($dept_map[$role])) {
            exit("Département inconnu.");
        }
        $upload_dir = $base_dir . "depts/" . $dept_map[$role] . "/";
        break;

    default:
        exit("Destination d’envoi invalide.");
}

// Créer le dossier si besoin
if (!is_dir($upload_dir)) {
    if (!mkdir($upload_dir, 0777, true)) {
        exit("Impossible de créer le dossier : $upload_dir");
    }
}

// Déplacement du fichier
$destination = $upload_dir . $filename;
if (!move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
    exit("Échec du déplacement du fichier.");
}

header('Location: files.php');
exit;
?>