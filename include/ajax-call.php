<?php

include('./dbconfig.php');
include('./function.php');
include('./paymentSendMail.php');

if (isset($_POST['admin_login'])) {
    $email_ID = mysqli_real_escape_string($dbconnection, $_POST['email']);
    $password = mysqli_real_escape_string($dbconnection, $_POST['password']);
    $accesslevel = mysqli_real_escape_string($dbconnection, $_POST['access']);

    if (checkUser('admin_login', $email_ID, $accesslevel, $dbconnection)) {
        $encrypt_password = passwordEncryption($password);
        $userselect = "SELECT * FROM `admin_login` WHERE `emp_email` = '$email_ID' AND `emp_password` = '$encrypt_password' AND   `emp_role` = '$accesslevel'";
        $userquery = mysqli_query($dbconnection, $userselect);
        if (mysqli_num_rows($userquery) > 0) {
            if ($row = mysqli_fetch_array($userquery)) {
                $emp_status = $row['emp_status'];
                if ($emp_status ==  1) {
                    ini_set('session.cookie_lifetime', 2147483647);
                    ini_set('session.gc-maxlifetime', 2147483647);
                    session_start();
                    $_SESSION["accountsauthenticated"] = true;
                    $_SESSION['emp_id'] = $row['emp_id'];
                    $_SESSION['emp_name'] = $row['emp_name'];
                    $_SESSION['emp_role'] = $row['emp_role'];
                    $_SESSION['emp_org'] = $row['emp_org'];
                    $_SESSION['emp_dep_type'] = $row['emp_dep_type'];

                    $errorcode =  '200';
                    $errorMessage = 'Logged In Successfully';

                    $data = array('errorCode' => $errorcode, 'errorMessage' => $errorMessage);
                    echo json_encode($data);
                } else {
                    $errorcode =  '100';
                    $errorMessage = 'Your Access has been revoked by Admin';

                    $data = array('errorCode' => $errorcode, 'errorMessage' => $errorMessage);
                    echo json_encode($data);
                }
            }
        } else {
            $errorcode =  '100';
            $errorMessage = 'Password Does not Match';

            $data = array('errorCode' => $errorcode, 'errorMessage' => $errorMessage);
            echo json_encode($data);
        }
    } else {
        $errorcode =  '100';
        $errorMessage = 'User Not Found';

        $data = array('errorCode' => $errorcode, 'errorMessage' => $errorMessage);
        echo json_encode($data);
    }
}

if (isset($_POST['approvePurchase'])) {
    $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
    $adminRole = mysqli_real_escape_string($dbconnection, $_POST['adminRole']);
    $adminId = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $approvalTime = date('Y-m-d H:i:s');

    //MD Purchase Approved Mail
    $userid = fetchData($dbconnection, 'created_by', 'purchase_request', 'pur_id', $purchaseId);
    $purchasecode = fetchData($dbconnection, 'purchase_code', 'purchase_request', 'pur_id', $purchaseId);
    $useremail = fetchData($dbconnection, 'emp_email', 'admin_login', 'emp_id', $userid);
    $username = fetchData($dbconnection, 'emp_name', 'admin_login', 'emp_id', $userid);



    if ($adminRole == 2) {
        $approvalType = 1;
        $approvalTypeText = 'First Approval';
        $colum1 = 'first_approval';
        $colum2 = 'first_approved_by';
        $colum3 = 'frist_approval_time';
    } else if ($adminRole == 5) {
        $approvalType = 2;
        $approvalTypeText = 'Second Approval';
        $colum1 = 'second_approval';
        $colum2 = 'second_approved_by';
        $colum3 = 'second_approval_time';
    } else if ($adminRole == 4) {
        $approvalType = 3;
        $approvalTypeText = 'Third Approval';
        $colum1 = 'third_approval';
        $colum2 = 'third_approved_by';
        $colum3 = 'third_approval_time';
    }

    $query = "UPDATE `purchase_request` SET `first_approval` = '1',`first_approved_by` = '$adminId' , `frist_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' " or die(mysqli_error($dbconnection));
    $approveexecute = mysqli_query($dbconnection, $query) or die(mysqli_error($dbconnection));
    $fetchorgName = fetchData($dbconnection, 'org_name', 'purchase_request', 'pur_id', $purchaseId);
    if ($fetchorgName == 1) {
        $updateorgleadapprove = "UPDATE `purchase_request` SET `orglead_approval` = '1', `orglead_approval_by` = '25', `orglead_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' ";
        $executeorgleadapprove = mysqli_query($dbconnection, $updateorgleadapprove);
    }
    if ($approveexecute) {
        //MD Approved Mail
        if (!empty($useremail) && !empty($username)) {
            // mdpurchaseapprovemail($useremail,$purchasecode,$username,'1');
        }
        $insertquery = "INSERT INTO `purchase_history`(`purchase_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) 
        VALUES ('$purchaseId' , '1' , 'Approved' , '$adminId','$adminRole' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')" or die(mysqli_error($dbconnection));
        $approveexecute = mysqli_query($dbconnection, $insertquery) or die(mysqli_error($dbconnection));
        echo "1";
    } else {
        echo "fail";
    }
}

if (isset($_POST['approveAlreadyPurchase'])) {
    $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
    $adminRole = mysqli_real_escape_string($dbconnection, $_POST['adminRole']);
    $adminId = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $approvalTime = date('Y-m-d H:i:s');

    //MD Purchase Approved Mail
    $userid = fetchData($dbconnection, 'created_by', 'purchase_request', 'pur_id', $purchaseId);
    $purchasecode = fetchData($dbconnection, 'purchase_code', 'purchase_request', 'pur_id', $purchaseId);
    $useremail = fetchData($dbconnection, 'emp_email', 'admin_login', 'emp_id', $userid);
    $username = fetchData($dbconnection, 'emp_name', 'admin_login', 'emp_id', $userid);



    if ($adminRole == 2) {
        $approvalType = 1;
        $approvalTypeText = 'First Approval';
        $colum1 = 'first_approval';
        $colum2 = 'first_approved_by';
        $colum3 = 'frist_approval_time';
    } else if ($adminRole == 5) {
        $approvalType = 2;
        $approvalTypeText = 'Second Approval';
        $colum1 = 'second_approval';
        $colum2 = 'second_approved_by';
        $colum3 = 'second_approval_time';
    } else if ($adminRole == 4) {
        $approvalType = 3;
        $approvalTypeText = 'Third Approval';
        $colum1 = 'third_approval';
        $colum2 = 'third_approved_by';
        $colum3 = 'third_approval_time';
    }

    $query = "UPDATE `purchase_request` SET `first_approval` = '1',`first_approved_by` = '$adminId' , `frist_approval_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' ";
    $approveexecute = mysqli_query($dbconnection, $query) or die(mysqli_error($dbconnection));
    if ($approveexecute) {
        //MD Approved Mail
        if (!empty($useremail) && !empty($username)) {
            // mdpurchaseapprovemail($useremail,$purchasecode,$username,'1');
        }
        $insertquery = "INSERT INTO `purchase_history`(`purchase_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) 
        VALUES ('$purchaseId' , '1' , 'Approved' , '$adminId','$adminRole' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
        $approveexecute = mysqli_query($dbconnection, $insertquery);
        echo "1";
    } else {
        echo "fail";
    }
}

if (isset($_POST['disapprovMDPurchase'])) {
    $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
    $adminRole = mysqli_real_escape_string($dbconnection, $_POST['adminRole']);
    $adminId = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $cancelReason = mysqli_real_escape_string($dbconnection, $_POST['cancelReason']);
    $approvalTime = date('Y-m-d H:i:s');


    $query = "UPDATE `purchase_request` SET `first_approval` = '4',`first_approved_by` = '$adminId' ,`cancelled_by` ='$adminId' ,`cancel_reason` = '$cancelReason', `cancelled_admin_role` = '$adminRole' , `cancelled_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' " or die(mysqli_error($dbconnection));
    $approveexecute = mysqli_query($dbconnection, $query) or die(mysqli_error($dbconnection));
    if ($approveexecute) {
        $insertquery = "INSERT INTO `purchase_history`(`purchase_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) 
        VALUES ('$purchaseId' , '1' , 'Cancelled' , '$adminId','$adminRole' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')" or die(mysqli_error($dbconnection));
        $approveexecute = mysqli_query($dbconnection, $insertquery) or die(mysqli_error($dbconnection));
        echo "1";
    } else {
        echo "fail";
    }
}


if (isset($_POST['disApprovePurchase'])) {
    $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
    $adminRole = mysqli_real_escape_string($dbconnection, $_POST['adminRole']);
    $adminId = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $approvalTime = date('Y-m-d H:i:s');

    if ($adminRole == 5) {
        $approvalType = 1;
        $approvalTypeText = 'First Approval';
        $colum1 = 'first_approval';
        $colum2 = 'first_approved_by';
        $colum3 = 'frist_approval_time';
    } else if ($adminRole == 2) {
        $approvalType = 2;
        $approvalTypeText = 'Second Approval';
        $colum1 = 'second_approval';
        $colum2 = 'second_approved_by';
        $colum3 = 'second_approval_time';
    } else if ($adminRole == 4) {
        $approvalType = 3;
        $approvalTypeText = 'Third Approval';
        $colum1 = 'third_approval';
        $colum2 = 'third_approved_by';
        $colum3 = 'third_approval_time';
    }

    $query = "UPDATE `purchase_request` SET `$colum1` = '4',`$colum2` = '$adminId' , `$colum3` = '$approvalTime' WHERE `pur_id` = '$purchaseId' " or die(mysqli_error($dbconnection));
    $approveexecute = mysqli_query($dbconnection, $query) or die(mysqli_error($dbconnection));
    if ($approveexecute) {
        mysqli_query($dbconnection, "UPDATE `purchase_history` SET `status` = 0 WHERE  `purchase_id`='$purchaseId'");
        $insertquery = "INSERT INTO `purchase_history`(`purchase_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) 
        VALUES ('$purchaseId' , '4' , 'Cancelled' , '$adminId','$adminRole' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')" or die(mysqli_error($dbconnection));
        $approveexecute = mysqli_query($dbconnection, $insertquery) or die(mysqli_error($dbconnection));
        echo "1";
    } else {
        echo "fail";
    }
}

if (isset($_POST['disFinalApprovePurchase'])) {
    $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
    $adminRole = mysqli_real_escape_string($dbconnection, $_POST['adminRole']);
    $adminId = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $cancelReason = mysqli_real_escape_string($dbconnection, $_POST['cancelReason']);
    $approvalTime = date('Y-m-d H:i:s');

    if ($adminRole == 5) {
        $approvalType = 1;
        $approvalTypeText = 'First Approval';
        $colum1 = 'first_approval';
        $colum2 = 'first_approved_by';
        $colum3 = 'frist_approval_time';
    } else if ($adminRole == 2) {
        $approvalType = 2;
        $approvalTypeText = 'Second Approval';
        $colum1 = 'second_approval';
        $colum2 = 'second_approved_by';
        $colum3 = 'second_approval_time';
    } else if ($adminRole == 4) {
        $approvalType = 3;
        $approvalTypeText = 'Third Approval';
        $colum1 = 'third_approval';
        $colum2 = 'third_approved_by';
        $colum3 = 'third_approval_time';
    }

    $query = "UPDATE `purchase_request` SET `$colum1` = '4',`$colum2` = '$adminId' , `$colum3` = '$approvalTime' , `cancel_reason` = '$cancelReason' ,`cancelled_by` ='$adminId', `cancelled_admin_role` ='$adminRole' WHERE `pur_id` = '$purchaseId' " or die(mysqli_error($dbconnection));
    $approveexecute = mysqli_query($dbconnection, $query) or die(mysqli_error($dbconnection));
    if ($approveexecute) {
        mysqli_query($dbconnection, "UPDATE `purchase_history` SET `status` = 0 WHERE  `purchase_id`='$purchaseId'");
        $insertquery = "INSERT INTO `purchase_history`(`purchase_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) 
        VALUES ('$purchaseId' , '4' , 'Cancelled' , '$adminId','$adminRole' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')" or die(mysqli_error($dbconnection));
        $approveexecute = mysqli_query($dbconnection, $insertquery) or die(mysqli_error($dbconnection));
        echo "1";
    } else {
        echo "fail";
    }
}

if (isset($_POST['ajaxData'])) {
    $purid = $_POST['purchaseId'];
    $sql = "SELECT * FROM `purchased_products` LEFT JOIN `ft_product_master` ON `ft_product_master`.`product_id` = `purchased_products`.`pr_product_id` WHERE  `purchased_products`.`pr_purchase_id`='$purid'";
    $resultset = mysqli_query($dbconnection, $sql);

    $output = '<table cellpadding="5" cellspacing="0" border="1" style="padding-left:10px;">
        <tr>
        <th>Product Name</th>   
        <th>Specification</th>   
        <th>Qty</th>   
        </tr>
';
    while ($row = mysqli_fetch_assoc($resultset)) {

        $output .= '
        <tr> 
        <td>' . $row['product_name'] . '</td>  
        <td>' . $row['product_specification'] . '</td>  
        <td>' . $row['pr_qty'] . '</td>  
        </tr>
';
    }
    $output .= '</table>';
    echo $output;
}


if (isset($_POST['approvePayment'])) {
    $pay_id = mysqli_real_escape_string($dbconnection, $_POST['paymentId']);
    $logged_role = mysqli_real_escape_string($dbconnection, $_POST['adminRole']);
    $teamleaderid = mysqli_real_escape_string($dbconnection, $_POST['adminId']);

    //MD Payment Approved Mail
    $userid = fetchData($dbconnection, 'created_by', 'payment_request', 'pay_id', $pay_id);
    $useremail = fetchData($dbconnection, 'emp_email', 'admin_login', 'emp_id', $userid);


    $expamount = fetchData($dbconnection, 'amount', 'payment_request', 'pay_id', $pay_id);
    $paymentAgainst = fetchData($dbconnection, 'payment_against', 'payment_request', 'pay_id', $pay_id);

    if ($paymentAgainst == 9) {
        $expAmountUpdate = mysqli_query($dbconnection, "UPDATE `payment_request` SET `expenditure_amount` = '$expamount' , `expenditure_status` = 1 WHERE `pay_id` = '$pay_id'");
    }


    $approvalTime = date('Y-m-d H:i:s');
    if ($logged_role == '2') {
        $approvequery = "UPDATE `payment_request` SET `third_approval` = '1', `third_approval_by` = '$teamleaderid', `third_approval_time` = '$approvalTime' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
    }
    if ($executeupdate && $logged_role == '2') {
        $approvalTime = date('Y-m-d H:i:s');
        if ($logged_role == 2) {
            $approvalType = 3;
            $approvalTypeText = 'Thrid Approval';
            $colum1 = 'third_approval';
            $colum2 = 'third_approved_by';
            $colum3 = 'third_approval_time';
        }
        $insertquery = "INSERT INTO `payment_history`(`payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$pay_id' , '1' , 'Approved' , '$teamleaderid','$logged_role' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
        $approveexecute = mysqli_query($dbconnection, $insertquery);

        //MD Approved Mail
        if (!empty($useremail)) {
            // mdpaymentapprovemail($dbconnection,$useremail,$pay_id,'1');
        }
        if ($approveexecute) {
            echo "1";
        }
    } else {
        echo "fail";
    }
}


if (isset($_POST['FinalApprovePayment'])) {
    $pay_id = mysqli_real_escape_string($dbconnection, $_POST['paymentId']);
    $logged_role = mysqli_real_escape_string($dbconnection, $_POST['adminRole']);
    $teamleaderid = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $cancelReason = mysqli_real_escape_string($dbconnection, $_POST['cancelReason']);
    $approvalTime = date('Y-m-d H:i:s');

    //MD Approved Mail
    $userid = fetchData($dbconnection, 'created_by', 'payment_request', 'pay_id', $pay_id);
    $useremail = fetchData($dbconnection, 'emp_email', 'admin_login', 'emp_id', $userid);

    if (!empty($useremail)) {
        // mdpaymentapprovemail($dbconnection,$useremail,$pay_id,'4');
    }
    $approvalTime = date('Y-m-d H:i:s');

    if ($logged_role == '2') {
        $approvequery = "UPDATE `payment_request` SET `third_approval` = '4', `third_approval_by` = '$teamleaderid', `third_approval_time` = '$approvalTime', `cancel_reason` = '$cancelReason' WHERE `pay_id` = '$pay_id'";
        $executeupdate = mysqli_query($dbconnection, $approvequery);
    }
    if ($executeupdate) {
        $approvalTime = date('Y-m-d H:i:s');
        if ($logged_role == 2) {
            $approvalType = 3;
            $approvalTypeText = 'Third Approval';
            $colum1 = 'third_approval';
            $colum2 = 'third_approved_by';
            $colum3 = 'third_approval_time';
        }
        $insertquery = "INSERT INTO `payment_history`(`payment_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$pay_id' , '4' , 'Cancelled' , '$teamleaderid','$logged_role' , '$approvalType' , '$approvalTypeText' , '$approvalTime' , '1')";
        $approveexecute = mysqli_query($dbconnection, $insertquery);
        if ($approveexecute) {
            echo "1";
        }
    } else {
        echo "fail";
    }
}


if (isset($_POST['raisePaymentRequest'])) {
    $pay_id = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
    $logged_role = mysqli_real_escape_string($dbconnection, $_POST['adminRole']);
    $teamleaderid = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $selectpurchase = "SELECT * FROM `purchase_request` WHERE `pur_id` = '$pay_id'";
    $executpurchase = mysqli_query($dbconnection, $selectpurchase);
    if (mysqli_num_rows($executpurchase) > 0) {
        if ($row = mysqli_fetch_array($executpurchase)) {
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
            $teamleader = $row['team_leader'];
            $logged_id = $row['created_by'];
            $remarks = null; // Get from add purchase request 
            $paymentAgainst = 'Advance'; // Change the select option 
            $payCode = 'PAY-' . hexdec(rand(100000, 999999));
            $accNo = null;
            $ifsccode = null;
            $inchargeName = fetchData($dbconnection, 'emp_name', 'admin_login', 'emp_id', $logged_id);
            $purchasepayment = '1';

            $addquery = "INSERT INTO `payment_request` ( `pay_code`,`team_leader`,`incharge_name`, `company_name`,`bill_no`, `supplier_mobile`, `supplier_mail`, `reason`, `po_no`, `amount`, `amount_words`, `payment_type`, `payment_against`, `remarks`, `po_file`,  `acc_no`, `ifsc_code`, `created_by`, `purchase_payment`) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? ) " or die($dbconnection->error);
            $stmt = $dbconnection->prepare($addquery);
            $stmt->bind_param("sssssssssssssssssss", $payCode, $teamleader, $inchargeName, $supplierName, $billNo, $supplierMobile, $supplierEmail, $reason, $PONum, $amount, $amountWords, $paymentType, $paymentAgainst, $remarks, $uniqueimage, $accNo, $ifsccode, $logged_id, $purchasepayment);
            $executeadd = $stmt->execute();

            $last_id = $dbconnection->insert_id;
            if ($paymentAgainst == 'Advance' && !empty($last_id)) {
                $advancepaymentquery = "UPDATE `payment_request` SET `advanced_amonut` = '$advance', `balance_amount` = '$balance' WHERE `pay_id` = '$last_id' ";
                $executequery = mysqli_query($dbconnection, $advancepaymentquery);
            }
        }
    }
}

if (isset($_POST['visitstatus'])) {

    $approvalTime = date('Y-m-d H:i:s');
    $pay_id = mysqli_real_escape_string($dbconnection, $_POST['paymentId']);
    $teamleaderid = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $payCode = fetchData($dbconnection, 'pay_code', 'payment_request', 'pay_id', $pay_id);
    $visitstatus = 1;
    $selectquery = "SELECT * FROM `user_visit` WHERE `pay_id` = '$pay_id' AND `visit_by` = '$teamleaderid'";
    $executeselect = mysqli_query($dbconnection, $selectquery);
    if (mysqli_num_rows($executeselect) > 0) {
        echo '0';
    } else {
        $addquery = "INSERT INTO `user_visit` ( `pay_id`,`visit_status`,`visit_by`) VALUES ( ? , ? , ? ) ";
        $stmt = $dbconnection->prepare($addquery);
        $stmt->bind_param("sss", $pay_id, $visitstatus, $teamleaderid);
        $executeadd = $stmt->execute();
        $updatepayment = mysqli_query($dbconnection, "UPDATE `payment_request` SET `close_pay` = '1', `closed_by` = '$teamleaderid', `closed_time` = '$approvalTime' WHERE `pay_code` = '$payCode' ");
        if ($executeadd && $updatepayment) {
            echo '1';
        }
    }
}



if (isset($_POST['closePurchase'])) {
    $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
    $adminRole = mysqli_real_escape_string($dbconnection, $_POST['adminRole']);
    $adminId = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $approvalTime = date('Y-m-d H:i:s');


    $query = "UPDATE `purchase_request` SET `completed`=1 , `completed_time` = '$approvalTime' WHERE `pur_id` = '$purchaseId' ";
    $approveexecute = mysqli_query($dbconnection, $query) or die(mysqli_error($dbconnection));
    if ($approveexecute) {
        $insertquery = "INSERT INTO `purchase_history`(`purchase_id`, `aprrove_status`, `approve_status_text`, `approved_by`,   `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) 
        VALUES ('$purchaseId' , '1' , 'Completed' , '$adminId','$adminRole' , '1' , 'Final Approval' , '$approvalTime' , '1')";
        $approveexecutes = mysqli_query($dbconnection, $insertquery);
        echo "1";
    } else {
        echo "fail";
    }
}



if (isset($_POST['adminDeletePurchase'])) {
    $purchaseId = mysqli_real_escape_string($dbconnection, $_POST['purchaseId']);
    $adminRole = mysqli_real_escape_string($dbconnection, $_POST['adminRole']);
    $adminId = mysqli_real_escape_string($dbconnection, $_POST['adminId']);


    $query = "DELETE FROM `purchase_request` WHERE `pur_id` = '$purchaseId' ";
    $deletePurchase = mysqli_query($dbconnection, $query);
    if ($deletePurchase) {
        $query2 = "DELETE FROM `purchased_products` WHERE `pr_purchase_id` = '$purchaseId' ";
        $deletePurchase2 = mysqli_query($dbconnection, $query2);
        mysqli_query($dbconnection, "DELETE FROM `purchase_id` WHERE `purchase_id` = '$purchaseId' ");
        echo "1";
    } else {
        echo "fail";
    }
}


if (isset($_POST['DeletePayment'])) {
    $pay_id = mysqli_real_escape_string($dbconnection, $_POST['paymentId']);
    $payCode = fetchData($dbconnection, 'pay_code', 'payment_request', 'pay_id', $pay_id);
    if (!empty($payCode)) {
        $deleterequest = mysqli_query($dbconnection, "DELETE FROM `payment_request` WHERE `pay_code` = '$payCode' ");
    }
    if ($deleterequest) {
        $deletepdf = mysqli_query($dbconnection, "DELETE FROM `payment_pdf` WHERE `pay_id` = '$pay_id'");
        $deletehistory = mysqli_query($dbconnection, "DELETE FROM `payment_history` WHERE `payment_id` = '$pay_id'");
        $deletevisit = mysqli_query($dbconnection, "DELETE FROM `user_visit` WHERE `pay_id` = '$pay_id'");
        echo '1';
    } else {
        echo '0';
    }
}

if (isset($_POST['newmessage'])) {

    $currentTime = date('Y-m-d H:i:s');
    $logged_id =  $_POST['logged_id'];
    $logged_role =  $_POST['logged_role'];
    $message = $_POST['message'];
    $pay_id =  $_POST['paymentId'];
    $payCode =  $_POST['payCode'];
    $createdid = fetchData($dbconnection, 'created_by', 'payment_request', 'pay_id', $pay_id);
    if ($logged_role == 4 || $logged_role == 8 || $logged_role == 9) {
        $senderid = $createdid;
    } else {
        $senderid = '';
    }
    $addmessage = "INSERT INTO `message` (`pay_id`,`pay_code`,`message_content`,`trigger_from`,`trigger_from_time`,`trigger_to`,`trigger_to_time`,`sender`) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? ) ";
    $stmt = $dbconnection->prepare($addmessage);
    $stmt->bind_param("ssssssss", $pay_id, $payCode, $message, $logged_id, $currentTime, $senderid, $currentTime, $logged_role);
    $executemessage = $stmt->execute();

    if ($executemessage) {
        echo '1';
    }
}


if (isset($_GET['updateAmountAdmin'])) {

    $currentTime = date('Y-m-d H:i:s');
    $logged_id =  $_GET['adminId'];
    $logged_role =  $_GET['adminRole'];
    $payCode =  "PAY-" . $_GET['paymentcode'];
    $amount =  $_GET['amount'];

    $paycodeCount = noneditbalance($dbconnection, $payCode);

    $selectQuery = mysqli_query($dbconnection, "SELECT `pay_id` FROM `payment_request` WHERE `pay_code` = '$payCode'");
    $purid_array  = array();
    while ($row = mysqli_fetch_array($selectQuery)) {
        array_push($purid_array, $row['pay_id']);
    }

    $selectSum = mysqli_query($dbconnection, "SELECT SUM(advanced_amonut) AS TotalAdvanceAmount FROM `payment_request` WHERE `pay_code` = '$payCode'");


    for ($i = 0; $i < $paycodeCount; $i++) {

        if ($i == 0) {
            $updatedAmount = fetchBalanceAmountChangeAdmin($dbconnection, $i, $amount, $purid_array[$i]);
        } else {
            $currentAdvanceTotal = fetchBalanceAmountChangeAdmin($dbconnection, $i, $amount, $purid_array[$i]);
            $currentBalanceAmount = AmountChangeAdmin($dbconnection, $amount, $purid_array[$i - 1]);
            $updatedAmount =  $currentBalanceAmount - $currentAdvanceTotal;
        }
        mysqli_query($dbconnection, "UPDATE `payment_request`  SET `amount`='$amount' , `balance_amount` = '$updatedAmount' WHERE `pay_id` = '$purid_array[$i]'");
    }
}


if (isset($_POST["comepleteFollowup"])) {
    $pay_id = mysqli_real_escape_string($dbconnection, $_POST['paymentId']);
    $adminId = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $approvalTime = date('Y-m-d H:i:s');

    $exeFollowup = mysqli_query($dbconnection, "UPDATE `followup_payments` SET `followup_completed_by`='$adminId' , `followup_status` = 1, `followup_completed_time` = '$approvalTime' WHERE `id` = '$pay_id'") or die(mysqli_error($dbconnection));
    if ($exeFollowup) {
        echo 200;
    } else {
        echo 505;
    }
}




if (isset($_POST['closeExpenditure'])) {
    $approvalTime = date('Y-m-d H:i:s');
    $pay_id = mysqli_real_escape_string($dbconnection, $_POST['paymentId']);
    $closeepxenditure = 0;

    $updatepayment = mysqli_query($dbconnection, "UPDATE `payment_request` SET `expenditure_status` = 0  WHERE `pay_id` = '$pay_id' ");
    if ($updatepayment) {
        echo '1';
    }
}


if (isset($_POST['completeExpenditure'])) {
    $approvalTime = date('Y-m-d H:i:s');
    $pay_id = mysqli_real_escape_string($dbconnection, $_POST['paymentId']);
    $adminId = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $closeepxenditure = 0;
    $updatExpend = mysqli_query($dbconnection, "UPDATE `expenditures` SET `exp_approval_1` = 1 , `exp_approval1_time` ='$approvalTime' , `exp_approval1_by` = '$adminId'  WHERE `exp_id` = '$pay_id'");
    if ($updatExpend) {
        echo 200;
    } else {
        echo 505;
    }
}

if (isset($_POST['fetchexpenditure'])) {
    $fieldid = $_POST['fieldid'];
    $logged_role = $_POST['logged_role'];
    $customerselect = "SELECT * FROM `expenditures` WHERE `exp_created_by` ='$fieldid' AND `exp_approval_1` = 0 ORDER BY `exp_id` DESC ";
    $custoemrquery = mysqli_query($dbconnection, $customerselect);
    if (mysqli_num_rows($custoemrquery) > 0) {
        $expensecount = 0;
        while ($row = mysqli_fetch_array($custoemrquery)) {
            $exp_name = $row['exp_name'];
            $exp_id = $row['exp_id'];
            $createdTime = date('d-M-Y H:i A', strtotime($row['exp_created_time']));
            $amount = $row['exp_amount'];
            $createdBy = $row['exp_created_by'];
            $createdName = fetchData($dbconnection, 'emp_name', 'admin_login', 'emp_id', $createdBy);
            $fileAttach = $row['exp_files'];
            $creditLeft = $row['exp_credit_left'];
            $filePath = "https://www.vencar.in/accounts/assets/pdf/expenditure/";
            $approval1 = $row['exp_approval_1'];
            if (!empty($fileAttach)) {
                $file = '<a href=' . $filePath . $fileAttach . ' target="_blank" class="btn btn-info btn-xs">View File</a>';
            } else {
                $file = 'No File Attached';
            }
            if (empty($approval1)) {
                if ($logged_role == 2) {
                    $expenseapproval = '<label class="badge badge-primary">Pending</label> <br>By - M.D';
                } else if ($logged_role == 4) {
                    $expenseapproval = '<label class="badge badge-primary">Pending</label> <br>By - Finance';
                } else {
                    $expenseapproval = "";
                }
            } else {
                if ($logged_role == 2) {
                    $expenseapproval = '<label class="badge badge-success">Approved</label> <br>By - M.D';
                } else if ($logged_role == 4) {
                    $expenseapproval = '<label class="badge badge-success">Approved</label> <br>By - Finance';
                } else {
                    $expenseapproval = "";
                }
            }
            $response[] = array("empid" => $exp_id, "empname" => $exp_name, "createtime" => $createdTime, "amount" => $amount, "createby" => $createdName, "file" => $file, "left" => $creditLeft, "status" => $expenseapproval);
        }
        echo json_encode($response);
    }
}

if (isset($_POST['searchproject'])) {
    $search = mysqli_real_escape_string($dbconnection, $_POST['search']);
    $query = "SELECT * FROM `ft_projects_tb` WHERE `project_title` LIKE '%" . $search . "%'";
    $result = mysqli_query($dbconnection, $query);
    $response[] = "";
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $response[] = array("id" => $row['project_id'],"label" => $row['project_title']);
        }
    }
    echo json_encode($response);
}

if (isset($_POST['approveexpense'])) {
    $closeid = mysqli_real_escape_string($dbconnection, $_POST['closeId']);
    $logged_id = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $logged_role = mysqli_real_escape_string($dbconnection, $_POST['adminrole']);
    $approvalTime = date('Y-m-d H:i:s');
    $created_id = fetchData($dbconnection, 'created_by', 'close_expenditure', 'close_ID', $closeid);

    if ($logged_role == 3 || $logged_role == 11 || $logged_role == 7) {
        $executeupdate = mysqli_query($dbconnection, "UPDATE `close_expenditure` SET `approve_status` = 1 WHERE `close_ID` = '$closeid' ");
    }
    if ($logged_role == 2) {
        $executeupdate = mysqli_query($dbconnection, "UPDATE `close_expenditure` SET `approve_status` = 3 WHERE `close_ID` = '$closeid' ");
        if ($executeupdate) {
            $updatexp = "UPDATE `expenditures` SET `exp_approval_1` = 1, `exp_approval1_time` = '$approvalTime', `exp_approval1_by` = '$logged_id' WHERE `exp_created_by` = '$created_id' ";
            $executeupdatexp = mysqli_query($dbconnection, $updatexp);
        }
    }
    if ($logged_role == 4) {
        $executeupdate = mysqli_query($dbconnection, "UPDATE `close_expenditure` SET `approve_status` = 4 WHERE `close_ID` = '$closeid' ");
        if ($executeupdate) {
            $updatexp = "UPDATE `expenditure_amount` SET `status` = 0, `closed_date` = '$approvalTime' WHERE `rasisd_for` = '$created_id' AND `status` = 1 ";
            $executeupdatexp = mysqli_query($dbconnection, $updatexp);
        }
    }

    if ($executeupdate) {
        if ($logged_role == 3 || $logged_role == 11 || $logged_role == 7) {
            $approvalStatus = 1;
            $approvalStatusText = 'Apporved';
            $approvalType = 1;
            $approvalTypeText = 'First Approval';
        }
        if ($logged_role == 2) {
            $approvalStatus = 3;
            $approvalStatusText = 'Apporved';
            $approvalType = 1;
            $approvalTypeText = 'Third Approval';
        }
        if ($logged_role == 4) {
            $approvalStatus = 4;
            $approvalStatusText = 'Apporved';
            $approvalType = 1;
            $approvalTypeText = 'Fourth Approval';
        }
        if ($approvalStatus == 1) {
            if (existapprovedexpenditure($dbconnection, $closeid, '1') == 0) {
                $insertquery = "INSERT INTO `expenditure_history` (`close_ID`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$closeid', '$approvalStatus', '$approvalStatusText', '$logged_id', '$logged_role', '$approvalType', '$approvalTypeText', '$approvalTime', '1')";
                $approveexecute = mysqli_query($dbconnection, $insertquery);
            }
        }
        if ($approvalStatus == 3) {
            if (existapprovedexpenditure($dbconnection, $closeid, '3') == 0) {
                $insertquery = "INSERT INTO `expenditure_history`(`close_ID`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$closeid', '$approvalStatus', '$approvalStatusText', '$logged_id', '$logged_role', '$approvalType', '$approvalTypeText', '$approvalTime', '1')";
                $approveexecute = mysqli_query($dbconnection, $insertquery);
            }
        }
        if ($approvalStatus == 4) {
            if (existapprovedexpenditure($dbconnection, $closeid, '4') == 0) {
                $insertquery = "INSERT INTO `expenditure_history`(`close_ID`, `aprrove_status`, `approve_status_text`, `approved_by`, `approve_admin_role`,`approval_type`, `approval_type_text`, `approve_time`, `history_status`) VALUES ('$closeid', '$approvalStatus', '$approvalStatusText', '$logged_id', '$logged_role', '$approvalType', '$approvalTypeText', '$approvalTime' , '1')";
                $approveexecute = mysqli_query($dbconnection, $insertquery);
            }
        }
    }
    if ($executeupdate) {
        echo '200';
    } else {
        echo '300';
    }
}

if (isset($_POST['completeAllExpenditure'])) {
    $created_id = mysqli_real_escape_string($dbconnection, $_POST['closefor']);
    $logged_id = mysqli_real_escape_string($dbconnection, $_POST['adminId']);
    $logged_role = mysqli_real_escape_string($dbconnection, $_POST['adminrole']);
    $approvalTime = date('Y-m-d H:i:s');

    $updatexp = "UPDATE `expenditures` SET `exp_approval_1` = '1', `exp_approval1_time` = '$approvalTime', `exp_approval1_by` = '$logged_id' WHERE `exp_created_by` = '$created_id' AND `exp_approval_1` = 0 ";
    $executeupdate = mysqli_query($dbconnection, $updatexp);

    if ($executeupdate) {
        echo '200';
    } else {
        echo '300';
    }
}

if(isset($_POST['add_New_Deduction'])) 
{ 
    $allowanceName = mysqli_real_escape_string($dbconnection, $_POST['allowanceName']);  
    $deptid = mysqli_real_escape_string($dbconnection, $_POST['deptid']);  
    $deptaction = mysqli_real_escape_string($dbconnection, $_POST['deptaction']);  

    if($deptaction =='add'){
        $insertdept = "INSERT INTO `ft_deductions` (`deduction`) VALUES (?) " ;
        $stmt = $dbconnection->prepare($insertdept) ;
        $stmt->bind_param("s",$allowanceName);
        $executedepartment = $stmt->execute();
        if($executedepartment){
            $data = array('statusCode' => '200', 'statusMessage' => 'Success');
            echo json_encode($data);
        }else{
            $data = array('statusCode' => '500', 'statusMessage' => 'Success');
            echo json_encode($data);
        }
    }else if($deptaction =='edit'){
        $insertdept = "UPDATE `ft_deductions` SET `deduction` = ?  WHERE `deduction_id` = ? " ;
        $stmt = $dbconnection->prepare($insertdept) ;
        $stmt->bind_param("ss",$allowanceName,$deptid);
        $executedepartment = $stmt->execute();
        if($executedepartment){
            $data = array('statusCode' => '200', 'statusMessage' => 'Success');
            echo json_encode($data);
        }else{
            $data = array('statusCode' => '500', 'statusMessage' => 'Success');
            echo json_encode($data);
        }
    }
   
}



if(isset($_POST['addNewAllowance']))
{ 
    $allowanceName = mysqli_real_escape_string($dbconnection, $_POST['allowanceName']);  
    $deptid = mysqli_real_escape_string($dbconnection, $_POST['deptid']);  
    $deptaction = mysqli_real_escape_string($dbconnection, $_POST['deptaction']);  

    if($deptaction =='add'){
        $insertdept = "INSERT INTO `ft_allowances` (`allowance`) VALUES (?) " ;
        $stmt = $dbconnection->prepare($insertdept) ;
        $stmt->bind_param("s",$allowanceName);
        $executedepartment = $stmt->execute();
        if($executedepartment){
            $data = array('statusCode' => '200', 'statusMessage' => 'Success');
            echo json_encode($data);
        }else{
            $data = array('statusCode' => '500', 'statusMessage' => 'Success');
            echo json_encode($data);
        }
    }else if($deptaction =='edit'){
        $insertdept = "UPDATE `ft_allowances` SET `allowance` = ?  WHERE `allowance_id` = ? " ;
        $stmt = $dbconnection->prepare($insertdept) ;
        $stmt->bind_param("ss",$allowanceName,$deptid);
        $executedepartment = $stmt->execute();
        if($executedepartment){
            $data = array('statusCode' => '200', 'statusMessage' => 'Success');
            echo json_encode($data);
        }else{
            $data = array('statusCode' => '500', 'statusMessage' => 'Success');
            echo json_encode($data);
        }
    }
   
}
if(isset($_POST['add_New_Tax']))
{ 
    $taxName = mysqli_real_escape_string($dbconnection, $_POST['taxName']);  
    $taxid = mysqli_real_escape_string($dbconnection, $_POST['taxid']);  
    $deptaction = mysqli_real_escape_string($dbconnection, $_POST['deptaction']);  

    if($deptaction =='add'){
        $insertdept = "INSERT INTO `ft_tax` (`tax_name`) VALUES (?) " ;
        $stmt = $dbconnection->prepare($insertdept) ;
        $stmt->bind_param("s",$taxName);
        $executedepartment = $stmt->execute();
        if($executedepartment){
            $data = array('statusCode' => '200', 'statusMessage' => 'Success');
            echo json_encode($data);
        }else{
            $data = array('statusCode' => '500', 'statusMessage' => 'Success');
            echo json_encode($data);
        }
    }else if($deptaction =='edit'){
        $insertdept = "UPDATE `ft_tax` SET `tax_name` = ?  WHERE `tax_id` = ? " ;
        $stmt = $dbconnection->prepare($insertdept) ;
        $stmt->bind_param("ss",$taxName,$taxid);
        $executedepartment = $stmt->execute();
        if($executedepartment){
            $data = array('statusCode' => '200', 'statusMessage' => 'Success');
            echo json_encode($data);
        }else{
            $data = array('statusCode' => '500', 'statusMessage' => 'Success');
            echo json_encode($data);
        }
    }
   
}

if(isset($_POST['addNewTransport']))
{ 
    $transportMode = mysqli_real_escape_string($dbconnection, $_POST['transportMode']);  
    $deptid = mysqli_real_escape_string($dbconnection, $_POST['deptid']);  
    $deptaction = mysqli_real_escape_string($dbconnection, $_POST['deptaction']);  

    if($deptaction =='add'){
        $insertdept = "INSERT INTO `ft_transport_mode` (`transport_mode`) VALUES (?) " ;
        $stmt = $dbconnection->prepare($insertdept) ;
        $stmt->bind_param("s",$transportMode);
        $executedepartment = $stmt->execute();
        if($executedepartment){
            $data = array('statusCode' => '200', 'statusMessage' => 'Success');
            echo json_encode($data);
        }else{
            $data = array('statusCode' => '500', 'statusMessage' => 'Success');
            echo json_encode($data);
        }
    }else if($deptaction =='edit'){
        $insertdept = "UPDATE `ft_transport_mode` SET `transport_mode` = ?  WHERE `transport_id` = ? " ;
        $stmt = $dbconnection->prepare($insertdept) ;
        $stmt->bind_param("ss",$transportMode,$deptid);
        $executedepartment = $stmt->execute();
        if($executedepartment){
            $data = array('statusCode' => '200', 'statusMessage' => 'Success');
            echo json_encode($data);
        }else{
            $data = array('statusCode' => '500', 'statusMessage' => 'Success');
            echo json_encode($data);
        }
    }
   
}


if(isset($_POST["filterProducts"])){
    $id = $_POST["groupId"];
    $query1 = "SELECT * FROM `ft_product_master` WHERE `product_group` = '$id'"; 
    $result1 = mysqli_query($dbconnection,$query1);  
    echo '<option value="" selected>---</option>';
    
    while($row = mysqli_fetch_array($result1)){  
           echo '<option value="'.$row['product_id'].'"  >'.$row['product_name'].'</option>';   
    }   
}
if(isset($_POST["filterType"])){
    $type = $_POST["type"];
    //  1= tax , 2 = addition , 3= deduction
    if($type == 1){
        $query1 = "SELECT * FROM `ft_tax`"; 
        $result1 = mysqli_query($dbconnection,$query1);   
         
        echo '<option value="" selected>---</option>';
        while($row = mysqli_fetch_array($result1)){    
             
                echo '<option value="'.$row['tax_id'].'" data-extra="'.$row['tax_percentage'].'" > '.$row['tax_name'].'</option>';     
             
        }    
    }else if($type == 2){
        $query1 = "SELECT * FROM `ft_allowances`"; 
        $result1 = mysqli_query($dbconnection,$query1);  
        echo '<option value="" selected>---</option>';
        while($row = mysqli_fetch_array($result1)){    
             
                echo '<option value="'.$row['allowance_id'].'" >'.$row['allowance'].'</option>';     
        }
    }else if($type == 3){
        $query1 = "SELECT * FROM `ft_deductions`"; 
        $result1 = mysqli_query($dbconnection,$query1);  
        echo '<option value="" selected>---</option>';
        while($row = mysqli_fetch_array($result1)){    
             
                echo '<option value="'.$row['deduction_id'].'" >'.$row['deduction'].'</option>';    
             
        }
    }
}

if(isset($_POST["filterAmount"])){
    $prodId = $_POST["prodId"];
    $supplierID = $_POST["supplierID"];
    
    $query1 = "SELECT * FROM `ft_product_details` WHERE `supplier_id`='$supplierID' AND `product_id`='$prodId'"; 
    $result1 = mysqli_query($dbconnection,$query1);    
    if($row = mysqli_fetch_array($result1)){          
            echo  $row['details_amount'];      
    }    
     
}

if(isset($_POST["filterAmountQty"])){
    $prodId = $_POST["prodId"];
    $supplierID = $_POST["supplierID"];
    $purchaseID = $_POST["purchaseID"];

    $productamount = $productqty = '';
    $query1 = "SELECT * FROM `ft_product_details` WHERE `supplier_id`='$supplierID' AND `product_id`='$prodId'"; 
    $result1 = mysqli_query($dbconnection,$query1);    
    if($row1 = mysqli_fetch_array($result1)){          
            $productamount =  $row1['details_amount'];      
    }
    
    $query2 = "SELECT * FROM `purchase_request` LEFT JOIN `purchased_products` ON `purchased_products`.`pr_purchase_id` = `purchase_request`.`pur_id` WHERE `purchased_products`.`pr_purchase_id`='$purchaseID' AND `purchased_products`.`pr_product_id`='$prodId'"; 
    $result2 = mysqli_query($dbconnection,$query2);    
    if($row2 = mysqli_fetch_array($result2)){          
        $productqty =    $row2['pr_qty'];      
    }    
     
    $data = array('productAmount' => $productamount, 'productQty' => $productqty );
    echo json_encode($data);
}

if(isset($_POST["filterPO"])){
     
    $supplierID = $_POST["supplierID"];
    
    $query1 = "SELECT * FROM `ft_po` WHERE (`po_status` = 1 OR `po_status` = 2) AND  `po_supplier_id`='$supplierID' "; 
    $result1 = mysqli_query($dbconnection,$query1); 
    echo '<option value="" selected>---</option>';   
    while($row = mysqli_fetch_array($result1)){          
        echo '<option value="'.$row['po_id'].'" > '.$row['po_code'].'</option>';           
    }    
     
}


if(isset($_POST["filterInwardProducts"])){
     
    $poid = $_POST["poid"];
    
    $query1 = "SELECT * FROM `ft_po` LEFT JOIN `ft_po_details` ON `ft_po_details`.`po_id` = `ft_po`.`po_id`  WHERE `ft_po`.`po_id`='$poid'"; 
    $result1 = mysqli_query($dbconnection,$query1); 
    $elem = ''; 
    if(mysqli_num_rows($result1) > 0){
        while($row = mysqli_fetch_array($result1)){          
            $productId = $row["po_product_id"];
            $productName = $row["po_product_name"];
            $productQty = $row["po_product_qty"];
            if(!empty($productId)){
                $elem .= '<tr class="text-center">';           
                $elem .= '<td><input type="hidden" class="form-control" name="productId[]" value="'.$productId.'">'.$productName.'</td>';                       
                $elem .= '<td><input type="text" id="poqty-'.$productId.'" class="form-control" name="productPOQty[]"  value="'.$productQty.'" readonly></td>';                        
                $elem .= '<td><input type="text" id="recqty-'.$productId.'" class="form-control" name="receivedqty[]" onkeyup="updateQty('.$productId.')" required></td>';                       
                $elem .= '<td><input type="text" id="penqty-'.$productId.'" class="form-control" name="pendingqty[]" readonly ></td>';                          
                $elem .= '<td>';
                $elem .= '<select id="store-'.$productId.'" class="form-control" name="storeid[]" onchange="updateRack('.$productId.')" required>';
                $elem .= '<option value="">-----</option>'; 
                $query2 = "SELECT * FROM `ft_store_room` "; 
                $result2 = mysqli_query($dbconnection,$query2); 
                while($row2 = mysqli_fetch_array($result2)){
                    $elem .= '<option value="'.$row2["store_id"].'">'.$row2["store_name"].'</option>'; 
                 } 
                $elem .= '</select>';
                $elem .=  '</td>';                          
                $elem .= '<td>';
                $elem .= '<select id="rack-'.$productId.'" class="form-control" name="rackid[]" onchange="updateColumn('.$productId.')">';
                $elem .= '<option value=" " selected>-----</option>'; 
                $elem .= '</select>';
                $elem .=  '</td>';                          
                $elem .= '<td>';
                $elem .= '<select id="column-'.$productId.'" class="form-control" name="columnid[]">'; 
                $elem .= '<option value=" " selected>-----</option>'; 
                $elem .= '</select>';
                $elem .=  '</td>';                          
                $elem .= '</tr>';            
            }else{
                $elem  .= '<tr class="text-center">';         
                $elem  .= '<td colspan="4"><p>No Products</p></td>';         
                $elem  .= '</tr>';         
            }
        }    
         echo $elem; 
    }else{
        $elem  .= '<tr class="text-center">';         
        $elem  .= '<td colspan="4"><p>No Products</p></td>';         
        $elem  .= '</tr>';         
    }
}



if(isset($_POST["filterAvailableQty"])){
    $prodId = $_POST["prodId"];  
    $query1 = "SELECT * FROM `ft_stock_master` WHERE `product_id`='$prodId'"; 
    $result1 = mysqli_query($dbconnection,$query1);    
    if($row = mysqli_fetch_array($result1)){          
            echo  $row['product_current_qty'];      
    }else{
        echo 0;
    }    
     
}


if(isset($_POST["filterRacking"])){
    $id = $_POST["storeRoom"];
    $query1 = "SELECT * FROM `ft_rack` WHERE `store_id` = '$id'"; 
    $result1 = mysqli_query($dbconnection,$query1);  
    echo '<option value="" selected>---</option>';
    
    while($row = mysqli_fetch_array($result1)){  
           echo '<option value="'.$row['rack_id'].'"  >'.$row['rack_name'].'</option>';   
    }   
}


if(isset($_POST["filterracks"])){
    $id = $_POST["store"];
    $query1 = "SELECT * FROM `ft_rack` WHERE `store_id` = '$id'"; 
    $result1 = mysqli_query($dbconnection,$query1);  
    echo '<option value="" selected>---</option>';
    
    while($row = mysqli_fetch_array($result1)){  
           echo '<option value="'.$row['rack_id'].'"  >'.$row['rack_name'].'</option>';   
    }   
}


if(isset($_POST["filtercolumns"])){
    $store = $_POST["store"];
    $rack = $_POST["rack"];
    $query1 = "SELECT * FROM `ft_column` WHERE `store_id` = '$store' AND `rack_id`='$rack'"; 
    $result1 = mysqli_query($dbconnection,$query1);  
    echo '<option value="" selected>---</option>';
    
    while($row = mysqli_fetch_array($result1)){  
           echo '<option value="'.$row['column_id'].'"  >'.$row['column_name'].'</option>';   
    }   
}