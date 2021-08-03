<?php

function send_mail($to)
{
        require '../PHPMailer/src/Exception.php'; 
        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/SMTP.php';
        
        $mail = new PHPMailer\PHPMailer\PHPMailer(); 

        $mail->SMTPDebug = 2;  


        $mail->isSMTP();                                      
        $mail->Host = 'smtp.mu3innovativesolutions.com';
        $mail->SMTPAuth = true;                              
        $mail->SMTPSecure = 'ssl';  
        $mail->Username = 'surendar@mu3innovativesolutions.com';                   
        $mail->Password = 'Admin@123';          
        $mail->Port = 465;                        
        $mail->From = 'your@email.com';
        $mail->FromName = 'Vencar Accounts Team';
        $mail->addAddress($to);                 
        $mail->isHTML(true);                    
        
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->addAttachment('../assets/images/favicon.png', 'favicon.png');
        
        if(!$mail->send()){return  $mail->ErrorInfo;}else{return true;}
}


echo send_mail('surendraworkacc@gmail.com');