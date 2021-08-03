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
  <title>Payment List |Freeztex | Accounts</title>
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
    .advance-text {
      color: red;
    }

    .advance-text:hover {
      color: red;
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
                <h3>Payment Request</h3>
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item">Payment List</li>
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
              <?php if ($logged_admin_role != 2) { ?>
                <div class="card height-equal">
                  <div class="card-body">
                    <ul class="nav nav-pills justify-content-center" id="pills-icontab" role="tablist">
                      <li class="nav-item"><a class="nav-link <?php if ($logged_admin_role != 4 && $logged_admin_role != 8 && $logged_admin_role != 9 && $logged_admin_role != 11){ echo 'active'; } ?>" id="pills-pending-tab" data-bs-toggle="pill" href="#pills-pending" role="tab" aria-controls="pills-pending" aria-selected="true">New Request Raised</a></li>
                      <li class="nav-item"><a class="nav-link <?php if ($logged_admin_role == 11 || $logged_admin_role == 8){ echo 'active'; } ?>" id="pills-onprocessing-tab" data-bs-toggle="pill" href="#pills-onprocessing" role="tab" aria-controls="pills-onprocessing" aria-selected="false">TL Approved</a></li>
                      <li class="nav-item"><a class="nav-link" id="pills-orglead-tab" data-bs-toggle="pill" href="#pills-orglead" role="tab" aria-controls="pills-orglead" aria-selected="false">OL Approved</a></li>
                      <li class="nav-item"><a class="nav-link" id="pills-preapproved-tab" data-bs-toggle="pill" href="#pills-preapproved" role="tab" aria-controls="pills-preapproved" aria-selected="false">Finance Preapproved</a></li>
                      <li class="nav-item"><a class="nav-link <?php if ($logged_admin_role == 4 || $logged_admin_role == 9) { echo 'active'; } ?>" id="pills-waiting-tab" data-bs-toggle="pill" href="#pills-waiting" role="tab" aria-controls="pills-waiting" aria-selected="false">MD Approved</a></li>
                      <li class="nav-item"><a class="nav-link" id="pills-approve-tab" data-bs-toggle="pill" href="#pills-approve" role="tab" aria-controls="pills-approve" aria-selected="false">Payment Done</a></li>
                      <li class="nav-item"><a class="nav-link" id="pills-cancel-tab" data-bs-toggle="pill" href="#pills-cancel" role="tab" aria-controls="pills-cancel" aria-selected="false">Cancelled</a></li>
                      <li class="nav-item"><a class="nav-link advance-text" id="pills-advance-tab" data-bs-toggle="pill" href="#pills-advance" role="tab" aria-controls="pills-advance" aria-selected="false">Advanced</a></li>
                      <li class="nav-item"><a class="nav-link" id="pills-all-tab" data-bs-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="false">All</a></li>
                      <li class="nav-item"><a class="nav-link advance-text" id="pills-complete-tab" data-bs-toggle="pill" href="#pills-complete" role="tab" aria-controls="pills-complete" aria-selected="false">Advance Completed</a></li>
                      <?php if ($logged_admin_role != 8) { ?><li class="nav-item"><a class="nav-link" id="pills-expenditure-tab" data-bs-toggle="pill" href="#pills-expenditure" role="tab" aria-controls="pills-expenditure" aria-selected="false">Expenditure Close</a></li> <?php } ?>
                      <?php if ($logged_admin_role == 4 || $logged_admin_role == 9) { ?> <li class="nav-item"><a class="nav-link" id="pills-newbill-tab" data-bs-toggle="pill" href="#pills-newbill" role="tab" aria-controls="pills-newbill" aria-selected="false">New Bill</a></li> <?php } ?>
                      <?php if ($logged_admin_role == 6) { ?> <li class="nav-item"><a class="nav-link" id="pills-newmessage-tab" data-bs-toggle="pill" href="#pills-newmessage" role="tab" aria-controls="pills-newmessage" aria-selected="false">Feedback</a></li> <?php } ?>
                    </ul>
                  </div>
                </div>
              <?php }
              if ($logged_admin_role == 2) { ?>
                <div class="card height-equal">
                  <div class="card-body">
                    <ul class="nav nav-pills justify-content-center" id="pills-icontabmd" role="tablist">
                      <li class="nav-item"><a class="nav-link active" id="pills-mdpending-tab" data-bs-toggle="pill" href="#pills-mdpending" role="tab" aria-controls="pills-mdpending" aria-selected="true">Pending</a></li>
                      <li class="nav-item"><a class="nav-link" id="pills-mdapproved-tab" data-bs-toggle="pill" href="#pills-mdapproved" role="tab" aria-controls="pills-mdapproved" aria-selected="false">Approved</a></li>
                      <li class="nav-item"><a class="nav-link" id="pills-mdexpenditure-tab" data-bs-toggle="pill" href="#pills-mdexpenditure" role="tab" aria-controls="pills-mdexpenditure" aria-selected="false">Expenditure Close</a></li>
                      <li class="nav-item"><a class="nav-link" id="pills-paymentdone-tab" data-bs-toggle="pill" href="#pills-paymentdone" role="tab" aria-controls="pills-paymentdone" aria-selected="false">Payment Done</a></li>
                    </ul>
                  </div>
                </div>
              <?php } ?>
              <div class="card">
                <?php if ($logged_admin_role != 2) { ?>
                  <div class="tab-content" id="pills-icontabContent">
                    <div class="tab-pane <?php if ($logged_admin_role != 4 && $logged_admin_role != 8 && $logged_admin_role != 9 && $logged_admin_role != 11) { echo 'fade show active'; } ?>" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role != 2) {
                            include('./include/payment-pending-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane <?php if ($logged_admin_role == 11 || $logged_admin_role == 8) { echo 'fade show active'; } ?>" id="pills-onprocessing" role="tabpanel" aria-labelledby="pills-onprocessing-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role != 2) {
                            include('./include/payment-onprocessing-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-orglead" role="tabpanel" aria-labelledby="pills-orglead-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role != 2) {
                            include('./include/payment-orglead-approved-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-preapproved" role="tabpanel" aria-labelledby="pills-preapproved-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role != 2) {
                            include('./include/payment-preapproved-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane <?php if ($logged_admin_role == 4 || $logged_admin_role == 9) { echo 'fade show active'; } ?>" id="pills-waiting" role="tabpanel" aria-labelledby="pills-waiting-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role != 2) {
                            include('./include/payment-waiting-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-approve" role="tabpanel" aria-labelledby="pills-approve-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role != 2) {
                            include('./include/payment-approved-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role != 2) {
                            include('./include/payment-cancel-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-advance" role="tabpanel" aria-labelledby="pills-advance-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role != 2) {
                            include('./include/payment-advanced-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-6">
                              <?php if ($logged_admin_role == 1) { ?>
                                <button class="btn btn-success f-left" id="exportPaymentBTN" type="button">Export Table Data</button>
                              <?php } ?>
                            </div>
                            <div class="col-md-6 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role == 1) {
                            include('./include/payment-admin-all-table.php');
                          }
                          if ($logged_admin_role != 2 && $logged_admin_role != 1) {
                            include('./include/payment-all-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div> 
                    <div class="tab-pane" id="pills-complete" role="tabpanel" aria-labelledby="pills-complete-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role != 2) {
                            include('./include/payment-complete-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-newbill" role="tabpanel" aria-labelledby="pills-newbill-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role != 2) {
                            include('./include/payment-newbill-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-expenditure" role="tabpanel" aria-labelledby="pills-expenditure-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role != 2 || $logged_admin_role != 8) {
                            include('./include/expenditure-close-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-newmessage" role="tabpanel" aria-labelledby="pills-newmessage-tab">
                      <div class="card-body">
                        <?php if ($logged_admin_role != 2) { ?>
                          <div class="row">
                            <div class="col-md-12 m-b-30">
                              <a href="./new-payment.php"><button class="btn btn-primary f-right" type="button">New Payment Request</button> </a>
                            </div>
                          </div>
                        <?php } ?>
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role == 6) {
                            include('./include/payment-newmessage-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php }
                if ($logged_admin_role == 2) { ?>
                  <div class="tab-content" id="pills-icontabmdContent">
                    <div class="tab-pane fade show active" id="pills-mdpending" role="tabpanel" aria-labelledby="pills-mdpending-tab">
                      <div class="card-body">
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role == 2) {
                            include('./include/md-payment-pending-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-mdapproved" role="tabpanel" aria-labelledby="pills-mdapproved-tab">
                      <div class="card-body">
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role == 2) {
                            include('./include/md-payment-approved-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-paymentdone" role="tabpanel" aria-labelledby="pills-paymentdone-tab">
                      <div class="card-body">
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role == 2) {
                            include('./include/payment-approved-md-table.php');
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="pills-mdexpenditure" role="tabpanel" aria-labelledby="pills-mdexpenditure-tab">
                      <div class="card-body">
                        <div class="table-responsive">
                          <?php
                          if ($logged_admin_role == 2) {
                            include('./include/expenditure-close-table.php');
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
  <script>
    $(document).ready(function() {
      $("#exportPaymentBTN").click(function() {
        TableToExcel.convert(document.getElementById("exportPaymentTable"), {
          name: "Payment_request_list.xlsx",
          sheet: {
            name: "Sheet1"
          }
        });
      });
    });

    function aprrovePurchase(paymentId, adminId, adminRole) {
      $('.mdapprove').attr('disabled', true);
      $.ajax({
        url: "./include/ajax-call.php",
        cache: false,
        type: 'POST',
        data: {
          approvePayment: 1,
          paymentId: paymentId,
          adminRole: adminRole,
          adminId: adminId
        },
        success: function(data) { 
          window.location.reload();
        }
      });
    }

    function finaldisAprrovePurchase(paymentId, adminId, adminRole) {
      $('.mddisapprove').attr('disabled', true);
      swal("Are you sure ? Do you want to disapprove this request ?", {
          buttons: {
            DisApprove: "DisApprove",
            Cancel: true,
          },
          content: {
            element: "input",
            attributes: {
              placeholder: "Reason To Cancel",
              type: "text",
              idName: "inputfiledcustom",
            },
          },
          closeOnClickOutside: false,
          closeOnEsc: false,
        })
        .then((value) => {
          if (value == 'DisApprove') {
            var cancelReason = $('.swal-content__input').val();
            $.ajax({
              url: "./include/ajax-call.php",
              cache: false,
              type: 'POST',
              data: {
                FinalApprovePayment: 1,
                paymentId: paymentId,
                adminRole: adminRole,
                adminId: adminId,
                cancelReason: cancelReason
              },
              success: function(data) {
                if (data == '1') {
                  swal("Success", "Payment Request Cancelled", "success", {
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
        });
    }

    function deletepayment(paymentId) {
      $('.mddisapprove').attr('disabled', true);
      swal("Are you sure ? Do you want to Delete this request ?", {
          buttons: {
            Delete: "Delete",
            Cancel: true,
          },
          icon: 'warning',
          closeOnClickOutside: false,
          closeOnEsc: false,
        })
        .then((value) => {
          if (value == 'Delete') {
            $.ajax({
              url: "./include/ajax-call.php",
              cache: false,
              type: 'POST',
              data: {
                DeletePayment: 1,
                paymentId: paymentId
              },
              success: function(data) {
                if (data == '1') {
                  swal("Success", "Payment Request Deleted Successfully", "success", {
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
        });
    }
    
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
      function approveExpenditure(closeId,adminId,adminrole){
          $('#expenditureBtn').attr('disabled', true);
          $.ajax({
              url: "./include/ajax-call.php",
              cache: false,
              type: 'POST',
              data:{approveexpense:1,closeId:closeId,adminId:adminId,adminrole:adminrole},
              success: function(data){
                  console.log(data);
                  if (data == '200') {
                    swal("Success", "Expenditure Close Request Approved", "success", {
                      buttons: {
                        Approve: "DONE",
                      },
                    })
                    .then((value) => {
                      if (value == 'Approve') {
                        setTimeout(function(){ 
                          window.location.reload();
                        }, 500);
                      }
                    });
                  }else{
                    alert('Data Submit Error, Try Again !!!!');
                    $('#expenditureBtn').attr('disabled', false);
                  }
              }
          });
      }
  </script>
</body>

</html>