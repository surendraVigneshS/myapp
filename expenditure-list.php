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
                            <div class="col-md-6">
                                <?php if ($logged_admin_role != 2) { ?>
                                    <h5>Current Credit Left: <?php echo IND_money_format(getPreviousExp($dbconnection, $logged_admin_id)); ?></h5> 
                                <?php } ?>
                            </div>
                            <div class="col-md-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Expenditure List</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Expenditure Modal-->
                <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog">
                        <form action="./include/_expController.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="OrgID" id="OrgID" value="<?php echo $logged_admin_org ?>">
                            <input type="hidden" name="logged_admin_id" id="logged_admin_id" value="<?php echo $logged_admin_id ?>">
                            <input type="hidden" name="logged_admin_role" id="logged_admin_role" value="<?php echo $logged_admin_role ?>">
                            <input type="hidden" name="logged_admin_name" id="logged_admin_name" value="<?php echo $logged_admin_name ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLongTitle">Close Expenditure</h6>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <label class="col-sm-12 col-form-label">Expenditure Type</label>
                                        <div class="col">
                                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                            <div class="form-check form-check-inline radio radio-primary">
                                                <input class="form-check-input" id="closeexp" type="radio" name="expenseType" value="1">
                                                <label class="form-check-label mb-0" for="closeexp">Close Expense</label>
                                            </div>
                                            <div class="form-check form-check-inline radio radio-primary">
                                                <input class="form-check-input" id="addexp" type="radio" name="expenseType" value="2">
                                                <label class="form-check-label mb-0" for="addexp">Add Expense</label>
                                            </div>
                                            </div>
                                        </div>
                                        <div id="closefield" class="mt-4">
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label" for="">Bill no *</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="billNo" name="billNo">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label" for="">UTR no</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="UTRNo" name="UTRNo">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label">Bill Copy</label>
                                                <div class="col-sm-7">
                                                    <input class="form-control" type="file" name="billfile" id="billfile" accept="image/x-png, image/jpeg, image/jpg , application/pdf">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="addfield" class="mt-4">
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label" for="">Amount *</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="expreamount" name="amount">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-4 col-form-label" for="">Remarks</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                  <button class="btn btn-primary" type="submit" id="expensechangeBTN">Submit</button>
                                </div>
                            </div>
                        </form>
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
                                            <a class="nav-link active" id="pills-cur-tab" data-bs-toggle="pill" href="#pills-cur" role="tab" aria-controls="pills-cur" aria-selected="true">Current Month Expenditure</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-history-tab" data-bs-toggle="pill" href="#pills-history" role="tab" aria-controls="pills-history" aria-selected="false">Expenditure History</a>
                                        </li>
                                        <?php } else {  ?>
                                        <li class="nav-item">
                                            <a class="nav-link active" id="pills-cur-tab" data-bs-toggle="pill" href="#md-pills-pend" role="tab" aria-controls="md-pills-pend-tab" aria-selected="true">Pending Expenses</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-com-tab" data-bs-toggle="pill" href="#md-pills-approved" role="tab" aria-controls="md-pills-approved-tab" aria-selected="false">Approved Expense</a>
                                        </li>
                                        <?php } ?>
                                        <?php if($logged_admin_role == 4){ ?>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-cur-tab" data-bs-toggle="pill" href="#md-pills-pend" role="tab" aria-controls="md-pills-pend-tab" aria-selected="true">Pending Expenses</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="pills-com-tab" data-bs-toggle="pill" href="#md-pills-approved" role="tab" aria-controls="md-pills-approved-tab" aria-selected="false">Approved Expense</a>
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
                                            <div class="row m-b-30">
                                                <div class="col-md-6">
                                                    <button class="btn btn-success f-left" id="exportExpenditureMonthBTN" type="button">Export Table Data</button>
                                                </div>
                                                <div class="col-md-6">
                                                <?php if (getPreviousExp($dbconnection, $logged_admin_id)  > 0) { ?>
                                                    <a href="./new-expenditure.php"><button class="btn btn-primary f-right" type="button">Add New Expense</button> </a>
                                                <?php } ?>
                                                <?php if (expenditurePending($dbconnection, $logged_admin_id) > 0) { ?>
                                                    <button class="btn btn-info f-right m-r-10" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalLong" data-bs-backdrop="static" data-bs-keyboard="false">Close Expenditure</button>
                                                <?php } ?>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <?php
                                                if ($logged_admin_role != 2) {
                                                    include('./include/expenditure-cur-table.php');
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab">
                                        <div class="card-body ">
                                            <div class="row m-b-30">
                                                <div class="col-md-6">
                                                    <button class="btn btn-success f-left" id="exportExpenditureHistoryBTN" type="button">Export Table Data</button>
                                                </div>
                                                <div class="col-md-6">
                                                <?php if (getPreviousExp($dbconnection, $logged_admin_id)  > 0) { ?>
                                                    <a href="./new-expenditure.php"><button class="btn btn-primary f-right" type="button">Add New Expense</button> </a>
                                                <?php } ?>
                                                <?php if (expenditurePending($dbconnection, $logged_admin_id) > 0) { ?>
                                                    <button class="btn btn-info f-right m-r-10" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalLong" data-bs-backdrop="static" data-bs-keyboard="false">Close Expenditure</button>
                                                <?php } ?>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <?php
                                                if ($logged_admin_role != 2) {
                                                    include('./include/expenditure-his-table.php');
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($logged_admin_role == 4){ ?>
                                    <div class="tab-pane fade" id="md-pills-pend" role="tabpanel" aria-labelledby="md-pills-pend-tab">
                                        <div class="card-body "> 
                                            <div class="table-responsive">
                                                <?php 
                                                    include('./include/expenditure-md-grouplist.php'); 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="md-pills-approved" role="tabpanel" aria-labelledby="md-pills-approved-tab">
                                        <div class="card-body ">
                                            <?php if (getPreviousExp($dbconnection, $logged_admin_id)  > 0) { ?>
                                                <div class="row">
                                                    <div class="col-md-12 m-b-30">
                                                        <a href="./new-remainder.php"><button class="btn btn-primary f-right" type="button">Create New Expense</button> </a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="table-responsive">
                                                <?php 
                                                    include('./include/md-comp-exp-table.php'); 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } else if ($logged_admin_role == 2) { ?>
                            <div class="card">
                                <div class="tab-content" id="pills-icontabContent">
                                    <div class="tab-pane fade show active" id="md-pills-pend" role="tabpanel" aria-labelledby="md-pills-pend-tab">
                                        <div class="card-body "> 
                                            <div class="table-responsive">
                                                <?php 
                                                    include('./include/expenditure-md-grouplist.php'); 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="md-pills-approved" role="tabpanel" aria-labelledby="md-pills-approved-tab">
                                        <div class="card-body ">
                                            <div class="table-responsive">
                                                <?php 
                                                    include('./include/md-comp-exp-table.php'); 
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
    <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <script>
        $(document).ready(function() {
            $("#exportExpenditureMonthBTN").click(function() {
                TableToExcel.convert(document.getElementById("exportExpenditureMonthTable"), {
                  name: "expenditure_month_list.xlsx",
                  sheet: {
                    name: "Sheet1"
                  }
                });
            });
        });
        $(document).ready(function() {
            $("#exportExpenditureHistoryBTN").click(function() {
                TableToExcel.convert(document.getElementById("exportExpenditureHistoryTable"), {
                  name: "expenditure_hsitory_list.xlsx",
                  sheet: {
                    name: "Sheet1"
                  }
                });
            });
        });
        $(document).ready(function() {
            $('#closefield').hide();
            $('#addfield').hide();
            $('#expensechangeBTN').attr('disabled', true);
            $("input[name$='expenseType']").click(function() {
                $('#expensechangeBTN').attr('disabled', false);
                var selectedval = $(this).val();
                if(selectedval == 1){
                    $('#closefield').show();
                    $('#addfield').hide();
                    $('#expensechangeBTN').attr('name', 'closeExpense');
                    $('#expreamount').attr('required', false);
                    $('#billNo').attr('required', true);
                }else{
                    $('#closefield').hide();
                    $('#addfield').show();
                    $('#expensechangeBTN').attr('name', 'addExpense');
                    $('#expreamount').attr('required', true);
                    $('#billNo').attr('required', false);
                }
            });
        });
        function approveExp(paymentId,adminId) {
            $('.completeexp').attr('disabled', true); 
            $.ajax({
              url: "./include/ajax-call.php",
              cache: false,
              type: 'POST',
              data: {
                completeExpenditure: 1,
                adminId: adminId,
                paymentId:paymentId 
              },
              success: function(data) { 
                  console.log(data);
                if (data == 200) {
                  swal("Success", "Expense Approved Successfully", "success", {
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
        function closeAllExpense(adminrole,adminId,closefor){
            $('#closeallexpense').attr('disabled', true);
            $.ajax({
              url: "./include/ajax-call.php",
              cache: false,
              type: 'POST',
              data: {completeAllExpenditure:1,adminId:adminId,adminrole:adminrole,closefor:closefor},
                success: function(data){ 
                    console.log(data);
                    if (data == 200) {
                        swal("Success", "Expense Approved Successfully", "success", {
                            buttons: {
                                Approve: "DONE",
                            },
                        })
                        .then((value) => {
                            if (value == 'Approve') {
                            setTimeout(function(){ window.location.reload(); }, 500);
                            }
                        });
                    }else{
                        alert('Data Submit Error, Try Again !!!!');
                        $('#closeallexpense').attr('disabled', false);
                    }
                }
            });
        }
    </script>
</body>

</html>