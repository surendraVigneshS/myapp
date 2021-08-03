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
  <title>Employee List |Freeztex | Accounts</title>
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
                          <h3>Existing Employee</h3>
                        </div>
                        <div class="col-6">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                            <li class="breadcrumb-item">Employee List</li>
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
                                        <?php if($logged_admin_role == 1){ ?>
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
                                                <th>Emp ID</th>
                                                <th>Emp Name</th>
                                                <th>Emp Email</th>
                                                <th>Emp Phone</th>
                                                <th>Emp Role</th>
                                                <th>Emp Organization</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php
                                                    $customerselect = "SELECT * FROM `admin_login` WHERE `emp_role` != 1 AND `emp_role` != 2  ORDER BY `emp_id` DESC ";
                                              $custoemrquery = mysqli_query($dbconnection, $customerselect);
                                              if (mysqli_num_rows($custoemrquery) > 0) {
                                                while ($row = mysqli_fetch_array($custoemrquery)){
                                                  $empid = $row['emp_id'];
                                                  $empno = $row['emp_no'];
                                                  $empemail = $row['emp_email'];
                                                  $empname = $row['emp_name'];
                                                  $empmobile = $row['emp_mobile'];
                                                  $emprole = $row['emp_role'];
                                                  $empstatus = $row['emp_status']; 
                                                  $rolename = fetchData($dbconnection,'user_role','user_roles','id',$emprole);
                                                  $orgName = fetchData($dbconnection,'organization_name','organization','id',$row['emp_org']);
                                              ?>
                                              <tr>
                                                <td><?php echo $empno  ?></td>
                                                <td><?php echo $empname  ?></td>
                                                <td><?php echo $empemail ?></td>
                                                <td><?php echo $empmobile ?></td>
                                                <td><?php echo $rolename ?></td>
                                                <td><?php echo $orgName ?></td>
                                                <td>
                                                  <?php if ($empstatus == 1) { ?>
                                                    <label class="badge badge-success"> Active </label>
                                                  <?php }if ($empstatus == 4) { ?>
                                                    <label class="badge badge-danger"> In Active </label>
                                                  <?php } ?>
                                                </td>
                                                <td>
                                                  <a href="./add-new-employee.php?platform=<?php echo randomString(45); ?>&action=editemployee&fieldid=<?php echo passwordEncryption($empid) ?>" class="btn btn-primary btn-xs" type="button">Edit</a>
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