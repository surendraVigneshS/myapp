<?php 
    include('./include/dbconfig.php');
    include('./include/function.php');
    include('./include/authenticate.php'); 
    $action =""; 
    if(isset($_GET['action'])) { $action = $_GET['action']; }
?> 
<!DOCTYPE html>
<html lang="en">  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <title>Edit User Details |Freeztex | Accounts</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
</head>

<body>
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include('./include/topbar.php'); ?>
        <div class="page-body-wrapper">
            <?php include('./include/left-sidebar.php'); ?>
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><?php if($action == 'addemployee'){ echo 'Add New Employee'; }if($action == 'editemployee'){ echo 'Edit Details'; } ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-xl-9">
                            <div class="row">
                            <?php if (isset($_SESSION['userprofileSuccess'])) { ?>
                            <div class="col-lg-8">
                                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                <p> <?php echo $_SESSION['userprofileSuccess']; ?> </p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php }
                            unset($_SESSION['userprofileSuccess']);
                            if (isset($_SESSION['userprofileFailed'])) { ?>
                                <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                                <p> <?php echo $_SESSION['userprofileFailed']; ?> </p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php } unset($_SESSION['userprofileFailed']); ?>
                            </div>
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php if($action == 'editemployee'){ echo 'Edit Profile Details'; } ?></h5>
                                        </div>
                                        <div class="card-body"> 
                                            <?php  if($action == 'editemployee'){
                                                $customerselect = "SELECT * FROM `admin_login` WHERE `emp_id` = '$logged_admin_id'";
                                                $custoemrquery = mysqli_query($dbconnection, $customerselect);
                                                if (mysqli_num_rows($custoemrquery) > 0) {
                                                    if($row = mysqli_fetch_array($custoemrquery)){
                                                        $empid = $row['emp_id'];
                                                        $empno = $row['emp_no']; 
                                                        $empemail = $row['emp_email'];
                                                        $empname = $row['emp_name'];
                                                        $empmobile = $row['emp_mobile'];
                                                        $emprole = $row['emp_role'];
                                                        $empstatus = $row['emp_status'];    
                                            ?>
                                            <form action="./include/_userController.php" method="POST">
                                                <input type="hidden" name="empid" id="empid" value="<?php echo $logged_admin_id; ?>"> 
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="empEmail">Your Email</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" id="empEmail" name="empEmail" value="<?php echo $empemail ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="empName">Your Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="empName" name="empName" value="<?php echo $empname ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="empMobile">Your Mobile</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="empMobile" name="empMobile" value="<?php echo $empmobile ?>" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="empNo">Your Role</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-select digits" id="empRole" name="empRole" disabled>
                                                            <option value="1" <?php if($emprole == 1){ echo 'selected'; } ?>> Admin </option>
                                                            <option value="2" <?php if($emprole == 2){ echo 'selected'; } ?>>Managing Director</option>
                                                            <option value="3" <?php if($emprole == 3){ echo 'selected'; } ?>>Team Leader</option>
                                                            <option value="4" <?php if($emprole == 4){ echo 'selected'; } ?>>Account Team</option>
                                                            <option value="6" <?php if($emprole == 6){ echo 'selected'; } ?>>Employee</option>
                                                            <option value="5" <?php if($emprole == 5){ echo 'selected'; } ?>>Purchase Team</option>
                                                            <option value="7" <?php if($emprole == 7){ echo 'selected'; } ?>>Purchase Lead</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="row mb-3">
                                                    <label class="col-sm-4 col-form-label" for="empStatus">Your Status</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-select digits" id="empStatus" name="empStatus" disabled>
                                                            <option value="1" <?php if($empstatus == 1){ echo 'selected'; } ?>>Active</option>
                                                            <option value="4" <?php if($empstatus == 4){ echo 'selected'; } ?>>In Active</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <?php if(checkUserflow($dbconnection,$logged_admin_id)){ ?>
                                                <div class="row" id="userflow">
                                                    <label class="col-sm-4 col-form-label">Payment User Flow</label>
                                                    <div class="col-sm-8">
                                                        <?php 
                                                            $selectpaymentflow = mysqli_query($dbconnection, "SELECT * FROM `payment_user_flow` WHERE `emp_id` = '$pur_id'");
                                                            if($rowpaymentflow = mysqli_fetch_array($selectpaymentflow)){
                                                                $paymentflow1 = $rowpaymentflow['first_approval'];
                                                                $paymentflow2 = $rowpaymentflow['orglead_approval'];
                                                                $paymentflow3 = $rowpaymentflow['second_approval'];
                                                                $paymentflow4 = $rowpaymentflow['third_approval'];
                                                                $paymentflow5 = $rowpaymentflow['fourth_apporval'];
                                                            }
                                                        ?>
                                                        <div class="m-checkbox-inline">
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-1" type="checkbox" name="orgflow1" value="1" <?php if(!empty($paymentflow1)){ echo 'checked'; } ?> disabled>
                                                              <label class="form-check-label label-1" for="inline-1">Team Lead</label>
                                                            </div>
                                                            <?php if($logged_admin_org != 1){ ?>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-2" type="checkbox" name="orgflow2" value="1" <?php if(!empty($paymentflow2)){ echo 'checked'; } ?> disabled>
                                                              <label class="form-check-label label-2" for="inline-2">Organization Lead</label>
                                                            </div>
                                                            <?php } ?>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-2" type="checkbox" name="orgflow3" value="1" <?php if(!empty($paymentflow3)){ echo 'checked'; } ?> disabled>
                                                              <label class="form-check-label label-2" for="inline-2">Accounts</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-3" type="checkbox" name="orgflow4" value="1" <?php if(!empty($paymentflow4)){ echo 'checked'; } ?> disabled>
                                                              <label class="form-check-label label-3" for="inline-3">MD</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-4" type="checkbox" name="orgflow5" value="1" <?php if(!empty($paymentflow5)){ echo 'checked'; } ?> disabled>
                                                              <label class="form-check-label label-4" for="inline-4"><?php if($logged_admin_org == 2){ echo 'AGEM Finance'; }else{ echo 'Finance'; } ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php if(checkUserPurchaseflow($dbconnection,$logged_admin_id)){ ?>
                                                <div class="row" id="userflow">
                                                    <label class="col-sm-4 col-form-label">Purchase User Flow</label>
                                                    <div class="col-sm-8">
                                                        <?php 
                                                            $selectpurchaseflow = mysqli_query($dbconnection, "SELECT * FROM `purchase_user_flow` WHERE `emp_id` = '$pur_id'");
                                                            if(mysqli_num_rows($selectpurchaseflow) > 0){
                                                                if($rowpurchaseflow = mysqli_fetch_array($selectpurchaseflow)){
                                                                    $purchaseflow1 = $rowpurchaseflow['orglead_approval'];
                                                                    $purchaseflow2 = $rowpurchaseflow['first_approval'];
                                                                    $purchaseflow3 = $rowpurchaseflow['second_approval'];
                                                                }
                                                            }
                                                        ?>
                                                        <div class="m-checkbox-inline">
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-1" type="checkbox" name="orgflow1" value="1" <?php if(!empty($purchaseflow1)){ echo 'checked'; } ?> disabled>
                                                              <label class="form-check-label label-1" for="inline-1">Organization Lead</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-3" type="checkbox" name="orgflow4" value="1" <?php if(!empty($purchaseflow2)){ echo 'checked'; } ?> disabled>
                                                              <label class="form-check-label label-3" for="inline-3">MD</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-4" type="checkbox" name="orgflow5" value="1" <?php if(!empty($purchaseflow3)){ echo 'checked'; } ?> disabled>
                                                              <label class="form-check-label label-4" for="inline-4">Purchase Team</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                 

                                                <div class="card-footer text-center mt-2">
                                                    <button class="btn btn-info" type="submit" name="updateProfile" id="updateProfile">Save Changes</button>
                                                </div>
                                            </form>
                                            <?php } }else{ ?> 
                                            <h3>Error Loading This Page</h3> 
                                            <?php } }else { ?>
                                            <h3>Error Loading This Page</h3>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php include('./include/footer.php'); ?>
    </div>
    </div>
    <script src="./assets/js/jquery-3.5.1.min.js"></script>
    <script src="./assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="./assets/js/icons/feather-icon/feather-icon.js"></script>
    <script src="./assets/js/scrollbar/simplebar.js"></script>
    <script src="./assets/js/scrollbar/custom.js"></script>
    <script src="./assets/js/config.js"></script>
    <script src="./assets/js/sidebar-menu.js"></script>
    <script src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        function checkPass(){
    		var password = document.getElementById('empconPassword');
    		var confirm  = document.getElementById('empPassword');
			var message = document.getElementById('confirm-message2');
    		var good_color = "#66cc66";
    		var bad_color  = "#ff6666";
			var strongRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
			var pass =  password.value;
			if( pass == confirm.value &&  strongRegex.test(pass)){
				message.style.color = good_color;
				message.innerHTML  = 'Passwords Match';
				$("#addEmployee").removeAttr("disabled");
			}else{
				message.style.color = bad_color;
				message.innerHTML = 'Passwords Do Not Match!!!!';
				$("#addEmployee").attr("disabled", "true");
			}
		}
        $('#empRole').on('change',function(){
            var selection = $(this).val();
            switch(selection){
                case "6":
                    $("#teamLeader").show();
                    $("#teamLeaderdiv").show();
                break;
                default:
                    $("#teamLeader").hide();
                    $("#teamLeaderdiv").hide();
            }
        });
    </script>
</body>

</html>