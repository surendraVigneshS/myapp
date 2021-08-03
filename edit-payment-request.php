<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');

$pur_id = $action = "";
if (isset($_GET['fieldid'])) {
  $pur_id = $_GET['fieldid'];
  $pur_id = passwordDecryption($pur_id);
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
  <title>VENCAR - Accounts</title>
  <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/vendors/scrollbar.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/vendors/animate.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
  <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
  <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
  <style>
    .comment-box {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
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
              <div class="col-lg-10">
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
              <div class="col-6">
              </div>
              <div class="col-6">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                  <li class="breadcrumb-item"><a href="./payment-list.php"><i data-feather="trending-up"></i></a></li>
                  <li class="breadcrumb-item">Edit Request</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12 col-lg-8 col-xl-8 col-md-8">
              <div class="row">
                <div class="col-sm-12">
                  <div class="card">
                    <div class="card-header">
                      <h5>Edit Payment Request</h5>
                    </div>
                    <?php
                    $customerselect = "SELECT * FROM `payment_request` WHERE `pay_id` = '$pur_id'";
                    $custoemrquery = mysqli_query($dbconnection, $customerselect);
                    if (mysqli_num_rows($custoemrquery) > 0) {
                      if ($row = mysqli_fetch_array($custoemrquery)) {
                        $payCode = $row['pay_code'];
                        $company_name = $row['company_name'];
                        $org_name = $row['org_name'];
                        $project_title = $row['project_title'];
                        $reason = $row['reason'];
                        $supplier_mail = $row['supplier_mail'];
                        $supplier_phone = $row['supplier_mobile'];
                        $supplier_branch = $row['supplier_branch'];
                        $account_no = $row['acc_no'];
                        $ifsc_code = $row['ifsc_code'];
                        $po_no = $row['po_no'];
                        $amount = $row['amount'];
                        $advancetype = $row['advance_step'];
                        $advance = $row['advanced_amonut'];
                        $balance = $row['balance_amount'];
                        $amount_words = $row['amount_words'];
                        $payment_type = $row['payment_type'];
                        $payment_against = $row['payment_against'];
                        $gst = $row['gst'];
                        $gst_no = $row['gst_no'];
                        $bill_no = $row['bill_no'];
                        $pofile = $row['po_file'];
                        $remarks = $row['remarks'];
                        $UTR_no = $row['utr_no'];
                        $accteampo = $row['acc_po'];
                        $userCancel = $row['user_cancel'];
                        $firstApproval = $row['first_approval'];
                        $orgLeadApproval = $row['orglead_approval'];
                        $secondApproval = $row['second_approval'];
                        $thirdApproval = $row['third_approval'];
                        $fourthApproval = $row['fourth_approval'];
                        $PurchasePayment = $row['purchase_payment'];
                        $createdBy = $row['created_by'];
                        $paymentclose = $row['close_pay'];
                        $resubmitpayment = $row['resubmit'];
                        $expStatus = $row['expenditure_status'];
                        $billupload = NULL;
                        if ($PurchasePayment == 1) {
                          $uploadedPO = './assets/pdf/purchase/';
                        } else {
                          $uploadedPO = './assets/pdf/payment/';
                        }
                      }
                    }
                    ?>
                    <div class="card-body pt-0">
                      <form action="./include/_paymentController.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" name="logged_admin_id" id="logged_admin_id" value="<?php echo $logged_admin_id ?>">
                        <input type="hidden" name="logged_admin_name" id="logged_admin_name" value="<?php echo fetchData($dbconnection, 'emp_name', 'admin_login', 'emp_id', $logged_admin_id); ?>">
                        <input type="hidden" name="logged_admin_role" id="logged_admin_role" value="<?php echo $logged_admin_role ?>">
                        <input type="hidden" name="logged_admin_org" id="logged_admin_org" value="<?php echo $logged_admin_org ?>">
                        <input type="hidden" name="payid" id="payid" value="<?php echo $pur_id; ?>">
                        <input type="hidden" name="paycode" id="paycode" value="<?php echo $payCode; ?>">
                        <input type="hidden" name="purchasepayment" id="purchasepayment" value="<?php echo $PurchasePayment; ?>">
                        <h6 class="mb-4 mt-4">Beneficiary Details</h6>
                        <?php
                        if ($payment_against != 3) {
                          if ($logged_admin_role == 6) {
                            if ($firstApproval == 0) {
                              include('./include/edit-payment-form.php');
                            } else {
                              include('./include/non-edit-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 5) {
                            if ($firstApproval == 0) {
                              include('./include/edit-payment-form.php');
                            } else {
                              include('./include/non-edit-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 8) {
                            if ($firstApproval == 1 && ($secondApproval == 0 || $secondApproval == 1) && $thirdApproval == 0) {
                              include('./include/edit-payment-form.php');
                            } else {
                              include('./include/non-edit-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 7) {
                            if ($firstApproval == 0 || $secondApproval == 0) {
                              include('./include/edit-payment-form.php');
                            } else {
                              include('./include/non-edit-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 3 || $logged_admin_role == 10) {
                            if ($firstApproval == 0 || $secondApproval == 0) {
                              include('./include/edit-payment-form.php');
                            } else {
                              include('./include/non-edit-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 4 || $logged_admin_role == 9) {
                            if (($firstApproval == 0 || $secondApproval == 0) && $createdBy == $logged_admin_id) {
                              include('./include/non-edit-payment-form.php');
                            } else {
                              include('./include/non-edit-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 1) {
                            if (($firstApproval == 0 || $secondApproval == 0) && $createdBy == $logged_admin_id) {
                              include('./include/edit-payment-form.php');
                            } else {
                              include('./include/non-edit-payment-form.php');
                            }
                          }
                          if($logged_admin_role == 11){
                            if($firstApproval == 1 && $orgLeadApproval == 2){
                              include('./include/edit-payment-form.php');
                            }else{
                              include('./include/non-edit-payment-form.php');
                            }
                          }
                        }
                        if ($payment_against == 3){
                          if ($logged_admin_role == 6) {
                            if ($firstApproval == 0) {
                              include('./include/edit-advanced-payment-form.php');
                            } else {
                              include('./include/non-edit-advanced-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 5) {
                            if ($firstApproval == 0) {
                              include('./include/edit-advanced-payment-form.php');
                            } else {
                              include('./include/non-edit-advanced-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 8) {
                            if ($firstApproval == 1 && ($secondApproval == 0 || $secondApproval == 1) && $thirdApproval == 0) {
                              include('./include/edit-advanced-payment-form.php');
                            } else {
                              include('./include/non-edit-advanced-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 7) {
                            if ($firstApproval == 0 || $secondApproval == 0) {
                              include('./include/edit-advanced-payment-form.php');
                            } else {
                              include('./include/non-edit-advanced-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 3  || $logged_admin_role == 10) {
                            if ($firstApproval == 0 || $secondApproval == 0) {
                              include('./include/edit-advanced-payment-form.php');
                            } else {
                              include('./include/non-edit-advanced-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 4 || $logged_admin_role == 9) {
                            if (($firstApproval == 0 || $secondApproval == 0) && $createdBy == $logged_admin_id) {
                              include('./include/edit-advanced-payment-form.php');
                            } else {
                              include('./include/non-edit-advanced-payment-form.php');
                            }
                          }
                          if ($logged_admin_role == 1) {
                            if (($firstApproval == 0 || $secondApproval == 0) && $createdBy == $logged_admin_id) {
                              include('./include/edit-advanced-payment-form.php');
                            } else {
                              include('./include/non-edit-advanced-payment-form.php');
                            }
                          }
                          if($logged_admin_role == 11){
                            if($firstApproval == 1 && $orgLeadApproval == 2){
                              include('./include/edit-advanced-payment-form.php');
                            }else{
                              include('./include/non-edit-advanced-payment-form.php');
                            }
                          }
                        }
                        ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-xl-4 col-md-4" id="status-card">
              <div class="card m-b-30">
                <div class="card-header">
                  <div class="row align-items-center">
                    <div class="col-6">
                      <h5 class="card-title mb-0">Status</h5>
                    </div>
                    <div class="col-6 f-right">
                      <?php if (empty($firstApproval) && empty($userCancel)) { ?>
                        <h6><span class="badge rounded-pill badge-primary mt-1"> Created </span></h6>
                      <?php }
                      if (empty($userCancel) && $firstApproval == 1 && $secondApproval == 0) { ?>
                        <h6><span class="badge rounded-pill badge-warning"> On Processing </span></h6>
                      <?php }
                      if ($userCancel == 4 || $firstApproval == 4 || $secondApproval == 4 || $thirdApproval == 4 || $fourthApproval == 4) { ?>
                        <h6><span class="badge rounded-pill badge-danger"> Cancel </span></h6>
                      <?php }
                      if (empty($userCancel) && $firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 0) { ?>
                        <h6><span class="badge rounded-pill badge-blue"> Preapproved </span></h6>
                      <?php }
                      if (empty($userCancel) && $firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 0) { ?>
                        <h6><span class="badge rounded-pill badge-info"> Agreed </span></h6>
                      <?php }
                      if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 1 && $paymentclose == 0) { ?>
                        <h6><span class="badge rounded-pill badge-success"> Approved </span></h6>
                      <?php }
                      if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 1 && $paymentclose == 1) { ?>
                        <h6><span class="badge rounded-pill badge-voliet"> Completed </span></h6>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                <p>
                    Created By : <strong> <?php echo  getuserName(fetchData($dbconnection, 'created_by', 'payment_request', 'pay_id', $pur_id), $dbconnection); ?></strong>
                  </p>
                  <?php if (!empty($firstApproval) && empty($userCancel)) { ?>
                    <p>
                      Approval 1 : <?php if ($firstApproval == 1) {
                                      echo 'Approved By';
                                    }
                                    if ($firstApproval == 4) {
                                      echo 'Cancelled By';
                                    } ?> <strong> <?php echo getuserName(fetchData($dbconnection, 'first_approval_by', 'payment_request', 'pay_id', $pur_id), $dbconnection); ?> </strong>
                    </p>
                  <?php } ?>
                  <?php if (!empty($userCancel)) { ?>
                    <p>
                      Cancelled By : <?php if ($userCancel == 4) {
                                    } ?> <strong> <?php echo getuserName(fetchData($dbconnection, 'user_cancel_by', 'payment_request', 'pay_id', $pur_id), $dbconnection); ?> </strong>
                    </p>
                  <?php } ?>
                    <?php if (empty($userCancel) && $org_name == 1 ) { ?>
                    <?php if ($firstApproval == 1) { ?>
                    <p>
                      Approval 2 :
                      <?php
                      if ($firstApproval == 1 &&  empty($secondApproval)) {
                        echo "Waiting For Approval";
                      } else if ($firstApproval == 1 &&  $secondApproval == 1) {
                        echo 'Approved By';
                      } else if ($firstApproval == 1 &&  $secondApproval == 4) {
                        echo 'Cancelled By';
                      }
                      ?>
                      <?php if ($firstApproval == 1 &&  $secondApproval == 1 || $secondApproval == 4) {  ?>
                        <strong>
                          <?php echo getuserName(fetchData($dbconnection, 'second_approval_by', 'payment_request', 'pay_id', $pur_id), $dbconnection); ?>
                        </strong>
                      <?php } ?>
                    </p>
                  <?php } ?>
                  <?php if ($secondApproval == 1 && !empty($firstApproval)) { ?>
                    <p>
                      Approval 3 :
                      <?php
                      if ($firstApproval == 1 &&   $secondApproval == 1  && empty($thirdApproval)) {
                        echo "Waiting For Approval";
                      } else if ($firstApproval == 1 &&  $secondApproval == 1 &&  $thirdApproval != 4) {
                        echo 'Approved By';
                      } else if ($firstApproval == 1 &&  $secondApproval == 1 &&  $thirdApproval == 4) {
                        echo 'Cancelled By';
                      }
                      ?>
                      <?php if ($secondApproval == 1 &&  $thirdApproval == 1 || $thirdApproval == 4) {  ?>
                        <strong>
                          <?php echo getuserName(fetchData($dbconnection, 'third_approval_by', 'payment_request', 'pay_id', $pur_id), $dbconnection); ?>
                        </strong>
                      <?php } ?>
                    </p>
                  <?php } ?>
                  <?php if ($thirdApproval == 1 && !empty($firstApproval)) { ?>
                    <p>
                      Approval 4 :
                      <?php
                      if ($firstApproval == 1 &&   $secondApproval == 1 && $thirdApproval == 1  && empty($fourthApproval)) {
                        echo "Waiting For Approval";
                      } else if ($firstApproval == 1 &&  $secondApproval == 1 && $thirdApproval == 1 &&  $fourthApproval != 4) {
                        echo 'Approved By';
                      } else if ($firstApproval == 1 &&  $secondApproval == 1 && $thirdApproval == 1 &&  $fourthApproval == 4) {
                        echo 'Cancelled By';
                      }
                      ?>
                      <?php if ($secondApproval == 1 &&  $thirdApproval == 1 && $thirdApproval == 1 || $fourthApproval == 4) {  ?>
                        <strong>
                          <?php echo getuserName(fetchData($dbconnection, 'fourth_approval_by', 'payment_request', 'pay_id', $pur_id), $dbconnection); ?>
                        </strong>
                      <?php } ?>
                    </p>
                  <?php } ?>
                  <?php } ?>
                  <?php if (empty($userCancel) && $org_name != 1 ) { ?>
                    <?php if ($firstApproval == 1) { ?>
                    <p>
                      Approval 2 :
                      <?php
                      if ($firstApproval == 1 && $orgLeadApproval == 2) {
                        echo "Waiting For Approval";
                      } else if ($firstApproval == 1 &&  $orgLeadApproval == 1) {
                        echo 'Approved By';
                      } else if ($firstApproval == 1 &&  $orgLeadApproval == 4) {
                        echo 'Cancelled By';
                      }
                      ?>
                      <?php if ($firstApproval == 1 &&  $orgLeadApproval == 1 || $orgLeadApproval == 4) {  ?>
                        <strong>
                          <?php echo getuserName(fetchData($dbconnection, 'orglead_approval_by', 'payment_request', 'pay_id', $pur_id), $dbconnection); ?>
                        </strong>
                      <?php } ?>
                    </p>
                  <?php } ?>
                  <?php if ($firstApproval == 1 && $orgLeadApproval == 1) { ?>
                    <p>
                      Approval 3 :
                      <?php
                      if ($firstApproval == 1 && $orgLeadApproval == 1 && $secondApproval == 0) {
                        echo "Waiting For Approval";
                      } else if ($firstApproval == 1 && $orgLeadApproval == 1 && $secondApproval != 4 ) {
                        echo 'Approved By';
                      } else if ($firstApproval == 1 && $orgLeadApproval == 1 && $secondApproval == 4) {
                        echo 'Cancelled By';
                      }
                      ?>
                      <?php if ($secondApproval == 1 &&  $orgLeadApproval == 1 || $orgLeadApproval == 4) {  ?>
                        <strong>
                        <?php echo getuserName(fetchData($dbconnection, 'second_approval_by', 'payment_request', 'pay_id', $pur_id), $dbconnection); ?>
                        </strong>
                      <?php } ?>
                    </p>
                  <?php } ?>
                  <?php if ($secondApproval == 1 && $firstApproval == 1 && $orgLeadApproval == 1) { ?>
                    <p>
                      Approval 4 :
                      <?php
                      if ($firstApproval == 1 && $secondApproval == 1  && empty($thirdApproval)) {
                        echo "Waiting For Approval";
                      } else if ($firstApproval == 1 &&  $secondApproval == 1 &&  $thirdApproval != 4) {
                        echo 'Approved By';
                      } else if ($firstApproval == 1 &&  $secondApproval == 1 &&  $thirdApproval == 4) {
                        echo 'Cancelled By';
                      }
                      ?>
                      <?php if ($secondApproval == 1 &&  $thirdApproval == 1 || $thirdApproval == 4) {  ?>
                        <strong>
                          <?php echo getuserName(fetchData($dbconnection, 'third_approval_by', 'payment_request', 'pay_id', $pur_id), $dbconnection); ?>
                        </strong>
                      <?php } ?>
                    </p>
                  <?php } ?>
                  <?php if ($thirdApproval == 1 && $firstApproval == 1 && $orgLeadApproval == 1) { ?>
                    <p>
                      Approval 5 :
                      <?php
                      if ($firstApproval == 1 &&   $secondApproval == 1 && $thirdApproval == 1  && empty($fourthApproval)) {
                        echo "Waiting For Approval";
                      } else if ($firstApproval == 1 &&  $secondApproval == 1 && $thirdApproval == 1 &&  $fourthApproval != 4) {
                        echo 'Approved By';
                      } else if ($firstApproval == 1 &&  $secondApproval == 1 && $thirdApproval == 1 &&  $fourthApproval == 4) {
                        echo 'Cancelled By';
                      }
                      ?>
                      <?php if ($secondApproval == 1 &&  $thirdApproval == 1 && $thirdApproval == 1 || $fourthApproval == 4) {  ?>
                        <strong>
                          <?php echo getuserName(fetchData($dbconnection, 'fourth_approval_by', 'payment_request', 'pay_id', $pur_id), $dbconnection); ?>
                        </strong>
                      <?php } ?>
                    </p>
                  <?php } ?>
                  <?php } ?>
                  <?php
                  $showButton = false;
                  switch ($logged_admin_role) {
                    case '6':
                      // user
                      if ($logged_admin_role == 6 && $firstApproval == 0) {
                        $showButton = false;
                      }
                      break;
                    case '3':
                      // Team Leader
                      if ($logged_admin_role == 3 && $firstApproval == 0) {
                        $showButton = true;
                      }
                      break;
                    case '11':
                        // Organization Leader
                        if ($logged_admin_role == 11 && $firstApproval == 1 && $orgLeadApproval == 2) {
                          $showButton = true;
                        }
                    break;
                    case '7':
                      // Purchase Leader
                      if ($logged_admin_role == 7 && $firstApproval == 0) {
                        $showButton = true;
                      }
                      break;
                    case '8':
                      // Accounts
                      if ($logged_admin_role == 8 && $firstApproval == 1 && $secondApproval == 0) {
                        $showButton = true;
                      }
                      break;
                    case '9':
                      // AGEM Accounts
                      if ($logged_admin_role == 9 && $thirdApproval == 1 && $fourthApproval == 0) {
                        $showButton = true;
                      }
                      break;
                    case '4':
                      // Finance
                      if ($logged_admin_role == 4 && $thirdApproval == 1 && $fourthApproval == 0) {
                        $showButton = true;
                      }
                      break;
                    case '1':
                      // Admin
                      if (($firstApproval == 0) && $createdBy == $logged_admin_id) {
                        $showButton = true;
                    }
                      break;
                  }

                  ?>

                  <?php if ($showButton == 1) { ?>
                    <button type="submit" class="btn btn-success my-1" name="approvepaymentTeamLeader" id="approvepaymentTeamLeader"> <?php if ($logged_admin_role == 4 || $logged_admin_role == 9) { echo 'Save Changes'; } else {  echo 'Approve'; } ?> </button>
                    <?php if ($thirdApproval == 0 &&  $secondApproval == 1 &&  $firstApproval == 1) { ?>
                      <button type="submit" class="btn btn-danger my-1" name="cancelpaymentTeamLeader">Cancel</button>
                    <?php } else { ?>
                      <button type="submit" class="btn btn-danger my-1" name="cancelpaymentTeamLeader"> Cancel</button>
                    <?php } ?>
                  <?php } ?>
                  <?php
                  $showCancelButton = false;
                  switch ($logged_admin_role) {
                    case '6':
                    case '5':
                      // user
                      if ($logged_admin_role == 6  && $fourthApproval == 0 && $userCancel == 0 && $firstApproval != 4) {
                        $showCancelButton = true;
                      }
                    break;
                    case '3':
                    case '7':
                      if ($firstApproval == 1 && $fourthApproval == 0 && $userCancel == 0 && $firstApproval != 4) {
                        $showCancelButton = true;
                    }
                    break;
                  }  
                  ?>
                   <?php if ($showCancelButton == 1) { ?>
                    <button type="submit" class="btn btn-danger my-1" name="cancelpaymentAny"> Cancel</button>
                   <?php } ?>
                  <?php
                  if ($logged_admin_role == 4 || $logged_admin_role == 9) {
                    if ($secondApproval == 1 && $thirdApproval == 1 && $balance == 0 && $billupload == 'Bill' && $paymentclose == 0) { ?>
                    <button type="button" class="btn btn-info my-1" onclick="changevisitstatus(<?php echo $pur_id ?>,<?php echo $logged_admin_id; ?>)" name="closepaymentAccount" id="closepaymentAccount">Close Payment</button>
                  <?php }
                  }  ?>
                  <?php
                  if ($createdBy == $logged_admin_id && $resubmitpayment != 1 && $advancetype == 0 && ($userCancel == 4 || $firstApproval == 4 || $secondApproval == 4 || $thirdApproval == 4 || $fourthApproval == 4)) { ?>
                    <a href="./cancel-resubmit-form.php?platform=<?php echo randomString(45); ?>&action=resubmitrequest&fieldid=<?php echo passwordEncryption($pur_id) ?>" class="btn btn-primary btn-sm" onclick="" name="" id="">Resubmit New Request</a>
                  <?php }
                  if ($resubmitpayment == 1) { ?>
                    <h6 style="color:#ff0000">New Request Reinitiated</h6>
                  <?php } ?>
                </div>
                </form>
                <?php
                if ($logged_admin_role == 4 || $logged_admin_role == 8 || $createdBy == $logged_admin_id) {
                    if ($expStatus == 1 && $payment_against == 9 && $fourthApproval == 4) {
                        ?>
                <div class="row mb-3 text-center">
                  <div class="col">
                    <button type="button" class="btn btn-info my-1" onclick="closeExpenditure(<?php echo $pur_id ?>,<?php echo $logged_admin_id; ?>)" name="closepaymentAccount" id="closepaymentAccount">Close Expenditure</button>
                  </div>
                </div>
                <?php
                    }
                } ?>

              </div>
              <div class="card m-b-30 comment-box">
                <div class="card-header">
                  <div class="row align-items-center">
                    <div class="col-6">
                      <h5 class="card-title mb-0">Feedback</h5>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <form action="./include/_messageController.php" method="POST">
                    <?php
                    $executemessage = mysqli_query($dbconnection, "SELECT * FROM `message` WHERE `pay_id` = '$pur_id'");
                    if (mysqli_num_rows($executemessage)) {
                      $slno = 0;
                      while ($row = mysqli_fetch_array($executemessage)) {
                        $message = $row['message_content'];
                        $sendfrom = $row['trigger_from'];
                        $sendtime = $row['trigger_from_time'];
                        $sender = $row['sender'];
                        $slno++;
                    ?>
                        <ul>
                          <li class="pt-2">
                            <div class="media align-self-center">
                              <div class="media-body">
                                <div class="row">
                                  <div class="col-md-6">
                                    <h6 class="mt-0"><?php if ($sender == 4 || $sender == 9) {
                                                        echo 'Feedback by Finance';
                                                      }
                                                      if ($sender == 8) {
                                                        echo 'Feedback by Accounts';
                                                      }
                                                      if ($sender == 6) {
                                                        echo 'Feedback from Employee';
                                                      } ?></h6>
                                  </div>
                                  <div class="col-md-6">
                                    <span><?php echo date("d-M-Y h:i A", strtotime($sendtime));  ?></span>
                                  </div>
                                </div>
                                <p class="pb-3"><?php echo $message ?></p>
                              </div>
                            </div>
                          </li>
                        </ul>
                    <?php }
                    } ?>
                    <?php if ($logged_admin_role == 4 || $logged_admin_role == 8 || $logged_admin_role == 9) {
                      if (messagecount($dbconnection, $pur_id, $payCode, $logged_admin_role) < 1) { ?>
                        <div class="message-box">
                          <div class="row">
                            <div class="col">
                              <div>
                                <label class="form-label" for="message">Type Message</label>
                                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                              </div>
                            </div>
                          </div>
                          <button type="button" onclick="addmessage(<?php echo $pur_id ?>)" class="btn btn-info my-1 mt-3" name="newmessage" id="newmessage">Submit</button>
                        </div>
                    <?php }
                    } ?>
                    <?php
                    if ($logged_admin_role == 6) {
                      if (mysqli_num_rows($executemessage)) {
                        if (messagecount($dbconnection, $pur_id, $payCode, $logged_admin_role) < 2) {
                    ?>
                          <div class="message-box">
                            <div class="row">
                              <div class="col">
                                <div>
                                  <label class="form-label" for="message">Type Message</label>
                                  <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                                </div>
                              </div>
                            </div>
                            <button type="button" onclick="addmessage(<?php echo $pur_id ?>)" class="btn btn-info my-1 mt-3" name="newmessage" id="newmessage">Submit</button>
                          </div>
                        <?php }
                      } else { ?>
                        <div class="text-center">
                          <h5 class="font-primary">No Feedback Yet!!!!</h5>
                        </div>
                    <?php }
                    } ?>
                  </form>
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
  <script src="./js/functions.js"></script>
  <script src="./assets/js/sweet-alert/sweetalert.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  <script>
    $('#advencAmount,#totalamount').keyup(function() {
      var totalAmount = Number($('#totalamount').val());
      var advanceAmount = Number($('#advencAmount').val());
      var nonbalance = Number($('#nonbalanceAmount').val());
      $('#totalamountWords').val(inWords($('#totalamount').val()));
      if (advanceAmount) {
        if (nonbalance != 0) {
          if (nonbalance >= advanceAmount) {
            var balanceAmount = nonbalance - advanceAmount;
            $('#balanceAmount').val(balanceAmount);
            $('#totalamount').removeClass('is-invalid');
            $("#updateAdvancepayment").removeAttr("disabled");
            $("#approvepaymentTeamLeader").removeAttr("disabled");
            if (balanceAmount == 0) {
              $('#teamLeader').show();
              $('#billfile').attr("required", "true");
              $('#billNo').attr("required", "true");
            } else {
              $('#teamLeader').hide();
              $('#billfile').removeAttr("required");
              $('#billNo').removeAttr("required");
            }
          } else {
            $('#totalamount').addClass('is-invalid');
            $("#updateAdvancepayment").attr("disabled", "true");
            $("#approvepaymentTeamLeader").attr("disabled", "true");
            $('#balanceAmount').val('');
          }
        } else {
          if (totalAmount >= advanceAmount) {
            var balanceAmount = totalAmount - advanceAmount;
            $('#balanceAmount').val(balanceAmount);
            $('#totalamount').removeClass('is-invalid');
            $("#approvepaymentTeamLeader").removeAttr("disabled");
          } else {
            $('#totalamount').addClass('is-invalid');
            $("#updateAdvancepayment").attr("disabled", "true");
            $("#approvepaymentTeamLeader").attr("disabled", "true");
            $('#balanceAmount').val('');
          }
        }
      } else {
        if (nonbalance != 0) {
          var balanceAmount = nonbalance - advanceAmount;
          $('#balanceAmount').val(balanceAmount);
        } else {
          var balanceAmount = totalAmount - advanceAmount;
          $('#balanceAmount').val(balanceAmount);
        }
      }
    });

    function changevisitstatus(paymentId, adminId) {
      var location = "https://www.vencar.in/accounts/payment-list.php";
      $.ajax({
        url: "./include/ajax-call.php",
        cache: false,
        type: 'POST',
        data: {
          visitstatus: 1,
          paymentId: paymentId,
          adminId: adminId
        },
        success: function(data) {
          if (data == '1') {
            swal("Success", "Payment Closed Successfully", "success", {
                buttons: {
                  Approve: "DONE",
                },
              })
              .then((value) => {
                if (value == 'Approve') {
                  setTimeout(function() {
                    window.location.reload();
                  }, 100);
                }
              });
          }
        }
      });
    }
    
    function closeExpenditure(paymentId, adminId) {
      // var location = "https://www.vencar.in/accounts/payment-list.php";
      $.ajax({
        url: "./include/ajax-call.php",
        cache: false,
        type: 'POST',
        data: {
          closeExpenditure: 1,
          paymentId: paymentId,
          adminId: adminId
        },
        success: function(data) {
          if (data == '1') {
            swal("Success", "Expenditure Closed Successfully", "success", {
                buttons: {
                  Approve: "DONE",
                },
              })
              .then((value) => {
                if (value == 'Approve') {
                  setTimeout(function() {
                    location.reload();
                  }, 100);
                }
              });
          }
        }
      });
    }

    function addmessage(paymentId) {
      var message = $('#message').val();
      var logged_id = $('#logged_admin_id').val();
      var payCode = $('#paycode').val();
      var logged_role = $('#logged_admin_role').val();
      $.ajax({
        url: "./include/ajax-call.php",
        cache: false,
        type: 'POST',
        data: {
          newmessage: 1,
          paymentId: paymentId,
          message: message,
          logged_id: logged_id,
          payCode: payCode,
          logged_role: logged_role
        },
        success: function(data) {
          if (data == '1') {
            swal("Success", "Feedback Added Successfully", "success", {
                buttons: {
                  Approve: "DONE",
                },
              })
              .then((value) => {
                if (value == 'Approve') {
                  setTimeout(function() {
                    window.location.reload();
                  }, 100);
                }
              });
          }
        }
      });
    }


    function updataAmountByAdmin(adminId, adminRole, paymentcode) {
      var amount = $('#updateAmountsByAdmin').val();
      $.ajax({
        url: "./include/ajax-call.php",
        cache: false,
        type: 'GET',
        data: {
          updateAmountAdmin: 1,
          paymentcode: paymentcode,
          adminRole: adminRole,
          adminId: adminId,
          amount: amount
        },
        success: function(data) {
          // console.log(data);
          toastr["success"]('Amount Updated');
          setTimeout(function() {
            window.location.reload();
          }, 1000);

        }
      });
    }

    $('#updateAmountsByAdmin').keyup(function() {
      var OriginalTotalAmount = Number($('#OriginalTotalAmount').val());
      var changeableAmount = Number($('#updateAmountsByAdmin').val());
      if (changeableAmount < OriginalTotalAmount) {
        $('#updateAmountsByAdmin').addClass('is-invalid');
        $('#updateAdminAmount').attr("disabled", "true");
      } else {
        $('#updateAmountsByAdmin').removeClass('is-invalid');
        $('#updateAdminAmount').removeAttr("disabled");
      }
    });
  </script>
</body>

</html>