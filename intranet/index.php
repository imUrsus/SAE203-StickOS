<?php

session_start();
if (isset($_SESSION['user'])) {
    header("Location: wiki.php");
    exit();
}

else {
    header("Location:auth/login.php");
    exit();
}

?>
