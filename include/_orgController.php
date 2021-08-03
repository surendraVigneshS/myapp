<?php 

    include('./dbconfig.php');
    include('./function.php');
    session_start();
    if (isset($_POST['addorganization'])){
         
        $orgName =  $_POST['orgName'];
        if(isset($_POST['orgFlow'])){
            $orgFlow =  $_POST['orgFlow'];
        }else{
            $orgFlow =  0;
        } 
        $orgColor = $_POST['orgColor'];

        if(isset($_POST['orgflow1'])){
            $paymentfirstflow = $_POST['orgflow1'];
        }else{
            $paymentfirstflow = 0;
        }
        if(isset($_POST['orgflow2'])){
            $paymentorgleadflow = $_POST['orgflow2'];
        }else{
            $paymentorgleadflow = 0;
        }
        if(isset($_POST['orgflow3'])){
            $paymentsecondflow = $_POST['orgflow3'];
        }else{
            $paymentsecondflow = 0;
        }
        if(isset($_POST['orgflow4'])){
            $paymentthirdflow = $_POST['orgflow4'];
        }else{
            $paymentthirdflow = 0;
        }
        if(isset($_POST['orgflow5'])){
            $paymentfourthflow = $_POST['orgflow5'];
        }else{
            $paymentfourthflow = 0;
        }
        if(isset($_POST['orgflow6'])){
            $purchaseorgleadflow = $_POST['orgflow6'];
        }else{
            $purchaseorgleadflow = 0;
        }
        if(isset($_POST['orgflow7'])){
            $purchasefirstflow = $_POST['orgflow7'];
        }else{
            $purchasefirstflow = 0;
        }
        if(isset($_POST['orgflow8'])){
            $purchasesecondflow = $_POST['orgflow8'];
        }else{
            $purchasesecondflow = 0;
        }
         
        $addquery = "INSERT INTO `organization`(`organization_name`, `org_flow`, `org_color`, `first_approval`, `orglead_approval`, `second_approval`, `third_approval`, `fourth_apporval`, `purchase_orglead_approval`, `purchase_fisrt_approval`, `purchase_second_approval` ) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ) " ;
        $stmt = $dbconnection->prepare($addquery) ;
        $stmt->bind_param("sssssssssss",$orgName,$orgFlow,$orgColor,$paymentfirstflow,$paymentorgleadflow,$paymentsecondflow,$paymentthirdflow,$paymentfourthflow, $purchaseorgleadflow, $purchasefirstflow, $purchasesecondflow);
        $executeadd = $stmt->execute();
        if($executeadd){  
            $_SESSION['orgSuccess']="New Organization Added Successfully"; 
             header("location:../organization-list.php"); 
            exit();
        }
        else{
            $_SESSION['orgError']="Data Submit Error!!"; 
            header("location:../organization-list.php"); 
            exit(); 
        }

    }
    if (isset($_POST['editOrganization'])){
        
        $orgId =  $_POST['orgId'];
        $orgName =  $_POST['orgName'];
        $orgColor =  $_POST['orgColor'];
        $orgAction =  $_POST['orgAction'];
        
        if($orgAction == 'payment'){
            if(isset($_POST['orgflow1'])){
                $paymentfirstflow = $_POST['orgflow1'];
            }else{
                $paymentfirstflow = 0;
            }
            if(isset($_POST['orgflow2'])){
                $paymentorgleadflow = $_POST['orgflow2'];
            }else{
                $paymentorgleadflow = 0;
            }
            if(isset($_POST['orgflow3'])){
                $paymentsecondflow = $_POST['orgflow3'];
            }else{
                $paymentsecondflow = 0;
            }
            if(isset($_POST['orgflow4'])){
                $paymentthirdflow = $_POST['orgflow4'];
            }else{
                $paymentthirdflow = 0;
            }
            if(isset($_POST['orgflow5'])){
                $paymentfourthflow = $_POST['orgflow5'];
            }else{
                $paymentfourthflow = 0;
            }
            $updatequery = "UPDATE `organization` SET `organization_name` = '$orgName', `org_flow`='$orgFlow', `org_color` = '$orgColor', `first_approval` = '$paymentfirstflow', `orglead_approval` = '$paymentorgleadflow', `second_approval` = '$paymentsecondflow', `third_approval` = '$paymentthirdflow', `fourth_apporval` = '$paymentfourthflow' WHERE `id` = '$orgId' ";
            $executeupdate = mysqli_query($dbconnection,$updatequery); 
        }
        
        if($orgAction == 'purchase'){
            if(isset($_POST['orgflow6'])){
                $purchaseorgleadflow = $_POST['orgflow6'];
            }else{
                $purchaseorgleadflow = 0;
            }
            if(isset($_POST['orgflow7'])){
                $purchasefirstflow = $_POST['orgflow7'];
            }else{
                $purchasefirstflow = 0;
            }
            if(isset($_POST['orgflow8'])){
                $purchasesecondflow = $_POST['orgflow8'];
            }else{
                $purchasesecondflow = 0;
            }
            $updatequery = "UPDATE `organization` SET `organization_name` = '$orgName', `org_flow`='$orgFlow', `org_color` = '$orgColor', `purchase_orglead_approval` = '$purchaseorgleadflow', `purchase_fisrt_approval` = '$purchasefirstflow', `purchase_second_approval` = '$purchasesecondflow' WHERE `id` = '$orgId' ";
            $executeupdate = mysqli_query($dbconnection,$updatequery); 
        }
         
        
        if($executeupdate){  
            $_SESSION['orgSuccess']="Employee Details Updated Successfully"; 
            header("location:../organization-list.php"); 
            exit();
        }
        else{
            $_SESSION['orgError']="Data Submit Error!!"; 
            header("location:../organization-list.php"); 
            exit(); 
        }

    }

    if (isset($_POST['updateProfile'])){
        $empid =  $_POST['empid']; 
        $empmail =  $_POST['empEmail'];
        $empname =  $_POST['empName'];
        $empmobile =  $_POST['empMobile']; 

        $updatequery = "UPDATE `admin_login` SET  `emp_email` = '$empmail', `emp_name` = '$empname', `emp_mobile` = '$empmobile'  WHERE `emp_id` = '$empid' ";
        $executeupdate = mysqli_query($dbconnection,$updatequery); 
        
        if($executeupdate){  
            $_SESSION['userprofileSuccess']="Profile Details Updated Successfully"; 
            $randomString = RandomString(50);
            header("location:../user-profile.php?platform=$randomString&action=editemployee"); 
            exit();
        }
        else{
            $_SESSION['userprofileFailed']="Data Submit Error!!"; 
            header("location:../user-profile.php"); 
            exit(); 
        }

    }


?>