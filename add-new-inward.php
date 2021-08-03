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
    <title>Add New PO Inward | Freeztex | Accounts</title>
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
                                <h3> PO Inward</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="./po-inward-list.php"><i data-feather="archive"></i></a></li>
                                    <li class="breadcrumb-item">Add PO Inward</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <form action="./include/_inwardController.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-10">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5>Add New PO Inward</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="mb-4 row">
                                            <div class="col-6">
                                                <label class="col-form-label" for="group">PO Inward Date *</label>
                                                <input type="text" id="datepicker1" class="form-control" name="poDate" value="<?php echo Date('d-m-Y'); ?>" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label" for="group">DC / Invoice No</label>
                                                <input type="text" class="form-control" name="dcNO"  >
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-6">
                                                <label for="user_name">Supplier Name</label>
                                                <select class="form-select select2" name="supplierID" id="supplierID" required>
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
                                                <div class="col-6">
                                                    <label for="user_name">PO Number</label>
                                                    <select class="form-select select2" name="poNo" id="poNo" required>
                                                    <!-- <option value="" selected disabled>----</option>
                                                <?php
                                                    $query = mysqli_query($dbconnection,"SELECT * FROM `ft_po` WHERE  `po_status` = 1  ");
                                                    while ($rows = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                        <option value="<?php echo $rows['po_id']; ?>" class="text-capitalize">
                                                            <?php echo $rows['po_code']; ?>
                                                        </option>
                                                    <?php } ?> -->
                                                </select>
                                            </div>
                                        </div> 

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <textarea name="remarks" rows="2" placeholder="remarks if any" class="form-control"></textarea>
                                            </div>
                                        </div> 

                                        <h6 class="mb-3">Product List</h6> 
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">Product Name</th>
                                                        <th scope="col" width="10%">PO Qty</th>
                                                        <th scope="col" width="10%">Received Qty</th>
                                                        <th scope="col" width="10%">Pending Qty</th>
                                                        <th scope="col">Store </th>
                                                        <th scope="col">Rack </th>
                                                        <th scope="col">Column</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                <!-- <tr class="text-center">
                                                        <td> Name</td>
                                                        <td> Qty</td>
                                                        <td> Qty</td>
                                                        <td> Qty</td>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td></td>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                    
                                        <div class="card-footer text-center ">
                                            <button class="btn btn-info" type="submit" name="addinward">Create New PO Inward</button>
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

        $('#poNo').on('change', function() {
            var poid = $(this).val();

            if (poid) {
                $.ajax({
                    type: 'POST',
                    url: './include/ajax-call.php',
                    data: {
                        filterInwardProducts: 1,
                        poid: poid
                    },
                    success: function(elem) {
                        console.log(elem); 
                        $("#tableBody").html(elem);
                    }
                });
            }
        });

        $('#supplierID').on('change', function() {
            var supplierID = $(this).val();
            if (supplierID) {
                $.ajax({
                    type: 'POST',
                    url: './include/ajax-call.php',
                    data: {
                        filterPO: 1,
                        supplierID: supplierID
                    },
                    success: function(html) {
                        $('#poNo').html(html);
                    }
                });
            } else {
                $('#poNo').html('<option value="" selected disabled>----</option>');
            }
        });

        function updateQty(id) {
            var poQty = Number($("#poqty-" + id).val());
            var recvdQty = Number($("#recqty-" + id).val());
            var penqty = poQty - recvdQty;
            if (penqty >= 0) {
                $("#penqty-" + id).val(penqty);
            }else{
                $("#penqty-" + id).val(''); 
            }
        }
      
        function updateRack(id) {
            var store =  $("#store-" + id).val();
            
            if (store) {
                $.ajax({
                    type: 'POST',
                    url: './include/ajax-call.php',
                    data: {
                        filterracks: 1,
                        store: store
                    },
                    success: function(html) {
                        $("#rack-" + id).html(html);
                        $("#column-" + id).html('<option value="" selected disabled>----</option>');
                    }
                });
            } else {
                $("#rack-" + id).html('<option value="" selected disabled>----</option>');
                $("#column-" + id).html('<option value="" selected disabled>----</option>');
            }
        }
      
        function updateColumn(id) {
            var store =  $("#store-" + id).val();
            var rack =  $("#rack-" + id).val();
            
            if (store) {
                $.ajax({
                    type: 'POST',
                    url: './include/ajax-call.php',
                    data: {
                        filtercolumns: 1,
                        store: store,
                        rack: rack
                    },
                    success: function(html) {
                        $("#column-" + id).html(html);
                    }
                });
            } else {
                $("#column-" + id).html('<option value="" selected disabled>----</option>');
            }
        }


        $(function() {
            $("#datepicker1").datepicker();
        });
    </script>
</body>

</html>