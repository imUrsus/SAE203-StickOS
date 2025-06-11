
<pre>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION["action"] = $_POST;

if (isset($_POST["delete"])) {
    header(header:"Location:deleteUser.php?from=".explode('?', $_SERVER['HTTP_REFERER'])[0]);
}

if (isset($_POST["modify"])) {
    header(header:"Location:modifyUser.php?from=".explode('?', $_SERVER['HTTP_REFERER'])[0]);
}
?>
</pre>
