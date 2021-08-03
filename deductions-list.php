    <?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');
$action ='';
    $fieldid ='';
    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }
    if(isset($_GET['fieldname'])){
        $fieldid = $_GET['fieldname'];
        $fieldid = passwordDecryption($fieldid);
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
    <title>Deductions | Freeztek | Accounts</title>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
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
                                <h3> Deductions </h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Deductions</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-7">
                            <?php if (isset($_SESSION['deductionsSuccess'])) { ?>
                                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['deductionsSuccess']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php }
                            unset($_SESSION['deductionsSuccess']);
                            if (isset($_SESSION['deductionsError'])) { ?>
                                <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['deductionsError']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php }
                            unset($_SESSION['deductionsError']); ?>
                        </div>
                        <div class="col-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 m-b-30">
                                            <a href="./deductions-list.php?platform=<?php echo randomString(30) ?>&action=new"><button class="btn btn-primary f-right" type="button">Create New Deductions</button> </a>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="table-responsive">
                                            <table class="display payment-table" id="">
                                                <thead>
                                                    <tr>
                                                        <th>Sl.no</th>
                                                        <th>Deductions</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $selectallowance = "SELECT * FROM `ft_deductions` ORDER BY `deduction_id` DESC ";
                                                    $executeallowance = mysqli_query($dbconnection, $selectallowance);
                                                    $slno = 1;
                                                    if (mysqli_num_rows($executeallowance) > 0) {
                                                        while ($row = mysqli_fetch_array($executeallowance)) {
                                                            $deduction_id = $row['deduction_id'];
                                                            $deduction = $row['deduction'];
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $slno; ?></td>
                                                                <td><?php echo $deduction; ?></td>
                                                                <td><a onclick="addURL(this)" href="?platform=<?php echo randomString(45) ?>&action=edit&fieldname=<?php echo passwordEncryption($deduction_id) ?>" class="btn-primary btn-sm">Edit</a></td>
                                                            </tr>
                                                    <?php $slno++;
                                                        }
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
						<div class="card">
							<div class="card-body">
                                <?php if(empty($action)){ ?>
                                <p class="text-muted">Based on the user action form will be loaded</p>
                                <h6>Select anyone of the action. Either New or Edit Action</h6>
                                <?php }else if($action == 'new'){ ?>
								<div class="text-center">
									<h6 class="">Add New Deduction</h6>
								</div>
								<div class="form-body" id="addform">
                                    <form class="row g-3" method="POST" action="">
                                        <input type="hidden" name="" id="action" value="add">
                                        <input type="hidden" name="" id="id" value="0">
                                        <div class="col-12">
								    		<label for="allowancename" class="form-label">Deduction Name *</label>
                                            <input type="text" class="form-control" id="allowanceName" name="allowancename" value="">
								    	</div> 
                                        <div class="col-12">
											<div class="d-grid">
												<button type="button" class="btn btn-primary" id="add_btn"><i class="bx bx-save"></i>Save</button>
											</div>
										</div>
                                    </form>
                                </div>
                                <?php }else if($action == 'edit' && !empty($fieldid)){ ?>
                                <?php 
                                    $getallowance = mysqli_query($dbconnection,"SELECT * FROM `ft_deductions` WHERE `deduction_id` = '$fieldid'");
                                    if($rows = mysqli_fetch_array($getallowance)){
                                        $name = $rows['deduction']; 
                                    }    
                                ?>
								<div class="text-center">
									<h6 class="">Edit Deduction Details</h6>
								</div>
								<div class="form-body" id="addform">
                                    <form class="row g-3" method="POST" action="">
                                        <input type="hidden" name="" id="action" value="edit">
                                        <input type="hidden" name="" id="id" value="<?php echo $fieldid; ?>">
                                        <div class="col-12">
								    		<label for="allowancename" class="form-label">Deduction Name *</label>
                                            <input type="text" class="form-control" id="allowanceName" name="allowancename" value="<?php echo $name; ?>"  >
								    	</div> 
                                        <div class="col-12">
											<div class="d-grid">
												<button type="button" class="btn btn-primary" id="add_btn"><i class="bx bx-save"></i>Save</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script>
        function addURL(element) {
            $(element).attr('href', function() {
                return this.href;
            });
        }
        $(document).ready(function() {
            $("#add_btn").click(function() {
                var allowanceName = $("#allowanceName").val();
                var deptaction = $("#action").val();
                var allowid = $("#id").val();
                if (allowanceName) {
                    $.ajax({
                        url: "./include/ajax-call.php",
                        cache: false,
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            add_New_Deduction: 1,
                            allowanceName: allowanceName,
                            deptaction: deptaction,
                            deptid: allowid
                        },
                        beforeSend: function() {
                            $("#add_btn").html('Wait...');
                            $("#add_btn").addClass('disabled');
                        },
                        success: function(data) {  
                            if (data['statusCode'] == 200) {
                                toastr["success"](data['statusMessage']);
                                $("#add_btn").removeClass('disabled');
                                window.setTimeout(function() {
                                    location.reload()
                                }, 1000)
                            } else if (data['statusCode'] == 500) {
                                toastr["success"](data['statusMessage']);
                                $("#addform").load(location.href + " #addform");
                                $("#add_btn").removeClass('disabled');
                                setInterval('location.reload()', 1500);
                            }

                        }
                    });
                } else {
                    alert('Please Fill Required Fields');
                }
            });
        });
    </script>
</body>

</html>