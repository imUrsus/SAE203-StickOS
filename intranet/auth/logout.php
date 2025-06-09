<?php
require_once 'Auth.php';

Auth::logout();
header('Location: login.php');
exit();
?>
