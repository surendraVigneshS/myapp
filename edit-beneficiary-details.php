<?php 
    include('./include/dbconfig.php');
    include('./include/function.php');
    include('./include/authenticate.php'); 
    $pur_id = $action ="";
    if(isset($_GET['fieldid'])){ $pur_id = $_GET['fieldid']; $pur_id = passwordDecryption($pur_id); }
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
    <title>VENCAR - Accounts</title>
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
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php if($action == 'editbeneficiary'){ echo 'Edit Beneficiary Details'; }if($action == 'editsupplier'){ echo 'Edit Supplier Details'; } ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <?php if($action == 'editbeneficiary'){ ?>
                                            <form action="./include/_editController.php" method="POST">
                                                <input type="hidden" name="beneId" id="beneId" value="<?php echo $pur_id; ?>">
                                                <?php 
                                                    $selectquery = "SELECT * FROM `supplier_details` WHERE `cust_id` = '$pur_id' ";
                                                    $executequery = mysqli_query($dbconnection,$selectquery);
                                                    if(mysqli_num_rows($executequery) > 0){
                                                      if($row = mysqli_fetch_array($executequery)){
                                                        $beneficiaryname = $row['supplier_name'];
                                                        $beneficiarymail = $row['supplier_email'];
                                                        $beneficiarymobile = $row['supplier_mobile'];
                                                        $beneficiarybranch = $row['supplier_branch'];
                                                        $beneficiaryaccno = $row['supplier_acc_no'];
                                                        $beneficiaryifsc = $row['supplier_ifsc_code'];
                                                ?>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="beneName">Beneficiary Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="beneName" name="beneName" value="<?php echo $beneficiaryname ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="beneEmail">Beneficiary Email</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" id="beneEmail" name="beneEmail" value="<?php echo $beneficiarymail ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="beneMobile">Beneficiary Mobile</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="beneMobile" name="beneMobile" value="<?php echo $beneficiarymobile ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="beneName">Beneficiary Branch</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="beneBranch" name="beneBranch" value="<?php echo $beneficiarybranch ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="beneAccno">Beneficiary Acc No</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="beneAccno" name="beneAccno" value="<?php echo $beneficiaryaccno ?>" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label" for="beneifsc">Beneficiary IFSC Code</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="beneifsc" name="beneifsc" minlength="7" value="<?php echo $beneficiaryifsc ?>" required>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-center">
                                                    <button class="btn btn-primary" type="submit" name="editBeneficiary" id="editBeneficiary">Save Changes</button>
                                                </div>
                                                <?php } } ?>
                                            </form>
                                            <?php }if($action == 'editsupplier'){ ?>
                                                <form action="./include/_editController.php" method="POST">
                                                <input type="hidden" name="supplierId" id="supplierId" value="<?php echo $pur_id; ?>">
                                                <?php 
                                                    $selectquery = "SELECT * FROM `supplier_details` WHERE `cust_id` = '$pur_id' ";
                                                    $executequery = mysqli_query($dbconnection,$selectquery);
                                                    if(mysqli_num_rows($executequery) > 0){
                                                      if($row = mysqli_fetch_array($executequery)){
                                                        $suppliername = $row['supplier_name'];
                                                        $suppliermail = $row['supplier_email'];
                                                        $suppliermobile = $row['supplier_mobile']; 
                                                ?> 
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="supplierName">Supplier Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="supplierName" name="supplierName" value="<?php echo $suppliername ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="supplierEmail">Supplier Email</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" id="supplierEmail" name="supplierEmail" value="<?php echo $suppliermail ?>" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-4 col-form-label" for="supplierMobile">Supplier Mobile</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="supplierMobile" name="supplierMobile" value="<?php echo $suppliermobile ?>" required>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-center">
                                                    <button class="btn btn-primary" type="submit" name="editSupplier" id="editSupplier">Save Changes</button>
                                                </div>
                                                <?php } } ?>
                                            </form>
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

</body>

</html>