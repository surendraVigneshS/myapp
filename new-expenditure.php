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
    <title>New Expenditure - Accounts</title>
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
                                <h5>Create New Expenditure</h5>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="./expenditure-list.php"><i data-feather="shopping-bag"></i></a></li>
                                    <li class="breadcrumb-item">Create New Expenditure</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-xl-8">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                        <?php if(!empty(getPreviousExp($dbconnection, $logged_admin_id))){ ?>
                                            <form action="./include/_expController.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                                                <input type="hidden" name="logged_admin_id" value="<?php echo $logged_admin_id; ?>">
                                                <input type="hidden" id="postexpAmount" name="postexpAmount" value="<?php echo getPreviousExp($dbconnection, $logged_admin_id); ?>">
                                                <input type="hidden" id="payid" name="payid" value="<?php echo getPreviousExp($dbconnection, $logged_admin_id); ?>">
                                                <h6 class="mb-4">Expense Details</h6>
                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label" for="expName">Expense Name*</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="text" name="expName" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label" for="expamount">Total amount *</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="expamount" name="expamount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" required>
                                                        <div class="invalid-feedback">Total Amount should be less than Credit Amount</div>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label">File Attachment</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" id="expFiles" type="file" name="expFiles" accept="image/x-png, image/jpeg, image/jpg , application/pdf">
                                                    </div>
                                                </div>


                                                <div class="card-footer text-center">
                                                    <button class="btn btn-primary" name="addExpenditure" id="addExpenditure" type="submit">Save Expenditure</button>
                                                </div>
                                            </form>
                                            <?php }else{  ?>
                                                <h4>You can't add expense - you have 0 credits left</h4>
                                                <br>
                                                <h6>Create Payment Request to Start Adding Expenses</h6>
                                                <br>
                                                <a href="./new-payment.php"> <button class="btn btn-primary">Raise New Request</button></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-4 col-md-4" id="status-card">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <input type="hidden" id="curExpAmount" value="<?php echo getPreviousExp($dbconnection, $logged_admin_id); ?>">
                                            <h5 class="card-title mb-0">Credit Left : <span id="currentCredittext"><?php echo getPreviousExp($dbconnection, $logged_admin_id); ?></span></h5>
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
    <script src="./assets/js/datepicker/datepicker.js"></script>
    <script src="./assets/js/datepicker/datepicker.en.js"></script>
    <script src="./js/functions.js"></script>
    <script>
        $('#expamount').keyup(function() {
            var curcredit = Number($('#curExpAmount').val());
            var expamount = Number($('#expamount').val());
            
            if (expamount <= curcredit) {
                var balance = curcredit - expamount; 
                $('#expamount').removeClass('is-invalid');
                $('#addExpenditure').removeAttr('disabled');
                $('#currentCredittext').text(balance);
                $('#postexpAmount').val(balance);
            } else {
                $('#expamount').addClass('is-invalid');
                $('#addExpenditure').attr('disabled', true);
            }
            
        });
    </script>
</body>

</html>