<?php 

    include('./include/dbconfig.php');
    include('./include/function.php');
	$uemail= '';
	$token= '';
	$userID= '';
	if(isset($_GET['email'])){
		$uemail = $_GET['email'];
	}
	if(isset($_GET['token'])){
		$token = $_GET['token'];
	}
   
	$userID = fetchData($dbconnection,'emp_id','admin_login','emp_email',$uemail);
	$verifytoken = verifytoken($userID, $token, $dbconnection);
    $passwordSuccess = false;

 
	if(isset($_POST['confirm-pass-btn'])){
		if($verifytoken == '1'){
			if(isset($_POST['confirm-pass-btn'])){
				$new_password = $_POST['user_password'];
				$new_password = passwordEncryption($new_password);
				$retype_password = $_POST['confirm_password'];
				$retype_password = passwordEncryption($retype_password);
				if($new_password == $retype_password){
					$update_password = mysqli_query($dbconnection, "UPDATE `admin_login` SET `emp_password` = '$new_password' WHERE `emp_id` = $userID");
				if($update_password){
						mysqli_query($dbconnection, "UPDATE recovery_keys SET valid = 0 WHERE customer_ID = $userID AND token ='$token'");
            $passwordSuccess = true;
						$msg = "Password Changed Successfully";
            $msgclass = 'mail-success';
				}
				}else{
					$msg = "Password doesn't match";
					$msgclass = 'forget-error';
				}
			}
		}else{
			$msg = "You already use this link to reset password. To change the password again <a href='forget.php'>Click Here?</a>";
			$msgclass = 'forget-error';
			$hideclass = 'hide';
		}
	
	}
    
?> 

<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from admin.pixelstrap.com/cuba/theme/reset-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 31 Mar 2021 08:20:44 GMT -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <title>Forget Password - Premium Admin Template</title> 
    <!-- <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">   -->
    <link rel="stylesheet" type="text/css" href="./assets/css/fontawesome.css"> 
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/icofont.css"> 
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/themify.css"> 
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/flag-icon.css"> 
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css"> 
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
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
                <?php if($verifytoken == 1) { ?>
                  <form class="theme-form" method="POST" action="">
                    <h4 class="text-center">Reset Your Password</h4>
                    <?php if(isset($msg)) {?>
                    				<p class="<?php echo $msgclass; ?> text-center"><?php echo $msg; ?></p>
                    <?php } ?>
                    <?php if(!$passwordSuccess){ ?>
                    <div class="form-group">
                      <label class="col-form-label">New Password</label>
                      <input class="form-control" type="password" name="user_password" required="" onkeyup="checkPass();">
                      <div class="show-hide"><span class="show"></span></div>
                    </div>
                    <div class="form-group">
                      <label class="col-form-label">Retype Password</label>
                      <input class="form-control" type="password" name="confirm_password" required="" onkeyup="checkPass();">
                    </div>
                    <div class="form-group mb-0"> 
                      <button class="btn btn-primary btn-block col-12" type="submit" name="confirm-pass-btn" value="confirm-pass-btn" id="confirm-pass-btn">Reset</button>
                    </div> 
                    <?php }else if($passwordSuccess){ ?>
                     
                      <a href="login.php"><h2 style="font-weight:500;font-size:30px;text-align:center">Click To Login</h2></a>
                      <?php } ?>
                  </form>
                  <?php }else{ ?>
                <div class="col-lg-12 col-md-12 col-lg-offset-4">
                        <h2 style="font-weight:500;font-size:30px;text-align:center">Invalid or Broken Token</h2>
                        <p class="forget-error">Oops! The link you have come with is maybe broken or already used. Please make sure that you copied the link correctly or request another token link from from <a href="forget-password.php">Click Here?</a></p>
                </div>
                <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> 
    <script src="./assets/js/jquery-3.5.1.min.js"></script> 
    <script src="./assets/js/bootstrap/bootstrap.bundle.min.js"></script>  
    <script src="./assets/js/config.js"></script> 
    <script src="./assets/js/script.js"></script> 
    <script>
            function checkPass(){
    			var password = document.getElementById('user_password');
    			var confirm  = document.getElementById('confirm_password');
				var message = document.getElementById('confirm-message2');
    			var good_color = "#66cc66";
    			var bad_color  = "#ff6666";
				if(password.value == confirm.value){
					message.style.color = good_color;
					message.innerHTML  = 'Passwords Match';
					$("#confirm-pass-btn").removeAttr("disabled");
				}else{
					message.style.color = bad_color;
					message.innerHTML = 'Passwords Do Not Match!';
					$("#confirm-pass-btn").attr("disabled", "true");
				}
			}
        </script>
  </body> 
</html>