<?php
    require_once 'utils.php';
    session_destroy();
    $_SESSION['loggedout'] == true;
    header('location:index.php')
    

?>
