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
    <title>Beneficiary Lists |Freeztex | Accounts</title>
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
                          <h3>Supplier Details</h3>
                        </div>
                        <div class="col-6">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                            <li class="breadcrumb-item">Supplier List</li>
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
                <div class="row">
                    <div class="col-md-12 m-b-30">
                      <a href="./add-new-supplier.php?platform=<?php echo randomString(45); ?>&action=addsupplier"><button class="btn btn-primary f-right" type="button">Add New Supplier</button> </a>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                              <table class="display payment-table" id="">
                                <thead>
                                  <tr>
                                    <th>Supplier Name</th>
                                    <th>Moblie</th>
                                    <th>Email</th>
                                    <th>Branch</th>
                                    <th>Account No</th>
                                    <th>IFSC Code</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php 
                                    $selectquery = "SELECT * FROM `supplier_details` ORDER BY `cust_id` DESC";
                                    $executequery = mysqli_query($dbconnection,$selectquery);
                                    if(mysqli_num_rows($executequery) > 0){
                                      while($row = mysqli_fetch_array($executequery)){
                                        $beneficiaryid = $row['cust_id'];  
                                        $beneficiaryname = $row['supplier_name'];
                                        $beneficiarymail = $row['supplier_email'];
                                        $beneficiarymobile = $row['supplier_mobile'];
                                        $beneficiarybranch = $row['supplier_branch'];
                                        $beneficiaryaccno = $row['supplier_acc_no'];
                                        $beneficiaryifsc = $row['supplier_ifsc_code'];
                                  ?>
                                  <tr>
                                    <td><?php echo $beneficiaryname ?></td>
                                    <td><?php echo $beneficiarymail ?></td>
                                    <td><?php echo $beneficiarymobile ?></td>
                                    <td><?php echo $beneficiarybranch ?></td>
                                    <td><?php echo $beneficiaryaccno ?></td>
                                    <td><?php echo $beneficiaryifsc ?></td>
                                    <td>
                                      <a href="./add-new-supplier.php?platform=<?php echo randomString(45); ?>&action=editsupplier&fieldid=<?php echo passwordEncryption($beneficiaryid) ?>" class="btn btn-primary btn-xs" type="button">Edit</a>
                                    </td>
                                  </tr>
                                  <?php } } ?>
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
      <?php  include('./include/footer.php'); ?>
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