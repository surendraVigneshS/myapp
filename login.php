<?php 
    include('./include/dbconfig.php'); 
    include('./include/function.php'); 
    session_start();

?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login  - Accounts</title>
    <?php  include('./include/css.php'); ?>  
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-5"><img class="bg-img-cover bg-center" src="./assets/images/login/Login_bg.png" alt="looginpage"></div>
            <div class="col-xl-7 p-0">    
                <div class="login-card">
                    <div>
                         <a class="  text-start" href="login.php"><img class=" for-light" src="./assets/images/logo/logo.png" width="140px" height="120px" alt="looginpage"></a> 
                        <div class="login-main mt-3"> 
                            <form id="admin_login" action="./include/_loginController.php"  class="theme-form" method="POST">
                                <h4>Sign in to account</h4>
                                <?php if(isset($_SESSION["errorMessage"])) { ?>
                                <div class="error-message"><p><?php echo $_SESSION["errorMessage"]; ?></p></div>
                                <?php unset($_SESSION["errorMessage"]); } ?>
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input type="email" class="form-control color" id="username" name="username" placeholder="Email ID" value="admin@g.com" required>
                                </div>
                                <div class="form-group">
                                  <label class="col-form-label">Password</label> 
                                  <input class="form-control color" type="password" name="login_password" required="" id="password" placeholder="Password" value="Admin@123">
                                  <div class="show-hide"><span class="show"> </span></div>
                                </div> 
                                <div class="form-group m-t-20">
                                <select class="form-select digits" id="userRole" name="login_userRole" required>
                                    <option value="" selected disabled>Choose User Role</option>
                                    <?php 
                                        $exeQuery = mysqli_query($dbconnection,"SELECT * FROM `user_roles` ORDER BY `sort_order` ASC");
                                        while($row = mysqli_fetch_array($exeQuery)){  ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['user_role']; ?></option> 
                                    <?php } ?>
                                </select>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="form-check pt-2"></div>
                                    <a class="link" href="./forget-password.php">Forgot password?</a>
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit" name="admin_login" id="log_btn">Sign in</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/js/jquery-3.5.1.min.js"></script>
    <script src="./assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="./assets/js/icons/feather-icon/feather-icon.js"></script>
    <script src="./assets/js/config.js"></script>
    <script src="./assets/js/script.js"></script>  
</body>
</html>