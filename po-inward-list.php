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
    <title>PO Inward List | Freeztek | Accounts</title>
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
    <style>
        td,
        th {
            text-align: center !important;
            vertical-align: middle !important;
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
                                <h3> PO Inward List </h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">PO Inward List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-7">
                            <?php if (isset($_SESSION['poInwardSuccess'])) { ?>
                                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['poInwardSuccess']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" ></button>
                                </div>
                            <?php }
                            unset($_SESSION['poInwardSuccess']);
                            if (isset($_SESSION['poInwardError'])) { ?>
                                <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['poInwardError']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" ></button>
                                </div>
                            <?php }
                            unset($_SESSION['poInwardError']); ?>
                        </div>
                        <div class="col-sm-12">
                            <div class="card"> 
                                    <div class="card-body">
                                    <div class="row">
                                      <div class="col-md-12 m-b-20">
                                          <a href="./add-new-inward.php"><button class="btn btn-primary f-right" type="button">Add New PO Inward</button> </a>
                                      </div>
                                    </div>
                                        <div class="table-responsive">
                                            <div class="table-responsive">
                                                <table class="display payment-table" id="">
                                                    <thead>
                                                        <tr> 
                                                            <th>PO Inward Date</th>
                                                            <th>PO Date</th>
                                                            <th>PO Code</th>   
                                                            <th>Inward Status</th>   
                                                            <!-- <th>View</th> 
                                                            <th>Edit</th>  -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $productqrUrl ="./assets/qr/po/";
                                                        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_inward` LEFT JOIN `ft_po` ON `ft_po`.`po_id` = `ft_inward`.`pi_po_id` ORDER BY `ft_inward`.`pi_po_id` DESC");
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $id = $row['po_id'];
                                                            $piDate = date('d-M-Y' , strtotime($row['pi_date'])); 
                                                            $poDate = date('d-M-Y' , strtotime($row['po_date'])); 
                                                            $po_code = $row['po_code'];  
                                                            $pistatus = $row['pi_status'];  
                                                            if($pistatus == 1){
                                                                $status  = "Complete Inward";

                                                            }else if($pistatus == 2){
                                                                $status  = "Partial Inward";
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td> <?php echo $piDate;  ?></td>
                                                                <td> <?php echo $poDate;  ?></td>
                                                                <td> <?php echo $po_code; ?></td>  
                                                                <td> <?php echo $status;  ?></td>  
                                                                <!-- <td>
                                                                    <a href="./view-purchase-order.php?platform=<?php echo randomString(45); ?>&fieldid=<?php echo passwordEncryption($id) ?>" class="btn btn-info btn-xs" type="button">View</a>
                                                                </td> 
                                                                <td>
                                                                    <a href="./edit-purchase-order.php?platform=<?php echo randomString(45); ?>&fieldid=<?php echo passwordEncryption($id) ?>" class="btn btn-primary btn-xs" type="button">Edit</a>
                                                                </td>  -->
                                                            </tr>
                                                        <?php } ?>
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
    <script src="./assets/js/datatable/datatables/datatable.custom.js"></script>
    <script src="./assets/js/sweet-alert/sweetalert.min.js"></script>
</body> 
</html>