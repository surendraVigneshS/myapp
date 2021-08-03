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
    <title>Add New Product | Freeztex | Accounts</title>
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
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/select2.css">
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
                                    <li class="breadcrumb-item">Add Store Room</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <form action="./include/_productController.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12 col-xl-10 col-md-10">

                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5>Add New Product</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="mb-4 row">
                                            <div class="col-6">
                                                <label class="col-form-label" for="productType">Product Type *</label>
                                                <select class="form-select" name="productType" required>
                                                    <option value="Purchase Item">Purchase Item</option>
                                                    <option value="Product Item">Product Item</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label" for="group">Item Group *</label>
                                                <select class="form-select select2" id="group" name="group" required>
                                                    <option value="">---</option>
                                                    <?php
                                                    $executeQuery = mysqli_query($dbconnection, "SELECT * FROM `ft_item_group` WHERE `group_status` = 1");
                                                    while ($row = mysqli_fetch_array($executeQuery)) {
                                                    ?>
                                                        <option value="<?php echo $row["group_id"]; ?>"> <?php echo $row["group_name"] ?> </option>
                                                    <?php  } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4 row">
                                            <div class="col-6">
                                                <label class="col-form-label" for="projectid">Project Title</label>
                                                <select class="form-select select2" name="projectid" id="projectid"  onchange="getval(this);" > 
                                                <option value="" selected>---</option>
                                                    <?php
                                                    $executeQuery = mysqli_query($dbconnection, "SELECT * FROM `ft_projects_tb` WHERE `project_status` = 1");
                                                    while ($row = mysqli_fetch_array($executeQuery)) {
                                                    ?>
                                                        <option value="<?php echo $row["project_id"]; ?>"> <?php echo $row["project_title"] ?> </option>
                                                    <?php  } ?>
                                                </select>
                                            </div>
                                            <div class="col-6" style="display: none;" id="qtydiv">
                                                <label class="col-form-label" for="group">Project Qty</label>
                                                <input type="text" class="form-control" name="projectqty" id="projectqty">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-8">
                                                <label class="form-label" for="name">Product Name</label>
                                                <input class="form-control" name="name" type="text" required>
                                            </div>
                                            <div class="col-4">
                                                <label class="form-label" for="uom">UOM *</label>
                                                <select class="form-select" id="uom" name="uom" required>
                                                    <?php
                                                    $executeQuery = mysqli_query($dbconnection, "SELECT * FROM `ft_uom` WHERE `uom_status` = 1");
                                                    while ($row = mysqli_fetch_array($executeQuery)) {
                                                    ?>
                                                        <option value="<?php echo $row["uom_name"]; ?>"> <?php echo $row["uom_name"] ?> </option>
                                                    <?php  } ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class=" row mb-4">
                                            <div class="col-6">
                                                <label class="form-label" for="specification">Specification </label>
                                                <input class="form-control" name="specification" type="text">
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label" for="minqty">Minimum Qty</label>
                                                <input class="form-control" name="minqty" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label" for="maxqty">Maximum Qty</label>
                                                <input class="form-control" name="maxqty" type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-6">
                                                <label class="form-label" for="remarks">Remarks </label>
                                                <textarea name="remarks" rows="2" class="form-control"></textarea>
                                            </div>
                                            <div class="col-3 ">
                                                <label for="quotation">Product Image </label>
                                                <input type="file" name="productImage" id="productImage">
                                            </div>
                                            <div class="col-3">
                                                <label for="quotation">Is the Product Consumables? </label>
                                                <div class="  m-checkbox-inline custom-radio-ml">
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radioinline1" type="radio" name="consumable" value="Yes" checked>
                                                        <label class="form-check-label mb-0" for="radioinline1"> Yes </label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radioinline2" type="radio" name="consumable" value="No" >
                                                        <label class="form-check-label mb-0" for="radioinline2"> No </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <hr class="my-4">

                                        <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <label for="user_name">Supplier Name</label>
                                                        <select class="form-select select2" name="supplierID[]"  >
                                                            <option value="" selected  >----</option>
                                                            <?php
                                                            $query = mysqli_query($dbconnection, "SELECT * FROM `supplier_details` ORDER BY `supplier_name` ASC ");
                                                            while ($rows = mysqli_fetch_assoc($query)) {
                                                            ?>
                                                                <option value="<?php echo $rows['cust_id']; ?>" class="text-capitalize">
                                                                    <?php echo $rows['supplier_name']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="quotation">Product Amount</label>
                                                        <input type="text" class="form-control" name="productAmount[]">
                                                    </div> 
                                                </div>
                                                <div id="divrow"></div>

                                                <div class="row my-3">
                                                    <div class="col-10 d-flex justify-content-end">
                                                        <div class="mx-3">
                                                            <button id="addRow" type="button" class="btn btn-success mr-4">Add Supplier</button> 
                                                        </div>
                                                        <div>
                                                            <button id="removeRow" type="button" class="btn btn-danger">Remove Supplier</button> 
                                                        </div>
                                                    </div>
                                                </div>


                                        <div class="card-footer text-center ">
                                            <button class="btn btn-info" type="submit" name="addProduct">Add New Product</button>
                                        </div> 
                                    </div>
                                </div> 
                            </div>
                            
                        </div>
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
        function getval(id){
            var projectid = id.value;  
                if (projectid > 0) {
                    $("#qtydiv").show(200); 
                    $("#projectqty").attr('required', true);
                }else{
                    $("#qtydiv").hide(200);
                    $("#projectqty").removeAttr('required');
                } 
            }
        $(function() {
            $("#addRow").click(function() {

                var elem = '<div class="row mt-4">';
                elem += '<div class="col-md-6">'; 
                elem += '<select class="form-select select2 lastclass" name="supplierID[]" required>';
                elem += '<option value="" selected  disabled>----</option>';
                <?php
                $query = mysqli_query($dbconnection, "SELECT * FROM `supplier_details` ORDER BY `supplier_name` ASC ");
                while ($rows = mysqli_fetch_assoc($query)) {
                ?>
                    elem += '<option value="<?php echo $rows['cust_id']; ?>" class="text-capitalize"><?php echo $rows['supplier_name']; ?></option>';
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

            

            $("input[name='projectid']").on('change', function() {
                 
                var projectid = $("#projectid:checked").val();
                 
                if (projectid > 0) {
                    $("#qtydiv").show(200); 
                    $("#projectqty").attr('required', true);
                }else{
                    $("#qtydiv").hide(200);
                    $("#projectqty").removeAttr('required');
                } 
            });


        });
    </script>
</body>

</html>