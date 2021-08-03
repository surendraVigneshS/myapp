<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php'; 
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

define('SMTP_HOST','smtpout.asia.secureserver.net');
define('SMTP_PORT','80');
// define('SMTP_HOST','smtp.gmail.com');
// define('SMTP_PORT','587');
define('SENT_MAIL_PURCHASE','purchase@svcgpl.com');
define('SENT_MAIL_PAYMENT','maheshbabu@svcgpl.com');

function mdpaymentapprovemail($dbconnection,$to,$payid,$status){
    $userid = fetchData($dbconnection,'created_by','payment_request','pay_id',$payid);
    $paycode = fetchData($dbconnection,'pay_code','payment_request','pay_id',$payid);
    $username = fetchData($dbconnection,'incharge_name','payment_request','pay_id',$payid);
    $paymentamount = fetchData($dbconnection,'amount','payment_request','pay_id',$payid);
    $suppliername = fetchData($dbconnection,'company_name','payment_request','pay_id',$payid);
    if($status == 1){
        $mail = new PHPMailer();
        // $mail->IsSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure= false;
        $mail->Username = SENT_MAIL_PAYMENT;  
        $mail->Password = "Qwerty#007";   
        $mail->Port = SMTP_PORT;
        $mail->SetFrom(SENT_MAIL_PAYMENT, 'Vencar Account');
        $mail->Subject    = 'Update on Payment Request';
        $body = 'Dear <b>'.$username.',</b><br><br>';
        $body .= 'Your Payment Request for <b>'.$suppliername.'</b> of <b>₹'.$paymentamount.'</b> amonut has been approved by MD for the Payment ID: <b>'.$paycode.'</b>' ;
        $mail->isHTML();
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
        $mail->MsgHTML($body);
        $address = $to;
        $mail->AddAddress($address, $name);
        if($mail->Send()) {
            return 0;
        }else{
            return "Mailer Error: " . $mail->ErrorInfo;
        }
    }
    if($status == 4){
        $mail = new PHPMailer();
        // $mail->IsSMTP(); 
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure= false;    
        $mail->Username = SENT_MAIL_PAYMENT;  
        $mail->Password = "Qwerty#007"; 
        $mail->Port = SMTP_PORT;
        $mail->SetFrom(SENT_MAIL_PAYMENT, 'Vencar Account');
        $mail->Subject    = 'Update on Payment Request';
        $body = 'Dear <b>'.$username.',</b><br><br>';
        $body .= 'Your Payment Request for <b>'.$suppliername.'</b> of <b>₹'.$paymentamount.'</b> amonut has been cancelled by MD for the Payment ID: <b>'.$paycode.'</b>' ;
        $mail->isHTML();
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
        $mail->MsgHTML($body);
        $address = $to;
        $mail->AddAddress($address, $name);
        if($mail->Send()) {
            return 0;
        }else{
            "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}


function accountmailWA($dbconnection,$payid,$attachment,$temPath){

    $userid = fetchData($dbconnection,'created_by','payment_request','pay_id',$payid);
    $paycode = fetchData($dbconnection,'pay_code','payment_request','pay_id',$payid);
    $paymentamount = fetchData($dbconnection,'amount','payment_request','pay_id',$payid);
    $useremail = fetchData($dbconnection,'emp_email','admin_login','emp_id',$userid);
    $supplieremail = fetchData($dbconnection,'supplier_mail','payment_request','pay_id',$userid);
    $suppliername = fetchData($dbconnection,'company_name','payment_request','pay_id',$payid);
    $to = array($useremail, $supplieremail);

    $mail = new PHPMailer();
    // $mail->IsSMTP();  
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure= true;    
    $mail->Username = SENT_MAIL_PAYMENT;  
    $mail->Password = "Qwerty#007";  
    $mail->Port = SMTP_PORT;
    $mail->SetFrom(SENT_MAIL_PAYMENT, 'Vencar Account');
    $mail->Subject    = 'Update on Payment Request';
    $body = 'Dear <b>'.$suppliername.',</b><br><br>';
    $body .= 'Your payment request for <b>₹'.$paymentamount.'</b> has been accepted and the Payment ID: <b>'.$paycode.'</b>';
    $mail->isHTML();
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
    $mail->MsgHTML($body);
    $mail->AddAttachment($temPath, $attachment);
    foreach($to as $to_add){
        $mail->AddAddress($to_add);
    }
    if($mail->Send()) {
        return 0;
    }
}


function mdpurchaseapprovemail($to,$payid,$name,$status){
    $purchasecode = fetchData($dbconnection,'purchase_code','purchase_request','pur_id',$payid);
    $username = fetchData($dbconnection,'incharge_name','purchase_request','pur_id',$payid);
    $paymentamount = fetchData($dbconnection,'advance_amount','purchase_request','pur_id',$payid);
    $suppliername = fetchData($dbconnection,'supplier_name','purchase_request','pur_id',$payid);
    if($status == '1'){
        $mail = new PHPMailer();
        // $mail->IsSMTP();  
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure= false;    
        $mail->Username = SENT_MAIL_PURCHASE;  
        $mail->Password = "Qwerty#007"; 
        $mail->Port = SMTP_PORT;
        $mail->SetFrom(SENT_MAIL_PURCHASE, 'Vencar Account');
        $mail->Subject    = 'Update on Purchase Request';
        $body = 'Dear <b>'.$username.',</b><br><br>';
        $body .= 'Your Payment Request for <b>'.$suppliername.'</b> of <b>₹'.$paymentamount.'</b> amonut has been approved by MD for the Purchase ID: <b>'.$purchasecode.'</b>' ;
        $mail->isHTML();
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
        $mail->MsgHTML($body);
        $address = $to;
        $mail->AddAddress($address, $name);
        if($mail->Send()) {
            return 0;
        }
    }
    if($status == '4'){
        $mail = new PHPMailer();
        // $mail->IsSMTP();  
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure= false;    
        $mail->Username = SENT_MAIL_PURCHASE;  
        $mail->Password = "Qwerty#007"; 
        $mail->Port = SMTP_PORT;
        $mail->SetFrom(SENT_MAIL_PURCHASE, 'Vencar Account');
        $mail->Subject    = 'Update on Purchase Request';
        $body = 'Dear <b>'.$username.',</b><br><br>';
        $body .= 'Your Payment Request for <b>'.$suppliername.'</b> of <b>₹'.$paymentamount.'</b> amonut has been cancelled by MD for the Purchase ID: <b>'.$purchasecode.'</b>' ;
        $mail->isHTML();
        $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
        $mail->MsgHTML($body);
        $address = $to;
        $mail->AddAddress($address, $name);
        if($mail->Send()) {
            return 0;
        }
    }
}

function purchasepaymentmailWA($dbconnection,$payid,$emailsubJect,$emailBody = NULL,$attachment,$temPath){

    $userid = fetchData($dbconnection,'created_by','purchase_request','pur_id',$payid);
    $useremail = fetchData($dbconnection,'emp_email','admin_login','emp_id',$userid);
    $supplieremail = fetchData($dbconnection,'supplier_email','purchase_request','pur_id',$payid);
    $to = array($useremail,$supplieremail);

    $mail = new PHPMailer();
    // $mail->IsSMTP();  
    $mail->Host = SMTP_HOST; 
    $mail->SMTPAuth = true;
    $mail->SMTPSecure= true;    
    $mail->Username = SENT_MAIL_PURCHASE;  
        $mail->Password = "Qwerty#007";  
    $mail->Port = SMTP_PORT;
    $mail->SetFrom(SENT_MAIL_PURCHASE, 'Vencar Account');
    $mail->Subject    = $emailsubJect;
    $body  = $emailBody;
    $mail->isHTML();
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
    $mail->MsgHTML($body);
    $mail->AddAttachment($temPath, $attachment);
    foreach($to as $to_add){
        $mail->AddAddress($to_add);
    }
    if($mail->Send()) {
        return 0;
    }else{
        return 1;
    }
}

