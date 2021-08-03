<?php 
    include('./include/dbconfig.php');
    include('./include/function.php');
    include('./include/authenticate.php'); 

    $pur_id = $action ="";
    if(isset($_GET['fieldid'])){ $pur_id = $_GET['fieldid']; $pur_id = passwordDecryption($pur_id); }
    if(isset($_GET['action'])) { $action = $_GET['action']; }

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
                                    <li class="breadcrumb-item"><a href="./payment-list.php"><i data-feather="trending-up"></i></a></li>
                                    <li class="breadcrumb-item">New Request</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-xl-9">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Resubmit Payment Request</h5>
                                        </div>
                                        <?php 
                                        $customerselect = "SELECT * FROM `payment_request` WHERE `pay_id` = '$pur_id'";
                                        $custoemrquery = mysqli_query($dbconnection, $customerselect);
                                            if (mysqli_num_rows($custoemrquery) > 0) {
                                                if ($row = mysqli_fetch_array($custoemrquery)) {
                                                    $payCode = $row['pay_code'];
                                                    $company_name = $row['company_name'];
                                                    $org_name = $row['org_name'];
                                                    $reason = $row['reason'];
                                                    $supplier_mail = $row['supplier_mail'];
                                                    $supplier_phone = $row['supplier_mobile'];
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
                                                    $firstApproval = $row['first_approval'];
                                                    $secondApproval = $row['second_approval'];
                                                    $thirdApproval = $row['third_approval'];
                                                    $PurchasePayment = $row['purchase_payment'];
                                                    $createdBy = $row['created_by'];
                                                    $paymentclose = $row['close_pay'];
                                                    $billupload = NULL;
                                                    if($PurchasePayment == 1){
                                                      $uploadedPO = './assets/pdf/purchase/';
                                                    }else{
                                                      $uploadedPO = './assets/pdf/payment/';
                                                    }
                                                }
                                            }
                                        ?>
                                        <div class="card-body">
                                            <form action="./include/_paymentController.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                                                <input type="hidden" name="logged_admin_id" id="logged_admin_id" value="<?php echo $logged_admin_id ?>">
                                                <input type="hidden" name="logged_admin_name" id="logged_admin_name" value="<?php  echo fetchData($dbconnection,'emp_name','admin_login','emp_id',$logged_admin_id); ?>">
                                                <input type="hidden" name="logged_admin_role" id="logged_admin_role" value="<?php  echo $logged_admin_role ?>">
                                                <input type="hidden" name="logged_admin_org" id="logged_admin_org" value="<?php echo $logged_admin_org ?>">
                                                <input type="hidden" name="paycode" id="paycode" value="<?php  echo $payCode ?>">
                                                <input type="hidden" name="paymentid" id="paymentid" value="<?php  echo $pur_id ?>">
                                                <div class="mb-3 row">
                                                    <p style="color: #ff0000;font-size:12px">* fields are required once. Please fill these fields.</p>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="paymentAgainst">Payment against *</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-select digits" id="paymentAgainst" name="paymentAgainst" required <?php if($payment_against == 3){ echo 'disabled'; }?>>
                                                            <option value="">Choose...</option>
                                                            <?php 
                                                                $selectpayment = "SELECT * FROM `payment_type` ";
                                                                $executepayment = mysqli_query($dbconnection,$selectpayment);
                                                                if(mysqli_num_rows($executepayment) > 0){
                                                                    while($payment = mysqli_fetch_array($executepayment)){
                                                                        $paymentvalue = $payment['payment_value'];
                                                            ?>
                                                            <option value="<?php echo $paymentvalue;?>" <?php if($payment_against == $paymentvalue){ echo 'selected'; } ?> ><?php echo $payment['payment_name']; ?></option>
                                                            <?php } } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="orgName">Organization</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-select digits" id="orgName" name="orgName" required>
                                                        <?php 
                                                                $selectOrganization = "SELECT * FROM `organization` ";
                                                                $executeOrganization = mysqli_query($dbconnection,$selectOrganization); 
                                                                while($Organization = mysqli_fetch_array($executeOrganization)){
                                                            ?> 
                                                            <option value="<?php echo  $Organization['id']; ?>"><?php echo $Organization['organization_name']; ?></option> 
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div id="othername"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="projectName">Project Name</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="text" id="projectName" name="projectName" placeholder="Search By - Project Name">
                                                    </div>
                                                </div>
                                                <h6>Search Beneficiary</h6>
                                                <div class="mb-2">
                                                    <input class="form-control" type="text" id="autocomplete" placeholder="Search By - Beneficiary Name/Beneficiary Email/Beneficiary Moblie">
                                                </div>
                                                <hr class="mt-4 mb-4">
                                                <h6 class="mb-4">Beneficiary Details</h6>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="companyName">Company/Beneficiary name*</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="companyName" name="companyName" value="<?php echo $company_name ?>" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="companyEmail">Beneficiary email</label>
                                                    <div class="col-sm-8">
                                                        <input type="email" class="form-control" id="companyEmail" name="companyEmail" value="<?php echo $supplier_mail  ?>">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="companyMobile">Beneficiary moblie</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="companyMobile" name="companyMobile" onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="12" value="<?php echo $supplier_phone ?>">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="accNo">Account No</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="accNo" name="accNo" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $account_no ?>">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="ifsccode">IFSC Code </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="ifsccode" name="ifsccode" value="<?php echo $ifsc_code ?>">
                                                    </div>
                                                </div>
                                                <!-- <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="reason">Reason</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" id="reason" name="reason" rows="3"><?php echo $reason ?></textarea>
                                                    </div>
                                                </div> -->
                                                <hr class="mt-4 mb-4">
                                                <h6 class="mb-4">Payment Details</h6>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="amount">Total amount *</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="totalamount" name="amount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" value="<?php echo $amount ?>" required>
                                                        <div class="invalid-feedback">Total Amount should be less than  Advance Amount</div>
                                                    </div>
                                                </div>
                                                <?php if($payment_against != 3){ ?>
                                                <div id="teamLeader">
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label" for=""></label>
                                                        <div class="col-sm-4">
                                                            <label for="advencAmount">Advance amount *</label>
                                                            <input class="form-control" type="text" id="advencAmount" name="advencAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" >
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="balanceAmount">Balance amount</label>
                                                            <input type="text" class="form-control" id="balanceAmount" name="balanceAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php if($payment_against == 3){ ?>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for=""></label>
                                                    <div class="col-sm-4">
                                                        <label for="advencAmount">Advance amount *</label>
                                                        <input class="form-control" type="text" id="advencAmount" name="advencAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" value="<?php echo $advance ?>">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="balanceAmount">Balance amount</label>
                                                        <input type="text" class="form-control" id="balanceAmount" name="balanceAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" value="<?php echo $balance ?>" readonly>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="totalamountWords">Total Amount in words</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" id="totalamountWords" name="amountWords" rows="3"><?php echo $amount_words ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="paymentType">Payment type *</label>
                                                    <div class="col-sm-8">
                                                    <select class="form-select digits" id="paymentType" name="paymentType">
                                                        <option value="Immediate" <?php if($payment_type == 'Immediate'){ echo 'selected';} ?>>Immediate</option>
                                                        <option value="Normal" <?php if($payment_type == 'Normal'){ echo 'selected';} ?>>Normal</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="paymentType">GST *</label>
                                                    <div class="col-sm-8">
                                                        <div class="m-t-10 m-checkbox-inline custom-radio-ml">
                                                            <div class="form-check form-check-inline radio radio-primary">
                                                              <input class="form-check-input" id="gstYes" type="radio" name="gstOption" <?php if($gst == 1){ echo 'checked'; } ?> value="1">
                                                              <label class="form-check-label mb-0" for="gstYes">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline radio radio-primary">
                                                              <input class="form-check-input" id="gstNo" type="radio" name="gstOption" <?php if($gst == 0){ echo 'checked'; } ?> value="0">
                                                              <label class="form-check-label mb-0" for="gstNo">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-4 col-form-label" for="gstNo">GST Number</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="gstNo" class="form-control option 1" value="<?php echo $gst_no ?>" id="gstNo">
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="">Remarks</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" id="remarks" name="remarks" rows="3"><?php echo $remarks ?></textarea>
                                                    </div>
                                                </div>
                                                <div id="advance">
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label" for="PONum">PO No</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="PONum" name="PONum">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">PO Copy</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="file" name="pofile" id="pofile" accept="image/x-png, image/jpeg, image/jpg , application/pdf">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="bill">
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label" for="">Bill no *</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="billNo" name="billNo">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 row">
                                                        <label class="col-sm-4 col-form-label">Bill Copy *</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="file" name="billfile" id="billfile" accept="image/x-png, image/jpeg, image/jpg , application/pdf">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-center">
                                                    <button class="btn btn-primary" type="submit" name="ResubmitPaymentRequest" id="ResubmitPaymentRequest">Submit</button>
                                                </div>
                                            </form>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="./js/payment.js"></script>
    <script src="./js/functions.js"></script>
    <script>
        $('#advencAmount,#totalamount').keyup(function(){
            var totalAmount =  Number($('#totalamount').val());
            var advanceAmount =  Number($('#advencAmount').val());
            $('#totalamountWords').val(inWords($('#totalamount').val()));
            if(advanceAmount){
                if(totalAmount >= advanceAmount ){
                    var balanceAmount =  totalAmount - advanceAmount; 
                    $('#balanceAmount').val(balanceAmount);
                    $('#totalamount').removeClass('is-invalid');  
                    $("#addPayment").removeAttr("disabled");
                }
                else{
                    $('#totalamount').addClass('is-invalid');  
                    $("#addPayment").attr("disabled", "true");
                    $('#balanceAmount').val('');
                } 
            }else{
                $('#balanceAmount').val(totalAmount);
            }
        });
        $('#paymentAgainst').on('change',function(){
            var selection = $(this).val();
            switch(selection){
                case "3":
                    $("#teamLeader").show();
                    $('#advance').show();
                    $('#bill').hide();
                    $('#advencAmount').attr("required","true");
                    $('#balanceAmount').attr("required","true");
                    $('#billNo').removeAttr("required");
                    $('#billfile').removeAttr("required");
                break;
                case "2":
                    $('#bill').show();
                    $('#advance').hide();
                    $("#teamLeader").hide();
                    $('#billfile').attr("required","true");
                    $('#billNo').attr("required","true");
                    $('#advencAmount').removeAttr("required");
                    $('#balanceAmount').removeAttr("required");
                break;
                case "1":
                case "4":
                case "5":
                case "6":
                case "7":
                    $('#advance').show();
                    $('#bill').hide();
                    $("#teamLeader").hide();
                    $('#billNo').removeAttr("required");
                    $('#billfile').removeAttr("required");
                    $('#advencAmount').removeAttr("required");
                    $('#balanceAmount').removeAttr("required");
                break;
                default:
                    $("#teamLeader").hide();
                    $("#bill").hide();
                    $("#advance").hide();
                    $('#advencAmount').removeAttr("required");
                    $('#balanceAmount').removeAttr("required");
                    $('#billfile').removeAttr("required");
            }
        });
        $('#orgName').on('change',function(){
            var selection = $(this).val();
            switch(selection){
                case '3':
                    $('#othername').append("<input type='text' class='form-control mb-3' name='otherorgName' placeholder='Enter organization name' id='otherorgName' required>");
                break;
                default:
                $('#othername').html('');
                break;
            }
        });
        $( function(){
            $( "#projectName" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "./include/ajax-call.php",
                        cache: false,
                        type: 'POST',
                        dataType: 'JSON',
                        data:{searchproject:1,search:request.term},
                        success: function( data ) {
                            response( data );
                        }
                    });
                },
                select: function (event, ui) {
                    $('#projectName').val(ui.item.label);
                    return false;
                },
                focus: function(event, ui){
                    $( "#projectName" ).val( ui.item.label );
                    return false;
                },
            });
        });
    </script>
</body>

</html>