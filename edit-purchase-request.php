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
  <title> Edit Purchase | Freeztek | Accounts </title>
  <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/vendors/scrollbar.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/vendors/animate.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/vendors/sweetalert2.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
  <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
  <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/vendors/select2.css">
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
                  <li class="breadcrumb-item"><a href="./purchase-list.php"><i data-feather="shopping-bag"></i></a></li>
                  <li class="breadcrumb-item">New Request</li>
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
                      <h5>View Purchase Request Details</h5>
                    </div>
                    <?php
                    $uploadedPO = './assets/pdf/purchase/';
                    $selectpayment = "SELECT * FROM `purchase_request` LEFT JOIN `ft_projects_tb` ON `ft_projects_tb`.`project_id` = `purchase_request`.`pr_project_id` WHERE `purchase_request`.`pur_id` = '$pur_id' ";
                    $paymentQuery = mysqli_query($dbconnection, $selectpayment);
                    if (mysqli_num_rows($paymentQuery) > 0) {
                      if ($row = mysqli_fetch_array($paymentQuery)) {
                        $org_name = $row['org_name'];
                        $pofile = $row['po_file'];
                        $billfile = $row['bill_file'];
                        $firstApproval = $row['first_approval'];
                        $secondApproval = $row['second_approval'];
                        $thirdApproval = $row['third_approval'];
                        $leadApproval = $row['orglead_approval'];
                        $currentSupId = $row['pr_supplier_id'];
                        $pr_po_convert = $row['pr_po_convert'];
                        $showButton = false;
                    ?>
                        <?php
                        if ($logged_admin_role == 6) {
                          // User
                          if ($org_name == 1) {
                            if (empty($row['first_approval']) && empty($row['first_approved_by'])) {
                              include_once('./include/user-editable-purchaseform.php');
                            } else if (!empty($row['first_approval']) && !empty($row['first_approved_by'])) {
                              include_once('./include/user-not-editable-from.php');
                            }
                          } else {
                            if (empty($row['orglead_approval'])) {
                              include_once('./include/user-editable-purchaseform.php');
                            } else if (!empty($row['orglead_approval'])) {
                              include_once('./include/user-not-editable-from.php');
                            }
                          }
                        } else if ($logged_admin_role == 5 || $logged_admin_role == 3 || $logged_admin_role == 7 || $logged_admin_role == 1) {
                          // Purchase
                          if (empty($row['first_approval']) && empty($row['second_approval']) && $row['already_purchased'] == 0) {
                            include_once('./include/user-editable-purchaseform.php');
                          } else if (empty($row['second_approval']) && empty($row['second_approved_by']) && $row['already_purchased'] == 0 &&  $row['first_approval'] != 4) {
                            // After MD Approved
                            include_once('./include/editablepurchaseteam.php');
                          } else if (empty($row['second_approval']) && empty($row['second_approved_by']) && $row['already_purchased'] == 0 &&  $row['first_approval'] == 4) {
                            // After MD Cancelled
                            include_once('./include/purchase-form-md-cancelled.php');
                          } else if (empty($row['first_approval']) && empty($row['second_approval']) && $row['already_purchased'] == 1  &&  $row['created_by'] == $logged_admin_id) {
                            // After MD Approved
                            // done
                            include_once('./include/already-purchase-editable-form.php');
                          } else if (empty($row['second_approval']) && empty($row['second_approved_by']) && $row['already_purchased'] == 1) {
                            // After MD Approved  - already purchased
                            // done
                            include_once('./include/already-purchase-not-editable-form.php');
                          } else if ($row['second_approval'] == 1 && $row['first_approval'] == 1) {
                            // done
                            include_once('./include/noteditablepurchase.php');
                          } else if ($row['completed'] == 1 && $row['first_approval'] == 1) {
                            // done
                            include_once('./include/noteditablepurchase.php');
                          }
                        }
                        if ($logged_admin_role == 4 || $logged_admin_role == 8 || $logged_admin_role == 9) {
                          // Acc
                          // done
                          include_once('./include/user-not-editable-from.php');
                        }
                        if ($logged_admin_role == 11) {
                          // Purchase
                          if ($row['orglead_approval'] == 2 && empty($row['first_approval']) && empty($row['second_approval'])) {
                            // done
                            include_once('./include/user-editable-purchaseform.php');
                          } else if (($row['orglead_approval'] == 1 || $row['orglead_approval'] == 4)) {
                            // done
                            include_once('./include/user-not-editable-from.php');
                          }
                        }

                        ?>
                      <?php } ?>

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
                      <h6><span class="badge rounded-pill <?php echo fetchPurchaseStatus($dbconnection, $pur_id)[0]; ?> mt-1"><?php echo fetchPurchaseStatus($dbconnection, $pur_id)[1]; ?></span> </h6>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <p>
                    Created By : <strong> <?php echo  getuserName(fetchData($dbconnection, 'created_by', 'purchase_request', 'pur_id', $pur_id), $dbconnection); ?></strong>
                  </p>
                  <?php if ($org_name != 1 && $leadApproval == 1) { ?>
                    <p>
                      OL Approval :
                      <?php if ($leadApproval == 1) {
                          echo 'Approved By';
                        } else if ($leadApproval == 4) {
                          echo 'Cancelled By';
                        }
                      ?>
                      <strong> <?php echo getuserName(fetchData($dbconnection, 'orglead_approval_by', 'purchase_request', 'pur_id', $pur_id), $dbconnection); ?> </strong>
                    </p>
                  <?php } ?>
                  <?php if (!empty($firstApproval)) { ?>
                    <p>
                      MD Approval : <?php if ($firstApproval == 1) {
                                      echo 'Approved By';
                                    }
                                    if ($firstApproval == 4) {
                                      echo 'Cancelled By';
                                    } ?> <strong> <?php echo getuserName(fetchData($dbconnection, 'first_approved_by', 'purchase_request', 'pur_id', $pur_id), $dbconnection); ?> </strong>
                    </p>
                  <?php } ?>
                  <?php if ($logged_admin_role == 11) {
                        if ($leadApproval == 2) { ?>
                      <form action="./include/_purchaseController.php" method="POST">
                        <input type="hidden" name="purchaseId" value="<?php echo $pur_id; ?>">
                        <input type="hidden" name="logged_admin_id" value="<?php echo $logged_admin_id; ?>">
                        <input type="hidden" name="logged_admin_role" value="<?php echo $logged_admin_role; ?>">
                        <button type="submit" class="btn btn-success my-1" name="approvepurchaseTeamLeader">Approve</button>
                        <button type="submit" class="btn btn-danger my-1" name="cancelpurchaseTeamLeader">Cancel</button>
                      </form>
                  <?php }
                      } ?>
                  <?php if ($firstApproval == 4) { ?>
                    <p>
                      Cancelled Reason : <strong><?php echo $row['cancel_reason']; ?> </strong>
                    </p>
                    <?php if ($row['resubmit'] == 0 && $row['created_by'] == $logged_admin_id) { ?>
                      <a href="./raise-purchase.php?platform=<?php echo randomString(45); ?>&action=editpurchase&fieldid=<?php echo passwordEncryption($pur_id) ?>" class="btn btn-primary my-1"> Resubmit Request </a>
                    <?php } else if ($row['resubmit'] == 1 && $row['created_by'] == $logged_admin_id) { ?>
                      <p class="text-danger">New Request Reintiated</p>
                  <?php }
                      } ?>
                  <?php if ($firstApproval == 1 && $row['already_purchased'] == 0) { ?>
                    <p>
                      PO Upload :
                      <?php
                        if ($firstApproval == 1 &&  empty($secondApproval)) {
                          echo "Not Yet Uploaded";
                        } else if ($firstApproval == 1 &&  $secondApproval == 1) {
                          echo 'Payment Request Raised';
                        } else if ($firstApproval == 1 &&  $secondApproval == 4) {
                          echo 'Cancelled By';
                        }
                      ?>
                      <?php if ($firstApproval == 1 &&  $secondApproval == 1 || $secondApproval == 4) {  ?>
                        <strong>
                          <?php echo getuserName(fetchData($dbconnection, 'second_approved_by', 'purchase_request', 'pur_id', $pur_id), $dbconnection); ?>
                        </strong>
                      <?php } ?>
                    </p>
                  <?php } ?>
                  <?php if ($firstApproval == 1 && $row['already_purchased'] == 1) { ?>
                    <p>
                      Bill Upload :
                      <?php
                        if ($firstApproval == 1 && empty($row['bill_file'])) {
                          echo "Not Yet Uploaded";
                        } else if ($firstApproval == 1 &&  !empty($row['bill_file'])) {
                          echo 'Bill Uploaded By';
                        }
                      ?>
                      <?php if ($firstApproval == 1 &&  !empty($row['bill_file'])) {  ?>
                        <strong>
                          <?php echo getuserName(fetchData($dbconnection, 'created_by', 'purchase_request', 'pur_id', $pur_id), $dbconnection); ?>
                        </strong>
                      <?php } ?>
                    </p>
                  <?php } ?>
                  <?php if ($row['completed'] == 1) { ?>
                    <p>
                      Complete :
                      <?php
                        if ($firstApproval == 1) {
                          echo "Completed By";
                        }
                      ?>
                      <?php if ($firstApproval == 1  || $secondApproval == 4) {  ?>
                        <b>
                          <?php echo getPurchaseCompletedName($dbconnection, $purid); ?>
                        </b>
                        <strong>
                          <?php echo getuserName(getPurchaseCompletedName($dbconnection, $pur_id), $dbconnection); ?>
                        </strong>
                      <?php } ?>
                    </p>
                  <?php } ?>
                  <?php if ($secondApproval == 1  && $row['completed'] == '0' && $row['already_purchased'] ==  0   && $logged_admin_role != 6 && $logged_admin_role != 4 && $logged_admin_role != 1) { ?>
                    <button type="button" class="btn btn-info my-1 cloasereQuest" name="approvepaymentTeamLeader" onclick="closePurchase(<?php echo $pur_id ?>,<?php echo $logged_admin_id ?>,<?php echo $logged_admin_role ?>)"> Close Request </button>
                  <?php } ?>
                  <?php if ($firstApproval == 1  && $row['completed'] == '0' && $row['already_purchased'] == 1  && !empty($row['bill_file'])  && $logged_admin_role != 6 && $logged_admin_role != 4 && $logged_admin_role != 1) { ?>
                    <button type="button" class="btn btn-info my-1 cloasereQuest" name="approvepaymentTeamLeader" onclick="closePurchase(<?php echo $pur_id ?>,<?php echo $logged_admin_id ?>,<?php echo $logged_admin_role ?>)"> Close Request </button>
                  <?php } ?>
                  <?php if ($firstApproval == 1   &&  $row['completed'] == '0' && $row['already_purchased'] == 1  && !empty($row['bill_file'])  && $logged_admin_role != 6 && $logged_admin_role != 4 && $logged_admin_role != 1 && $row['purchase_payment'] == 0) { ?>
                    <form action="./include/_purchaseController.php" method="POST">
                      <input type="hidden" name="purchaseId" value="<?php echo $pur_id; ?>">
                      <input type="hidden" name="logged_admin_id" value="<?php echo $logged_admin_id; ?>">
                      <input type="hidden" name="logged_admin_role" value="<?php echo $logged_admin_role; ?>">
                      <button type="submit" class="btn btn-success my-1" name="raisePaymentRequest"> Raise Payment Request </button>
                    </form>
                  <?php } ?>
                </div>
              </div>
              <?php if(empty($pofile)){ ?> 
              <div class="card  text-center">
                <div class="card-header">
                    <h5>Generate PO File</h5>
                </div>
                <div class="card-body">
                  <a href="raise-purchase-order.php?platform=M4LQqPZJIpm37G11cxoc7tVOnDWmwfSfLYeyFe22Lu9oY&fieldid=<?php echo passwordEncryption($pur_id); ?>"><button type="button" class="btn btn-info" > Click to generate PO </button></a> 
                </div>
              </div>
                <?php } ?>
              <?php if(!empty($pofile)){?>
              <div class="card  text-center">
              <div class="card-header ">
                  <h5>PO Details</h5>
              </div>
              <div class="card-body">
                  <div class="row">
                      <div class="col">
                          <a href="<?php echo $uploadedPO . $pofile; ?>" target="_blank"> <button type="button" class="btn btn-info"><i class="fas fa-eye mr-2"></i> View </button> </a>
                          <a href="<?php echo $uploadedPO . $pofile; ?>" target="_blank" download=""> <button type="button" class="btn btn-xs btn-success" style="font-size:14px;padding:5px 10px"><i class="fas fa-download"></i> Download</button></a>
                      </div>
                  </div>
              </div>
              </div>
                <?php } ?>
                <?php if(!empty($pofile)){?> 
                  <div class="card  text-center">
              <div class="card-header ">
                  <h5>Bill Details</h5>
              </div>
              <div class="card-body">
                  <div class="row">
                      <div class="col">
                          <a href="<?php echo $uploadedPO . $billfile; ?>" target="_blank"> <button type="button" class="btn btn-info"><i class="fas fa-eye mr-2"></i> View </button> </a>
                          <a href="<?php echo $uploadedPO . $billfile; ?>" target="_blank" download=""> <button type="button" class="btn btn-xs btn-success" style="font-size:14px;padding:5px 10px"><i class="fas fa-download"></i> Download</button></a>
                      </div>
                  </div>
              </div>
              </div>
                   <?php } ?>
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
  <script src="./assets/js/select2/select2.full.min.js"></script>
  <script src="./assets/js/script.js"></script>
  <script src="./assets/js/sweet-alert/sweetalert.min.js"></script> 
  <script src="./js/functions.js"></script>

  <script>
    $('#ifpodone').change(function() {
      $('#productimageupload').toggle(500);
    });

    $('input[name="Action"]').change(function() {
      var value = $('input[name=Action]:checked').val();
      if (value == "sendMailOnly") {
        $('#pofile,#poNO').attr("required", true);
        $('#emailBody,#emailSubject').attr("required", true);
        $('#sentPOEmail').removeAttr('disabled');
        $('#savePOFILE,#addPurchasePO').attr('disabled', true);
        $('#totalAmount,#advencAmount').removeAttr('required');
      } else if (value == "savePOOnly") {
        $('#savePOFILE').removeAttr('disabled');
        $('#pofile').attr("required", true);
        $('#addPurchasePO,#sentPOEmail').attr('disabled', true);
        $('#emailSubject,#emailBody').removeAttr('required');
        $('#totalAmount,#advencAmount').removeAttr('required');
      } else if (value == "raisePayOnly") {
        $('#totalAmount,#advencAmount').attr("required", true);
        $('#addPurchasePO').removeAttr('disabled');
        $('#pofile,#poNO').removeAttr('required');
        $('#sentPOEmail,#savePOFILE').attr('disabled', true);
        $('#emailSubject,#emailBody').removeAttr('required');


      }
    });






    $('#advencAmount,#totalAmount').keyup(function() {
      var totalAmount = Number($('#totalAmount').val());

      var advanceAmount = Number($('#advencAmount').val());
      $('#amountWords').val(inWords($('#totalAmount').val()));

      if (advanceAmount) {

        if (totalAmount >= advanceAmount) {
          var balanceAmount = totalAmount - advanceAmount;
          $('#balanceAmount').val(balanceAmount);
          $('#totalAmount').removeClass('is-invalid');
          $("#addPurchasePO").removeAttr("disabled");
        } else {
          $('#totalAmount').addClass('is-invalid');
          $("#addPurchasePO").attr("disabled", "true");
          $('#balanceAmount').val('');
        }

      }
    });




    function closePurchase(purchaseId, adminId, adminRole) {
      $('.cloasereQuest').html('Please Wait..!');
      $.ajax({
        url: "./include/ajax-call.php",
        cache: false,
        type: 'POST',
        data: {
          closePurchase: 1,
          purchaseId: purchaseId,
          adminId: adminId,
          adminRole: adminRole
        },
        success: function(data) {

          if (data == '1') {
            location.reload();
          }
        }
      });
    }

    $("#addNewCap2").click(function() {
      var elem = '<div class="m-b-10 m-t-10 row rows" id="">';
              elem += '<div class="col-sm-8 col-md-9">'; 
              elem += '<select class="form-select  select2 lastclass" id="projectTitle" name="productID[]" required>';
              elem += '<option value="" selected disabled>----</option>';
              <?php
                $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_master` ORDER BY `product_name` ASC ");
                while ($rows = mysqli_fetch_assoc($query)) {
                    ?>
                    elem += '<option value="<?php echo $rows['product_id']; ?>">';
                    elem += '<?php echo  ucfirst($rows['product_name']); ?>';
                    elem += '</option>'; 
                <?php } ?> 
              elem += '</select>'; 
              elem += '</div>'; 
              elem += '<div class="col-sm-2 col-md-3">'; 
              elem += '<input type="text" class="form-control" name="productQTY[]"  required>';
              elem += '</div>';
              elem += '</div>'; 

      $("#capacity-div2").append(elem);
      $('.lastclass:last').select2();

    });

    $("#addNewRemove2").click(function() {
      console.log($('#capacity-div2 .rows').length);
      if ($('#capacity-div2 .rows').length > 0) {
        $('#capacity-div2 .rows').last().remove();
      } else {
        alert("You can't remove fields anymore..!");
      }
    }); 
  </script>
</body>

</html>