<?php
    session_start();
    if(!isset($_SESSION['authenticated']))
    {
        $_SESSION['status'] = 'Please login to access!';
        header("location: ../../login.php");
        exit(0);
    }
?>