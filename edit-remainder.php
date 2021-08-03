<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');

$pur_id = $action = "";
if (isset($_GET['fieldid'])) {
  $uniqueid = $_GET['fieldid'];
  $uniqueid = passwordDecryption($uniqueid);
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
  <title> Edit Purchase |Freeztex | Accounts </title>
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
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item"><a href="./remainder-list.php"><i data-feather="shopping-bag"></i></a></li>
                  <li class="breadcrumb-item">New Reminder</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-8 col-sm-12 col-md-8">
              <div class="row">
                <div class="col-sm-12">
                  <div class="card">
                    <div class="card-header">
                      <h5>Create Reminder</h5>
                    </div> 
                    <?php
                    $uploadedPO = './assets/pdf/purchase/';
                    $selectpayment = "SELECT * FROM `remainder` WHERE `id` = '$uniqueid'";
                    $paymentQuery = mysqli_query($dbconnection, $selectpayment);
                    if (mysqli_num_rows($paymentQuery) > 0) {
                      if ($row = mysqli_fetch_array($paymentQuery)) {
                         $remainderId = $row['id'];
                         $pay_id = $row['remainder_pay_id'];
                         $remainder_supplier_id = $row['remainder_supplier_id'];
                         $remainder_amount = $row['remainder_amount'];
                         $remainder_date = $row['remainder_date'];
                         $remainder_status = $row['remainder_status'];
                    ?>
                      <?php  
                            include_once('./include/editable-remainderform.php');  
                      } ?>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } else {  ?>
        <div class="card-body ">
          <p>You Can't Access This Page</p>
        </div>
      <?php } ?>
      </div>

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