<?php
	session_start(); 
	if(!empty($_SESSION["accountsauthenticated"])){
    	$logged_admin_name = $_SESSION['emp_name'];
    	$logged_admin_id = $_SESSION['emp_id'];  
    	$logged_admin_role = $_SESSION['emp_role'];
    	$logged_admin_org = $_SESSION['emp_org'];
    }
	if(empty($_SESSION["accountsauthenticated"]) || $_SESSION["accountsauthenticated"] != true){   
		header('Location: login.php');
		exit();
	} 