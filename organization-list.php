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
  <style>
    td,th { text-align: center !important;  vertical-align: middle !important; }
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
                          <h3> Organization List </h3>
                        </div>
                        <div class="col-6">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                            <li class="breadcrumb-item">Organization List</li>
                          </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-7">
                        <?php if (isset($_SESSION['orgSuccess'])) { ?>
                        <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                              <p> <?php echo $_SESSION['orgSuccess']; ?> </p>
                              <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                        </div>
                        <?php }
                        unset($_SESSION['orgSuccess']);
                        if (isset($_SESSION['orgError'])) { ?>
                          <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                            <p> <?php echo $_SESSION['orgError']; ?> </p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                          </div>
                        <?php }
                        unset($_SESSION['orgError']); ?>
                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <?php if($logged_admin_role == 1){ ?>
                                <ul class="nav nav-pills justify-content-center" id="pills-icontab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="pills-payment-flow-tab" data-bs-toggle="pill" href="#pills-payment-flow" role="tab" aria-controls="pills-payment-flow" aria-selected="true">Payment Org Flow</a></li>
                                    <li class="nav-item"><a class="nav-link" id="pills-purchase-flow-tab" data-bs-toggle="pill" href="#pills-purchase-flow" role="tab" aria-controls="pills-purchase-flow" aria-selected="false">Purchase Org Flow</a></li>
                                </ul>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card">
                            <?php if ($logged_admin_role == 1) { ?>
                            <div class="tab-content" id="pills-icontabContent">
                              <div class="tab-pane fade show active" id="pills-payment-flow" role="tabpanel" aria-labelledby="pills-payment-flow-tab">
                                <div class="card-body">
                                  <?php if ($logged_admin_role == 1) { ?>
                                    <div class="row">
                                      <div class="col-md-12 m-b-30">
                                          <a href="./add-new-organization.php?platform=<?php echo randomString(45); ?>&action=addorganization"><button class="btn btn-primary f-right" type="button">Add New Organization</button> </a>
                                      </div>
                                    </div>
                                  <?php } ?>
                                  <div class="table-responsive">
                                    <?php
                                    if ($logged_admin_role == 1) {
                                      include('./include/payment-org-flow-list.php');
                                    }
                                    ?>
                                  </div>
                                </div>
                              </div>
                              <div class="tab-pane" id="pills-purchase-flow" role="tabpanel" aria-labelledby="pills-purchase-flow">
                                <div class="card-body">
                                  <?php if ($logged_admin_role == 1) { ?>
                                    <div class="row">
                                      <div class="col-md-12 m-b-30">
                                          <a href="./add-new-organization.php?platform=<?php echo randomString(45); ?>&action=addorganization"><button class="btn btn-primary f-right" type="button">Add New Organization</button> </a>
                                      </div>
                                    </div>
                                  <?php } ?>
                                  <div class="table-responsive">
                                    <?php
                                    if ($logged_admin_role == 1) {
                                      include('./include/purchase-org-flow-list.php');
                                    }
                                    ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?>
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