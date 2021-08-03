<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');

$fieldid =""; 
if(isset($_GET['fieldid'])){ 
    $encryptid = $_GET['fieldid']; 
    $fieldid = passwordDecryption($encryptid);
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
                                    <li class="breadcrumb-item">Expenditure List</li>
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
                            <?php if ($logged_admin_role == 2) { ?>
                                <div class="card">
                                    <form id="expenditure-form" action="./include/_expController.php" method="POST">
                                        <input type="hidden" id="fieldID" name="createdid" value="<?php echo $fieldid ?>">
                                        <input type="hidden" name="logged_admin_id" id="logged_admin_id" value="<?php echo $logged_admin_id ?>">
                                        <input type="hidden" name="logged_admin_name" id="logged_admin_name" value="<?php echo fetchData($dbconnection, 'emp_name', 'admin_login', 'emp_id', $logged_admin_id); ?>">
                                        <input type="hidden" name="logged_admin_role" id="logged_admin_role" value="<?php echo $logged_admin_role ?>">
                                        <div class="card-body "> 
                                            <div class="row mb-4">
                                                <div class="col-md-6"><h6 class="task_title_0">Approve the Select Payments</h6></div>
                                                <div class="col-md-6"><button class="btn btn-primary btn-sm f-right" type="submit" name="approvedexpense">Approve Expense </button></div>
                                            </div>
                                            <div class="table-responsive">
                                                <?php 
                                                    include('./include/expenditure-md-cur-table.php'); 
                                                ?>
                                            </div>
                                        </div> 
                                    </form>
                                </div>
                            <?php } ?>
                            <?php if ($logged_admin_role == 4) { ?>
                                <div class="card">
                                    <form id="expenditure-form" action="./include/_expController.php" method="POST">
                                        <input type="hidden" id="fieldID" name="createdid" value="<?php echo $fieldid ?>">
                                        <input type="hidden" name="logged_admin_id" id="logged_admin_id" value="<?php echo $logged_admin_id ?>">
                                        <input type="hidden" name="logged_admin_name" id="logged_admin_name" value="<?php echo fetchData($dbconnection, 'emp_name', 'admin_login', 'emp_id', $logged_admin_id); ?>">
                                        <input type="hidden" name="logged_admin_role" id="logged_admin_role" value="<?php echo $logged_admin_role ?>">
                                        <div class="card-body "> 
                                            <div class="row mb-4">
                                                <div class="col-md-6"><h6 class="task_title_0">Approve the Select Payments</h6></div>
                                                <div class="col-md-6"><button class="btn btn-primary btn-sm f-right" type="submit" name="approvedexpense">Approve Expense </button></div>
                                            </div>
                                            <div class="table-responsive">
                                                <?php 
                                                    include('./include/expenditure-md-cur-table.php'); 
                                                ?>
                                            </div>
                                        </div> 
                                    </form>
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
            var fieldid = $('#fieldID').val();
            var logged_role = $('#logged_admin_role').val();
            $.ajax({
                url: "./include/ajax-call.php",
                cache: false,
                type: 'POST',
                data:{fetchexpenditure:1,fieldid:fieldid,logged_role:logged_role},
                success: function(response){
                    var jsonObject = JSON.parse(response); 
                    createTable(jsonObject);
                }
            });
            function createTable(datavalue){
                var table = $('#checkboxTable').DataTable({
                    data : datavalue,
                    columns: [
                        {"data" : "empid"},        
                        {"data" : "createtime"},        
                        {"data" : "empname"},        
                        {"data" : "createby"},        
                        {"data" : "amount"},        
                        {"data" : "left"},        
                        {"data" : "file"},    
                        {"data" : "status"},    
                    ],
                    'columnDefs': [{
                        'targets': 0,
                        'searchable':false,
                        'orderable':false,
                        'className': 'dt-body-center',
                        'render': function (data, type, full, meta){
                           return '<input type="checkbox" name="expenseid[]" value="' 
                              + $('<div/>').text(data).html() + '">';
                       }
                    }],
                    'order': false,
                });
            }
            $('#table-select-all').on('click', function(){
                var rows = $('#checkboxTable').DataTable().rows({ 'search': 'applied' }).nodes();
                $('input[type="checkbox"]', rows).prop('checked', this.checked);
            });
            $('#checkboxTable tbody').on('change', 'input[type="checkbox"]', function(){
                if(!this.checked){
                    var el = $('#table-select-all').get(0);
                    if(el && el.checked && ('indeterminate' in el)){
                        el.indeterminate = true;
                    }
                }
            });
            $('#expenditure-form').on('submit', function(e){
                var form = this;
                $('#checkboxTable tbody').$('input[type="checkbox"]').each(function(){
                    if(!$.contains(document, this)){
                        if(this.checked){
                            $(form).append(
                            $('<input>').attr('type', 'hidden').attr('name', this.name).val(this.value)
                            );
                        }
                    }    
                });
            });
        });
    </script>
</body>

</html>