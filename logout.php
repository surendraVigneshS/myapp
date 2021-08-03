<?php 
    session_start();
    session_destroy();
    // Remove cookie variables
    unset($_SESSION['emp_id']);

    header('location:./login.php');

?>