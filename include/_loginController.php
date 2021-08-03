<?php

include('./dbconfig.php');
include('./function.php');

session_start();

if(isset($_POST['admin_login'])){
    $email_ID = mysqli_real_escape_string($dbconnection, $_POST['username']);
    $password = mysqli_real_escape_string($dbconnection, $_POST['login_password']);
    $accesslevel = mysqli_real_escape_string($dbconnection, $_POST['login_userRole']);  
      
    if(checkUser('admin_login', $email_ID, $accesslevel , $dbconnection)){ 
        $encrypt_password = passwordEncryption($password); 
        $userselect = "SELECT * FROM `admin_login` WHERE `emp_email` = '$email_ID' AND `emp_password` = '$encrypt_password' AND   `emp_role` = '$accesslevel'";
        $userquery = mysqli_query($dbconnection, $userselect);
        if(mysqli_num_rows($userquery) > 0){
            if($row = mysqli_fetch_array($userquery)){
                $emp_status = $row['emp_status'];
                if ($emp_status ==  1){
                    $_SESSION["accountsauthenticated"] = true;
                    $_SESSION['emp_id'] = $row['emp_id'];
                    $_SESSION['emp_name'] = $row['emp_name'];
                    $_SESSION['emp_role'] = $row['emp_role'];
                    $_SESSION['emp_org'] = $row['emp_org'];
                    $_SESSION['emp_dep_type'] = $row['emp_dep_type'];
                    header("location:../home-dashboard.php");
                    exit();
                }else{ 
                    $_SESSION["errorMessage"] = "Your Access has been revoked by Admin !!!!";
                    header("location:../login.php");
                    exit();
                }
            }
        }else{
            $_SESSION["errorMessage"] = "Password Does not Match !!!!";
            header("location:../login.php");
            exit();
        }
    }else{
        $_SESSION["errorMessage"] = "User Not Found !!!!";
        header("location:../login.php");
        exit();
    }   
}



?>