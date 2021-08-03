<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');
$fieldid = $action = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
if (isset($_GET['fieldid'])) {
    $fieldid = passwordDecryption($_GET['fieldid']);
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
    <title>Edit Product | Freeztex | Accounts</title>
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
    <style>
        .card .card-body {
            padding: 10px 20px;
        }

        .ellipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ellipsis:hover {
            text-overflow: initial;
            overflow: visible;
            white-space: normal;
        }
    </style>
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
                                <h3> Product Master</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="./product-list.php"><i data-feather="server"></i></a></li>
                                    <li class="breadcrumb-item">Edit Product</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <form action="./include/_productController.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="fieldid" value="<?php echo $fieldid; ?>">
                        <?php
                        $productimgUrl = "./assets/images/product/";
                        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_master` LEFT JOIN `ft_store_room` ON `ft_store_room`.`store_id` =  `ft_product_master`.`location_id` WHERE `product_id` = '$fieldid'");
                        if (mysqli_num_rows($query) > 0) {
                            if ($row = mysqli_fetch_array($query)) {
                                $curunit = $row["product_unit"]; ?>
                                <div class="row">
                                    <div class="col-sm-12 col-xl-7 col-md-7">

                                        <div class="card">
                                            <div class="card-header text-center">
                                                <h5>Edit Product Details</h5>
                                            </div>
                                            <div class="card-body">

                                                <div class="mb-4 row">
                                                    <div class="col-6">
                                                        <label class="col-form-label" for="productType">Product Type *</label>
                                                        <select class="form-select" name="productType" required>
                                                            <option value="Purchase Item" <?php if ($row["product_type"] == 'Purchase Item') {
                                                                                                echo 'selected';
                                                                                            } ?>>Purchase Item</option>
                                                            <option value="Product Item" <?php if ($row["product_type"] == 'Product Item') {
                                                                                                echo 'selected';
                                                                                            } ?>>Product Item</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="col-form-label" for="group">Group *</label>
                                                        <select class="form-select" id="group" name="group" required>
                                                            <?php
                                                            $executeQuery = mysqli_query($dbconnection, "SELECT * FROM `ft_item_group` WHERE `group_status` = 1");
                                                            while ($row2 = mysqli_fetch_array($executeQuery)) {
                                                            ?>
                                                                <option value="<?php echo $row2["group_id"]; ?>" <?php if ($row2["group_id"] == $row["product_group"]) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>> <?php echo $row2["group_name"] ?> </option>
                                                            <?php  } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-8">
                                                        <label class="form-label" for="name">Product Name</label>
                                                        <input class="form-control" name="name" type="text" value="<?php echo $row["product_name"] ?>" required>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label" for="uom">UOM *</label>
                                                        <select class="form-select" id="uom" name="uom" required>
                                                            <?php
                                                            $executeQuery2 = mysqli_query($dbconnection, "SELECT * FROM `ft_uom` WHERE `uom_status`=1");
                                                            while ($row3 = mysqli_fetch_array($executeQuery2)) {
                                                            ?>
                                                                <option value="<?php echo $row3["uom_name"]; ?>" <?php if ($row3["uom_name"] == $row["product_unit"]) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>> <?php echo $row3["uom_name"] ?> </option>
                                                            <?php  } ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class=" row mb-4">
                                                    <div class="col-6">
                                                        <label class="form-label" for="specification">Specification </label>
                                                        <input class="form-control" name="specification" type="text" value="<?php echo $row['product_specification']; ?>">
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="form-label" for="minqty">Minimum Qty</label>
                                                        <input class="form-control" name="minqty" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $row['min_qty']; ?>">
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="form-label" for="maxqty">Maximum Qty</label>
                                                        <input class="form-control" name="maxqty" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $row['max_qty']; ?>">
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-6">
                                                        <label class="form-label" for="remarks">Remarks </label>
                                                        <textarea name="remarks" rows="2" class="form-control"><?php echo $row['product_remarks']; ?></textarea>
                                                    </div>
                                                    <div class="col-6 mt-4">
                                                        <label for="quotation">Is the Product Consumables? </label>
                                                        <div class="  m-checkbox-inline custom-radio-ml">
                                                            <div class="form-check form-check-inline radio radio-primary">
                                                                <input class="form-check-input" id="radioinline1" type="radio" name="consumable" value="Yes" <?php if ($row["product_consumable"] == 'Yes') {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label mb-0" for="radioinline1"> Yes </label>
                                                            </div>
                                                            <div class="form-check form-check-inline radio radio-primary">
                                                                <input class="form-check-input" id="radioinline2" type="radio" name="consumable" value="No" <?php if ($row["product_consumable"] == 'No') {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label mb-0" for="radioinline2"> No </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6 ">
                                                        <label for="quotation">Product Image </label>
                                                        <input type="file" name="productImage" id="productImage">
                                                    </div>
                                                    <?php if (!empty($row["product_image"])) { ?>
                                                        <div class="col-6 d-flex justify-content-center">
                                                            <label class="form-label" for="remarks">Current Image :</label>
                                                            <img src="<?php echo $productimgUrl . $row["product_image"]; ?>" width="150" height="150">
                                                        </div>
                                                    <?php } ?>
                                                </div>


                                                <div class="card-footer text-center ">
                                                    <button class="btn btn-info" type="submit" name="updateProduct">Save Changes</button>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 col-xl-5 col-md-5">
                                        <div class="card">
                                            <div class="card-header text-center">
                                                <h5>Add Suppliers</h5>
                                            </div>
                                            <div class="card-body">
                                            <div id="divrow">
                                            <?php
                                            $query1 = mysqli_query($dbconnection, "SELECT * FROM `ft_product_details` WHERE  `product_id` = '$fieldid'");
                                            while ($suprow = mysqli_fetch_assoc($query1)) {
                                            ?>
                                                <div class="row mt-4">
                                                    <div class="col-md-7">
                                                        <label for="user_name">Supplier Name</label>
                                                        <select class="form-select select2" name="supplierID[]"  >
                                                            <option value="" selected  > </option>
                                                            <?php
                                                            $query = mysqli_query($dbconnection, "SELECT * FROM `supplier_details` ORDER BY `supplier_name` ASC ");
                                                            while ($rows = mysqli_fetch_assoc($query)) {
                                                            ?>
                                                                <option value="<?php echo $rows['cust_id']; ?>" class="text-capitalize"
                                                                <?php if($suprow["supplier_id"] == $rows['cust_id']){echo'selected';} ?>
                                                                >
                                                                    <?php echo $rows['supplier_name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label for="quotation">Product Amount</label>
                                                        <input type="text" class="form-control" name="productAmount[]" value="<?php echo $suprow["details_amount"] ?>">
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                
                                                    
                                                </div>

                                                <div class="row my-3">
                                                    <div class="col-12 d-flex justify-content-around">
                                                        <button id="addRow" type="button" class="btn btn-success mr-4">Add</button>
                                                        <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="card">
                                            <div class="card-header text-center">
                                                <h5>Edit Store Room</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row my-3 d-flex align-items-center justify-content-center">
                                                    <div class="col-5">
                                                        <label for="user_name">Select Store Room :</label> 
                                                    </div> 
                                                    <div class="col-7"> 
                                                        <select class="form-select" name="storeroom">
                                                            <option value="" selected  > </option>
                                                            <?php
                                                            $query = mysqli_query($dbconnection, "SELECT * FROM `ft_store_room`");
                                                            while ($row4 = mysqli_fetch_assoc($query)) {
                                                            ?>
                                                                <option value="<?php echo $row4['store_id']; ?>"  <?php if ($row4["store_id"] == $row["location_id"]) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?> class="text-capitalize">
                                                                    <?php echo $row4['store_name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div> 
                                                </div> 
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            <?php  }
                        } else { ?>
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>Error Loading the page</h4>
                                </div>
                            </div>
                        <?php } ?>
                    </form>
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
    <script src="./assets/js/select2/select2.full.min.js"></script> 
    <script src="./assets/js/script.js"></script>
    <script>
        $(function() {
            $("#addRow").click(function() {

                var elem = '<div class="row mt-4">';
                elem += '<div class="col-md-7">'; 
                elem += '<select class="form-select lastclass" name="supplierID[]" required>';
                elem += '<option value="" selected > </option>';
                <?php
                $query = mysqli_query($dbconnection, "SELECT * FROM `supplier_details` ORDER BY `supplier_name` ASC ");
                while ($rows = mysqli_fetch_assoc($query)) {
                ?>
                    elem += '<option value="<?php echo $rows['cust_id']; ?>" class="text-capitalize"><?php echo $rows['supplier_name']; ?></option>';
                <?php } ?>
                elem += '</select>';
                elem += '</div>';
                elem += '<div class="col-md-5">'; 
                elem += '<input type="text" class="form-control" name="productAmount[]">'; 
                elem += '</div>';
                elem += '</div>';

                $("#divrow").append(elem);
                $('.lastclass').select2();
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