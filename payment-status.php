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
    <title>VENCAR - Accounts</title>
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
                                <h3>Payment Status</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Payment Status</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-7">
                            <?php if (isset($_SESSION['paymentSuccess'])) { ?>
                                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['paymentSuccess']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php }
                            unset($_SESSION['paymentSuccess']);
                            if (isset($_SESSION['paymentError'])) { ?>
                                <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['paymentError']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php }
                            unset($_SESSION['paymentError']); ?>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php if ($logged_admin_role == 1) { ?>
                                        <div class="row">
                                            <div class="col-md-12 m-b-30">
                                                <a href="./add-new-employee.php?platform=<?php echo randomString(45); ?>&action=addemployee"><button class="btn btn-primary f-right" type="button">Add New Employee</button> </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="table-responsive">
                                        <table class="display payment-table" id="">
                                            <thead>
                                                <tr>
                                                    <th>Created Date</th>
                                                    <th>Company Name</th>
                                                    <th>Amount</th>
                                                    <th>Created By</th>
                                                    <th>Pending By</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $customerselect = "SELECT * FROM `payment_request` WHERE  (`first_approval` = 0  OR `second_approval` = 0 OR `third_approval` = 0 OR `fourth_approval` = 0 )  ORDER BY `pay_id` DESC ";
                                                $custoemrquery = mysqli_query($dbconnection, $customerselect);
                                                if (mysqli_num_rows($custoemrquery) > 0) {
                                                    while ($row = mysqli_fetch_array($custoemrquery)) {
                                                    
                                                      if($row['first_approval'] == 0){
                                                          $pendingBy ='Team Lead'; 
                                                          $badgeColor = 'badge-primary';
                                                      }else if($row['second_approval'] == 0){
                                                        $pendingBy ='Accounts Team';     
                                                        $badgeColor = 'badge-warning';
                                                      }else if($row['third_approval'] == 0){
                                                        $pendingBy ='Managing Director';  
                                                        $badgeColor = 'badge-blue'; 
                                                      }else if($row['fourth_approval'] == 0){
                                                          $badgeColor = 'badge-info'; 
                                                          $pendingBy ='Finance';   
                                                          if($row['org_name'] ==2){
                                                              $pendingBy ='AGEM Finance';  
                                                          }
                                                      }else if($row['fourth_approval'] == 1){
                                                        $pendingBy ='Completed';  
                                                        $badgeColor = 'badge-violet';
                                                      }    

                                                      $amount = $row['amount'];  
                                                     if($row['payment_against'] == 3){
                                                        $amount = $row['advanced_amonut'];
                                                     } 

                                                ?>
                                                        <tr>
                                                            <td><?php echo date("d-M-Y h:i A", strtotime( $row['created_date']));  ?></td>
                                                            <td><?php echo $row['company_name']  ?></td>
                                                            <td><?php echo $amount ?></td> 
                                                            <td> 
                                                                <?php echo ucfirst(getuserName( $row['created_by'], $dbconnection)); ?>
                                                            </td> 
                                                            <td> 
                                                                    <label class="badge <?php echo $badgeColor ?>"><?php echo $pendingBy ?></label> 
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
    <script src="./assets/js/datatable/datatables/datatable.custom.js"></script>
    <script src="./assets/js/sweet-alert/sweetalert.min.js"></script>
</body>

</html>