<?php

include('./dbconfig.php');
include('./function.php');
include('./paymentSendMail.php');

$approvalTime = date('Y-m-d H:i:s');

session_start();
if (isset($_POST['addPayment'])) {
    $inchargeName =  $_POST['logged_admin_name'];
    $logged_id =  $_POST['logged_admin_id'];
    $logged_role =  $_POST['logged_admin_role'];
    $logged_org =  $_POST['logged_admin_org'];
    $teamleaderid = fetchData($dbconnection, 'team_leader', 'admin_login', 'emp_id', $logged_id);
    $companyName ='';
    if(isset($_POST['companyName'])){
        $companyName =   $_POST['companyName']; 
    }
    $projectname = "";
    if(isset($_POST['projectName'])){
        $projectname = $_POST['projectName'];
    }
    $companyEmail =  $_POST['companyEmail'];
    $companyMobile = $_POST['companyMobile'];
    $companyBranch = $_POST['companyBranch'];
    $ifsccode = $_POST['ifsccode'];
    // $reason = $_POST['reason'];
    $reason = "";
    $PONum = $_POST['PONum'];
    $amount = $_POST['amount'];
    $amountWords = $_POST['amountWords'];
    $accNo = $_POST['accNo'];
    $paymentType = $_POST['paymentType'];
    $paymentAgainst = $_POST['paymentAgainst'];
    $billNo = $_POST['billNo'];
    $remarks = mysqli_real_escape_string($dbconnection,$_POST['remarks']);
    $uniqueimage = null;
    $payCode = 'PAY-' . hexdec(rand(100000, 999999));
    $orgName = $_POST['orgName'];
    $otherorgName = '';
    $currentTime = date('Y-m-d H:i:s');
    $gstNo = '';

    if (isset($_POST['otherorgName'])) {
        $otherorgName = $_POST['otherorgName'];
    }

    if ($orgName == 3) {
        $orgName = $otherorgName;
    }

    $gst = $_POST['gstOption'];

    if (isset($_POST['gstNo'])) {
        $gstNo = $_POST['gstNo'];
    } 

    $executeapprove = "";


    if (!empty($_FILES['pofile']['name'])) {
        $image_name = '';
        $image_name = $_FILES['pofile']['name'];
        $uniqueimage = time() . '_' . $image_name;
        $target_dir = "../assets/pdf/payment/";
        $target_file = $target_dir . basename($uniqueimage);
        $upload_success = move_uploaded_file($_FILES['pofile']['tmp_name'], $target_dir . $uniqueimage);
    }

    if (!empty($_FILES['billfile']['name'])) {
        $image_name = '';
        $image_name = $_FILES['billfile']['name'];
        $uniqueimage = time() . '_' . $image_name;
        $target_dir = "../assets/pdf/payment/";
        $target_file = $target_dir . basename($uniqueimage);
        $upload_success = move_uploaded_file($_FILES['billfile']['tmp_name'], $target_dir . $uniqueimage);
    }

    $addquery = "INSERT INTO `payment_request` ( `pay_code`,`team_leader`,`incharge_name`, `company_name`, `org_name`, `project_title`, `bill_no`, `supplier_mobile`, `supplier_mail`, `supplier_branch`, `reason`, `po_no`, `amount`, `amount_words`, `payment_type`, `payment_against`, `gst`, `gst_no`, `remarks`, `acc_no`, `ifsc_code`, `created_by` , `created_date`) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ) ";
    $stmt = $dbconnection->prepare($addquery);
    $stmt->bind_param("sssssssssssssssssssssss", $payCode, $teamleaderid, $inchargeName, $companyName, $orgName, $projectname, $billNo, $companyMobile, $companyEmail, $companyBranch, $reason, $PONum, $amount, $amountWords, $paymentType, $paymentAgainst, $gst, $gstNo, $remarks, $accNo, $ifsccode, $logged_id, $currentTime);
    $executeadd = $stmt->execute();

    $last_id = $dbconnection->insert_id;

    if (($logged_role == 6 || $logged_role == 3)) {
        $updateraise = "UPDATE `payment_request` SET `raised_by` = 1 WHERE `pay_id` = '$last_id' ";
        $executeraise = mysqli_query($dbconnection, $updateraise);
    } else if (($logged_role == 5 || $logged_role == 7 || $logged_role == 1)) {
        $updateraise = "UPDATE `payment_request` SET `raised_by` = 2 WHERE `pay_id` = '$last_id' ";
        $executeraise = mysqli_query($dbconnection, $updateraise);
    } else {
        $updateraise = "UPDATE `payment_request` SET `raised_by` = 3 WHERE `pay_id` = '$last_id' ";
        $executeraise = mysqli_query($dbconnection, $updateraise);
    }

    if ($logged_role == 3  || $logged_role == 10) {
        $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeapprove = mysqli_query($dbconnection, $updateapprove);
    } else if ($logged_role == 7) {
        $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeapprove = mysqli_query($dbconnection, $updateapprove);
    } else if (($logged_role == 8 || $logged_role == 9 || $logged_role == 4 || $logged_role == 1)) {
        $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime', `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeapprove = mysqli_query($dbconnection, $updateapprove);
    }else if($logged_role == 11){
        $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime', `orglead_approval` = 1, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeapprove = mysqli_query($dbconnection, $updateapprove);
    }
    

    if (checkOrgStatus($dbconnection, $logged_id)) {
        $updateapprove1 = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime', `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeapprove1 = mysqli_query($dbconnection, $updateapprove1);
    }

    if($orgName == 1){
        $updateorgleadapprove = "UPDATE `payment_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeorgleadapprove = mysqli_query($dbconnection, $updateorgleadapprove);
    }else{
        $updateorgleadapprove = "UPDATE `payment_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeorgleadapprove = mysqli_query($dbconnection, $updateorgleadapprove);
    }

    
    if (is_numeric($orgName) && $orgName != 1){
        $approval_arr = fetchOrgflow($dbconnection, $orgName, 1);
        $orgfirstapproval = $approval_arr['approval1'];
        $orgleadapproval = $approval_arr['approval2'];
        $orgsecondapproval = $approval_arr['approval3'];
        $orgthirdapproval = $approval_arr['approval4'];
        $orgfourthapporval = $approval_arr['approval5'];
        if($orgfirstapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
        if($orgleadapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `orglead_approval` = 1, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
        if($orgsecondapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
        if($orgthirdapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `third_approval` = 1, `third_approval_by` = 7, `third_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
    }

    if(!empty($logged_org)){
        $selectflow = mysqli_query($dbconnection, "SELECT * FROM `payment_user_flow` WHERE `emp_id` = '$logged_id' AND `org_Id` = '$logged_org'");
        if(mysqli_num_rows($selectflow) > 0){
            if($row = mysqli_fetch_array($selectflow)){
                $firstapproval = $row['first_approval'];
                $orgleadapproval = $row['orglead_approval'];
                $secondapproval = $row['second_approval'];
                $thirdapproval = $row['third_approval'];
                $fourthapporval = $row['fourth_apporval'];
                if($firstapproval == 0){
                    $updatepayment = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executepayment = mysqli_query($dbconnection, $updatepayment);
                }
                if($orgleadapproval == 0){
                    $updateapprove = "UPDATE `payment_request` SET `orglead_approval` = 1, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executeapprove = mysqli_query($dbconnection, $updateapprove);
                }
                if($secondapproval == 0){
                    $updatepayment = "UPDATE `payment_request` SET `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executepayment = mysqli_query($dbconnection, $updatepayment);
                }
                if($thirdapproval == 0){
                    $updatepayment = "UPDATE `payment_request` SET `third_approval` = 1, `third_approval_by` = 7, `third_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executepayment = mysqli_query($dbconnection, $updatepayment);
                }
            }
        }
    }
    
    $approvalType = '';
    $approvalTypeText = '';


    if ($executeapprove) {
        if ($logged_role == 3 || $logged_role == 7  || $logged_role == 10 || $logged_role == 11){
            $approvalType = 1;
            $approvalTypeText = 'First Approval';
            $colum1 = 'first_approval';
            $colum2 = 'first_approved_by';
            $colum3 = 'frist_approval_time';
        }else if ($logged_role == 8 || $logged_role == 4 || $logged_role == 9 ||  $logged_role == 1) {
            $approvalType = 2;
            $approvalTypeText = 'Second Approval';
            $colum1 = 'second_approval';
            $colum2 = 'second_approved_by';
            $colum3 = 'second_approval_time';
        }
        if($logged_role !=6 || $logged_role != 5){
            $insertquery = "INSERT INTO `payment_history`(`payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$last_id' , '1' , 'Approved' , '$logged_id','$logged_role' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
            $approveexecute = mysqli_query($dbconnection, $insertquery);
        }
    }


    if ($paymentAgainst == 3 && !empty($last_id)) {
        $logged_id =  $_POST['logged_admin_id'];
        $advanceAmount = $_POST['advencAmount'];
        $balanceAmount = $_POST['balanceAmount'];
        $advancepaymentquery = "UPDATE `payment_request` SET `advanced_amonut` = '$advanceAmount', `balance_amount` = '$balanceAmount', `advance_step` = 0 WHERE `pay_id` = '$last_id' ";
        $executequery = mysqli_query($dbconnection, $advancepaymentquery);
        $uploaded_type = 'PO';
        $lastpaycode = fetchData($dbconnection, 'pay_code', 'payment_request', 'pay_id', $last_id);
        $addpofile = "INSERT INTO `payment_pdf` (`pay_id`,`pay_code`,`uploaded_type`,`po_filename`,`uploaded_by`,`total_amount`,`advance_amount`) VALUES ( ? , ? , ? , ? , ? , ? , ? ) ";
        $stmt = $dbconnection->prepare($addpofile);
        $stmt->bind_param("sssssss", $last_id, $lastpaycode, $uploaded_type, $uniqueimage, $logged_id, $amount, $advanceAmount);
        $executepofile = $stmt->execute();
    }
    if ($paymentAgainst != 3 && !empty($last_id)) {
        $logged_id =  $_POST['logged_admin_id'];
        $advanceAmount = 0;
        $uploaded_type = 'Bill';
        $lastpaycode = fetchData($dbconnection, 'pay_code', 'payment_request', 'pay_id', $last_id);
        $addpofile = "INSERT INTO `payment_pdf` (`pay_id`,`pay_code`,`uploaded_type`,`po_filename`,`uploaded_by`,`total_amount`,`advance_amount`) VALUES ( ? , ? , ? , ? , ? , ? , ? ) ";
        $stmt = $dbconnection->prepare($addpofile);
        $stmt->bind_param("sssssss", $last_id, $lastpaycode, $uploaded_type, $uniqueimage, $logged_id, $amount, $advanceAmount);
        $executepofile = $stmt->execute();
    }

    if ($executeadd) {
        if(!empty($companyName)){
            if (checkCompanyName($companyName, 'supplier_details', 'supplier_name', $dbconnection) == false) {
                $addcustquery = "INSERT INTO `supplier_details`(`supplier_name`, `supplier_email`, `supplier_mobile`, `supplier_branch`, `supplier_acc_no`,`supplier_ifsc_code`)  VALUES ( ? , ? , ? , ? , ? , ?) ";
                $stmt = $dbconnection->prepare($addcustquery);
                $stmt->bind_param("ssssss", $companyName, $companyEmail, $companyMobile, $companyBranch, $accNo, $ifsccode);
                $executecust = $stmt->execute();
            }
        }
    }

    if ($executeadd) {
        $_SESSION['paymentSuccess'] = "New Payment Request Added Successfully";
        header("location:../payment-list.php");
        exit();
    } else {
        $_SESSION['paymentError'] = "Data Submit Error!!";
        header("location:../payment-list.php");
        exit();
    }
}

if (isset($_POST['approvepaymentTeamLeader'])) {
    $inchargeName =  $_POST['logged_admin_name'];
    $teamleaderid =  $_POST['logged_admin_id'];
    $logged_role =  $_POST['logged_admin_role'];
    $pay_id =  $_POST['payid'];
    $payCode =  $_POST['paycode'];
    $companyName =   $_POST['companyName'];
    $companyEmail =  $_POST['companyEmail'];
    $companyMobile = $_POST['companyMobile'];
    $ifsccode = $_POST['ifsccode'];
    if(isset($_POST['followupCheck'])){
        $followup = $_POST['followupCheck'];
    }
    $amount = "";
    $amountWords = "";

    if ($logged_role == 4 || $logged_role == 9) {
        $previousadvance = fetchData($dbconnection, 'advanced_amonut', 'payment_request', 'pay_id', $pay_id);
        $previousbalance = fetchData($dbconnection, 'balance_amount', 'payment_request', 'pay_id', $pay_id);
    }else {
        $PONum = $_POST['PONum'];
        // $reason = $_POST['reason'];
        $reason = "";
        $amount = $_POST['amount'];
        if(isset($_POST['billNo'])){
            $billNo = $_POST['billNo'];
        }else{
            $billNo = "";
        }
        $remarks = mysqli_real_escape_string($dbconnection,$_POST['remarks']);
        $paymentType = $_POST['paymentType'];
    }

    if (noneditbalance($dbconnection, $payCode) == 1) {
        if(isset($_POST['amountWords'])){
            $amountWords = $_POST['amountWords'];
        }
    } else {
        $amountWords = fetchData($dbconnection, 'amount_words', 'payment_request', 'pay_id', $pay_id);
    }

    $accNo = $_POST['accNo'];
    $paymentAgainst = fetchData($dbconnection, 'payment_against', 'payment_request', 'pay_id', $pay_id);
    $uniqueimage = null;
    $refNo = NULL;
    if ($paymentAgainst == '3') {
        if ($logged_role == '4' || $logged_role == '9') {
            $advancepaymentquery = "UPDATE `payment_request` SET `advanced_amonut` = '$previousadvance', `balance_amount` = '$previousbalance' WHERE `pay_id` = '$pay_id' ";
            $executequery = mysqli_query($dbconnection, $advancepaymentquery);
        } else if ($logged_role != 4 || $logged_role != 9) {
            $logged_id =  $_POST['logged_admin_id'];
            $advance = $_POST['advencAmount'];
            $advanceAmount = $advance;
            $balanceAmount = $_POST['balanceAmount'];
            $amount = $_POST['amount'];
            $PurchasePayment = $_POST['purchasepayment'];
            $uploaded_type = 'PO';
            if (!empty($_FILES['pofile']['name'])) {
                $image_name = '';
                $image_name = $_FILES['pofile']['name'];
                $uniqueimage = time() . '_' . $image_name;
                if ($PurchasePayment == 1) {
                    $target_dir = "../assets/pdf/purchase/";
                } else {
                    $target_dir = "../assets/pdf/payment/";
                }
                $target_file = $target_dir . basename($uniqueimage);
                $upload_success = move_uploaded_file($_FILES['pofile']['tmp_name'], $target_dir . $uniqueimage);
                $updatepofile = "UPDATE `payment_pdf` SET `po_filename` = '$uniqueimage', `uploaded_by` = '$logged_id', `total_amount` = '$amount', `advance_amount` = '$advanceAmount' WHERE `pay_id` = '$pay_id' ";
                $executepofile = mysqli_query($dbconnection, $updatepofile);
            }
            $advancepaymentquery = "UPDATE `payment_request` SET `advanced_amonut` = '$advanceAmount', `balance_amount` = '$balanceAmount' WHERE `pay_id` = '$pay_id' ";
            $executequery = mysqli_query($dbconnection, $advancepaymentquery);

            //Update Query 
            if (isset($_POST['gstOption'])) {
                $gst = $_POST['gstOption'];
            }
            if (isset($_POST['gstNo'])) {
                if ($gst == 1) {
                    $gstNo = $_POST['gstNo'];
                } else {
                    $gstNo = '';
                }
            } else {
                $gstNo = '';
            }

            $updateorgrequest = "UPDATE `payment_request` SET `gst` = '$gst', `gst_no` = '$gstNo' WHERE `pay_id` = '$pay_id' ";
            $executeorgrequest = mysqli_query($dbconnection, $updateorgrequest);
        }
    }
    if (isset($_POST['refNo'])) {
        $refNo = $_POST['refNo'];
    }
    if ($paymentAgainst != 3) {
        $logged_id =  $_POST['logged_admin_id'];
        if (!empty($_FILES['pofile']['name'])) {
            $image_name = '';
            $image_name = $_FILES['pofile']['name'];
            $uniqueimage = time() . '_' . $image_name;
            $target_dir = "../assets/pdf/payment/";
            $target_file = $target_dir . basename($uniqueimage);
            $upload_success = move_uploaded_file($_FILES['pofile']['tmp_name'], $target_dir . $uniqueimage);
            $updatepoquery = "UPDATE `payment_pdf` SET `po_filename` = '$uniqueimage', `uploaded_by` = '$logged_id', `total_amount` = '$amount' WHERE `pay_id` = '$pay_id' ";
            $executepo = mysqli_query($dbconnection, $updatepoquery);
        } else {
            $updatepoquery = "UPDATE `payment_pdf` SET `total_amount` = '$amount' WHERE `pay_id` = '$pay_id' ";
            $executepo = mysqli_query($dbconnection, $updatepoquery);
        }
    }
    if ($logged_role == '3' || $logged_role == '7' || $logged_role == '1'  || $logged_role == '10') {
        $approvequery = "UPDATE `payment_request` SET `company_name` = '$companyName', `bill_no` = '$billNo', `supplier_mobile` = '$companyMobile', `supplier_mail` = '$companyEmail', `reason` = '$reason', `po_no`= '$PONum', `amount` = '$amount', `amount_words` = '$amountWords', `payment_type` = '$paymentType', `payment_against` = '$paymentAgainst', `remarks` = '$remarks', `acc_no` = '$accNo', `ifsc_code` = '$ifsccode', `first_approval` = '1', `first_approval_by` = '$teamleaderid', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
    }else if ($logged_role == '4' || $logged_role == '9') {
        $updatequery = "UPDATE `payment_request` SET `fourth_approval` = '1', `fourth_approval_by` = '$teamleaderid', `fourth_approval_time` = '$approvalTime', `utr_no` = '$refNo' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $updatequery);
    }else if ($logged_role == '5' || $logged_role == '6') {
        $updatequery = "UPDATE `payment_request` SET `company_name` = '$companyName', `bill_no` = '$billNo', `supplier_mobile` = '$companyMobile', `supplier_mail` = '$companyEmail', `reason` = '$reason', `po_no`= '$PONum', `amount` = '$amount', `amount_words` = '$amountWords', `payment_type` = '$paymentType', `payment_against` = '$paymentAgainst', `remarks` = '$remarks', `acc_no` = '$accNo', `ifsc_code` = '$ifsccode' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $updatequery);
    }else if($logged_role == '11'){
        $updatequery = "UPDATE `payment_request` SET `company_name` = '$companyName', `bill_no` = '$billNo', `supplier_mobile` = '$companyMobile', `supplier_mail` = '$companyEmail', `reason` = '$reason', `po_no`= '$PONum', `amount` = '$amount', `amount_words` = '$amountWords', `payment_type` = '$paymentType', `payment_against` = '$paymentAgainst', `remarks` = '$remarks', `acc_no` = '$accNo', `ifsc_code` = '$ifsccode', `orglead_approval` = '1', `orglead_approval_by` = '$teamleaderid', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $updatequery);
    }
    if ($logged_role == '8') {
        $approvequery = "UPDATE `payment_request` SET `second_approval` = '1', `second_approval_by` = '$teamleaderid', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
        $fetchorgName = fetchData($dbconnection, 'org_name','payment_request','pay_id',$pay_id);
        if($fetchorgName == 1){
            $updateorgleadapprove = "UPDATE `payment_request` SET `orglead_approval` = '1', `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id' ";
            $executeorgleadapprove = mysqli_query($dbconnection, $updateorgleadapprove);
        }
    }

    if (!empty($_FILES['accpofile']['name'])) {
        $image_name = '';
        $image_name = $_FILES['accpofile']['name'];

        $uniqueimage = time() . '_' . $image_name;
        $target_dir = "../assets/pdf/payment/";
        $target_file = $target_dir . basename($uniqueimage);
        $upload_success = move_uploaded_file($_FILES['accpofile']['tmp_name'], $target_dir . $uniqueimage);

        //Account Team Mail
        $mailsent = accountmailWA($dbconnection,$pay_id,$image_name,$target_file);

        $imageaddquery = "UPDATE `payment_request` SET `acc_po` = '$uniqueimage' WHERE `pay_id` = '$pay_id'";
        $executepdfadd = mysqli_query($dbconnection, $imageaddquery);
    }
    if ($executeupdate) {
        $approvalTime = date('Y-m-d H:i:s');
        if ($logged_role == 3) {
            $approvalType = 1;
            $approvalTypeText = 'First Approval';
            $colum1 = 'first_approval';
            $colum2 = 'first_approved_by';
            $colum3 = 'frist_approval_time';
        }else if ($logged_role == 11) {
            $approvalType = 2;
            $approvalTypeText = 'OrgLead Approval';
            $colum1 = 'orglead_approval';
            $colum2 = 'orglead_approved_by';
            $colum3 = 'orglead_approval_time';
        }else if ($logged_role == 8) {
            $approvalType = 2;
            $approvalTypeText = 'Second Approval';
            $colum1 = 'second_approval';
            $colum2 = 'second_approved_by';
            $colum3 = 'second_approval_time';
        }else if ($logged_role == 4 || $logged_role == 9) {
            $approvalType = 3;
            $approvalTypeText = 'Fourth Approval';
            $colum1 = 'fourth_approval';
            $colum2 = 'fourth_approved_by';
            $colum3 = 'fourth_approval_time';
        }else if ($logged_role == 7) {
            $approvalType = 1;
            $approvalTypeText = 'First Approval';
            $colum1 = 'first_approval';
            $colum2 = 'first_approved_by';
            $colum3 = 'frist_approval_time';
        }else if ($logged_role == 1) {
            $approvalType = 1;
            $approvalTypeText = 'First Approval';
            $colum1 = 'first_approval';
            $colum2 = 'first_approved_by';
            $colum3 = 'frist_approval_time';
        }else if ($logged_role == 5 || $logged_role == 6) {
            $approvalType = 0;
        }
        if ($approvalType == 1) {
            if (existapproved($dbconnection, $pay_id, '1') == 0) {
                $insertquery = "INSERT INTO `payment_history`(`payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$pay_id' , '1' , 'Approved' , '$teamleaderid','$logged_role' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
                $approveexecute = mysqli_query($dbconnection, $insertquery);
            }
        } else if ($approvalType == 2) {
            if (existapproved($dbconnection, $pay_id, '2') == 0) {
                $insertquery = "INSERT INTO `payment_history`(`payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$pay_id' , '1' , 'Approved' , '$teamleaderid','$logged_role' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
                $approveexecute = mysqli_query($dbconnection, $insertquery);
            }
        } else if ($approvalType == 3) {
            $insertquery = "INSERT INTO `payment_history`(`payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$pay_id' , '1' , 'Approved' , '$teamleaderid','$logged_role' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
            $approveexecute = mysqli_query($dbconnection, $insertquery);
        }
    }

    $value = "";

    // Code Added By --- Surendar --- Starts Here
    if (!empty($followup)) {
        foreach ($followup as $key => $value) {
            if ($value == 3) {
                $remianderAmount = fetchData($dbconnection, 'amount', 'payment_request', 'pay_id', $pay_id);
                $supplierID = fetchData($dbconnection, 'cust_id', 'supplier_details', 'supplier_name', $companyName);
                $exeFollowup = mysqli_query($dbconnection, "INSERT INTO `remainder`(`remainder_pay_id`,`remainder_amount`,`remainder_supplier_id`,`remainder_created_by`, `remainder_created_time`,`remainder_type`,`remainder_status`) VALUES ('$pay_id','$remianderAmount','$supplierID','$teamleaderid','$approvalTime',2,1)");
            } else{
                $exeFollowup = mysqli_query($dbconnection, "INSERT INTO `followup_payments`(`pay_id`, `followup_raised_by`, `followup_type`) VALUES ('$pay_id','$teamleaderid','$value')");
            }
        }
    }
    // Code Added By --- Surendar --- Ends Here

    $created_id = fetchData($dbconnection,'created_by','payment_request','pay_id',$pay_id);
    if($paymentAgainst == 9 || $value == 4){
        if($logged_role == 4 || $logged_role == 9){
            $exp_amount = $_POST['expamount'];
            $previoustotalexp = getPreviousExp($dbconnection,$created_id);
            if(empty($previoustotalexp)){
                $totalexp = $exp_amount;
            }else{
                $totalexp = $previoustotalexp + $exp_amount;
            }
            $inseramount = "INSERT INTO `expenditure_amount` (`pay_id`, `amount`, `rasisd_for`, `raised_date`, `total_credit`) VALUES ('$pay_id','$exp_amount','$created_id','$approvalTime','$totalexp') ";
            $executeexp = mysqli_query($dbconnection, $inseramount);
        }
    }

    if ($executeupdate) {
        if (checkCompanyName($companyName, 'supplier_details', 'supplier_name', $dbconnection) == true) {
            $addcustquery = "UPDATE `supplier_details` SET  `supplier_acc_no` = '$accNo', `supplier_ifsc_code` = '$ifsccode' WHERE `supplier_name` = '$companyName' ";
            $updateSupplier = mysqli_query($dbconnection, $addcustquery);
        }
        $_SESSION['paymentSuccess'] = "Payment Request Success Updated Successfully";
        header("location:../payment-list.php"); 
        exit();
    } else {
        $_SESSION['paymentError'] = "Data Submit Error!!";
        header("location:../payment-list.php"); 
        exit();
    }
}

if (isset($_POST['cancelpaymentTeamLeader'])) {

    $teamleaderid =  $_POST['logged_admin_id'];
    $logged_role =  $_POST['logged_admin_role'];
    $pay_id =  $_POST['payid'];
    if ($logged_role == '3' || $logged_role == '7'  || $logged_role == 10) {
        $approvequery = "UPDATE `payment_request` SET `first_approval` = '4', `first_approval_by` = '$teamleaderid', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
    }
    if ($logged_role == '4' || $logged_role == '9') {
        $approvequery = "UPDATE `payment_request` SET `fourth_approval` = '4', `fourth_approval_by` = '$teamleaderid', `fourth_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
    }
    if ($logged_role == '8' || $logged_role == '1') {
        $approvequery = "UPDATE `payment_request` SET `second_approval` = '4', `second_approval_by` = '$teamleaderid', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
    }
    if($logged_role == '11'){
        $approvequery = "UPDATE `payment_request` SET `orglead_approval` = '4', `orglead_approval_by` = '$teamleaderid', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
    }
    if ($executeupdate) {
        $approvalTime = date('Y-m-d H:i:s');
        if ($logged_role == 3 || $logged_role == 7) {
            $approvalType = 4;
            $approvalTypeText = 'First Approval';
            $colum1 = 'first_approval';
            $colum2 = 'first_approved_by';
            $colum3 = 'frist_approval_time';
        }else if ($logged_role == 11) {
            $approvalType = 4;
            $approvalTypeText = 'OrgLead Approval';
            $colum1 = 'orglead_approval';
            $colum2 = 'orglead_approved_by';
            $colum3 = 'orglead_approval_time';
        }else if ($logged_role == 4 || $logged_role == 9) {
            $approvalType = 4;
            $approvalTypeText = 'Fourth Approval';
            $colum1 = 'fourth_approval';
            $colum2 = 'fourth_approved_by';
            $colum3 = 'fourth_approval_time';
        } else if ($logged_role == 8 || $logged_role == 1) {
            $approvalType = 4;
            $approvalTypeText = 'Second Approval';
            $colum1 = 'second_approval';
            $colum2 = 'second_approved_by';
            $colum3 = 'second_approval_time';
        }
        $insertquery = "INSERT INTO `payment_history`(`payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$pay_id' , '1' , 'Cancelled' , '$teamleaderid','$logged_role' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
        $approveexecute = mysqli_query($dbconnection, $insertquery);
    }
    if ($approveexecute) {
        $_SESSION['paymentSuccess'] = "Payment Request Success Updated Successfully";
        header("location:../payment-list.php");
        exit();
    } else {
        $_SESSION['paymentError'] = "Data Submit Error!!";
        header("location:../payment-list.php");
        exit();
    }
}

if (isset($_POST['updateAdvancepayment'])) {
    $inchargeName =  $_POST['logged_admin_name'];
    $logged_id =  $_POST['logged_admin_id'];
    $logged_role =  $_POST['logged_admin_role'];
    $logged_org =  $_POST['logged_admin_org'];
    $advance = $_POST['advencAmount'];
    $payid = $_POST['payid'];

    //New Payment Request
    $payCode = fetchData($dbconnection, 'pay_code', 'payment_request', 'pay_id', $payid);
    $teamleaderid = fetchData($dbconnection, 'team_leader', 'payment_request', 'pay_id', $payid);
    $inchargeName = fetchData($dbconnection, 'incharge_name', 'payment_request', 'pay_id', $payid);
    $paymentType = fetchData($dbconnection, 'payment_type', 'payment_request', 'pay_id', $payid);
    $orgName = fetchData($dbconnection, 'org_name', 'payment_request', 'pay_id', $payid);
    $projectname = fetchData($dbconnection, 'project_title', 'payment_request', 'pay_id', $payid);
    $previoustotal = $_POST['amount'];
    $companyName =   $_POST['companyName'];
    $companyEmail =  $_POST['companyEmail'];
    $companyMobile = $_POST['companyMobile'];
    $ifsccode = $_POST['ifsccode'];
    $reason = NULL;
    $PONum = $_POST['PONum'];
    $billNo = NULL;
    $remarks = NULL;
    $accNo = $_POST['accNo'];
    $ifsccode = $_POST['ifsccode'];
    $amountWords = fetchData($dbconnection, 'amount_words', 'payment_request', 'pay_id', $payid);
    $raiseBy = fetchData($dbconnection, 'raised_by', 'payment_request', 'pay_id', $payid);
    if (isset($_POST['billNo'])) {
        $billNo = $_POST['billNo'];
    }
    $previousadvance = fetchData($dbconnection, 'advanced_amonut', 'payment_request', 'pay_id', $payid);
    $advanceAmount = $previousadvance + $advance;
    $balanceAmount = $_POST['balanceAmount'];
    $amount = $_POST['amount'];
    $uniqueimage = null;
    $PurchasePayment = $_POST['purchasepayment'];
    $uploaded_type = 'Bill';
    if (!empty($_FILES['pofile']['name'])) {
        $image_name = '';
        $image_name = $_FILES['pofile']['name'];
        $uniqueimage = time() . '_' . $image_name;
        if ($PurchasePayment == 1) {
            $target_dir = "../assets/pdf/purchase/";
        } else {
            $target_dir = "../assets/pdf/payment/";
        }
        $target_file = $target_dir . basename($uniqueimage);
        $upload_success = move_uploaded_file($_FILES['pofile']['tmp_name'], $target_dir . $uniqueimage);
        $addbillfile = "INSERT INTO `payment_pdf` (`pay_id`,`pay_code`,`uploaded_type`,`po_filename`,`uploaded_by`,`total_amount`,`advance_amount`) VALUES ( ? , ? , ? , ? , ? , ? , ? ) ";
        $stmt = $dbconnection->prepare($addbillfile);
        $stmt->bind_param("sssssss", $payid, $payCode, $uploaded_type, $uniqueimage, $logged_id, $amount, $advanceAmount);
        $executepofile = $stmt->execute();
    }

    $paymentAgainst = 3;

    $PreviousadvanceStep = fetchData($dbconnection, 'advance_step', 'payment_request', 'pay_id', $payid);
    $advanceStepCount = $PreviousadvanceStep + 1;


    $addquery = "INSERT INTO `payment_request` ( `pay_code`,`team_leader`,`incharge_name`, `company_name`, `org_name`, `project_title`, `bill_no`, `supplier_mobile`, `supplier_mail`, `reason`, `po_no`, `amount`, `advanced_amonut`, `advance_step`, `balance_amount`, `amount_words`, `payment_type`, `payment_against`, `remarks`, `acc_no`, `ifsc_code`, `created_by`, `raised_by`) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?  , ? , ? , ? , ? , ? , ? ) ";
    $stmt = $dbconnection->prepare($addquery);
    $stmt->bind_param("sssssssssssssssssssssss", $payCode, $teamleaderid, $inchargeName, $companyName, $orgName, $projectname, $billNo, $companyMobile, $companyEmail, $reason, $PONum, $previoustotal, $advance, $advanceStepCount, $balanceAmount, $amountWords, $paymentType, $paymentAgainst, $remarks, $accNo, $ifsccode, $logged_id, $raiseBy) or die($dbconnection->error);
    $executeadd = $stmt->execute() or die($dbconnection->error);

    $last_id = $dbconnection->insert_id;

    if ($orgName == '2') {
        $updateapprove2 = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime', `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeapprove2 = mysqli_query($dbconnection, $updateapprove2);
    }

    if (!empty($last_id)) {
        $uploaded_type = 'PO';
        $lastpaycode = fetchData($dbconnection, 'pay_code', 'payment_request', 'pay_id', $last_id);
        $addpofile = "INSERT INTO `payment_pdf` (`pay_id`,`pay_code`,`uploaded_type`,`po_filename`,`uploaded_by`,`total_amount`,`advance_amount`) VALUES ( ? , ? , ? , ? , ? , ? , ? ) ";
        $stmt = $dbconnection->prepare($addpofile);
        $stmt->bind_param("sssssss", $last_id, $lastpaycode, $uploaded_type, $uniqueimage, $logged_id, $amount, $advanceAmount);
        $executepofile = $stmt->execute();
    }

    if (!empty($last_id)){
        if ($logged_role == 3) {
            $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeapprove = mysqli_query($dbconnection, $updateapprove);
        } else if ($logged_role == 7) {
            $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeapprove = mysqli_query($dbconnection, $updateapprove);
        } else if (($logged_role == 8 || $logged_role == 4 || $logged_role == 1 || $logged_role == 9)) {
            $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime', `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeapprove = mysqli_query($dbconnection, $updateapprove);
        }
    }

    if($orgName == 1){
        $updateorgleadapprove = "UPDATE `payment_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeorgleadapprove = mysqli_query($dbconnection, $updateorgleadapprove);
    }else{
        $updateorgleadapprove = "UPDATE `payment_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeorgleadapprove = mysqli_query($dbconnection, $updateorgleadapprove);
    }
    
    if (is_numeric($orgName)){
        $approval_arr = fetchOrgflow($dbconnection, $orgName, 1);
        $orgfirstapproval = $approval_arr['approval1'];
        $orgleadapproval = $approval_arr['approval2'];
        $orgsecondapproval = $approval_arr['approval3'];
        $orgthirdapproval = $approval_arr['approval4'];
        $orgfourthapporval = $approval_arr['approval5'];
        if($orgfirstapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
        if($orgleadapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `orglead_approval` = 1, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
        if($orgsecondapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
        if($orgthirdapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `third_approval` = 1, `third_approval_by` = 7, `third_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
    }

    if(!empty($logged_org)){
        $selectflow = mysqli_query($dbconnection, "SELECT * FROM `payment_user_flow` WHERE `emp_id` = '$logged_id' AND `org_Id` = '$logged_org'");
        if(mysqli_num_rows($selectflow) > 0){
            if($row = mysqli_fetch_array($selectflow)){
                $firstapproval = $row['first_approval'];
                $orgleadapproval = $row['orglead_approval'];
                $secondapproval = $row['second_approval'];
                $thirdapproval = $row['third_approval'];
                $fourthapporval = $row['fourth_apporval'];
                if($firstapproval == 0){
                    $updatepayment = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executepayment = mysqli_query($dbconnection, $updatepayment);
                }
                if($orgleadapproval == 0){
                    $updateapprove = "UPDATE `payment_request` SET `orglead_approval` = 1, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executeapprove = mysqli_query($dbconnection, $updateapprove);
                }
                if($secondapproval == 0){
                    $updatepayment = "UPDATE `payment_request` SET `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executepayment = mysqli_query($dbconnection, $updatepayment);
                }
                if($thirdapproval == 0){
                    $updatepayment = "UPDATE `payment_request` SET `third_approval` = 1, `third_approval_by` = 7, `third_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executepayment = mysqli_query($dbconnection, $updatepayment);
                }
            }
        }
    }

    if ($executeapprove) {
        if (($logged_role == 3 || $logged_role == 7  || $logged_role == 10 || $logged_role == 11)) {
            $approvalType = 1;
            $approvalTypeText = 'First Approval';
            $colum1 = 'first_approval';
            $colum2 = 'first_approved_by';
            $colum3 = 'frist_approval_time';
        } else if (($logged_role == 8 || $logged_role == 4 || $logged_role == 1 || $logged_role == 9)) {
            $approvalType = 2;
            $approvalTypeText = 'Second Approval';
            $colum1 = 'second_approval';
            $colum2 = 'second_approved_by';
            $colum3 = 'second_approval_time';
        }
        $insertquery = "INSERT INTO `payment_history`(`payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$last_id' , '1' , 'Approved' , '$logged_id','$logged_role' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
        $approveexecute = mysqli_query($dbconnection, $insertquery);
    }


    if ($executeadd) {
        $_SESSION['paymentSuccess'] = "Payment Request Updated Successfully";
        header("location:../payment-list.php");
        exit();
    } else {
        $_SESSION['paymentError'] = "Data Submit Error!!";
        header("location:../payment-list.php");
        exit();
    }
}

if (isset($_POST['uploadbillfile'])) {

    $logged_id =  $_POST['logged_admin_id'];
    $advance = $_POST['advencAmount'];
    $payid = $_POST['payid'];
    $billNo = $_POST['billNo'];
    $payCode = fetchData($dbconnection, 'pay_code', 'payment_request', 'pay_id', $payid);
    $previousadvance = fetchData($dbconnection, 'advanced_amonut', 'payment_request', 'pay_id', $payid);
    $advanceAmount = $previousadvance + $advance;
    $balanceAmount = $_POST['balanceAmount'];
    $amount = $_POST['amount'];
    $uniqueimage = null;
    $PurchasePayment = $_POST['purchasepayment'];
    $uploaded_type = 'Bill';
    $executeupdate = mysqli_query($dbconnection, "UPDATE `payment_request` SET `bill_no` = '$billNo' WHERE `pay_id` = '$payid' ");
    if (!empty($_FILES['pofile']['name'])) {
        $image_name = '';
        $image_name = $_FILES['pofile']['name'];
        $uniqueimage = time() . '_' . $image_name;
        if ($PurchasePayment == 1) {
            $target_dir = "../assets/pdf/purchase/";
        } else {
            $target_dir = "../assets/pdf/payment/";
        }
        $target_file = $target_dir . basename($uniqueimage);
        $upload_success = move_uploaded_file($_FILES['pofile']['tmp_name'], $target_dir . $uniqueimage);
        $addbillfile = "INSERT INTO `payment_pdf` (`pay_id`,`pay_code`,`uploaded_type`,`po_filename`,`uploaded_by`,`total_amount`,`advance_amount`) VALUES ( ? , ? , ? , ? , ? , ? , ? ) ";
        $stmt = $dbconnection->prepare($addbillfile);
        $stmt->bind_param("sssssss", $payid, $payCode, $uploaded_type, $uniqueimage, $logged_id, $amount, $advanceAmount);
        $executepofile = $stmt->execute();
    }
    if ($executepofile) {
        $_SESSION['paymentSuccess'] = "Payment Request Updated Successfully";
        header("location:../payment-list.php");
        exit();
    } else {
        $_SESSION['paymentError'] = "Data Submit Error!!";
        header("location:../payment-list.php");
        exit();
    }
}


if (isset($_POST['ResubmitPaymentRequest'])) {
    $inchargeName =  $_POST['logged_admin_name'];
    $logged_id =  $_POST['logged_admin_id'];
    $logged_role =  $_POST['logged_admin_role'];
    $logged_org =  $_POST['logged_admin_org'];
    $teamleaderid = fetchData($dbconnection, 'team_leader', 'admin_login', 'emp_id', $logged_id);
    $companyName =   $_POST['companyName'];
    $companyEmail =  $_POST['companyEmail'];
    $companyMobile = $_POST['companyMobile'];
    $ifsccode = $_POST['ifsccode']; 
    // $reason = mysqli_real_escape_string($dbconnection,$_POST['reason']);
    $reason = "";
    $PONum = $_POST['PONum'];
    $amount = $_POST['amount'];
    $amountWords = $_POST['amountWords'];
    $accNo = $_POST['accNo'];
    $paymentType = $_POST['paymentType'];
    $orgName = $_POST['orgName'];
    $otherorgName = '';

    if (isset($_POST['otherorgName'])) {
        $otherorgName = $_POST['otherorgName'];
    }

    $projectname = "";
    if(isset($_POST['projectName'])){
        $projectname = $_POST['projectName'];
    }


    if ($orgName == 3) {
        $orgName = $otherorgName;
    }

    if (empty($_POST['paymentAgainst'])) {
        $paymentAgainst = 3;
    } else {
        $paymentAgainst = $_POST['paymentAgainst'];
    }
    $billNo = $_POST['billNo'];
    $remarks = mysqli_real_escape_string($dbconnection,$_POST['remarks']);
    
    $uniqueimage = null;
    $payCode = 'PAY-' . hexdec(rand(100000, 999999));

    $gst = $_POST['gstOption'];
    if ($_POST['gstNo']) {
        $gstNo = $_POST['gstNo'];
    } else {
        $gstNo = '';
    }

    if (!empty($_FILES['pofile']['name'])) {
        $image_name = '';
        $image_name = $_FILES['pofile']['name'];
        $uniqueimage = time() . '_' . $image_name;
        $target_dir = "../assets/pdf/payment/";
        $target_file = $target_dir . basename($uniqueimage);
        $upload_success = move_uploaded_file($_FILES['pofile']['tmp_name'], $target_dir . $uniqueimage);
    }

    if (!empty($_FILES['billfile']['name'])) {
        $image_name = '';
        $image_name = $_FILES['billfile']['name'];
        $uniqueimage = time() . '_' . $image_name;
        $target_dir = "../assets/pdf/payment/";
        $target_file = $target_dir . basename($uniqueimage);
        $upload_success = move_uploaded_file($_FILES['billfile']['tmp_name'], $target_dir . $uniqueimage);
    }

    $addquery = "INSERT INTO `payment_request` ( `pay_code`,`team_leader`, `incharge_name`, `company_name`, `org_name`, `project_title`, `bill_no`, `supplier_mobile`, `supplier_mail`, `reason`, `po_no`, `amount`, `amount_words`, `payment_type`, `payment_against`, `gst`, `gst_no`, `remarks`, `acc_no`, `ifsc_code`, `created_by`) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ) ";
    $stmt = $dbconnection->prepare($addquery);
    $stmt->bind_param("sssssssssssssssssssss", $payCode, $teamleaderid, $inchargeName, $companyName, $orgName, $projectname, $billNo, $companyMobile, $companyEmail, $reason, $PONum, $amount, $amountWords, $paymentType, $paymentAgainst, $gst, $gstNo, $remarks, $accNo, $ifsccode, $logged_id);
    $executeadd = $stmt->execute();

    $last_id = $dbconnection->insert_id;

    if ($logged_role == 6 || $logged_role == 3  || $logged_role == 10) {
        $updateraise = "UPDATE `payment_request` SET `raised_by` = 1 WHERE `pay_id` = '$last_id' ";
        $executeraise = mysqli_query($dbconnection, $updateraise);
    } else if (($logged_role == 5 || $logged_role == 7 || $logged_role == 1)) {
        $updateraise = "UPDATE `payment_request` SET `raised_by` = 2 WHERE `pay_id` = '$last_id' ";
        $executeraise = mysqli_query($dbconnection, $updateraise);
    } else {
        $updateraise = "UPDATE `payment_request` SET `raised_by` = 3 WHERE `pay_id` = '$last_id' ";
        $executeraise = mysqli_query($dbconnection, $updateraise);
    }

    if ($paymentAgainst == 3 && !empty($last_id)) {
        $logged_id =  $_POST['logged_admin_id'];
        $advanceAmount = $_POST['advencAmount'];
        $balanceAmount = $_POST['balanceAmount'];
        $advancepaymentquery = "UPDATE `payment_request` SET `advanced_amonut` = '$advanceAmount', `balance_amount` = '$balanceAmount' WHERE `pay_id` = '$last_id' ";
        $executequery = mysqli_query($dbconnection, $advancepaymentquery);
        $uploaded_type = 'PO';
        $lastpaycode = fetchData($dbconnection, 'pay_code', 'payment_request', 'pay_id', $last_id);
        $addpofile = "INSERT INTO `payment_pdf` (`pay_id`,`pay_code`,`uploaded_type`,`po_filename`,`uploaded_by`,`total_amount`,`advance_amount`) VALUES ( ? , ? , ? , ? , ? , ? , ? ) ";
        $stmt = $dbconnection->prepare($addpofile);
        $stmt->bind_param("sssssss", $last_id, $lastpaycode, $uploaded_type, $uniqueimage, $logged_id, $amount, $advanceAmount);
        $executepofile = $stmt->execute();
    }
    if ($paymentAgainst != 3 && !empty($last_id)) {
        $logged_id =  $_POST['logged_admin_id'];
        $advanceAmount = 0;
        $uploaded_type = 'Bill';
        $lastpaycode = fetchData($dbconnection, 'pay_code', 'payment_request', 'pay_id', $last_id);
        $addpofile = "INSERT INTO `payment_pdf` (`pay_id`,`pay_code`,`uploaded_type`,`po_filename`,`uploaded_by`,`total_amount`,`advance_amount`) VALUES ( ? , ? , ? , ? , ? , ? , ? ) ";
        $stmt = $dbconnection->prepare($addpofile);
        $stmt->bind_param("sssssss", $last_id, $lastpaycode, $uploaded_type, $uniqueimage, $logged_id, $amount, $advanceAmount);
        $executepofile = $stmt->execute();
    }

    $executeapprove = "";

    if($orgName == 1){
        if (!empty($last_id)) {
            if ($logged_role == 3 || $logged_role == 11) {
                $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                $executeapprove = mysqli_query($dbconnection, $updateapprove);
            } else if ($logged_role == 7) {
                $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                $executeapprove = mysqli_query($dbconnection, $updateapprove);
            } else if (($logged_role == 8 || $logged_role == 4 || $logged_role == 1 || $logged_role == 9)) {
                $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime', `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                $executeapprove = mysqli_query($dbconnection, $updateapprove);
            }
        }
    }

    if($orgName == 1){
        $updateorgleadapprove = "UPDATE `payment_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeorgleadapprove = mysqli_query($dbconnection, $updateorgleadapprove);
    }else{
        $updateorgleadapprove = "UPDATE `payment_request` SET `orglead_approval` = 2, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeorgleadapprove = mysqli_query($dbconnection, $updateorgleadapprove);
    }
    
    if (is_numeric($orgName)){
        $approval_arr = fetchOrgflow($dbconnection, $orgName, 1);
        $orgfirstapproval = $approval_arr['approval1'];
        $orgleadapproval = $approval_arr['approval2'];
        $orgsecondapproval = $approval_arr['approval3'];
        $orgthirdapproval = $approval_arr['approval4'];
        $orgfourthapporval = $approval_arr['approval5'];
        if($orgfirstapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
        if($orgleadapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `orglead_approval` = 1, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
        if($orgsecondapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
        if($orgthirdapproval == 0){
            $updateorgflowapprove = "UPDATE `payment_request` SET `third_approval` = 1, `third_approval_by` = 7, `third_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeorgflowapprove = mysqli_query($dbconnection, $updateorgflowapprove);
        }
    }

    if(!empty($logged_org)){
        $selectflow = mysqli_query($dbconnection, "SELECT * FROM `payment_user_flow` WHERE `emp_id` = '$logged_id' AND `org_Id` = '$logged_org'");
        if(mysqli_num_rows($selectflow) > 0){
            if($row = mysqli_fetch_array($selectflow)){
                $firstapproval = $row['first_approval'];
                $orgleadapproval = $row['orglead_approval'];
                $secondapproval = $row['second_approval'];
                $thirdapproval = $row['third_approval'];
                $fourthapporval = $row['fourth_apporval'];
                if($firstapproval == 0){
                    $updatepayment = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executepayment = mysqli_query($dbconnection, $updatepayment);
                }
                if($orgleadapproval == 0){
                    $updateapprove = "UPDATE `payment_request` SET `orglead_approval` = 1, `orglead_approval_by` = '$logged_id', `orglead_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executeapprove = mysqli_query($dbconnection, $updateapprove);
                }
                if($secondapproval == 0){
                    $updatepayment = "UPDATE `payment_request` SET `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executepayment = mysqli_query($dbconnection, $updatepayment);
                }
                if($thirdapproval == 0){
                    $updatepayment = "UPDATE `payment_request` SET `third_approval` = 1, `third_approval_by` = 7, `third_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
                    $executepayment = mysqli_query($dbconnection, $updatepayment);
                }
            }
        }
    }

    if ($executeapprove) {
        if (($logged_role == 3 || $logged_role == 7  || $logged_role == 10 || $logged_role == 11)) {
            $approvalType = 1;
            $approvalTypeText = 'First Approval';
            $colum1 = 'first_approval';
            $colum2 = 'first_approved_by';
            $colum3 = 'frist_approval_time';
        } else if (($logged_role == 8 || $logged_role == 4 || $logged_role == 1 || $logged_role == 9)) {
            $approvalType = 2;
            $approvalTypeText = 'Second Approval';
            $colum1 = 'second_approval';
            $colum2 = 'second_approved_by';
            $colum3 = 'second_approval_time';
        }
        $insertquery = "INSERT INTO `payment_history`(`payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$last_id' , '1' , 'Approved' , '$logged_id','$logged_role' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
        $approveexecute = mysqli_query($dbconnection, $insertquery);
    }

    if ($orgName == '2') {
        $updateapprove2 = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime', `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
        $executeapprove2 = mysqli_query($dbconnection, $updateapprove2);
    }

    if (!empty($last_id) && $executeadd) {
        $pay_id = $_POST['paymentid'];
        $updaterequest = "UPDATE `payment_request` SET `resubmit` = '1',`resubmit_by` = '$logged_id' WHERE `pay_id` = '$pay_id' ";
        $executerequest = mysqli_query($dbconnection, $updaterequest);
    }

    if ($executeadd) {
        if (checkCompanyName($companyName, 'supplier_details', 'supplier_name', $dbconnection) == false) {
            $addcustquery = "INSERT INTO `supplier_details`(`supplier_name`, `supplier_email`, `supplier_mobile`,`supplier_acc_no`,`supplier_ifsc_code`)  VALUES ( ? , ? , ? , ?  , ?) ";
            $stmt = $dbconnection->prepare($addcustquery);
            $stmt->bind_param("sssss", $companyName,   $companyEmail, $companyMobile, $accNo, $ifsccode);
            $executecust = $stmt->execute();
        }
    }

    if ($executeadd) {

        $_SESSION['paymentSuccess'] = "New Payment Request Added Successfully";
        header("location:../payment-list.php");
        exit();
    } else {
        $_SESSION['paymentError'] = "Data Submit Error!!";
        header("location:../payment-list.php");
        exit();
    }
}


if(isset($_POST['cancelpaymentAny'])){
    $teamleaderid =  $_POST['logged_admin_id'];
    $logged_role =  $_POST['logged_admin_role'];
    $pay_id =  $_POST['payid'];
    if($logged_role == '6' || $logged_role == '5'){
        $approvequery = "UPDATE `payment_request` SET `user_cancel` = '4', `user_cancel_by` = '$teamleaderid', `user_cancel_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
    }   
    if ($logged_role == '3' || $logged_role == '7'  || $logged_role == 10) {
        $approvequery = "UPDATE `payment_request` SET `first_approval` = '4', `first_approval_by` = '$teamleaderid', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
    }
    if ($logged_role == '4' || $logged_role == '9') {
        $approvequery = "UPDATE `payment_request` SET `fourth_approval` = '4', `fourth_approval_by` = '$teamleaderid', `fourth_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
    }
    if ($logged_role == '8' || $logged_role == '1') {
        $approvequery = "UPDATE `payment_request` SET `second_approval` = '4', `second_approval_by` = '$teamleaderid', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
    }
    if ($executeupdate) {
        $approvalTime = date('Y-m-d H:i:s');
        if ($logged_role == 6) {
            $approvalType = 1;
            $approvalTypeText = 'User Approval';
            $colum1 = 'User_approval';
            $colum2 = 'user_approved_by';
            $colum3 = 'user_approval_time';
        }else if ($logged_role == 3 || $logged_role == 7 || $logged_role == 11) {
            $approvalType = 1;
            $approvalTypeText = 'First Approval';
            $colum1 = 'first_approval';
            $colum2 = 'first_approved_by';
            $colum3 = 'frist_approval_time';
        }else if ($logged_role == 4 || $logged_role == 9) {
            $approvalType = 4;
            $approvalTypeText = 'Fourth Approval';
            $colum1 = 'fourth_approval';
            $colum2 = 'fourth_approved_by';
            $colum3 = 'fourth_approval_time';
        } else if ($logged_role == 8 || $logged_role == 1) {
            $approvalType = 4;
            $approvalTypeText = 'Second Approval';
            $colum1 = 'second_approval';
            $colum2 = 'second_approved_by';
            $colum3 = 'second_approval_time';
        }
        $insertquery = "INSERT INTO `payment_history`(`payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$pay_id' , '1' , 'Cancelled' , '$teamleaderid','$logged_role' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
        $approveexecute = mysqli_query($dbconnection, $insertquery);
    }
    if ($approveexecute) {
        $_SESSION['paymentSuccess'] = "Payment Request Success Updated Successfully";
        header("location:../payment-list.php");
        exit();
    } else {
        $_SESSION['paymentError'] = "Data Submit Error!!";
        header("location:../payment-list.php");
        exit();
    }
}
