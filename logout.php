<?php
if (@$_GET['action'] == 'logout') {
    session_destroy();
    header('Location: login.php');
}
?>