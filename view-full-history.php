<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');
$month = $action = "";
if (isset($_GET['fieldid'])) {
    $month = $_GET['fieldid'];
    $month = passwordDecryption($month);
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
                                <h3>Month : <?php echo date('F-Y', strtotime($month)); ?></h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="expenditure-list.php"><i data-feather="dollar-sign"></i></a></li>
                                    <li class="breadcrumb-item">Expenditure History</li>
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
                                <div class="card">
                                    <div class="card-body ">
                                        <div class="table-responsive">
                                            <table class="display payment-table">
                                                <thead>
                                                    <tr>
                                                        <th>Created Time</th>
                                                        <th>Expense Name</th>
                                                        <th>Created By</th>
                                                        <th>Expense Amount</th>
                                                        <th>Credit Left</th>
                                                        <th>File Attachment</th>
                                                        <th>Approval</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $customerselect = "SELECT * FROM `expenditures` WHERE `exp_created_by` ='$logged_admin_id'  AND `exp_month` ='$month' ";
                                                    $custoemrquery = mysqli_query($dbconnection, $customerselect);
                                                    if (mysqli_num_rows($custoemrquery) > 0) {
                                                        while ($row = mysqli_fetch_array($custoemrquery)) {
                                                            $exp_name = $row['exp_name'];
                                                            $createdTime = date('d-M-Y H:i A', strtotime($row['exp_created_time']));
                                                            $amount = $row['exp_amount'];
                                                            $createdBy = $row['exp_created_by'];
                                                            $fileAttach = $row['exp_files'];
                                                            $creditLeft = $row['exp_credit_left'];
                                                            $filePath = "./assets/pdf/expenditure/";
                                                            $approval1 = $row['exp_approval_1'];
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $createdTime;  ?></td>
                                                                <td><?php echo $exp_name;  ?></td>
                                                                <td><?php echo getuserName($createdBy, $dbconnection);  ?></td>
                                                                <td><?php echo IND_money_format($amount);  ?></td>
                                                                <td><?php echo IND_money_format($creditLeft);  ?></td>
                                                                <td>
                                                                    <?php if (!empty($fileAttach)) { ?>
                                                                        <a href="<?php echo $filePath . $fileAttach; ?>" target="_blank" class="btn btn-info btn-xs">View File</a>
                                                                    <?php } else {
                                                                        echo 'No File Attached';
                                                                    } ?>
                                                                </td>
                                                                <td>
                                                                    <?php if (empty($approval1)) { ?>
                                                                        <label class="badge badge-primary">Pending</label> <br>
                                                                        By - M.D
                                                                    <?php } else { ?>
                                                                        <label class="badge badge-success">Approved</label> <br>
                                                                        By - M.D
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                    <?php }
                                                    } ?>
                                                </tbody>
                                            </table>
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
</body>

</html>