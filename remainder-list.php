<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');

$current_date = date('M d Y H:i:s');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <title> Reminder Lists |Freeztex | Accounts</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/sweetalert2.css">
    <style>
        td.details-control {
            background: url('./assets/images/details_open.png') no-repeat center !important;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('./assets/images/details_close.png') no-repeat center center !important;
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
                                <h3>Reminder List</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Reminder List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <?php if (isset($_SESSION['remainderSuccess'])) { ?>
                        <div class="col-lg-8">
                            <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                <p> <?php echo $_SESSION['remainderSuccess']; ?> </p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                            </div>
                        <?php }
                        unset($_SESSION['remainderSuccess']);
                        if (isset($_SESSION['remainderError'])) { ?>
                        <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                            <p> <?php echo $_SESSION['remainderError']; ?> </p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                        </div>
                        <?php }
                        unset($_SESSION['remainderError']); ?>
                            </div>
                            <div class="col-sm-12">
                                <div class="card height-equal">
                                    <div class="card-body p-b-10 p-t-10">
                                        <ul class="nav nav-pills justify-content-center" id="pills-icontab" role="tablist" aria-controls="pills-icontabContent">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="pills-user-tab" data-bs-toggle="pill" href="#pills-new" role="tab" aria-controls="pills-new" aria-selected="true">New Reminder</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-pend-tab" data-bs-toggle="pill" href="#pills-pend" role="tab" aria-controls="pills-pend" aria-selected="false">Pending Reminder</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-curr-tab" data-bs-toggle="pill" href="#pills-curr" role="tab" aria-controls="pills-curr" aria-selected="false">Current Reminder</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="tab-content" id="pills-icontabContent">
                                        <input type="hidden" name="currentDate" id="currentDate" value="<?php echo $current_date; ?>">
                                        <input type="hidden" name="lastWeek" id="lastWeek" value="<?php echo date("M d Y H:i:s",strtotime("-7 Days", strtotime($current_date))); ?>">
                                        <input type="hidden" name="lastMonth" id="lastMonth" value="<?php echo date("M d Y H:i:s",strtotime("-1 Month", strtotime($current_date))); ?>">
                                        <div class="tab-pane fade show active" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <label for="" class="col-sm-2 col-form-label">Fliter By</label>
                                                            <div class="col-sm-4 select-option">
                                                                <select id="dateFilter1" class="form-select btn-square">
                                                                    <option disabled selected>Choose...</option>
                                                                    <option value="1">Last Week</option>
                                                                    <option value="2">Last Month</option>                
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 m-b-30">
                                                        <a href="./new-remainder.php"><button class="btn btn-primary f-right" type="button">Create New Reminder</button> </a>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <?php
                                                    if ($logged_admin_role != 2) {
                                                        include('./include/remainder-new-table.php');
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pills-pend" role="tabpanel" aria-labelledby="pills-pend-tab">
                                            <div class="card-body ">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <label for="" class="col-sm-2 col-form-label">Fliter By</label>
                                                            <div class="col-sm-4 select-option">
                                                                <select id="dateFilter2" class="form-select btn-square">
                                                                    <option disabled selected>Choose...</option>
                                                                    <option value="1">Last Week</option>
                                                                    <option value="2">Last Month</option>                
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 m-b-30">
                                                        <a href="./new-remainder.php"><button class="btn btn-primary f-right" type="button">Create New Reminder</button> </a>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <?php
                                                    if ($logged_admin_role != 2) {
                                                        include('./include/remainder-pending-table.php');
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane " id="pills-curr" role="tabpanel" aria-labelledby="pills-curr-tab">
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-6 ">
                                                        <h5>Upcoming 5 days Reminders are listed below </h5>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="./new-remainder.php"><button class="btn btn-primary f-right" type="button">Create New Reminder</button> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <?php
                                                    include('./include/remainder-current-table.php');
                                                    ?>
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
    <script src="./assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="./js/tablleExport.js"></script>
    <script src="./assets/js/datatable/datatables/datatable.custom.js"></script>
    <script src="./assets/js/sweet-alert/sweetalert.min.js"></script>
    <script src="./js/tableFilter.js"></script>
    <script>
        $(document).ready(function() {
            $("#exportPurchaseBTN").click(function() {
                TableToExcel.convert(document.getElementById("expotusersAllTable"), {
                    name: "Purchase_request_list.xlsx",
                    sheet: {
                        name: "Sheet1"
                    }
                });
            });
        });
    </script>
</body>

</html>