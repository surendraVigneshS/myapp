<?php

    include('./dbconfig.php');
    include('./function.php'); 
    include('./paymentSendMail.php');
    include('./createQR.php');
    $productpath = "../assets/qr/product/"; 
    $currentTime = date('Y-m-d H:i:s');
    session_start();

    if (isset($_POST['addPurchase']))
    {  
        $logged_user_id = $_POST['logged_admin_id']; 
        $purchaseCode = 'PUR-'.hexdec(rand(100000, 999999)); 
        $purchaseType =  $PRName = $projectTitle = $supplierName = $supplierEmail = $supplierMobile = $purchaseType  = $accNo = $ifsccode = $remarks = $approvalTime = $pofile = $poNO =$purchaseAgainst = $expectedDate =  $otherorgName = ''; 
        $PRName = $_POST['PRName']; 
        $orgName = $_POST['orgName'];  
        if(isset($_POST['otherorgName'])){ $otherorgName = $_POST['otherorgName']; }  
        if($orgName == 3){ $orgName = $otherorgName; } 
        if(isset($_POST['purchaseType'])) { $purchaseType = $_POST['purchaseType'];} 
        if(isset($_POST['expectedDate'])) { $expectedDate = $_POST['expectedDate']; } 
        if(isset($_POST['accNo'])){ $accNo = $_POST['accNo'];}
        if(isset($_POST['ifsccode'])){ $ifsccode = $_POST['ifsccode'];}
        if(isset($_POST['remarks'])){ $remarks = $_POST['remarks']; }
        if(isset($_POST['projectTitle'])) { $projectID = $_POST['projectTitle'];} 
        if(isset($_POST['supplierID'])){ $supplierID = $_POST['supplierID']; } 
        $approvalTime = date('Y-m-d H:i:s');  
        $teamleader = fetchData($dbconnection,'team_leader','admin_login','emp_id',$logged_user_id); 
        $purchaseAgainst  = $_POST['purchaseAgainst']; 
        
        $addquery = "INSERT INTO `purchase_request` (`purchase_code`,`pr_name`,`org_name`,`purchase_type`,`already_purchased`,`others`,`created_by`,`team_leader`,`created_date`,`expected_date`) VALUES (?,?,?,?,?,?,?,?,?,?)"; 
        $stmt = $dbconnection->prepare($addquery);   
        $stmt->bind_param("ssssssssss",$purchaseCode,$PRName,$orgName, $purchaseType, $purchaseAgainst,$remarks,$logged_user_id,$teamleader,$currentTime,$expectedDate);
        $executeadd = $stmt->execute();
        $purchaseId = $dbconnection->insert_id;

        if($purchaseAgainst == 1 ){
            $poNO  = $_POST['billNO'];
            if(isset($_POST['totalAmount'])) {$totalAmount  = $_POST['totalAmount']; };
            if(isset($_POST['amountWords'])) {$amountWords  = $_POST['amountWords']; };
            if (!empty($_FILES['billfile']['name'])) { 
                $image_name= '';
                $image_name = $_FILES['billfile']['name'];
                $pofile = uniqidReal(5).'_'.$image_name;
                $target_dir = "../assets/pdf/purchase/";
                $target_file = $target_dir . basename($pofile);
                $upload_success = move_uploaded_file($_FILES['billfile']['tmp_name'], $target_dir.$pofile); 
               mysqli_query($dbconnection,"UPDATE `purchase_request` SET `bill_no`='$poNO',`bill_file` = '$pofile' , `total_amount` ='$totalAmount' , `amount_words` = '$amountWords' WHERE  `pur_id`='$purchaseId' ");
           }
        }
        
        if($orgName == 1){
            $updatepurchasequery = "UPDATE `purchase_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$logged_user_id' , `orglead_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' "; 
            $executepurchaseupdate = mysqli_query($dbconnection, $updatepurchasequery);
        }else{
            $updatepurchasequery = "UPDATE `purchase_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$logged_user_id' , `orglead_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' "; 
            $executepurchaseupdate = mysqli_query($dbconnection, $updatepurchasequery);
        }

        if (is_numeric($orgName) && $orgName != 1){
            $approval_arr = fetchOrgflow($dbconnection, $orgName, 2);
            $orgleadapproval = $approval_arr['approval1'];
            $orgfirstapproval = $approval_arr['approval2'];
            $orgsecondapproval = $approval_arr['approval3'];
            if($orgfirstapproval == 0){
                $updateorgflowapprove = "UPDATE `purchase_request` SET `first_approval` = 1, `first_approval_by` = '$logged_user_id', `first_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' ";
                $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
            }
            if($orgleadapproval == 0){
                $updateorgflowapprove = "UPDATE `purchase_request` SET `orglead_approval` = 1, `orglead_approval_by` = '$logged_user_id', `orglead_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' ";
                $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
            }
            if($orgsecondapproval == 0){
                $updateorgflowapprove = "UPDATE `purchase_request` SET `second_approval` = 1, `second_approval_by` = '$logged_user_id', `second_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' ";
                $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
            }
        }

        if(!empty($orgName)){
            $selectflow = mysqli_query($dbconnection, "SELECT * FROM `purchase_user_flow` WHERE `emp_id` = '$logged_user_id' ");
            if(mysqli_num_rows($selectflow) > 0){
                if($row = mysqli_fetch_array($selectflow)){
                    $firstapproval = $row['first_approval'];
                    $orgleadapproval = $row['orglead_approval'];
                    $secondapproval = $row['second_approval'];
                    if($firstapproval == 0){
                        $updatepayment = "UPDATE `purchase_request` SET `first_approval` = 1, `first_approval_by` = '$logged_user_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$purchaseId' ";
                        $executepayment = mysqli_query($dbconnection, $updatepayment);
                    }
                    if($orgleadapproval == 0){
                        $updateapprove = "UPDATE `purchase_request` SET `orglead_approval` = 1, `orglead_approval_by` = '$logged_user_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$purchaseId' ";
                        $executeapprove = mysqli_query($dbconnection, $updateapprove);
                    }
                    if($secondapproval == 0){
                        $updatepayment = "UPDATE `purchase_request` SET `second_approval` = 1, `second_approval_by` = '$logged_user_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$purchaseId' ";
                        $executepayment = mysqli_query($dbconnection, $updatepayment);
                    }
                }
            }
        }


         
        if($executeadd)
        {  
            if($projectID == "$"){
                $projectName = $_POST["newproject"];
                $addedfrom = 2;
                $addquery = "INSERT INTO `ft_projects_tb`(`project_title`,`created_by`,`created_time`,`added_from`) VALUES( ? ,? ,? , ?)";   
                $stmt = $dbconnection->prepare($addquery);
                $stmt->bind_param("sssi",$projectName,$logged_user_id,$currentTime,$addedfrom);   
                $executecust = $stmt->execute(); 
                $projectID = $dbconnection->insert_id; 
            }
             
            if($supplierID == "$"){
                $supplierName = $_POST["supplierName"];
                $supplierEmail = $_POST["supplierEmail"];
                $supplierMobile = $_POST["supplierMobile"];
                $accNo = $_POST["accNo"];
                $ifsccode = $_POST["ifsccode"];
                $companyBranch = $_POST["companyBranch"];

                
                $addcustquery = "INSERT INTO `supplier_details`(`supplier_name`, `supplier_email`, `supplier_mobile`  , `supplier_acc_no` ,`supplier_ifsc_code`,`supplier_branch`) VALUES ( ?  , ? , ?, ?, ?  , ?  ) " ;
                $stmt = $dbconnection->prepare($addcustquery) ;
                $stmt->bind_param("ssssss",$supplierName , $supplierEmail, $supplierMobile , $accNo , $ifsccode,$companyBranch);
                $executecust = $stmt->execute(); 
                $supplierID = $dbconnection->insert_id; 
            }
             
             mysqli_query($dbconnection,"UPDATE `purchase_request` SET `pr_project_id` ='$projectID', `pr_supplier_id` ='$supplierID' WHERE `pur_id` = '$purchaseId' ");
            
            foreach ($_POST['productID'] as $key => $value) 
            {  
                $qty =   $_POST['productQTY'][$key];
                $insertProducts ="INSERT INTO `purchased_products`(`pr_product_id`, `pr_purchase_id`, `pr_project_id`, `pr_supplier_id`, `pr_qty`) VALUES (?,?,?,?,?)";
                $stmt = $dbconnection->prepare($insertProducts) ;
                $stmt->bind_param("sssss", $value,$purchaseId,$projectID,$supplierID,$qty);
                $stmt->execute(); 
            }      
            
            $_SESSION['purchaseSuccess']="New Purchase Request Added Successfully";   
            header("location:../purchase-list.php");  
            exit();  
        }
        else { 
            $_SESSION['purchaseError']="Data Submit Error!!";    
            header("location:../purchase-list.php");  
            exit();  
        }
    }
    
    
     if (isset($_POST['raiseaddPurchase']))
    {  
        $logged_user_id = $_POST['logged_admin_id']; 
        $purchaseCode = 'PUR-'.hexdec(rand(100000, 999999)); 
        $purchaseType =  $PRName = $projectTitle = $supplierName = $supplierEmail = $supplierMobile = $purchaseType  = $accNo = $ifsccode = $remarks = $approvalTime = $pofile = $poNO =$purchaseAgainst = $expectedDate =  $otherorgName = ''; 
        $PRName = $_POST['PRName']; 
        $orgName = $_POST['orgName'];  
        if(isset($_POST['otherorgName'])){ $otherorgName = $_POST['otherorgName']; }  
        if($orgName == 3){ $orgName = $otherorgName; } 
        if(isset($_POST['purchaseType'])) { $purchaseType = $_POST['purchaseType'];} 
        if(isset($_POST['expectedDate'])) { $expectedDate = $_POST['expectedDate']; } 
        if(isset($_POST['accNo'])){ $accNo = $_POST['accNo'];}
        if(isset($_POST['ifsccode'])){ $ifsccode = $_POST['ifsccode'];}
        if(isset($_POST['remarks'])){ $remarks = $_POST['remarks']; }
        if(isset($_POST['projectTitle'])) { $projectID = $_POST['projectTitle'];} 
        if(isset($_POST['supplierID'])){ $supplierID = $_POST['supplierID']; } 
        $approvalTime = date('Y-m-d H:i:s');  
        $teamleader = fetchData($dbconnection,'team_leader','admin_login','emp_id',$logged_user_id); 
        $purchaseAgainst  = $_POST['purchaseAgainst']; 
        
        $addquery = "INSERT INTO `purchase_request` (`purchase_code`,`pr_name`,`org_name`,`purchase_type`,`already_purchased`,`others`,`created_by`,`team_leader`,`created_date`,`expected_date`) VALUES (?,?,?,?,?,?,?,?,?,?)"; 
        $stmt = $dbconnection->prepare($addquery);   
        $stmt->bind_param("ssssssssss",$purchaseCode,$PRName,$orgName, $purchaseType, $purchaseAgainst,$remarks,$logged_user_id,$teamleader,$currentTime,$expectedDate);
        $executeadd = $stmt->execute();
        $purchaseId = $dbconnection->insert_id;

        if($purchaseAgainst == 1 ){
            $poNO  = $_POST['billNO'];
            if(isset($_POST['totalAmount'])) {$totalAmount  = $_POST['totalAmount']; };
            if(isset($_POST['amountWords'])) {$amountWords  = $_POST['amountWords']; };
            if (!empty($_FILES['billfile']['name'])) { 
                $image_name= '';
                $image_name = $_FILES['billfile']['name'];
                $pofile = uniqidReal(5).'_'.$image_name;
                $target_dir = "../assets/pdf/purchase/";
                $target_file = $target_dir . basename($pofile);
                $upload_success = move_uploaded_file($_FILES['billfile']['tmp_name'], $target_dir.$pofile); 
               mysqli_query($dbconnection,"UPDATE `purchase_request` SET `bill_no`='$poNO',`bill_file` = '$pofile' , `total_amount` ='$totalAmount' , `amount_words` = '$amountWords' WHERE  `pur_id`='$purchaseId' ");
           }
        }
        
        if($orgName == 1){
            $updatepurchasequery = "UPDATE `purchase_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$logged_user_id' , `orglead_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' "; 
            $executepurchaseupdate = mysqli_query($dbconnection, $updatepurchasequery);
        }else{
            $updatepurchasequery = "UPDATE `purchase_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$logged_user_id' , `orglead_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' "; 
            $executepurchaseupdate = mysqli_query($dbconnection, $updatepurchasequery);
        }

        if (is_numeric($orgName) && $orgName != 1){
            $approval_arr = fetchOrgflow($dbconnection, $orgName, 2);
            $orgleadapproval = $approval_arr['approval1'];
            $orgfirstapproval = $approval_arr['approval2'];
            $orgsecondapproval = $approval_arr['approval3'];
            if($orgfirstapproval == 0){
                $updateorgflowapprove = "UPDATE `purchase_request` SET `first_approval` = 1, `first_approval_by` = '$logged_user_id', `first_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' ";
                $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
            }
            if($orgleadapproval == 0){
                $updateorgflowapprove = "UPDATE `purchase_request` SET `orglead_approval` = 1, `orglead_approval_by` = '$logged_user_id', `orglead_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' ";
                $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
            }
            if($orgsecondapproval == 0){
                $updateorgflowapprove = "UPDATE `purchase_request` SET `second_approval` = 1, `second_approval_by` = '$logged_user_id', `second_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' ";
                $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
            }
        }

        if(!empty($orgName)){
            $selectflow = mysqli_query($dbconnection, "SELECT * FROM `purchase_user_flow` WHERE `emp_id` = '$logged_user_id' ");
            if(mysqli_num_rows($selectflow) > 0){
                if($row = mysqli_fetch_array($selectflow)){
                    $firstapproval = $row['first_approval'];
                    $orgleadapproval = $row['orglead_approval'];
                    $secondapproval = $row['second_approval'];
                    if($firstapproval == 0){
                        $updatepayment = "UPDATE `purchase_request` SET `first_approval` = 1, `first_approval_by` = '$logged_user_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$purchaseId' ";
                        $executepayment = mysqli_query($dbconnection, $updatepayment);
                    }
                    if($orgleadapproval == 0){
                        $updateapprove = "UPDATE `purchase_request` SET `orglead_approval` = 1, `orglead_approval_by` = '$logged_user_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$purchaseId' ";
                        $executeapprove = mysqli_query($dbconnection, $updateapprove);
                    }
                    if($secondapproval == 0){
                        $updatepayment = "UPDATE `purchase_request` SET `second_approval` = 1, `second_approval_by` = '$logged_user_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$purchaseId' ";
                        $executepayment = mysqli_query($dbconnection, $updatepayment);
                    }
                }
            }
        }


         
        if($executeadd)
        {  
            if($projectID == "$"){
                $projectName = $_POST["newproject"];
                $addedfrom = 2;
                $addquery = "INSERT INTO `ft_projects_tb`(`project_title`,`created_by`,`created_time`,`added_from`) VALUES( ? ,? ,? , ?)";   
                $stmt = $dbconnection->prepare($addquery);
                $stmt->bind_param("sssi",$projectName,$logged_user_id,$currentTime,$addedfrom);   
                $executecust = $stmt->execute(); 
                $projectID = $dbconnection->insert_id; 
            }
             
            if($supplierID == "$"){
                $supplierName = $_POST["supplierName"];
                $supplierEmail = $_POST["supplierEmail"];
                $supplierMobile = $_POST["supplierMobile"];
                $accNo = $_POST["accNo"];
                $ifsccode = $_POST["ifsccode"];
                $companyBranch = $_POST["companyBranch"];

                
                $addcustquery = "INSERT INTO `supplier_details`(`supplier_name`, `supplier_email`, `supplier_mobile`  , `supplier_acc_no` ,`supplier_ifsc_code`,`supplier_branch`) VALUES ( ?  , ? , ?, ?, ?  , ?  ) " ;
                $stmt = $dbconnection->prepare($addcustquery) ;
                $stmt->bind_param("ssssss",$supplierName , $supplierEmail, $supplierMobile , $accNo , $ifsccode,$companyBranch);
                $executecust = $stmt->execute(); 
                $supplierID = $dbconnection->insert_id; 
            }
             
             mysqli_query($dbconnection,"UPDATE `purchase_request` SET `pr_project_id` ='$projectID', `pr_supplier_id` ='$supplierID' WHERE `pur_id` = '$purchaseId' ");
            
            foreach ($_POST['productID'] as $key => $value) 
            {  
                $qty =   $_POST['productQTY'][$key];
                $insertProducts ="INSERT INTO `purchased_products`(`pr_product_id`, `pr_purchase_id`, `pr_project_id`, `pr_supplier_id`, `pr_qty`) VALUES (?,?,?,?,?)";
                $stmt = $dbconnection->prepare($insertProducts) ;
                $stmt->bind_param("sssss", $value,$purchaseId,$projectID,$supplierID,$qty);
                $stmt->execute(); 
            } 
            
            $_SESSION['purchaseSuccess']="New Purchase Request Added Successfully";   
            header("location:../purchase-list.php");  
            exit();  
        }
        else { 
            $_SESSION['purchaseError']="Data Submit Error!!";    
            header("location:../purchase-list.php");  
            exit();  
        }
    }
   

   
    if (isset($_POST['editPurchase']))
    { 
         
        $purchaseId =  $_POST['purchaseId'];
        $logged_user_id =  $_POST['logged_admin_id'];   
        $projectID =  $_POST['projectID'];   
        $projectTitle =  $_POST['projectTitle'];
        $supplierId = $_POST["supplierId"];
        $supplierName = $_POST["supplierName"];
        $supplierEmail = $_POST["supplierEmail"];
        $supplierMobile = $_POST["supplierMobile"];
        $accNo = $_POST["accNo"];
        $ifsccode = $_POST["ifsccode"];
        $companyBranch = $_POST["companyBranch"];

        $purchaseType = $_POST['purchaseType'];
        $remarks = $_POST['remarks']; 
        $purchaseAgainst  = $_POST['purchaseAgainst'];
        
        $addquery = "UPDATE `purchase_request` SET  `purchase_type` = '$purchaseType', `others` = '$remarks' ,`already_purchased` = '$purchaseAgainst' WHERE `pur_id` = '$purchaseId' "; 
        $executeUpdate = mysqli_query($dbconnection, $addquery) or die(mysqli_error($dbconnection)); 
        
        
        if($executeUpdate)
        {  
             mysqli_query($dbconnection, "UPDATE `supplier_details` SET  `supplier_name` = '$supplierName', `supplier_email` = '$supplierEmail' ,`supplier_mobile` = '$supplierMobile' ,`supplier_branch` = '$companyBranch' ,`supplier_acc_no` = '$accNo' , `supplier_ifsc_code` = '$ifsccode' WHERE `cust_id` = '$supplierId' ") or die(mysqli_error($dbconnection)); 
            $delete = "DELETE FROM `purchased_products` WHERE `pr_purchase_id`='$purchaseId';"; 
            $deleteexecute = mysqli_query($dbconnection,$delete); 
            foreach ($_POST['productID'] as $key => $value) 
            {  
                $qty =   $_POST['productQTY'][$key];
                $insertProducts ="INSERT INTO `purchased_products`(`pr_product_id`, `pr_purchase_id`, `pr_project_id`, `pr_supplier_id`, `pr_qty`) VALUES (?,?,?,?,?)";
                $stmt = $dbconnection->prepare($insertProducts) ;
                $stmt->bind_param("sssss", $value,$purchaseId,$projectID,$supplierId,$qty);
                $stmt->execute(); 
            }      
        } 


        if($executeUpdate) 
        { 
             $_SESSION['purchaseSuccess']="Purchase Request Updated Successfully";   
            header("location:../purchase-list.php");  
            exit();  
        }
        else 
        { 
             $_SESSION['purchaseError']="Data Submit Error!!";   
            header("location:../purchase-list.php");  
            exit();  
        }
    }
   
    if (isset($_POST['editPurchaseAlready']))
    { 
         
        $purchaseId =  $_POST['purchaseId'];
        $logged_user_id =  $_POST['logged_admin_id']; 
        $purchaseType = $_POST['purchaseType'];
        $remarks = $_POST['remarks']; 
        $purchaseAgainst  = $_POST['purchaseAgainst']; 
        if($purchaseAgainst == 1 ){
            $poNO  = $_POST['billNO'];
            if(isset($_POST['totalAmount'])) {$totalAmount  = $_POST['totalAmount']; }; 
            if (!empty($_FILES['billfile']['name'])) { 
                $image_name= '';
                $image_name = $_FILES['billfile']['name'];
                $pofile = uniqidReal(5).'_'.$image_name;
                $target_dir = "../assets/pdf/purchase/";
                $target_file = $target_dir . basename($pofile);
                $upload_success = move_uploaded_file($_FILES['billfile']['tmp_name'], $target_dir.$pofile); 
                mysqli_query($dbconnection,"UPDATE `purchase_request` SET `bill_no`='$poNO',`bill_file` = '$pofile'  WHERE  `pur_id`='$purchaseId' ");
           }
        }     
        
        $addquery = "UPDATE `purchase_request` SET `purchase_type` = '$purchaseType', `others` = '$remarks' ,`already_purchased` = '$purchaseAgainst' , `total_amount` ='$totalAmount' WHERE `pur_id` = '$purchaseId' "; 
        $executeUpdate = mysqli_query($dbconnection, $addquery); 
  
        if($executeUpdate) 
        { 
            $_SESSION['purchaseSuccess']="Purchase Request Updated Successfully";   
            header("location:../purchase-list.php");  
            exit();  
        }
        else 
        { 
            $_SESSION['purchaseError']="Data Submit Error!!";   
            header("location:../purchase-list.php");  
            exit();  
        }
    }
 
    if (isset($_POST['addPurchasePO']))
    { 
        

        $totalAmount = $amountWords =  $advencAmount = $balanceAmount =  null;  

         
        if(isset($_POST['billNo'])) { $billNo = $_POST['billNo'];  }
        
          
        $ifpo = 1;
         
        $pofile = null;
        $billfile = null; 
        $approvalTime = date('Y-m-d H:i:s'); 

        $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
        $adminRole = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_role']);
        $adminId = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_id']);   
      
      

        if(!empty($ifpo) && $ifpo == 1 ){
            if(isset($_POST['totalAmount'])){
                $totalAmount = $_POST['totalAmount']; 
                $amountWords = $_POST['amountWords']; 
                $advencAmount = $_POST['advencAmount']; 
                $balanceAmount = $_POST['balanceAmount'];  
            }
        }


        if(isset($_POST['poNO'])) {$poNO = $_POST['poNO'];  } 
         
        if (!empty($_FILES['pofile']['name'])) 
        {
             
 
            $image_name= '';
            $image_name = $_FILES['pofile']['name'];
            $pofile = uniqidReal(5).'_'.$image_name; 
            $target_dir = "../assets/pdf/purchase/";
            $target_file = $target_dir . basename($pofile);
            $filePath = $target_dir.$pofile; 
            $upload_success = move_uploaded_file($_FILES['pofile']['tmp_name'], $target_dir.$pofile);   
            $executepoUpdate = mysqli_query($dbconnection, "UPDATE `purchase_request` SET  `po_no` = '$poNO', `po_file` = '$pofile'  WHERE `pur_id` = '$purchaseId' "); 
        }
 
        $addquery = "UPDATE `purchase_request` SET `if_po_done` ='$ifpo' ,`total_amount` = '$totalAmount', `advance_amount`  = '$advencAmount', `balance_amount`  = '$balanceAmount', `amount_words` = '$amountWords', `second_approval` = '1',`second_approved_by` = '$adminId' , `second_approval_time` = '$approvalTime' , `purchase_payment` = 1 WHERE `pur_id` = '$purchaseId' "; 
        $executeUpdate = mysqli_query($dbconnection, $addquery); 

        if($executeUpdate) 
        { 
            $insertquery = "INSERT INTO `purchase_history`(`purchase_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) 
            VALUES ('$purchaseId' , '1' , 'Payment Processed' , '$adminId','$adminRole' , '1' , 'Second Approval' , '$approvalTime' , '1')";
            $approveexecute = mysqli_query($dbconnection, $insertquery); 

            if($insertquery){  
                $selectpurchase = "SELECT * FROM `purchase_request` WHERE `pur_id` = '$purchaseId'";
                $executpurchase = mysqli_query($dbconnection,$selectpurchase);
                if(mysqli_num_rows($executpurchase) > 0){
                    if($row = mysqli_fetch_array($executpurchase)){
                        $PRName =   $row['pr_name'];
                        $projectTitle =  $row['project_title']; 
                        $supplierName = $row['supplier_name']; 
                        $supplierEmail = $row['supplier_email']; 
                        $supplierMobile = $row['supplier_mobile']; 
                        $paymentType = $row['purchase_type'];
                        $reason = null;
                        $amount = $row['total_amount'];
                        $advance = $row['advance_amount'];
                        $balance = $row['balance_amount'];
                        $amountWords = $row['amount_words'];
                        $PONum = $row['po_no'];
                        $billNo = $row['bill_no'];
                        $uniqueimage = $row['po_file'];
                        $teamleader = 0; 
                        $remarks = $_POST['remarks']; // Get from add purchase request 
                        $paymentAgainst = '3'; // Change the select option 
                        $payCode = 'PAY-'.hexdec(rand(100000, 999999));
                        $accNo = $row['supplier_accno'];
                        $ifsccode = $row['supplier_ifsccode']; 
                        $inchargeName = fetchData($dbconnection,'emp_name','admin_login','emp_id',$adminId); 
                        $orgName = fetchData($dbconnection,'org_name','purchase_request','pur_id',$purchaseId); 
                         
                        $purchasepayment = '1';
                        $raisedBy = '2';
                        $companyBranch = null;
                        $gst = 0;
                        $gstNo = null;
                        
                        $raisedBy = 2;
                        $purchasepayment = 1;
            
                        $addquery = "INSERT INTO `payment_request` ( `pay_code`,`team_leader`,`incharge_name`, `company_name`, `org_name`, `project_title`, `bill_no`, `supplier_mobile`, `supplier_mail`, `supplier_branch`, `reason`, `po_no`, `amount`, `amount_words`, `payment_type`, `payment_against`, `gst`, `gst_no`, `remarks`, `acc_no`, `ifsc_code`, `created_by` , `created_date`, `raised_by`, `pur_id`, `purchase_payment`) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ) ";
                        $stmt = $dbconnection->prepare($addquery);
                        $stmt->bind_param("ssssssssssssssssssssssssss", $payCode, $teamleaderid, $inchargeName, $supplierName, $orgName, $projectTitle, $billNo, $supplierMobile, $supplierEmail, $companyBranch, $reason, $PONum, $amount, $amountWords, $paymentType, $paymentAgainst, $gst, $gstNo, $remarks, $accNo, $ifsccode, $adminId, $currentTime, $raisedBy, $purchaseId, $purchasepayment);
                        $executeadd = $stmt->execute();
 
                        $last_id = $dbconnection->insert_id;
                        
                        
                        if($adminRole == 3  || $adminRole == 7){
                            $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$adminId', `first_approval_time` = '$currentTime' WHERE `pay_id` = '$last_id' ";
                            mysqli_query($dbconnection,$updateapprove);
                        }else if(($logged_role == 8 || $logged_role == 4 || $logged_role == 9 || $logged_role == 1)){
                            $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$adminId', `first_approval_time` = '$currentTime', `second_approval` = 1, `second_approval_by` = '$adminId', `second_approval_time` = '$currentTime' WHERE `pay_id` = '$last_id' ";
                            mysqli_query($dbconnection,$updateapprove);
                        }
                        if($orgName =='2'){
                            $updateapprove2 = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$adminId', `first_approval_time` = '$currentTime', `second_approval` = 1, `second_approval_by` = '$adminId', `second_approval_time` = '$currentTime' WHERE `pay_id` = '$last_id' ";
                            $executeapprove2 = mysqli_query($dbconnection,$updateapprove2);   
                        }
                        
                        if($paymentAgainst == '3' && !empty($last_id)){ 
                            $advancepaymentquery = "UPDATE `payment_request` SET `advanced_amonut` = '$advance', `balance_amount` = '$balance' WHERE `pay_id` = '$last_id' ";
                            $executequery = mysqli_query($dbconnection,$advancepaymentquery);
                            $uploaded_type = 'PO';
                            $uniqueimage = null;
                            $addpofile = "INSERT INTO `payment_pdf` (`pay_id`,`uploaded_type`,`po_filename`,`uploaded_by`,`total_amount`,`advance_amount`) VALUES ( '$last_id', '$uploaded_type', '$uniqueimage', '$adminId', '$amount', '$advance' ) ";
                            $executepofile = mysqli_query($dbconnection,$addpofile);   
                        }

                        if($orgName == 1){
                            $updateorgleadapprove = "UPDATE `payment_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$adminId', `orglead_approval_time` = '$currentTime' WHERE `pay_id` = '$last_id' ";
                            $executeorgleadapprove = mysqli_query($dbconnection, $updateorgleadapprove);
                        }else{
                            $updateorgleadapprove = "UPDATE `payment_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$adminId', `orglead_approval_time` = '$currentTime' WHERE `pay_id` = '$last_id' ";
                            $executeorgleadapprove = mysqli_query($dbconnection, $updateorgleadapprove);
                        }
                    }
                } 
            $_SESSION['purchaseSuccess']="Purchase To Payment Request Added Successfully";  
            header("location:../purchase-list.php");    
            }
            exit();  
        }else{
            $_SESSION['purchaseError']="Data Submit Error!!";   
            header("location:../purchase-list.php");   
            exit();   
        }
    }


    if(isset($_POST['sentPOEmail']))
    {
  
          
        $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
        $adminRole = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_role']);
        $adminId = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_id']);   
        $emailsubJect = mysqli_real_escape_string($dbconnection, $_POST['emailSubject']);   
        if(isset($_POST['emailBody'])){  $emailBody = $_POST['emailBody'];  }
        if(isset($_POST['poNO'])) {$poNO = $_POST['poNO'];  }
        
        if (!empty($_FILES['pofile']['name'])) 
        {
         
            $image_name= '';
            $image_name = $_FILES['pofile']['name'];
            $pofile = uniqidReal(5).'_'.$image_name; 
            $target_dir = "../assets/pdf/purchase/";
            $target_file = $target_dir . basename($pofile);
            $filePath = $target_dir.$pofile; 
            $upload_success = move_uploaded_file($_FILES['pofile']['tmp_name'], $target_dir.$pofile); 
            if($emailBody){
                $executepoUpdate = mysqli_query($dbconnection, "UPDATE `purchase_request` SET  `po_no` = '$poNO', `po_file` = '$pofile' , `mail_sent` =1 WHERE `pur_id` = '$purchaseId' ");
             }
            purchasepaymentmailWA($dbconnection,$purchaseId,$emailsubJect,$emailBody,$image_name,$filePath);
            $encrypt = passwordEncryption($purchaseId);
            header("location:../edit-purchase-request.php?platform=4iiirZa4xud5JuYOQ1JVp8h0GT8ODlfxhsEka8X4ZmVmN&fieldid=$encrypt&action=editpurchase");   
     
        }
        else{ 
     
            $target_dir = "../assets/pdf/purchase/";
            $image_name = fetchData($dbconnection,'po_file','purchase_request','pur_id',$purchaseId); 
            $filePath = $target_dir.$image_name;
            purchasepaymentmailWA($dbconnection,$purchaseId,$emailsubJect,$emailBody,$image_name,$filePath);
                   if($emailBody){
            $executepoUpdate = mysqli_query($dbconnection, "UPDATE `purchase_request` SET `mail_sent` =1 WHERE `pur_id` = '$purchaseId' ");
                   }
            $encrypt = passwordEncryption($purchaseId); 
            header("location:../edit-purchase-request.php?platform=4iiirZa4xud5JuYOQ1JVp8h0GT8ODlfxhsEka8X4ZmVmN&fieldid=$encrypt&action=editpurchase");      
            
            
        }
        
    }
   
   
    if(isset($_POST['savefPOFILE']))
    {
         
        $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
        $adminRole = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_role']);
        $adminId = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_id']);   
        
        
        if(isset($_POST['poNO'])) {$poNO = $_POST['poNO'];  }
        
        if(isset($_POST['poNO'])) {$poNO = $_POST['poNO'];  } 
                if(isset($_POST['totalAmount'])){
                    $totalAmount = $_POST['totalAmount'];  
                    $amountWords = $_POST['amountWords']; 
                    $advencAmount = $_POST['advencAmount']; 
                    $balanceAmount = $_POST['balanceAmount']; 
                    mysqli_query($dbconnection, "UPDATE `purchase_request` SET  `total_amount` = '$totalAmount', `advance_amount`  = '$advencAmount', `balance_amount`  = '$balanceAmount', `amount_words` = '$amountWords' WHERE `pur_id` = '$purchaseId' "); 
                    
                }
        
                
        if (!empty($_FILES['pofile']['name'])) 
        {
 
            $image_name= '';
            $image_name = $_FILES['pofile']['name'];
            $pofile = uniqidReal(5).'_'.$image_name; 
            $target_dir = "../assets/pdf/purchase/";
            $target_file = $target_dir . basename($pofile);
            $filePath = $target_dir.$pofile; 
            $upload_success = move_uploaded_file($_FILES['pofile']['tmp_name'], $target_dir.$pofile); 
            $executepoUpdate = mysqli_query($dbconnection, "UPDATE `purchase_request` SET  `po_no` = '$poNO', `po_file` = '$pofile' WHERE `pur_id` = '$purchaseId' "); 
            $encrypt = passwordEncryption($purchaseId);
            header("location:../edit-purchase-request.php?platform=4iiirZa4xud5JuYOQ1JVp8h0GT8ODlfxhsEka8X4ZmVmN&fieldid=$encrypt&action=editpurchase");  
        } 
    }


    if(isset($_POST['saveOnlyPO']))
    {
         
        $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
        $adminRole = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_role']);
        $adminId = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_id']);   
        
        
      
        if (!empty($_FILES['pofile']['name'])) 
        {
 
            $image_name= '';
            $image_name = $_FILES['pofile']['name'];
            $pofile = uniqidReal(5).'_'.$image_name; 
            $target_dir = "../assets/pdf/purchase/";
            $target_file = $target_dir . basename($pofile);
            $filePath = $target_dir.$pofile; 
            $upload_success = move_uploaded_file($_FILES['pofile']['tmp_name'], $target_dir.$pofile); 
            $executepoUpdate = mysqli_query($dbconnection, "UPDATE `purchase_request` SET  `po_no` = '$poNO', `po_file` = '$pofile' WHERE `pur_id` = '$purchaseId' "); 
            $encrypt = passwordEncryption($purchaseId);
            header("location:../edit-purchase-request.php?platform=4iiirZa4xud5JuYOQ1JVp8h0GT8ODlfxhsEka8X4ZmVmN&fieldid=$encrypt&action=editpurchase");  
        } 
    }
    
    
   
    if(isset($_POST['saveSupplierDetails']))
    {
 
        $purchaseId =  $_POST['purchaseId'];
        $supplierId = $_POST["supplierId"];
  
        if(isset($_POST['supplierName']))
        {
            $supplierName =  $_POST['supplierName'];  
        }
        
        if(isset($_POST['supplierEmail']))
        {
        $supplierEmail =  $_POST['supplierEmail'];  
        }
        if(isset($_POST['supplierMobile']))
        {
        $supplierMobile = $_POST['supplierMobile'];    
        } 
        if(isset($_POST['purchaseType']))
        {
        $purchaseType =   $_POST['purchaseType']; 
        }
        if(isset($_POST['accNo'])){ $accNo = $_POST['accNo'];}
        if(isset($_POST['ifsccode'])){ $ifsccode = $_POST['ifsccode'];}
        if(isset($_POST['remarks'])){ $remarks = $_POST['remarks']; }
        $companyBranch = $_POST["companyBranch"];
        $executeUpdate = mysqli_query($dbconnection, "UPDATE `supplier_details` SET  `supplier_name` = '$supplierName', `supplier_email` = '$supplierEmail' ,`supplier_mobile` = '$supplierMobile' ,`supplier_branch` = '$companyBranch' ,`supplier_acc_no` = '$accNo' , `supplier_ifsc_code` = '$ifsccode' WHERE `cust_id` = '$supplierId' ");
        if($executeUpdate)
        {  
            $encrypt = passwordEncryption($purchaseId);
            header("location:../edit-purchase-request.php?platform=4iiirZa4xud5JuYOQ1JVp8h0GT8ODlfxhsEka8X4ZmVmN&fieldid=$encrypt&action=editpurchase");   
        } 
    }
    
    if (isset($_POST['raisePaymentRequest']))
    {  
        $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
        $adminRole = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_role']);
        $adminId = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_id']);   
      
      
 
 
        $addquery = "UPDATE `purchase_request` SET   `second_approval` = '1',`second_approved_by` = '$adminId' , `second_approval_time` = '$approvalTime' , `purchase_payment` = 1 WHERE `pur_id` = '$purchaseId' "; 
        $executeUpdate = mysqli_query($dbconnection, $addquery); 

        if($executeUpdate) 
        { 
            $insertquery = "INSERT INTO `purchase_history`(`purchase_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) 
            VALUES ('$purchaseId' , '1' , 'Payment Processed' , '$adminId','$adminRole' , '1' , 'Second Approval' , '$approvalTime' , '1')";
            $approveexecute = mysqli_query($dbconnection, $insertquery); 

            if($insertquery){  
                $selectpurchase = "SELECT * FROM `purchase_request` WHERE `pur_id` = '$purchaseId'";
                $executpurchase = mysqli_query($dbconnection,$selectpurchase);
                if(mysqli_num_rows($executpurchase) > 0){
                    if($row = mysqli_fetch_array($executpurchase)){
                        $PRName =   $row['pr_name'];
                        $projectTitle =  $row['project_title']; 
                        $supplierName = $row['supplier_name']; 
                        $supplierEmail = $row['supplier_email']; 
                        $supplierMobile = $row['supplier_mobile']; 
                        $paymentType = $row['purchase_type'];
                        $reason = $row['others'];
                        $amount = $row['total_amount'];
                        $advance = $row['advance_amount'];
                        $balance = $row['balance_amount'];
                        $amountWords = $row['amount_words'];
                        $PONum = $row['po_no'];
                        $billNo = $row['bill_no'];
                        $uniqueimage = $row['po_file'];
                        $teamleader = 0; 
                        $remarks = null; // Get from add purchase request 
                        $paymentAgainst = '2'; // Change the select option 
                        $payCode = 'PAY-'.hexdec(rand(100000, 999999));
                        $accNo = $row['supplier_accno'];
                        $ifsccode = $row['supplier_ifsccode']; 
                        $inchargeName = fetchData($dbconnection,'emp_name','admin_login','emp_id',$adminId);   
                        
                        $purchasepayment = '1';
                        $raisedBy = '2'; 
                        
                        $addquery = "INSERT INTO `payment_request` ( `pay_code`,`team_leader`,`incharge_name`, `company_name`,`bill_no`, `supplier_mobile`, `supplier_mail`, `reason`, `po_no`, `amount`, `amount_words`, `payment_type`, `payment_against`, `remarks`, `po_file`,  `acc_no`, `ifsc_code`, `created_by` ,`raised_by`,`purchase_payment`) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ,? , ? , ? , ? , ? , ? , ? ) ";
                        $stmt = $dbconnection->prepare($addquery) ;
                        $stmt->bind_param("ssssssssssssssssssss",$payCode,$teamleader,$inchargeName, $supplierName, $billNo, $supplierMobile, $supplierEmail, $reason, $PONum, $amount, $amountWords, $paymentType, $paymentAgainst, $remarks, $uniqueimage, $accNo, $ifsccode,$adminId,$raisedBy,$purchasepayment);
                        $executeadd = $stmt->execute(); 
 
                        $last_id = $dbconnection->insert_id;
                        if($paymentAgainst == '2' && !empty($last_id)){  
                            $uploaded_type = 'Bill';
                            $addpofile = "INSERT INTO `payment_pdf` (`pay_id`,`uploaded_type`,`po_filename`,`uploaded_by`,`total_amount`,`advance_amount`) VALUES ( '$last_id', '$uploaded_type', '$uniqueimage', '$adminId', '$amount', '$advance' ) ";
                            $executepofile = mysqli_query($dbconnection,$addpofile);   
                        }
                    }
                } 
            $_SESSION['purchaseSuccess']="Purchase To Payment Request Added Successfully";  
            header("location:../purchase-list.php");    
            }
            exit();  
        }else{
            $_SESSION['purchaseError']="Data Submit Error!!";   
            header("location:../purchase-list.php");   
            exit();   
        }
    }

 
    if(isset($_POST['approvepurchaseTeamLeader'])){
        $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
        $adminRole = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_role']);
        $adminId = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_id']);

        $approvalTime = date('Y-m-d H:i:s');
        $updatequery = "UPDATE `purchase_request` SET `orglead_approval` = '1', `orglead_approval_by` = '$adminId' , `orglead_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' "; 
        $executeUpdate = mysqli_query($dbconnection, $updatequery);

        if($adminRole == 11){
            $approvalType = 1;
            $approvalTypeText = 'Lead Approval';
            $colum1 = 'lead_approval';
            $colum2 = 'lead_approved_by';
            $colum3 = 'lead_approval_time';
            $insertquery = "INSERT INTO `purchase_history`(`purchase_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$purchaseId' , '1' , 'Approved' , '$adminId','$adminRole' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
            $approveexecute = mysqli_query($dbconnection, $insertquery);
        }
        
        if($executeUpdate){ 
            $_SESSION['purchaseSuccess']="Purchase Request Approved Successfully";   
            header("location:../purchase-list.php");  
            exit();  
        }
        else { 
            $_SESSION['purchaseError']="Data Submit Error!!";   
            header("location:../purchase-list.php");  
            exit();  
        }
    }

    if(isset($_POST['cancelpurchaseTeamLeader'])){
        $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
        $adminRole = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_role']);
        $adminId = mysqli_real_escape_string($dbconnection, $_POST['logged_admin_id']);

        $approvalTime = date('Y-m-d H:i:s');
        $updatequery = "UPDATE `purchase_request` SET `orglead_approval` = '4', `orglead_approval_by` = '$adminId' , `orglead_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' "; 
        $executeUpdate = mysqli_query($dbconnection, $updatequery);

        if($adminRole == 11){
            $approvalType = 1;
            $approvalTypeText = 'Lead Approval';
            $colum1 = 'lead_approval';
            $colum2 = 'lead_approved_by';
            $colum3 = 'lead_approval_time';
            $insertquery = "INSERT INTO `purchase_history`(`purchase_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$purchaseId' , '1' , 'Cancelled' , '$adminId','$adminRole' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
            $approveexecute = mysqli_query($dbconnection, $insertquery);
        }
        
        if($executeUpdate){ 
            $_SESSION['purchaseSuccess']="Purchase Request Cancelled Successfully";   
            header("location:../purchase-list.php");  
            exit();  
        }
        else { 
            $_SESSION['purchaseError']="Data Submit Error!!";   
            header("location:../purchase-list.php");  
            exit();  
        }

    }

    if(isset($_POST['uploadQuotation'])){ 
        $purchaseId =  $_POST['purchaseqoId'];
        $logged_admin_id =  $_POST['logged_admin_id'];
        $currentTime = date('Y-m-d H:i:s');  

        if (!empty($_FILES['quotationFile']['name'])) {
            echo 'echo '; 
            $image_name= '';
            $image_name = $_FILES['quotationFile']['name'];
            $pofile = uniqidReal(5).'_'.$image_name;
            $target_dir = "../assets/quotations/";
            $target_file = $target_dir . basename($pofile);
            $upload_success = move_uploaded_file($_FILES['quotationFile']['tmp_name'], $target_dir.$pofile); 
            
        $addquery = "INSERT INTO `quotation_table`(`purchase_id`, `quo_file`, `created_by`, `created_time`) VALUES (?,?,?,?)";

        $stmt = $dbconnection->prepare($addquery);   
        $stmt->bind_param("ssss",$purchaseId,$pofile,$logged_admin_id,$currentTime);  

         $executeadd = $stmt->execute();

           
       }
       $encrypt = passwordEncryption($purchaseId);
       $_SESSION['quotationMessage']="Upload Success"; 
       header("location:../edit-purchase-request.php?platform=4iiirZa4xud5JuYOQ1JVp8h0GT8ODlfxhsEka8X4ZmVmN&fieldid=$encrypt&action=editpurchase");   
    }