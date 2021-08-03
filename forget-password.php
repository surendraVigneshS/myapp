<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
	include('./include/dbconfig.php');
	include('./include/function.php');
	if (isset($_POST['forget-btn'])) 
	{
		$uemail = $_POST['resetEmail'];
		$uemail = mysqli_real_escape_string($dbconnection, $uemail);
		if(checkEmailUser($uemail,$dbconnection)){
			$userID = fetchData($dbconnection,'emp_id','admin_login','emp_email',$uemail);
			$token = RandomString(20);
			$query = mysqli_query($dbconnection, "INSERT INTO `recovery_keys` (`customer_ID`, `token`) VALUES ($userID, '$token') ");
			if($query){
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
				$headers .= "From: Vencar <accounts@vencar.in>\r\n";
				$subject = 'Password Recovery Request from Vencar Accounts';       
				$link = 'https://www.vencar.in/accounts/reset-password.php?email='.$uemail.'&token='.$token;  
          		$message = "<b>Hello</b><br><br>You have requested for your password recovery. <a href='$link' target='_blank'>Click here</a> to reset your password.<br> If you are unable to click the link then copy the below link and paste in your browser to reset your password.<br><i>". $link."</i>"."<br><br><br><br>Regards<br>SVCGPL's Team";
				$mailsent= mail($uemail,$subject,$message,$headers);
				if($mailsent)
				{
					$msg = 'A Mail with Recovery Instruction has Sent to your email.';
					$msgclass = 'mail-success';
				}else{
					$msg = 'Mail Sent has been failed';
					$msgclass = 'forget-error';
				}
			}else{
				$msg = 'There is something wrong. Please try again after some time';
				$msgclass = 'forget-error';
			}	
		}else{
			$msg = "This is not register email Address. Please Register first";
			$msgclass = 'forget-error';
		}
	}
		
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <title>Reset Password - Premium Admin Template</title> 
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./assets/css/fontawesome.css">  
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
    <style>
        .forget-error{
          color:red!important;
        }
        .mail-success{
          color:green  !important;
        }

    </style>
  </head>
  <body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
      <div class="container-fluid p-0">
        <div class="row">
          <div class="col-12">     
            <div class="login-card">
              <div>
                <div>
                    <a class="logo" href="home-dashboard.php">
                      <img class="img-fluid for-light img-60" src="./assets/images/logo/logo.png" alt="looginpage">
                      <img class="img-fluid for-dark img-60" src="./assets/images/logo/logo.png" alt="looginpage">
                    </a>
                </div>
                <div class="login-main"> 
                  <form class="theme-form" method="POST" action="">
                    <h4 class="text-center">Forget Password</h4>
                    <?php if(isset($msg)) {?>
                    				<p class="<?php echo $msgclass; ?> text-center"><?php echo $msg; ?></p>
                    <?php } ?>
                    <div class="form-group">
                      <label class="col-form-label">Registered Email Address</label>
                      <input class="form-control" type="email" name="resetEmail" required > 
                    </div> 
                    <div class="form-group mb-0 text-center "> 
                      <button class="btn btn-primary btn-block col-md-12" type="submit" name="forget-btn">Get Reset Email</button>
                    </div>
                    <!-- <p class="mt-4 mb-0">Don't have account?<a class="ms-2" href="sign-up.html">Create Account</a></p> -->
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- page-wrapper Ends-->
    <!-- latest jquery-->
    <script src="./assets/js/jquery-3.5.1.min.js"></script> 
    <script src="./assets/js/bootstrap/bootstrap.bundle.min.js"></script> 
    <script src="./assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="./assets/js/icons/feather-icon/feather-icon.js"></script> 
    <script src="./assets/js/config.js"></script> 
    <script src="./assets/js/script.js"></script> 
  </body> 
</html>