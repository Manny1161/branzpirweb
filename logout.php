<?php
    require_once 'utils.php';
    if(isset($_POST['csrf_token'] == $_SESSION['csrf_token']))
    {
        session_destroy();
        echo 0;
    }
    else
    {
        echo 1;
    }
    

?>