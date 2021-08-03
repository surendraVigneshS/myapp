<?php

include('./dbconfig.php');
include('./function.php');
include('./authenticate.php');
include('./createQR.php');
include('./createPDF.php');
require '../PHPMailer/src/Exception.php'; 
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
$poqrpath = "../assets/qr/po/";
$currentTime = date('Y-m-d H:i:s');


if (isset($_POST['addPurchaseOrder'])){ 
    if(isset($_POST['productid']) && !empty($_POST['productid'])){
        $curyear =  date("y");
        $curyear1 =  date("y") + 1;
        $purType = $_POST['purType'];
        $poDate = date('Y-m-d', strtotime($_POST['poDate']));
        // if(isset($_POST['poDueDate'])){ $poDueDate = date('Y-m-d', strtotime($_POST['poDueDate'])); } 
        $supplierID = $_POST['supplierID'];
        $itemType = $_POST['itemType'];  
        $remarks = $_POST['remarks'];   
        $finalNetAmount = $_POST['finalNetAmount'];  
        $transportName = $_POST['transportName'];  
        $transportMode = $_POST['transportMode'];  
        



        $ruppessWords = numtowords($finalNetAmount);
        if($purType == "Job Order"){ $arg1  = 'JO';  }else if($purType == "Purchase Order"){ $arg1  = 'PO'; }
        $lastcode = fetchlastestPOCode($dbconnection);
    
        
        if (empty($lastcode)) { 
            $lastcode =1;
            $arg2 = str_pad($lastcode, 4, "0", STR_PAD_LEFT);  
        } else { 
            $lastcode++; 
            $arg2 = str_pad($lastcode, 4, "0", STR_PAD_LEFT);   
        }
        
        $arg3 = $curyear.'-'.$curyear1;  
        $finalPOCode =  $arg1.'/'.$arg2.'/'.$arg3; 
    
        $porductcount = count($_POST['productid']);
        $taxamounts = $finalamounts = 0; 

        
    
        $addquery = "INSERT INTO `ft_po`(`po_type`, `po_code` ,`po_short_code`, `po_date`,`po_supplier_id`, `po_product_count`, `po_product_type`, `po_final_amount`,`po_remarks`,`amount_in_words`,`po_transport_name`,`po_transport_mode`,`po_created_by`, `po_created_time`) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
        $stmt = $dbconnection->prepare($addquery);
        $stmt->bind_param("ssssssssssssss", $purType, $finalPOCode,$lastcode,$poDate, $supplierID, $porductcount, $itemType,$finalNetAmount,$remarks,$ruppessWords,$transportName,$transportMode,$logged_admin_id,$currentTime);
        $executeadd = $stmt->execute();
        $poautoid = $dbconnection->insert_id;
        
        $poqr = createProductqr($poqrpath,$poautoid);
        mysqli_query($dbconnection,"UPDATE `ft_po` SET `po_qr_code`='$poqr' WHERE  `po_id`='$poautoid' ");
     
    
                foreach ($_POST['productid'] as $key => $value) 
                { 
                    $productname = $_POST['productname'][$key];
                    $productdesc = $_POST['productdesc'][$key];
                    $productqty = $_POST['productqty'][$key];
                    $productrate = $_POST['productrate'][$key];
                    $productdiscper = $_POST['productdiscper'][$key];
                    $productdiscamount = $_POST['productdiscamount'][$key];
                    $productfinamount = $_POST['productfinamount'][$key]; 
                    $addquery2 = "INSERT INTO `ft_po_details`(`po_id`, `po_product_id`, `po_product_name` ,`po_product_desc`, `po_product_qty`, `po_product_sub_amount`, `po_product_final_amount`, `po_product_disc_per`, `po_product_disc_amount`, `po_supplier_id`) VALUES (?,?,?,?,?,?,?,?,?,?)"; 
                    $stmt2 = $dbconnection->prepare($addquery2); 
                    $stmt2->bind_param("ssssssssss", $poautoid, $value,$productname,$productdesc,$productqty, $productrate, $productfinamount, $productdiscper, $productdiscamount,$supplierID); 
                    $executeadd2 = $stmt2->execute(); 
                    $finalamounts += $productfinamount;
                }
                
                foreach ($_POST["taxType"] as $key => $value) {
                    $taxName = $_POST['taxName'][$key];
                    $disctaxPercen = $_POST['disctaxPercen'][$key];
                    $disctaxAmount = $_POST['disctaxAmount'][$key]; 
                    $addquery3 = "INSERT INTO `ft_po_add_details`(`po_add_po_id`, `po_add_type`, `po_add_name`, `po_add_per`, `po_add_amount`) VALUES (?,?,?,?,?)"; 
                    $stmt3 = $dbconnection->prepare($addquery3);
                    $stmt3->bind_param("sssss",$poautoid, $value, $taxName,$disctaxPercen, $disctaxAmount);
                    $executeadd3 = $stmt3->execute(); 
                    $taxamounts += $disctaxAmount;
                }
                
                mysqli_query($dbconnection, "UPDATE `ft_po` SET `po_total_amount`='$finalamounts' ,  `po_additions_amount` = '$taxamounts'  WHERE  `po_id`='$poautoid' ");
    
               
                
        if ($executeadd) {

            foreach ($_POST["termsId"] as $key => $value) {
                $termsConditions = $_POST["content"][$key];
                $query = "INSERT INTO `ft_po_terms`(`ft_terms_po_id`, `ft_terms_id`, `ft_terms_content`) VALUES(?,?,?) "; 
                $stmt4 = $dbconnection->prepare($query);
                $stmt4->bind_param("sss",$poautoid,$value,$termsConditions);
                $executeadd3 = $stmt4->execute();   
            }
            
            $pofilegenereated =  createpofile($dbconnection, $poautoid);
            mysqli_query($dbconnection, "UPDATE `ft_po` SET `po_file`='$pofilegenereated' WHERE  `po_id`='$poautoid' ");
            mysqli_query($dbconnection, "INSERT INTO `ft_po_status`(`po_id`, `po_status_text`, `po_status`, `status_added_by`, `status_added_time`) VALUES ('$poautoid','PO Created',1,'$logged_admin_id','$currentTime')");


            $_SESSION['poOrderSuccess'] = "New Purchase Created Successfully";
            header("location:../po-list.php"); 
            exit();
        } else {
            $_SESSION['poOrderError'] = "Data Submit Error!!";
            header("location:../po-list.php"); 
            exit(); 
        }
    }else{
        $_SESSION['poOrderError'] = "Product Name Empty..PO Not Created";
        header("location:../po-list.php"); 
        exit();  
    } 
}

if (isset($_POST['updatePurchaseOrder'])){ 
    if(isset($_POST['productid']) && !empty($_POST['productid'])){
         
        $purType = $_POST['purType'];
        $poDate = date('Y-m-d', strtotime($_POST['poDate']));
        $supplierID = $_POST['supplierID'];
        $poautoid = $_POST['fieldid'];
        $itemType = $_POST['itemType'];  
        $remarks = $_POST['remarks'];   
        $finalNetAmount = $_POST['finalNetAmount'];   
        $ruppessWords = numtowords($finalNetAmount);
        
        $porductcount = count($_POST['productid']);
        $taxamounts = $finalamounts = 0; 
    
        $addquery = "UPDATE `ft_po` SET `po_type` = ?,`po_date`= ?,`po_supplier_id`= ?, `po_product_count`= ?, `po_product_type`= ?, `po_final_amount`= ?,`po_remarks`= ?,`amount_in_words`= ?,`po_updated_by` = ?, `po_updated_time` = ? WHERE `po_id` = ?"; 
        $stmt = $dbconnection->prepare($addquery);
        $stmt->bind_param("sssssssssss", $purType,$poDate, $supplierID, $porductcount, $itemType,$finalNetAmount,$remarks,$ruppessWords,$logged_admin_id,$currentTime,$poautoid);

        $executeadd = $stmt->execute();
        
        // if (!empty($_FILES['fileAttach']['name'])) {
        //     $image_name = $_FILES['fileAttach']['name'];
        //     $pofile = uniqidReal(5) . '_' . $image_name;
        //     $target_dir = "../assets/pdf/poattachment/";
        //     $target_file = $target_dir . basename($pofile);
        //     $upload_success = move_uploaded_file($_FILES['fileAttach']['tmp_name'], $target_dir . $pofile);
        //     mysqli_query($dbconnection, "UPDATE `ft_po` SET `po_file_attachment`='$pofile' WHERE  `po_id`='$poautoid' ");
        // } 
        
        if ($executeadd) {
            $pofilegenereated =  createpofile($dbconnection, $poautoid);
            mysqli_query($dbconnection, "UPDATE `ft_po` SET `po_file`='$pofilegenereated' WHERE  `po_id`='$poautoid' "); 
            mysqli_query($dbconnection, "DELETE FROM `ft_po_details` WHERE  `po_id`='$poautoid'");  
            mysqli_query($dbconnection, "DELETE FROM `ft_po_add_details` WHERE  `po_add_po_id`='$poautoid'");  
            foreach ($_POST['productid'] as $key => $value) 
            { 
                $productname = $_POST['productname'][$key];
                $productdesc = $_POST['productdesc'][$key];
                $productqty = $_POST['productqty'][$key];
                $productrate = $_POST['productrate'][$key];
                $productdiscper = $_POST['productdiscper'][$key];
                $productdiscamount = $_POST['productdiscamount'][$key];
                $productfinamount = $_POST['productfinamount'][$key]; 
                $addquery2 = "INSERT INTO `ft_po_details`(`po_id`, `po_product_id`, `po_product_name` ,`po_product_desc`, `po_product_qty`, `po_product_sub_amount`, `po_product_final_amount`, `po_product_disc_per`, `po_product_disc_amount`, `po_supplier_id`) VALUES (?,?,?,?,?,?,?,?,?,?)"; 
                $stmt2 = $dbconnection->prepare($addquery2);
                $stmt2->bind_param("ssssssssss", $poautoid, $value,$productname,$productdesc,$productqty, $productrate, $productfinamount, $productdiscper, $productdiscamount,$supplierID);
                $executeadd2 = $stmt2->execute();
                $finalamounts += $productfinamount;
            }
            
            foreach ($_POST["taxType"] as $key => $value) {
                $taxName = $_POST['taxName'][$key];
                $disctaxPercen = $_POST['disctaxPercen'][$key];
                $disctaxAmount = $_POST['disctaxAmount'][$key]; 
                $addquery3 = "INSERT INTO `ft_po_add_details`(`po_add_po_id`, `po_add_type`, `po_add_name`, `po_add_per`, `po_add_amount`) VALUES (?,?,?,?,?)"; 
                $stmt3 = $dbconnection->prepare($addquery3);
                $stmt3->bind_param("sssss",$poautoid, $value, $taxName,$disctaxPercen, $disctaxAmount);
                $executeadd3 = $stmt3->execute(); 
                $taxamounts += $disctaxAmount;
            }
            
            mysqli_query($dbconnection, "UPDATE `ft_po` SET `po_total_amount`='$finalamounts' ,  `po_additions_amount` = '$taxamounts'  WHERE  `po_id`='$poautoid' ");



            $_SESSION['poOrderSuccess'] = "Purchase Order Updated Successfully";
            $poautoid = passwordEncryption($poautoid); 
            header("location:../view-purchase-order.php?platform=6sLBDpHSbDM9JwXDRFtc3zawUkuFbBWbftU&fieldid=$poautoid"); 
            exit();
        } else {
            $_SESSION['poOrderError'] = "Data Submit Error!!";
            header("location:../po-list.php"); 
            exit(); 
        }
    }else{
        $_SESSION['poOrderError'] = "Product Name Empty..PO Not Created";
        header("location:../po-list.php"); 
        exit();  
    } 
}

if (isset($_POST['createPOFile'])){ 
    
        $poid = $_POST['poid']; 
        
        foreach ($_POST["termsId"] as $key => $value) {
            $termsConditions = $_POST["content"][$key];
            $query = "INSERT INTO `ft_po_terms`(`ft_terms_po_id`, `ft_terms_id`, `ft_terms_content`) VALUES(?,?,?) "; 
            $stmt3 = $dbconnection->prepare($query);
            $stmt3->bind_param("sss",$poid,$value,$termsConditions);
            $executeadd3 = $stmt3->execute();   
        }
        
        $pofilegenereated =  createpofile($dbconnection, $poid);
        mysqli_query($dbconnection, "UPDATE `ft_po` SET `po_file`='$pofilegenereated' WHERE  `po_id`='$poid' ");
    
        $ePoid = passwordEncryption($poid);      
        if ($executeadd3) {
            $_SESSION['createOrderSucc'] = "PO File Generated Successfully";
            header("location:../view-purchase-order.php?platform=mYId4KroUtZ8jW8wce2IP9L0MId4AltjuNK31MgPmLqAI&fieldid=$ePoid"); 
            exit();
        } else {
            $_SESSION['createOrderError'] = "Data Submit Error!!"; 
            // header("location:../view-purchase-order.php?platform=mYId4KroUtZ8jW8wce2IP9L0MId4AltjuNK31MgPmLqAI&fieldid=$ePoid"); 
            exit(); 
        }
      
}


if (isset($_POST['raisePurchaseOrder'])){ 
    if(isset($_POST['productid']) && !empty($_POST['productid'])){
        $curyear =  date("y");
        $curyear1 =  date("y") + 1;
        $purType = $_POST['purType'];
        $poDate = date('Y-m-d', strtotime($_POST['poDate']));
        $purchaseid = $_POST['fieldid'];
        $addedfrom = 2; 
        $supplierID = $_POST['supplierID'];
        $itemType = $_POST['itemType'];  
        $remarks = $_POST['remarks'];   
        $finalNetAmount = $_POST['finalNetAmount'];  
        $transportName = $_POST['transportName'];  
        $transportMode = $_POST['transportMode'];
        
        $ruppessWords = numtowords($finalNetAmount);
        if($purType == "Job Order"){ $arg1  = 'JO';  }else if($purType == "Purchase Order"){ $arg1  = 'PO'; }
        $lastcode = fetchlastestPOCode($dbconnection);
    
        
        if (empty($lastcode)) { 
            $lastcode =1;
            $arg2 = str_pad($lastcode, 4, "0", STR_PAD_LEFT);  
        } else { 
            $lastcode++; 
            $arg2 = str_pad($lastcode, 4, "0", STR_PAD_LEFT);   
        }
        
        $arg3 = $curyear.'-'.$curyear1;  
        $finalPOCode =  $arg1.'/'.$arg2.'/'.$arg3;  
        $porductcount = count($_POST['productid']);
        $taxamounts = $finalamounts = 0;  
        $addquery = "INSERT INTO `ft_po`(`po_type`, `po_code` ,`po_short_code`, `po_date`,`po_supplier_id`, `po_product_count`, `po_product_type`, `po_final_amount`,`po_remarks`,`amount_in_words`,`po_transport_name`,`po_transport_mode`,`po_created_by`, `po_created_time`,`po_pr_id`,`created_from`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
        $stmt = $dbconnection->prepare($addquery);
        $stmt->bind_param("ssssssssssssssss", $purType, $finalPOCode,$lastcode,$poDate, $supplierID, $porductcount, $itemType,$finalNetAmount,$remarks,$ruppessWords,$transportName,$transportMode,$logged_admin_id,$currentTime,$purchaseid,$addedfrom);
        $executeadd = $stmt->execute();
        $poautoid = $dbconnection->insert_id;
        
        $poqr = createProductqr($poqrpath,$poautoid);
        mysqli_query($dbconnection,"UPDATE `ft_po` SET `po_qr_code`='$poqr' WHERE  `po_id`='$poautoid' ");
    
    
        // if (!empty($_FILES['fileAttach']['name'])) {
        //     $image_name = $_FILES['fileAttach']['name'];
        //     $pofile = uniqidReal(5) . '_' . $image_name;
        //     $target_dir = "../assets/pdf/poattachment/";
        //     $target_file = $target_dir . basename($pofile);
        //     $upload_success = move_uploaded_file($_FILES['fileAttach']['tmp_name'], $target_dir . $pofile);
        //     mysqli_query($dbconnection, "UPDATE `ft_po` SET `po_file_attachment`='$pofile' WHERE  `po_id`='$poautoid' ");
        // } 
    
                foreach ($_POST['productid'] as $key => $value) 
                { 
                    $productname = $_POST['productname'][$key];
                    $productdesc = $_POST['productdesc'][$key];
                    $productqty = $_POST['productqty'][$key];
                    $productrate = $_POST['productrate'][$key];
                    $productdiscper = $_POST['productdiscper'][$key];
                    $productdiscamount = $_POST['productdiscamount'][$key];
                    $productfinamount = $_POST['productfinamount'][$key]; 
                    $addquery2 = "INSERT INTO `ft_po_details`(`po_id`, `po_product_id`, `po_product_name` ,`po_product_desc`, `po_product_qty`, `po_product_sub_amount`, `po_product_final_amount`, `po_product_disc_per`, `po_product_disc_amount`, `po_supplier_id`) VALUES (?,?,?,?,?,?,?,?,?,?)"; 
                    $stmt2 = $dbconnection->prepare($addquery2);
                    $stmt2->bind_param("ssssssssss", $poautoid, $value,$productname,$productdesc,$productqty, $productrate, $productfinamount, $productdiscper, $productdiscamount,$supplierID);
                    $executeadd2 = $stmt2->execute();
                    $finalamounts += $productfinamount;
                }
                
                if(isset($_POST["taxType"])){
                    foreach ($_POST["taxType"] as $key => $value) {
                        $taxName = $_POST['taxName'][$key];
                        $disctaxPercen = $_POST['disctaxPercen'][$key];
                        $disctaxAmount = $_POST['disctaxAmount'][$key]; 
                        $addquery3 = "INSERT INTO `ft_po_add_details`(`po_add_po_id`, `po_add_type`, `po_add_name`, `po_add_per`, `po_add_amount`) VALUES (?,?,?,?,?)"; 
                        $stmt3 = $dbconnection->prepare($addquery3);
                        $stmt3->bind_param("sssss",$poautoid, $value, $taxName,$disctaxPercen, $disctaxAmount);
                        $executeadd3 = $stmt3->execute(); 
                        $taxamounts += $disctaxAmount;
                    } 
                }
                
    mysqli_query($dbconnection,"UPDATE `ft_po` SET `po_total_amount`='$finalamounts' , `po_additions_amount` = '$taxamounts' WHERE `po_id`='$poautoid' ");        
        if ($executeadd) {

            foreach ($_POST["termsId"] as $key => $value) {
                $termsConditions = $_POST["content"][$key];
                $query = "INSERT INTO `ft_po_terms`(`ft_terms_po_id`, `ft_terms_id`, `ft_terms_content`) VALUES(?,?,?) "; 
                $stmt4 = $dbconnection->prepare($query);
                $stmt4->bind_param("sss",$poautoid,$value,$termsConditions);
                $executeadd3 = $stmt4->execute();   
            }
            
            $pofilegenereated =  createpofile($dbconnection, $poautoid);
            mysqli_query($dbconnection, "UPDATE `ft_po` SET `po_file`='$pofilegenereated' WHERE  `po_id`='$poautoid' "); 
            mysqli_query($dbconnection,"UPDATE `purchase_request` SET  `po_no` = '$finalPOCode',`po_file`='$pofilegenereated',`if_po_done`='1',`pr_po_convert`='2'  WHERE  `pur_id`='$purchaseid'"); 
            mysqli_query($dbconnection, "INSERT INTO `ft_po_status`(`po_id`, `po_status_text`, `po_status`, `status_added_by`, `status_added_time`) VALUES ('$poautoid','PO Created',1,'$logged_admin_id','$currentTime')");


            $_SESSION['poOrderSuccess'] = "New Purchase Created Successfully";
            header("location:../po-list.php"); 
            exit();
        } else {
            $_SESSION['poOrderError'] = "Data Submit Error!!";
            header("location:../po-list.php"); 
            exit(); 
        }
    }else{
        $_SESSION['poOrderError'] = "Product Name Empty..PO Not Created";
        header("location:../po-list.php"); 
        exit();  
    } 
}


if (isset($_POST['sendMailPO'])){ 
     
        $poid = $_POST["poid"];
        $mailSub = $_POST["emailSubject"];
        $mailBody = $_POST["emailBody"];
        $supMail = $_POST["supEmail"];
        $mailcc = "";
        // $supMail = "surendraworkacc@gmail.com";
     
        $pofile = fetchData($dbconnection,'po_file','ft_po','po_id',$poid);
        $pofilepath = "../assets/pdf/purchase/";
        $mailcc = implode(",",$_POST["mailccId"]);   
        
    
        $addquery = "INSERT INTO `ft_po_mail`(`po_id`, `mail_subject`, `mail_body`, `mail_cc`, `mail_sent_by`, `mail_sent_time`) VALUES(?,?,?,?,?,?)" or die($dbconnection->error);
        $stmt = $dbconnection->prepare($addquery) or die($dbconnection->error);
        $stmt->bind_param("ssssss",$poid,$mailSub,$mailBody,$mailcc,$logged_admin_id,$currentTime) or die($dbconnection->error);
        $executeadd = $stmt->execute() or die($dbconnection->error);

       
            $mail = new PHPMailer\PHPMailer\PHPMailer(); 
    
            $mail->SMTPDebug = 0;   
    
    
            $mail->isSMTP();                                      
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;                              
            $mail->SMTPSecure = 'ssl';  
            $mail->Username = 'mu3interactive@gmail.com';                   
            $mail->Password = 'Chottu@5050';          
            $mail->Port = 465;                        
            $mail->From = 'your@email.com';
            $mail->FromName = 'Freezetech Accounts Team';
            $mail->addAddress($supMail);        
            foreach ($_POST["mailccId"] as $key => $value) {
                $name = $_POST["mailccName"][$key]; 
                $mail->AddBcc($key, $name);          
            }         
            $mail->isHTML(true);                    
            
            $mail->Subject = $mailSub;
            $mail->Body    = $mailBody;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; 
            $mail->addAttachment($pofilepath.$pofile, $pofile);
            $mail->send(); 

            mysqli_query($dbconnection, "UPDATE `ft_po` SET `po_mail_sent`='1' WHERE  `po_id`='$poid' ");  

        if ($executeadd) {
            $poid = passwordEncryption($poid); 
            $_SESSION['createOrderSucc'] = "Mail Sent Successfully";
            header("location:../view-purchase-order.php?platform=6sLBDpHSbDM9JwXDRFtc3zawUkuFbBWbftU&fieldid=$poid"); 
            exit();
        } else {
            $_SESSION['createOrderError'] = "Data Submit Error!!";
            header("location:../view-purchase-order.php?platform=6sLBDpHSbDM9JwXDRFtc3zawUkuFbBWbftU&fieldid=$poid"); 
            exit(); 
        }
        
}

if (isset($_POST['addDcEntry'])){ 
     
        $poid = $_POST["poid"];
        $dcNO = $_POST["dcNO"];
        $expectedDate = date('Y-m-d', strtotime($_POST["expectedDate"]));
        $reminderAmount = $_POST["finalAmount"];
        $supid = $_POST["supid"];
        
        $addquery = "INSERT INTO `ft_po_dc`(`dc_no`, `dc_po_id`, `dc_date`, `dc_created_by`, `dc_created_time`) VALUES  (?,?,?,?,?)";
        $stmt = $dbconnection->prepare($addquery);
        $stmt->bind_param("sssss",$dcNO,$poid,$expectedDate,$logged_admin_id,$currentTime);
        $executeadd = $stmt->execute();
        
        mysqli_query($dbconnection,"UPDATE `ft_po` SET `po_dc_entry` = 1,`po_status` = 2 WHERE `po_id`='$poid'");

        mysqli_query($dbconnection, "INSERT INTO `ft_po_status`(`po_id`, `po_status_text`, `po_status`, `status_added_by`, `status_added_time`) VALUES ('$poid','Under Transit',2,'$logged_admin_id','$currentTime')");
        
        mysqli_query($dbconnection, "INSERT INTO `remainder`(`remainder_po_id`, `remainder_supplier_id`, `remainder_amount`, `remainder_type`, `remainder_created_by`, `remainder_created_time`, `remainder_status`, `remainder_date`) VALUES ('$poid','$supid','$reminderAmount',3,'$logged_admin_id','$currentTime' ,1,'$expectedDate')");

        if ($executeadd) {
            $poid = passwordEncryption($poid); 
            $_SESSION['createOrderSucc'] = "DC Entry Created Successfully";
            // header("location:../view-purchase-order.php?platform=6sLBDpHSbDM9JwXDRFtc3zawUkuFbBWbftU&fieldid=$poid"); 
            exit();
        } else {
            $_SESSION['createOrderError'] = "Data Submit Error!!";
            // header("location:../view-purchase-order.php?platform=6sLBDpHSbDM9JwXDRFtc3zawUkuFbBWbftU&fieldid=$poid"); 
            exit(); 
        }
        
}

if (isset($_POST['addSupInvoice'])){ 
     
        $poid = $_POST["poid"];
        $bilNO = $_POST["bilNO"];
         
        
        if (!empty($_FILES['billFile']['name'])) {
            $image_name = $_FILES['billFile']['name'];
            $billfile = uniqidReal(5) . '_' . $image_name;
            $target_dir = "../assets/pdf/purchase/";
            $target_file = $target_dir . basename($billfile);
            $upload_success = move_uploaded_file($_FILES['billFile']['tmp_name'], $target_dir . $billfile); 
        } 
    
        if($upload_success){
            $addquery = "UPDATE  `ft_po` SET `bill_no` = ?,`bill_file` = ? WHERE `po_id` = ? ";
            $stmt = $dbconnection->prepare($addquery);
            $stmt->bind_param("sss",$bilNO,$billfile,$poid);
            $executeadd = $stmt->execute();

            $prId = fetchData($dbconnection,'po_pr_id','ft_po','po_id',$poid);
            if(!empty($prId)){
                mysqli_query($dbconnection,"UPDATE `purchase_request` SET `bill_no` = '$bilNO' , `bill_file`='$billfile' WHERE `pur_id`= '$prId'");
            }
        }
        
         

        if ($upload_success) {
            $poid = passwordEncryption($poid); 
            $_SESSION['createOrderSucc'] = "Bill Uploaded  Successfully";
            header("location:../view-purchase-order.php?platform=6sLBDpHSbDM9JwXDRFtc3zawUkuFbBWbftU&fieldid=$poid"); 
            exit();
        } else {
            $_SESSION['createOrderError'] = "Data Submit Error!!";
            header("location:../view-purchase-order.php?platform=6sLBDpHSbDM9JwXDRFtc3zawUkuFbBWbftU&fieldid=$poid"); 
            exit(); 
        }
        
}