<?php
require_once 'function.php';
$id = $_GET['id'] ?? null;
if ($id !== null) {
    deleteClient($id);
}
header('Location: index1.php');
exit;
