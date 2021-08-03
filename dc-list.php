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
    <title>DC List | Freeztek | Accounts</title>
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
                                <h3> DC List </h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">DC List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-7">
                            <?php if (isset($_SESSION['dcEntrySuccess'])) { ?>
                                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['dcEntrySuccess']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php }
                            unset($_SESSION['dcEntrySuccess']);
                            if (isset($_SESSION['dcEntryError'])) { ?>
                                <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['dcEntryError']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php }
                            unset($_SESSION['dcEntryError']); ?>
                        </div>
                        <div class="col-sm-12">
                            <div class="card height-equal">
                                <div class="card-body p-b-10 p-t-10">
                                    <ul class="nav nav-pills justify-content-center" id="pills-icontabmd" role="tablist">
                                        <li class="nav-item"><a class="nav-link active" id="pills-nonreturnable-tab" data-bs-toggle="pill" href="#pills-nonreturnable" role="tab" aria-controls="pills-nonreturnable" aria-selected="true">Non DC Returnable</a></li>
                                        <li class="nav-item"><a class="nav-link" id="pills-returnable-tab" data-bs-toggle="pill" href="#pills-returnable" role="tab" aria-controls="pills-returnable" aria-selected="false">DC Returnable</a></li>
                                        <li class="nav-item"><a class="nav-link" id="pills-receipt-tab" data-bs-toggle="pill" href="#pills-receipt" role="tab" aria-controls="pills-receipt" aria-selected="false">Dc Against Receipt</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card">
                                <div class="tab-content" id="pills-icontabContent">
                                    <div class="tab-pane  fade show active" id="pills-nonreturnable" role="tabpanel" aria-labelledby="pills-nonreturnable-tab">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 m-b-20">
                                                     <a href="./add-new-dc.php"><button class="btn btn-primary f-right" type="button">Add New DC</button> </a>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <div class="table-responsive">
                                                    <table class="display payment-table">
                                                        <thead>
                                                            <tr>
                                                                <th>DC Date</th>
                                                                <th>DC Code</th>
                                                                <th>DC Type</th>
                                                                <th>Total Items Count</th>
                                                                <th>Issued To</th>
                                                                <th>View</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $productqrUrl = "./assets/qr/po/";
                                                            $query = mysqli_query($dbconnection, "SELECT * FROM `ft_dc` WHERE `dc_type` = 2 ORDER BY `dc_id` DESC");
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $id = $row['dc_id'];
                                                                $dcCode = $row['dc_code'];
                                                                $dcDate = date('d-M-Y', strtotime($row['dc_date']));
                                                                $dcType = $row['dc_type'];
                                                                $issued_to =  $row['dc_issued_to'];
                                                                $productCount = $row['dc_product_count'];  
                                                                 

                                                                if($dcType == 1){ $dcType = 'Returnable DC '; }else if($dcType == 2){ $dcType = 'Non Returnable DC ';  }else if($dcType == 3){ $dcType = 'DC Against Receipt';  } 
                                                                 
                                                            ?>
                                                                <tr>
                                                                    <td> <?php echo $dcDate;  ?></td>
                                                                    <td> <?php echo $dcCode;  ?></td>
                                                                    <td> <?php echo $dcType;  ?></td>
                                                                    <td> <?php echo $productCount;  ?></td> 
                                                                    <td> <?php echo fetchData($dbconnection, 'supplier_name', 'supplier_details', 'cust_id', $issued_to);  ?></td>
                                                                    <td>
                                                                        <a href="./view-dc.php?platform=<?php echo randomString(45); ?>&fieldid=<?php echo passwordEncryption($id) ?>" class="btn btn-info btn-xs" type="button">View</a>
                                                                    </td> 
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="pills-returnable" role="tabpanel" aria-labelledby="pills-returnable-tab">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 m-b-20">
                                                     <a href="./add-new-dc.php"><button class="btn btn-primary f-right" type="button">Add New DC</button> </a>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <div class="table-responsive">
                                                    <table class="display payment-table">
                                                        <thead>
                                                            <tr>
                                                                <th>DC Date</th>
                                                                <th>DC Code</th>
                                                                <th>DC Type</th>
                                                                <th>Total Items Count</th>
                                                                <th>Issued To</th>
                                                                <th>View</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $productqrUrl = "./assets/qr/po/";
                                                            $query = mysqli_query($dbconnection, "SELECT * FROM `ft_dc` WHERE `dc_type` = 1 ORDER BY `dc_id` DESC");
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $id = $row['dc_id'];
                                                                $dcCode = $row['dc_code'];
                                                                $dcDate = date('d-M-Y', strtotime($row['dc_date']));
                                                                $dcType = $row['dc_type'];
                                                                $issued_to =  $row['dc_issued_to'];
                                                                $productCount = $row['dc_product_count']; 

                                                                if($dcType == 1){ $dcType = 'Returnable DC '; }else if($dcType == 2){ $dcType = 'Non Returnable DC ';  }else if($dcType == 3){ $dcType = 'DC Against Receipt';  } 
                                                                 
                                                            ?>
                                                                <tr>
                                                                    <td> <?php echo $dcDate;  ?></td>
                                                                    <td> <?php echo $dcCode;  ?></td>
                                                                    <td> <?php echo $dcType;  ?></td>
                                                                    <td> <?php echo $productCount;  ?></td> 
                                                                    <td> <?php echo fetchData($dbconnection, 'supplier_name', 'supplier_details', 'cust_id', $issued_to);  ?></td>
                                                                    <td>
                                                                        <a href="./view-dc.php?platform=<?php echo randomString(45); ?>&fieldid=<?php echo passwordEncryption($id) ?>" class="btn btn-info btn-xs" type="button">View</a>
                                                                    </td> 
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="pills-receipt" role="tabpanel" aria-labelledby="pills-receipt-tab">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 m-b-20">
                                                     <a href="./add-new-dc.php"><button class="btn btn-primary f-right" type="button">Add New DC</button> </a>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <div class="table-responsive">
                                                    <table class="display payment-table">
                                                        <thead>
                                                            <tr>
                                                                <th>DC Date</th>
                                                                <th>DC Code</th>
                                                                <th>DC Type</th>
                                                                <th>Total Items Count</th>
                                                                <th>Issued To</th>
                                                                <th>View</th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $productqrUrl = "./assets/qr/po/";
                                                            $query = mysqli_query($dbconnection, "SELECT * FROM `ft_dc` WHERE `dc_type` = 3 ORDER BY `dc_id` DESC");
                                                            while ($row = mysqli_fetch_array($query)) {
                                                                $id = $row['dc_id'];
                                                                $dcCode = $row['dc_code'];
                                                                $dcDate = date('d-M-Y', strtotime($row['dc_date']));
                                                                $dcType = $row['dc_type'];
                                                                $issued_to =  $row['dc_issued_to'];
                                                                $productCount = $row['dc_product_count'];
                                                                 

                                                                if($dcType == 1){ $dcType = 'Returnable DC '; }else if($dcType == 2){ $dcType = 'Non Returnable DC ';  }else if($dcType == 3){ $dcType = 'DC Against Receipt';  } 
                                                                 
                                                            ?>
                                                                <tr>
                                                                    <td> <?php echo $dcDate;  ?></td>
                                                                    <td> <?php echo $dcCode;  ?></td>
                                                                    <td> <?php echo $dcType;  ?></td>
                                                                    <td> <?php echo $productCount;  ?></td> 
                                                                    <td> <?php echo fetchData($dbconnection, 'supplier_name', 'supplier_details', 'cust_id', $issued_to);  ?></td>
                                                                    <td>
                                                                        <a href="./view-dc.php?platform=<?php echo randomString(45); ?>&fieldid=<?php echo passwordEncryption($id) ?>" class="btn btn-info btn-xs" type="button">View</a>
                                                                    </td> 
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
</body>

</html>