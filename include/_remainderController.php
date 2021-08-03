<?php

    include('./dbconfig.php');
    include('./function.php');  
    session_start();
    $approvalTime = date('Y-m-d H:i:s');  

    if (isset($_POST['addRemainder']))
    {   
        $logged_user_id = $_POST['logged_admin_id']; 
        $supplierId = $_POST['supplierId']; 
        $amount = $_POST['amount']; 
        $remainderDate = date('Y-m-d' , strtotime($_POST['remainderDate'])); 
 
        $exeFollowup = mysqli_query($dbconnection, "INSERT INTO `remainder`(`remainder_amount`,`remainder_supplier_id`,`remainder_created_by`, `remainder_created_time`,`remainder_date`,`remainder_type`,`remainder_status`) VALUES ('$amount','$supplierId','$logged_user_id','$approvalTime','$remainderDate',1,0)");

        if ($exeFollowup) {
            $_SESSION['remainderSuccess'] = "Reminder Added Successfully";
            header("location:../remainder-list.php");
            exit();
        } else {
            $_SESSION['remainderError'] = "Data Submit Error!!";
            header("location:../remainder-list.php");
            exit();
        }
    }
    
    
    if (isset($_POST['updateRemainder']))
    {   
        $logged_user_id = $_POST['logged_admin_id']; 
        $remainderId = $_POST['remainderId']; 
        $supplierId = $_POST['supplierId']; 
        $amount = $_POST['amount']; 
        $remainderStatus = $_POST['remainderStatus']; 
        $remainderDate = date('Y-m-d' , strtotime($_POST['remainderDate']));  
        $exeFollowup = mysqli_query($dbconnection, "UPDATE `remainder` SET `remainder_amount` = '$amount',`remainder_supplier_id` ='$supplierId',`remainder_date` = '$remainderDate',`remainder_status` = '$remainderStatus' , `remainder_updated_time` = '$approvalTime' , `remainder_updated_by` = '$logged_user_id' WHERE `id`= '$remainderId' ");
        

        if ($exeFollowup) {
            $_SESSION['remainderSuccess'] = "Reminder Updated Successfully";
            header("location:../remainder-list.php");
            exit();
        } else {
            $_SESSION['remainderError'] = "Data Submit Error!!";
            header("location:../remainder-list.php");
            exit();
        }
    }