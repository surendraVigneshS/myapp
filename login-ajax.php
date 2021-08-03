<?php 
    include('./include/dbconfig.php'); 
    include('./include/function.php'); 

?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login  - Accounts</title>
    <?php  include('./include/css.php'); ?> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-5"><img class="bg-img-cover bg-center" src="./assets/images/login/Login_bg.png" alt="looginpage"></div>
        <div class="col-xl-7 p-0">    
          <div class="login-card">
            <div>
              <div><a class="logo text-start" href="https://www.vencar.in/accounts/login.php"><img class="img-fluid for-light" src="./assets/images/logo/logo.png" width="45px" alt="looginpage"><img class="img-fluid for-dark" src="./assets/images/logo/logo.png" width="45px" alt="looginpage"></a></div>
              <div class="login-main"> 
              <form id="admin_login" class="theme-form" method="post">
                  <h4>Sign in to account</h4>
                  <!--<p>Enter your email & password to login</p>-->
                  <div class="form-group">
                    <label class="col-form-label">Email Address</label>
                    <input type="email" class="form-control color" id="username" name="username" placeholder="Email ID" required>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Password</label> 
                    <input class="form-control color" type="password" name="login[password]" required="" id="password"     placeholder="Password" value="Svcgpl@123"  >
                    <div class="show-hide"><span class="show"> </span></div>
                  </div>  
                  <h3> 
                  </h3>
                  <div class="form-group m-t-20">
                    <!--<label for="formcontrol-select2">Choose User Role</label>-->
                    <select class="form-select digits" id="userRole" name="userRole">
                        <option selected disabled>Choose User Role</option>
                        <?php 
                            $exeQuery = mysqli_query($dbconnection,"SELECT * FROM `user_roles` ORDER BY `sort_order` ASC");
                            while($row = mysqli_fetch_array($exeQuery)){  ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['user_role']; ?></option> 
                        <?php } ?>
                    </select>
                  </div>
                  <div class="form-group mb-0">
                  <div class="form-check pt-2">
                    <!-- <input class="form-check-input" type="checkbox" value="1" id="remembermecheck" checked>
                    <label class="form-check-label" for="remembermecheck">Remember password</label> -->
                  </div><a class="link" href="./forget-password.php">Forgot password?</a>
                    <div class="text-end mt-3">
                      <button class="btn btn-primary btn-block w-100" type="button" id="log_btn">Sign in</button>
                    </div>
                  </div>
                </form>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
      <script>
        $(document).ready(function() {
            $("#log_btn").click(function(){
                
              var email = $("#username").val();
              var password = $("#password").val();
              var access = $("#userRole").val();
              if($('#remembermecheck').prop('checked') === true){
                var rememberme = $('#remembermecheck').val();
              }else{
                var rememberme = 0;
              }
                var location = "http://localhost/vencar-account/home-dashboard.php" ;  
                
                if(email && password && access){
                  $.ajax({
                    url: "./include/ajax-call.php",
                    cache: false,
                    type: 'POST',
                    dataType : 'JSON',
                    data:{admin_login:1,email:email,password:password,access:access},
                    beforeSend: function() { 
                       $("#log_btn").html('Wait...');
                    }, 
                    success:function(data){
                        
                        if(data['errorCode'] == 100){ 
                            toastr.error(data['errorMessage']);
                            $("#log_btn").html('Sign In');
                        } 
                        
                        else if(data['errorCode'] == 200){
                            toastr["success"](data['errorMessage']);
                            setTimeout(function(){ window.location = location;}, 1000);
                        }

                    }     
                });
                }else{
                  alert('Please Fill Required Fields');
                }  
            }); 
        });
      </script>  
  </body>
</html>