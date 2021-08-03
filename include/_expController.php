<?php

    include('./dbconfig.php');
    include('./function.php');  
    session_start();
    $approvalTime = date('Y-m-d H:i:s');  

    if (isset($_POST['addExpenditure']))
    {
        $logged_user_id = $_POST['logged_admin_id'];  
        $expName = $_POST['expName'];  
        $expamount = $_POST['expamount']; 
        $creditLeft = $_POST['postexpAmount']; 
        $totalAmount = $_POST['postexpAmount'] + $_POST['expamount'];
        $payid = $_POST['payid']; 
        $expDate = date('Y-m-d'); 

        $addquery = "INSERT INTO `expenditures` (`exp_name`, `exp_amount`, `exp_created_by`, `exp_created_time`,`exp_credit`,`exp_month`,`exp_credit_left`) VALUES ( ? , ? , ? , ? , ? , ? , ? )";
        $stmt = $dbconnection->prepare($addquery);
        $stmt->bind_param("sssssss", $expName, $expamount, $logged_user_id, $approvalTime, $totalAmount, $expDate, $creditLeft);
        $executeadd = $stmt->execute();

        $last_id = $dbconnection->insert_id;
        
        if (!empty($_FILES['expFiles']['name'])) {
            $image_name = '';
            $image_name = $_FILES['expFiles']['name'];
            $uniqueimage = time() . '_' . $image_name;
            $target_dir = "../assets/pdf/expenditure/";
            $target_file = $target_dir . basename($uniqueimage);
            $upload_success = move_uploaded_file($_FILES['expFiles']['tmp_name'], $target_dir . $uniqueimage);
        }

        if ($executeadd){
            $exeExpFiles = mysqLi_query($dbconnection,"UPDATE `expenditures` SET `exp_files` = '$uniqueimage' WHERE `exp_id` = '$last_id'");
            $updateexp = mysqli_query($dbconnection,"UPDATE `expenditure_amount` SET `total_credit` = '$creditLeft' WHERE `rasisd_for` = '$logged_user_id' AND `status` = 1 ORDER BY `amount_ID` DESC ");
            $_SESSION['expenditureSuccess'] = "Expense Added Successfully";
            header("location:../expenditure-list.php");
            exit();
        } else {
            $_SESSION['expenditureError'] = "Data Submit Error!!";
            header("location:../expenditure-list.php");
            exit();
        }
    }

    if(isset($_POST['approvedexpense'])){
        $approveall = '';
        $approveid = '';
        $logged_user_id = $_POST['logged_admin_id'];
        $logged_role = $_POST['logged_admin_role'];
        $created_id = $_POST['createdid'];
        if(isset($_POST['select_all'])){
            $approveall = $_POST['select_all'];
        }
        if($approveall == 1){
            $updatexp = "UPDATE `expenditures` SET `exp_approval_1` = '1', `exp_approval1_time` = '$approvalTime', `exp_approval1_by` = '$logged_user_id' WHERE `exp_created_by` = '$created_id' AND `exp_approval_1` = 0 ";
            $executeupdate = mysqli_query($dbconnection, $updatexp);
        }else if(isset($_POST['expenseid'])){
            $approveid = $_POST['expenseid'];
            foreach ($approveid as $value){
                $updatexp = "UPDATE `expenditures` SET `exp_approval_1` = '1', `exp_approval1_time` = '$approvalTime', `exp_approval1_by` = '$logged_user_id' WHERE `exp_id` = '$value' AND `exp_approval_1` = 0 ";
                $executeupdate = mysqli_query($dbconnection, $updatexp);
            }
        }
        if($executeupdate){
            $_SESSION['expenditureSuccess'] = "Expense Updated Successfully";
            header("location:../expenditure-list.php");
            exit();
        }else{
            $_SESSION['expenditureError'] = "Data Submit Error!!";
            header("location:../expenditure-list.php");
            exit();
        }
    }


    if(isset($_POST['closeExpense'])){
        $billno = '';
        $UTRno = '';
        $team_leader = '';
        $orgId = $_POST['OrgID'];
        $logged_id = $_POST['logged_admin_id'];
        $logged_role = $_POST['logged_admin_role'];

        if($orgId == 1){
            $team_leader = fetchData($dbconnection, 'team_leader', 'admin_login', 'emp_id', $logged_id);
        }
        if(isset($_POST['billNo'])){
            $billno = $_POST['billNo'];
        }
        if(isset($_POST['UTRNo'])){
            $UTRno = $_POST['UTRNo'];
        }
        if (!empty($_FILES['billfile']['name'])){
            $image_name = '';
            $image_name = $_FILES['billfile']['name'];
            $uniqueimage = time() . '_' . $image_name;
            $target_dir = "../assets/pdf/expenditure/";
            $target_file = $target_dir . basename($uniqueimage);
            $upload_success = move_uploaded_file($_FILES['billfile']['tmp_name'], $target_dir . $uniqueimage);
        }
        
        $addquery = "INSERT INTO `close_expenditure` (`org_name`, `team_leader`, `bill_no`, `UTR_no`, `upload_file`,`created_by`,`created_date`) VALUES ( ? , ? , ? , ? , ? , ? , ? )";
        $stmt = $dbconnection->prepare($addquery);
        $stmt->bind_param("sssssss", $orgId, $team_leader, $billno, $UTRno, $uniqueimage, $logged_id, $approvalTime);
        $executeadd = $stmt->execute();

        $last_id = $dbconnection->insert_id;

        if($logged_role == 3 || $logged_role == 11 || $logged_role == 7 || $logged_role == 4){
            $executeupdate = mysqli_query($dbconnection, "UPDATE `close_expenditure` SET `approve_status` = 1 WHERE `close_ID` = '$last_id' ");
        }

        if($logged_role == 6 || $logged_role == 3) {
            $updateraise = "UPDATE `close_expenditure` SET `raised_by` = 1 WHERE `close_ID` = '$last_id' ";
            $executeraise = mysqli_query($dbconnection, $updateraise);
        }else if($logged_role == 5 || $logged_role == 7) {
            $updateraise = "UPDATE `close_expenditure` SET `raised_by` = 2 WHERE `close_ID` = '$last_id' ";
            $executeraise = mysqli_query($dbconnection, $updateraise);
        }else{
            $updateraise = "UPDATE `close_expenditure` SET `raised_by` = 3 WHERE `close_ID` = '$last_id' ";
            $executeraise = mysqli_query($dbconnection, $updateraise);
        }

        if($executeadd){
            $_SESSION['expenditureSuccess'] = "Close Request Submitted Successfully";
            header("location:../expenditure-list.php");
            exit();
        }else{
            $_SESSION['expenditureError'] = "Data Submit Error!!";
            header("location:../expenditure-list.php");
            exit();
        }
    }

    

    if(isset($_POST['addExpense'])){
        $orgId = $_POST['OrgID'];
        $logged_id = $_POST['logged_admin_id'];
        $logged_role = $_POST['logged_admin_role'];
        $orgId = $_POST['OrgID'];


        $payCode = 'PAY-' . hexdec(rand(100000, 999999));
        $team_leader = 0;
        if($orgId == 1){
            $team_leader = fetchData($dbconnection, 'team_leader', 'admin_login', 'emp_id', $logged_id);
        }
        $inchargeName =  $_POST['logged_admin_name'];
        $companyName = $projectname = $billNo = $companyMobile = $companyEmail = $reason = $PONum = "";
        $amount = $_POST['amount'];
        $amountWords = getIndianCurrency($amount);
        $paymentType = 'Normal';
        $paymentAgainst = 9;
        $remarks = $_POST['remarks'];
        $gst = $gstNo = $accNo = $ifsccode = "";
        $executeapprove = "";


        $addquery = "INSERT INTO `payment_request` ( `pay_code`,`team_leader`,`incharge_name`, `company_name`, `org_name`, `project_title`, `bill_no`, `supplier_mobile`, `supplier_mail`, `reason`, `po_no`, `amount`, `amount_words`, `payment_type`, `payment_against`, `gst`, `gst_no`, `remarks`, `acc_no`, `ifsc_code`, `created_by` , `created_date`) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ) ";
        $stmt = $dbconnection->prepare($addquery) or die($dbconnection->error);
        $stmt->bind_param("ssssssssssssssssssssss", $payCode, $teamleaderid, $inchargeName, $companyName, $orgId, $projectname, $billNo, $companyMobile, $companyEmail, $reason, $PONum, $amount, $amountWords, $paymentType, $paymentAgainst, $gst, $gstNo, $remarks, $accNo, $ifsccode, $logged_id, $approvalTime);
        $executeadd = $stmt->execute() or die($dbconnection->error);

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
    
        if ($logged_role == 3  || $logged_role == 10 || $logged_role == 11) {
            $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeapprove = mysqli_query($dbconnection, $updateapprove);
        } else if ($logged_role == 7) {
            $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeapprove = mysqli_query($dbconnection, $updateapprove);
        } else if (($logged_role == 8 || $logged_role == 9 || $logged_role == 4 || $logged_role == 1)) {
            $updateapprove = "UPDATE `payment_request` SET `first_approval` = 1, `first_approval_by` = '$logged_id', `first_approval_time` = '$approvalTime', `second_approval` = 1, `second_approval_by` = '$logged_id', `second_approval_time` = '$approvalTime' WHERE `pay_id` = '$last_id' ";
            $executeapprove = mysqli_query($dbconnection, $updateapprove);
        }
        
        if (is_numeric($orgId)){
            $approval_arr = fetchOrgflow($dbconnection, $orgId, 1);
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
    
        if(!empty($orgId)){
            $selectflow = mysqli_query($dbconnection, "SELECT * FROM `payment_user_flow` WHERE `emp_id` = '$logged_id' AND `org_Id` = '$orgId'");
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
        

        if ($executeapprove && $logged_role != 6) {
            if (($logged_role == 3 || $logged_role == 7  || $logged_role == 10 || $logged_role == 11)) {
                $approvalType = 1;
                $approvalTypeText = 'First Approval';
                $colum1 = 'first_approval';
                $colum2 = 'first_approved_by';
                $colum3 = 'frist_approval_time';
            } else if (($logged_role == 8 || $logged_role == 4 || $logged_role == 9 ||  $logged_role == 1)) {
                $approvalType = 2;
                $approvalTypeText = 'Second Approval';
                $colum1 = 'second_approval';
                $colum2 = 'second_approved_by';
                $colum3 = 'second_approval_time';
            }
            $insertquery = "INSERT INTO `payment_history` (`payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$last_id' , '1' , 'Approved' , '$logged_id', '$logged_role', '$approvalType', '$approvalTypeText' , '$approvalTime' , '1')";
            $approveexecute = mysqli_query($dbconnection, $insertquery);
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
            $_SESSION['expenditureSuccess'] = "New Expenditure Request Added Successfully";
            header("location:../expenditure-list.php");
            exit();
        } else {
            $_SESSION['expenditureError'] = "Data Submit Error!!";
            header("location:../expenditure-list.php");
            exit();
        }
        

    }