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
    <title>Add New Purchase Order | Freeztex | Accounts</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/date-picker.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/select2.css">
    <style>
        .card .card-body,
        .card .card-footer {
            padding: 10px 20px;
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
                                <h3> Purchase Order</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="./po-list.php"><i data-feather="archive"></i></a></li>
                                    <li class="breadcrumb-item">Add Purchase Order</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <form action="./include/_dcController.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5>Add New Purchase Order</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="mb-4 row">
                                            <div class="col-6">
                                                <label class="col-form-label" for="dcType">DC Type *</label>
                                                <select class="form-select" name="dcType" required>
                                                    <option value="1">General DC Returnable </option>
                                                    <option value="2">General DC Non Returnal</option>
                                                    <option value="3">General DC Against Receipt</option>
                                                </select>
                                            </div>

                                            <div class="col-6">
                                                <label class="col-form-label" for="group">DC Date *</label>
                                                <input type="text" id="datepicker1" class="form-control" name="dcDate" value="<?php echo Date('d-m-Y'); ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6 col-sm-12">
                                                <label for="user_name">Issued To </label>
                                                <select class="form-select select2" name="issuedTo" id="issuedTo" required>
                                                    <option value="" selected disabled>----</option>
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
                                            <div class="col-md-6 col-sm-12">
                                                <label class="col-form-label " for="itemGroup">Item Group</label>
                                                <select class="form-select select2" id="itemGroup" name="itemGroup">
                                                    <option value="" selected disabled>---</option>
                                                    <?php
                                                    $executeQuery = mysqli_query($dbconnection, "SELECT * FROM `ft_item_group` WHERE `group_status` = 1");
                                                    while ($row = mysqli_fetch_array($executeQuery)) {
                                                    ?>
                                                        <option value="<?php echo $row["group_id"]; ?>"> <?php echo $row["group_name"] ?> </option>
                                                    <?php  } ?>
                                                </select>
                                            </div>
                                        </div>  
                                        

                                        <hr>
                                        <h6 class="mb-3">Product List</h6>
                                        <div class="row mb-3 ">
                                            <div class="col-6">
                                                <label class="col-form-label" for="proId">Product Name *</label>
                                                <select class="form-select    productList" id="proId">
                                                    <option value="" selected>---</option> 
                                                </select>
                                            </div>

                                            <div class="col-3">
                                                <label class="col-form-label" for="productQty">Product Available Qty  </label>
                                                <input class="form-control" type="text" id="productavailableQty" readonly>
                                            </div> 

                                            <div class="col-3">
                                                <label class="col-form-label" for="productQty">Product Issued Qty *</label>
                                                <input class="form-control" type="text" id="productQty" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div> 

                                        </div>

                                        <div class="row mt-md-3">
                                            <div class="col-12">
                                                <label class="col-form-label" for="productremark">Product Remark</label>
                                                <textarea id="productremark" rows="2" placeholder="Remarks if any" class="form-control"></textarea>
                                            </div>
                                        </div>
                                         

                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button class="btn btn-success m-4" type="button" id="addRow">Add New Row</button>

                                            </div>
                                        </div> 
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">Product Name</th>
                                                        <th scope="col">Issued Qty</th> 
                                                        <th scope="col">Product Remarks</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-4 col-md-4 col-sm-12"> 
                            <div class="card py-3">
                                    <div class="card-body d-flex justify-content-around align-items-center">
                                        <a href="./product-list.php">
                                            <p class="h6"><ins>Product Master</ins></p>
                                        </a>
                                        <a href="./supplier-list.php">
                                            <p class="h6"><ins>Supplier Master</ins></p>
                                        </a>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5>Submit Form</h5>
                                    </div>
                                    <div class="card-body">  
                                        <div class="row mb-4">
                                            <div class="col-12">
                                            <label class="col-form-label" for="productremark">Optional Attachment</label> 
                                                <input type="file" name="dcAttachment" id="dcAttachment" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <textarea name="remarks" rows="2" placeholder="remarks if any" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="card-footer text-center ">
                                            <button class="btn btn-info" type="submit" name="addDcEntry" id="addDcEntry">Create New Purchase Order</button>
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
    <script src="./assets/js/datepicker/datepicker.js"></script>
    <script src="./assets/js/datepicker/datepicker.en.js"></script>
    <script src="./assets/js/select2/select2.full.min.js"></script>
    <script src="./assets/js/script.js"></script>
    <script>
        $('#itemGroup').on('change', function() {
            var groupId = $(this).val();
            if (groupId) {
                $.ajax({
                    type: 'POST',
                    url: './include/ajax-call.php',
                    data: {
                        filterProducts: 1,
                        groupId: groupId
                    },
                    success: function(html) {
                        $('#proId').html(html);
                    }
                });
            } else {
                $('#proId').html('<option value="" selected>Select Modules first</option>');
            }
        });

        $('#proId').on('change', function() {
            var prodId = $('#proId').val();  
            if (prodId || supplierID) {
                $.ajax({
                    type: 'POST',
                    url: './include/ajax-call.php',
                    data: {
                        filterAvailableQty: 1,
                        prodId: prodId 
                    },
                    success: function(html) { 
                        $('#productavailableQty').val(html); 
                    }
                });
            } else {
                $('#productavailableQty').val('');
            }
        });

        function checkButtonStatus() {
            var amount = $('input[name="productid[]"]').length
            if (amount) {
                $("#addDcEntry").removeAttr("disabled");
            } else {
                $("#addDcEntry").attr("disabled", "true");
            }
        }
 

           

        $(function() {
            
            $("#datepicker1").datepicker({
                Format: 'dd-mm-yyyy'
            });


            $("#addRow").click(function() {
                var grandTotal = 0;
                var proid = $('#proId').val();
                var proname = $("#proId option:selected").text();
                var proqty = $('#productQty').val();
                
                var productdesc = $('#productremark').val(); 

                if (proid  && proqty) {
                    var elem = '<tr class="text-center">';
                    elem += '<td> <input type="hidden" name="productid[]" value="' + proid + '"><p>' + proname + '</p> ';
                    elem += '<td><input type="hidden" name="productqty[]" value="' + proqty + '"> <p>' + proqty + '</p> </td> '; 
                    elem += '<td><input type="hidden" name="productdesc[]" value="' + productdesc + '"> <p>' + productdesc + '</p> </td> ';
                    elem += '<td><a href="javascript:void(0);" class="remCF"><button class="btn btn-danger btn-xs" type="button" id="removeRow"  >Remove</button></a>  </td> ';
                    elem += '</tr>';

                    $("#tableBody").append(elem);

                     

                    $('#proId,#productQty,#productremark').val(''); 
                } else {
                    alert('product & amount cant be empty');
                }
                checkButtonStatus();
            });
            

            $("#tableBody").on('click', '.remCF', function() {
                $(this).parent().parent().remove();
                checkButtonStatus();
            }); 
            checkButtonStatus();
        });
    </script>
</body>

</html>