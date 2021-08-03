<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');
$pur_id = $action = "";
if (isset($_GET['fieldid'])) {
    $pur_id = $_GET['fieldid'];
    $pur_id = passwordDecryption($pur_id);
}
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <title>Edit Supplier | Freeztex | Accounts</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/select2.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
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
                                    <li class="breadcrumb-item">Edit Supplier Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <form action="./include/_editController.php" method="POST">
                    <div class="row">
                        <div class="col-sm-12 col-xl-7 col-md-7">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Edit Supplier Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <?php
                                            if ($action == 'editsupplier') {
                                                $customerselect = "SELECT * FROM `supplier_details` WHERE `cust_id` = '$pur_id'";
                                                $custoemrquery = mysqli_query($dbconnection, $customerselect);
                                                if (mysqli_num_rows($custoemrquery) > 0) {
                                                    if ($row = mysqli_fetch_array($custoemrquery)) {
                                                        $suppliername = $row['supplier_name'];
                                                        $suppliermail = $row['supplier_email'];
                                                        $suppliermobile = $row['supplier_mobile'];
                                                        $supplierbranch = $row['supplier_branch'];
                                                        $supplieraccno = $row['supplier_acc_no'];
                                                        $supplierifsc = $row['supplier_ifsc_code'];
                                                        $suppliergst = $row['supplier_gst'];
                                                        $supplieraddress = $row['supplier_address'];
                                                        $suppliercity = $row['supplier_city'];
                                                        $supplierpincode = $row['supplier_pincode'];
                                            ?>
                                                            <input type="hidden" name="supplierid" id="supplierid" value="<?php echo $pur_id; ?>">
                                                            <div class="mb-3 row">
                                                                <label class="col-sm-4 col-form-label" for="empNo">Supplier Name</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="supplierName" name="supplierName" value="<?php echo $suppliername ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-sm-4 col-form-label" for="empEmail">Supplier Email</label>
                                                                <div class="col-sm-8">
                                                                    <input type="email" class="form-control" id="supplierEmail" name="supplierEmail" value="<?php echo $suppliermail ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-sm-4 col-form-label" for="empMobile">Supplier Mobile</label>
                                                                <div class="col-sm-8">
                                                                    <input class="form-control" id="supplierMobile" name="supplierMobile" value="<?php echo $suppliermobile ?>" required nkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-sm-4 col-form-label" for="empNo">Supplier GST No</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="supplierGST" name="supplierGST" value="<?php echo $suppliergst ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-sm-4 col-form-label" for="empNo">Supplier Address</label>
                                                                <div class="col-sm-8">
                                                                    <textarea name="supplierAddress" id="supplierAddress" rows="3" class="form-control"><?php echo $supplieraddress ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-sm-4 col-form-label" for="empNo">Supplier City</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="supplierCity" name="supplierCity" value="<?php echo $suppliercity ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-sm-4 col-form-label" for="empNo">Supplier Pincode</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="supplierPincode" name="supplierPincode" value="<?php echo $supplierpincode ?>" nkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="6" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-sm-4 col-form-label" for="empNo">Supplier Branch</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="supplierBranch" name="supplierBranch" value="<?php echo $supplierbranch ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-sm-4 col-form-label" for="empNo">Supplier Acc No</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="supplierAcc" name="supplierAcc" value="<?php echo $supplieraccno ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 row">
                                                                <label class="col-sm-4 col-form-label" for="empNo">Supplier IFSC Code</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" class="form-control" id="supplierIFSC" name="supplierIFSC" value="<?php echo $supplierifsc ?>" minlength="11" maxlength="11" required>
                                                                </div>
                                                            </div>
                                                         
                                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xl-5 col-md-5">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Edit Product Amount</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="user_name">Product Name</label>
                                                </div>
                                                <div class="col-6">
                                                    <label for="quotation">Product Amount</label>
                                                </div>
                                            </div>
                                            <div id="divrow">
                                                <?php
                                                        $query1 = mysqli_query($dbconnection, "SELECT * FROM `ft_product_details` WHERE  `supplier_id` = '$pur_id'");
                                                        while ($suprow = mysqli_fetch_assoc($query1)) {
                                                ?>
                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
                                                            <select class="form-select select2" name="productId[]" required>
                                                                <option value="" selected>----</option>
                                                                <?php
                                                                $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_master` LEFT JOIN `ft_product_details` ON `ft_product_details`.`product_id` =  `ft_product_master`.`product_id` ORDER BY `product_group` ASC");
                                                                while ($rows = mysqli_fetch_assoc($query)) {
                                                                ?>
                                                                    <option value="<?php echo $rows['product_id']; ?>" class="text-capitalize" <?php if ($suprow["product_id"] == $rows['product_id']) { echo 'selected'; } ?>>
                                                                        <?php echo $rows['product_name']; ?>
                                                                    </option>
                                                                <?php
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="productAmount[]" value="<?php echo $suprow["details_amount"]; ?>" required>
                                                        </div>
                                                    </div>
                                                <?php
                                                        } ?>
                                            </div>

                                            <div class="row my-3">
                                                <div class="col-10 d-flex justify-content-end">
                                                    <div class="mx-3">
                                                        <button id="addRow" type="button" class="btn btn-success mr-4">Add Product</button>
                                                    </div>
                                                    <div>
                                                        <button id="removeRow" type="button" class="btn btn-danger">Remove Product</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                                                <button class="btn btn-primary" type="submit" name="updateSupplier" id="updateSupplier">Save Changes</button>
                                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php }
                                                }
                                            } ?>
                    </div>
                    </form> 
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
    <script src="./assets/js/select2/select2.full.min.js"></script>
    <script src="./assets/js/script.js"></script>
    <script>
        $(function() {
            $("#addRow").click(function() {

                var elem = '<div class="row mt-4">';
                elem += '<div class="col-md-6">';
                elem += '<select class="form-select select2 lastclass" name="productId[]" required>';
                elem += '<option value="" selected  disabled>----</option>';
                <?php
                $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_master` LEFT JOIN `ft_product_details` ON `ft_product_details`.`product_id` =  `ft_product_master`.`product_id` ORDER BY `product_group` ASC");
                while ($rows = mysqli_fetch_assoc($query)) {
                ?>
                    elem += '<option value="<?php echo $rows['product_id']; ?>" class="text-capitalize"><?php echo $rows['product_name']; ?></option>';
                <?php } ?>
                elem += '</select>';
                elem += '</div>';
                elem += '<div class="col-md-6">';
                elem += '<input type="text" class="form-control" name="productAmount[]">';
                elem += '</div>';
                elem += '</div>';

                $("#divrow").append(elem);
                $('.lastclass:last').select2();
            });

            $("#removeRow").click(function() {
                if ($('#divrow div.row').length >= 1) {
                    $('#divrow div.row').last().remove();
                } else {
                    alert("You can't remove Rows anymore..!");
                }
            });




        });
    </script>
</body>

</html>