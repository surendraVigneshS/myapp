<?php 

    include('./dbconfig.php');
    include('./function.php');
    session_start();
    if (isset($_POST['addEmployee'])){
        $empno =  $_POST['empNo'];
        $empno = 'EMP-'.$empno;
        $empmail =  $_POST['empEmail'];
        $empname =  $_POST['empName'];
        $empmobile =  $_POST['empMobile'];
        $emppass =  $_POST['empPassword'];
        $encryptpass = passwordEncryption($emppass);
        $emprole =  $_POST['empRole'];
        $empOrg =  $_POST['empOrg'];
        $emplead = 0;
        $empstatus = 1;
        if($emprole == 6){
            $emp_dept_type = 1;
        }else{
            $emp_dept_type = 2;
        }
        if(isset($_POST['empLead'])){
            if($emprole == 6){
                $emplead = $_POST['empLead'];    
            }
        }

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

        $addquery = "INSERT INTO `admin_login` ( `emp_no`,`emp_org`,`emp_email`,`emp_name`, `emp_mobile`,`emp_password`, `emp_role`, `team_leader`, `emp_dep_type`, `emp_status`) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ?, ? ) " ;
        $stmt = $dbconnection->prepare($addquery) ;
        $stmt->bind_param("ssssssssss",$empno,$empOrg,$empmail,$empname,$empmobile,$encryptpass,$emprole,$emplead,$emp_dept_type,$empstatus);
        $executeadd = $stmt->execute() or die($dbconnection->error);

        $last_id = $dbconnection->insert_id;
        
        if(!empty($last_id)){
            if(empty($paymentfirstflow) && empty($paymentorgleadflow) && empty($paymentsecondflow) && empty($paymentthirdflow) && empty($paymentfourthflow)){
            }else{
                $updateflow = "INSERT INTO `payment_user_flow` (`emp_id`, `org_Id`, `first_approval`, `orglead_approval`, `second_approval`, `third_approval`, `fourth_apporval`) VALUES ('$last_id', '$empOrg', '$paymentfirstflow', '$paymentorgleadflow', '$paymentsecondflow', '$paymentthirdflow', '$paymentfourthflow') ";
                $executeflow = mysqli_query($dbconnection, $updateflow);
            }
        }
        if(!empty($last_id)){
            if(empty($purchaseorgleadflow) && empty($purchasefirstflow) && empty($purchasesecondflow)){
            }else{
                $insertflow = "INSERT INTO `purchase_user_flow` (`emp_id`, `org_Id`, `first_approval`, `orglead_approval`, `second_approval`) VALUES ('$empid', '$empOrg', '$purchasefirstflow', '$purchaseorgleadflow', '$purchasesecondflow') ";
                $executeflow = mysqli_query($dbconnection, $insertflow);
            }
            
        }

        if($executeadd){  
            $_SESSION['paymentSuccess']="New Employee Added Successfully"; 
            header("location:../employee-list.php"); 
            exit();
        }
        else{
            $_SESSION['paymentError']="Data Submit Error!!"; 
            header("location:../employee-list.php"); 
            exit(); 
        }

    }
    if (isset($_POST['updateEmployee'])){
        $empid =  $_POST['empid'];
        $empno =  $_POST['empNo'];
        $empno = 'EMP-'.$empno;
        $empmail =  $_POST['empEmail'];
        $empname =  $_POST['empName'];
        $empmobile =  $_POST['empMobile'];
        $emprole =  $_POST['empRole'];
        $empstatus = $_POST['empStatus'];
        $empOrg = $_POST['empOrg'];
        
         
         
        $updatequery = "UPDATE `admin_login` SET `emp_no` = '$empno', `emp_org` = '$empOrg', `emp_email` = '$empmail', `emp_name` = '$empname', `emp_mobile` = '$empmobile', `emp_role` = '$emprole', `emp_status` = '$empstatus' WHERE `emp_id` = '$empid' ";
        $executeupdate = mysqli_query($dbconnection,$updatequery); 
        if(isset($_POST['empLead'])){
            if($emprole == 6){
                $emplead = $_POST['empLead'];
                $updatelead = "UPDATE `admin_login` SET `team_leader` = '$emplead' WHERE `emp_id` = '$empid' ";
            }else{
                $emplead = 0;
                $updatelead = "UPDATE `admin_login` SET `team_leader` = '$emplead', `emp_role` = '$emprole' WHERE `emp_id` = '$empid' ";
            }
            $executelead = mysqli_query($dbconnection,$updatelead);    
        }

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
        
        $existpaymentflow = checkUserflow($dbconnection, $empid);
        $existpurchaseflow = checkUserPurchaseflow($dbconnection, $empid);

        if(!empty($empid)){
            if($existpaymentflow){
                if(empty($paymentfirstflow) && empty($paymentorgleadflow) && empty($paymentsecondflow) && empty($paymentthirdflow) && empty($paymentfourthflow)){
                    $deleteflow = "DELETE FROM `payment_user_flow` WHERE `emp_id` = '$empid' ";
                    $executeflow = mysqli_query($dbconnection, $deleteflow);
                }else{
                    $updateflow = "UPDATE `payment_user_flow` SET `org_Id` = '$empOrg', `first_approval` = '$paymentfirstflow', `orglead_approval` = '$paymentorgleadflow', `second_approval` = '$paymentsecondflow', `third_approval` = '$paymentthirdflow', `fourth_apporval` = '$paymentfourthflow' WHERE `emp_id` = '$empid' ";
                    $executeflow = mysqli_query($dbconnection, $updateflow);
                }
            }else{
                if(empty($paymentfirstflow) && empty($paymentorgleadflow) && empty($paymentsecondflow) && empty($paymentthirdflow) && empty($paymentfourthflow)){
                    
                }else{
                    $insertflow = "INSERT INTO `payment_user_flow` (`emp_id`, `org_Id`, `first_approval`, `orglead_approval`, `second_approval`, `third_approval`, `fourth_apporval`) VALUES ('$empid', '$empOrg', '$paymentfirstflow', '$paymentorgleadflow', '$paymentsecondflow', '$paymentthirdflow', '$paymentfourthflow') ";
                    $executeflow = mysqli_query($dbconnection, $insertflow);
                }
            }
        }
        if(!empty($empid)){
            if($existpurchaseflow){
                if(empty($purchaseorgleadflow) && empty($purchasefirstflow) && empty($purchasesecondflow)){
                    $deleteflow = "DELETE FROM `purchase_user_flow` WHERE `emp_id` = '$empid' ";
                    $executeflow = mysqli_query($dbconnection, $deleteflow);
                }else{
                    $updateflow = "UPDATE `purchase_user_flow` SET `org_Id` = '$empOrg', `first_approval` = '$purchasefirstflow', `orglead_approval` = '$purchaseorgleadflow', `second_approval` = '$purchasesecondflow' WHERE `emp_id` = '$empid' ";
                    $executeflow = mysqli_query($dbconnection, $updateflow);
                }
            }else{
                if(empty($purchaseorgleadflow) && empty($purchasefirstflow) && empty($purchasesecondflow)){
                   
                }else{
                    $insertflow = "INSERT INTO `purchase_user_flow` (`emp_id`, `org_Id`, `first_approval`, `orglead_approval`, `second_approval`) VALUES ('$empid', '$empOrg', '$purchasefirstflow', '$purchaseorgleadflow', '$purchasesecondflow') ";
                    $executeflow = mysqli_query($dbconnection, $insertflow);
                }
            }
        }

        if(isset($_POST['empPassword']))
        {
            $empPassword = $_POST['empPassword'];   
            
            $encryptpass = passwordEncryption($empPassword);
            if(!empty($empPassword)){
                $updatePaswword = "UPDATE `admin_login` SET `emp_password` = '$encryptpass' WHERE `emp_id` = '$empid' ";
                $executepassword = mysqli_query($dbconnection,$updatePaswword);    
            }
        }        
        
        if($executeupdate){  
            $_SESSION['paymentSuccess']="Employee Details Updated Successfully"; 
            header("location:../employee-list.php"); 
            exit();
        }
        else{
            $_SESSION['paymentError']="Data Submit Error!!"; 
            header("location:../employee-list.php"); 
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

