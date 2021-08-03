<?php 
    include('./include/dbconfig.php');
    include('./include/function.php');
    include('./include/authenticate.php'); 
    $pur_id = $action = $flowmethod = ""; 
    if(isset($_GET['fieldid'])){ $pur_id = $_GET['fieldid']; $pur_id = passwordDecryption($pur_id); }
    if(isset($_GET['action'])) { $action = $_GET['action']; }
    if(isset($_GET['flow'])) { $flowmethod = $_GET['flow']; }
?> 
<!DOCTYPE html>
<html lang="en">  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <title>Create New Organization |Freeztex | Accounts</title>
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
                                    <li class="breadcrumb-item"><?php if($action == 'addorganization'){ echo 'Add New Organization'; }if($action == 'editorganization'){ echo 'Edit Details'; } ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-xl-8">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php if($action == 'addorganization'){ echo 'Add New Organization'; }if($action == 'editorganization'){ echo 'Edit Organization Details'; } ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <?php if($action == 'addorganization'){ ?>
                                            <form action="./include/_orgController.php" method="POST">
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="orgName">Organization Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="orgName" name="orgName" required>
                                                    </div>
                                                </div> 
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label">Chose Organization Color</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control form-control-color" type="color" value="#000" colorpick-eyedropper-active="true" name="orgColor" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row" id="userflow">
                                                    <label class="col-sm-4 col-form-label">Payment Organization Flow</label>
                                                    <div class="col-sm-8">
                                                        <div class="m-checkbox-inline">
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-1" type="checkbox" name="orgflow1" value="1">
                                                              <label class="form-check-label label-1" for="inline-1">Team Lead</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-5" type="checkbox" name="orgflow2" value="1">
                                                              <label class="form-check-label label-1" for="inline-5">Organization Lead</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-2" type="checkbox" name="orgflow3" value="1">
                                                              <label class="form-check-label label-2" for="inline-2">Accounts</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-3" type="checkbox" name="orgflow4" value="1">
                                                              <label class="form-check-label label-3" for="inline-3">MD</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-4" type="checkbox" name="orgflow5" value="1">
                                                              <label class="form-check-label label-4" for="inline-4">Finance</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row" id="Purchaseuserflow">
                                                    <label class="col-sm-4 col-form-label">Purchase Organization Flow</label>
                                                    <div class="col-sm-8">
                                                        <div class="m-checkbox-inline">
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-6" type="checkbox" name="orgflow6" value="1" <?php if(!empty($flow6)){ echo 'checked'; } ?>>
                                                              <label class="form-check-label label-1" for="inline-6">Organization Lead</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-7" type="checkbox" name="orgflow7" value="1" <?php if(!empty($flow7)){ echo 'checked'; } ?>>
                                                              <label class="form-check-label label-1" for="inline-7">MD</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-8" type="checkbox" name="orgflow8" value="1" <?php if(!empty($flow8)){ echo 'checked'; } ?>>
                                                              <label class="form-check-label label-1" for="inline-8">Purchase Team</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-center">
                                                    <button class="btn btn-primary" type="submit" name="addorganization" id="addorganization">Submit</button>
                                                </div>
                                            </form>
                                            <?php }if($action == 'editorganization'){
                                                $customerselect = "SELECT * FROM `organization` WHERE `id` = '$pur_id'";
                                                $custoemrquery = mysqli_query($dbconnection, $customerselect);
                                                if (mysqli_num_rows($custoemrquery) > 0) {
                                                    if($row = mysqli_fetch_array($custoemrquery)){
                                                        $orgId = $row['id'];
                                                        $orgName = $row['organization_name'];
                                                        $orgFlow = $row['org_flow'];   
                                                        $orgColor = $row['org_color'];   
                                                        $flow1 = $row['first_approval'];
                                                        $flow2 = $row['orglead_approval'];
                                                        $flow3 = $row['second_approval'];
                                                        $flow4 = $row['third_approval'];
                                                        $flow5 = $row['fourth_apporval'];  
                                                        $flow6 = $row['purchase_orglead_approval'];  
                                                        $flow7 = $row['purchase_fisrt_approval'];  
                                                        $flow8 = $row['purchase_second_approval'];  
                                            ?>
                                            <form action="./include/_orgController.php" method="POST">
                                                <input type="hidden" name="orgId" id="orgId" value="<?php echo $orgId; ?>"> 
                                                <input type="hidden" name="orgAction" id="orgAction" value="<?php echo $flowmethod; ?>"> 
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="orgName">Organization Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="orgName" name="orgName" value="<?php echo $orgName ?>" required>
                                                    </div>
                                                </div>  
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label">Chose Organization Color</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control form-control-color" type="color" value="<?php echo $orgColor ?>" colorpick-eyedropper-active="true" name="orgColor" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row" id="userflow">
                                                    <label class="col-sm-4 col-form-label"><?php if($flowmethod == 'payment'){ echo 'Payment'; }if($flowmethod == 'purchase'){ echo 'Purchase'; } ?> Organization Flow</label>
                                                    <?php if($flowmethod == 'payment'){ ?>
                                                    <div class="col-sm-8">
                                                        <div class="m-checkbox-inline">
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-1" type="checkbox" name="orgflow1" value="1" <?php if(!empty($flow1)){ echo 'checked'; } ?>>
                                                              <label class="form-check-label label-1" for="inline-1">Team  Leader</label>
                                                            </div>
                                                            <?php if($orgId != 1){ ?>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-5" type="checkbox" name="orgflow2" value="1" <?php if(!empty($flow2)){ echo 'checked'; } ?>>
                                                              <label class="form-check-label label-5" for="inline-5">Organization Lead</label>
                                                            </div>
                                                            <?php } ?>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-2" type="checkbox" name="orgflow3" value="1" <?php if(!empty($flow3)){ echo 'checked'; } ?>>
                                                              <label class="form-check-label label-2" for="inline-2">Accounts</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-3" type="checkbox" name="orgflow4" value="1" <?php if(!empty($flow4)){ echo 'checked'; } ?>>
                                                              <label class="form-check-label label-3" for="inline-3">MD</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-4" type="checkbox" name="orgflow5" value="1" <?php if(!empty($flow5)){ echo 'checked'; } ?>>
                                                              <label class="form-check-label label-4" for="inline-4">Finance</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <?php if($flowmethod == 'purchase'){ ?>
                                                    <div class="col-sm-8">
                                                        <div class="m-checkbox-inline">
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-1" type="checkbox" name="orgflow6" value="1" <?php if(!empty($flow6)){ echo 'checked'; } ?>>
                                                              <label class="form-check-label label-1" for="inline-1">Organization Lead</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-3" type="checkbox" name="orgflow7" value="1" <?php if(!empty($flow7)){ echo 'checked'; } ?>>
                                                              <label class="form-check-label label-3" for="inline-3">MD</label>
                                                            </div>
                                                            <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                                                              <input class="form-check-input" id="inline-4" type="checkbox" name="orgflow8" value="1" <?php if(!empty($flow8)){ echo 'checked'; } ?>>
                                                              <label class="form-check-label label-4" for="inline-4">Purchase Team</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="card-footer text-center">
                                                    <button class="btn btn-primary" type="submit" name="editOrganization" id="editOrganization">Save Changes</button>
                                                </div>
                                            </form>
                                            <?php } } } ?>
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
</body>

</html>