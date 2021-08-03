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
    <title> Expenditure Lists |Freeztex | Accounts</title>
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
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Followups List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <?php if (isset($_SESSION['expenditureSuccess'])) { ?>
                        <div class="col-lg-8">
                            <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                <p> <?php echo $_SESSION['expenditureSuccess']; ?> </p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                            </div>
                        <?php }
                        unset($_SESSION['expenditureSuccess']);
                        if (isset($_SESSION['expenditureError'])) { ?>
                            <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                                <p> <?php echo $_SESSION['expenditureError']; ?> </p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                            </div>
                        <?php }
                        unset($_SESSION['expenditureError']); ?>
                        </div>
                        <div class="col-sm-12">
                            <div class="card height-equal">
                                <div class="card-body p-b-10 p-t-10">
                                    <ul class="nav nav-pills justify-content-center" id="pills-icontab" role="tablist" aria-controls="pills-icontabContent">
                                        <?php if ($logged_admin_role != 2) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link active" id="pills-cur-tab" data-bs-toggle="pill" href="#pills-cur" role="tab" aria-controls="pills-cur" aria-selected="true">Followups Pending</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-history-tab" data-bs-toggle="pill" href="#pills-history" role="tab" aria-controls="pills-history" aria-selected="false">Followups Completed</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <?php if ($logged_admin_role != 2) { ?>
                            <div class="card">
                                <div class="tab-content" id="pills-icontabContent">
                                    <div class="tab-pane fade show active" id="pills-cur" role="tabpanel" aria-labelledby="pills-cur-tab">
                                        <div class="card-body ">
                                            <div class="table-responsive">
                                                <?php if ($logged_admin_role != 2) {
                                                    include('./include/followup-pending-table.php');
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab">
                                        <div class="card-body ">
                                            <div class="table-responsive">
                                                <?php
                                                if ($logged_admin_role != 2) {
                                                    include('./include/followup-complete-table.php');
                                                }
                                                ?>
                                            </div>
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
    <script src="./js/tablleExport.js"></script>
    <script src="./assets/js/datatable/datatables/datatable.custom.js"></script>
    <script src="./assets/js/sweet-alert/sweetalert.min.js"></script>
    <script>
        function comepleteFollowup(paymentId,adminId) {
      $('.completeFollowup').attr('disabled', true); 
            $.ajax({
              url: "./include/ajax-call.php",
              cache: false,
              type: 'POST',
              data: {
                comepleteFollowup: 1,
                adminId: adminId,
                paymentId:paymentId 
              },
              success: function(data) { 
                if (data == 200) {
                  swal("Success", "Followp Closed Successfully", "success", {
                      buttons: {
                        Approve: "DONE",
                      },
                    })
                    .then((value) => {
                      if (value == 'Approve') {
                        window.location.reload();
                      }
                    });
                }
              }
            });
    }
    </script>
</body>

</html>