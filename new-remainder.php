<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <title>New Purchase - Accounts</title>
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
                                <h5>Create New Reminder</h5>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="./remainder-list.php"><i data-feather="shopping-bag"></i></a></li>
                                    <li class="breadcrumb-item">Create New Reminder</li>
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
                                        <div class="card-body">
                                            <form action="./include/_remainderController.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="logged_admin_id" value="<?php echo $logged_admin_id; ?>">
                                                <h6 class="mb-4">Project Details</h6>

                                                
                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label" for="remainderDate">Reminder Date</label>
                                                    <div class="col-sm-9">
                                                        <input class="datepicker-here form-control digits" type="text" name="remainderDate" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label" for="supplierId">Select Supplier</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select digits" id="supplierId" name="supplierId" required>
                                                            <option selected disabled>Choose...</option>
                                                            <?php
                                                            $selectOrganization = "SELECT * FROM `supplier_details` WHERE `supplier_name` <>'' GROUP BY `supplier_name`";
                                                            $executeOrganization = mysqli_query($dbconnection, $selectOrganization);
                                                            while ($supplierRow = mysqli_fetch_array($executeOrganization)) {
                                                            ?>
                                                                <option value="<?php echo  $supplierRow['cust_id']; ?>"><?php echo  $supplierRow['supplier_name']; ?></option>
                                                            <?php
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label" for="amount">Total amount *</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="totalamount" name="amount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" required>
                                                    </div>
                                                </div>




                                                <div class="card-footer text-center">
                                                    <button class="btn btn-primary" name="addRemainder" id="addRemainder" type="submit">Save Reminder</button>
                                                </div>
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
    <script src="./assets/js/datepicker/datepicker.js"></script>
    <script src="./assets/js/datepicker/datepicker.en.js"></script>
    <script src="./js/functions.js"></script>
</body>

</html>