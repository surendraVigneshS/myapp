<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');
$fieldid = $action = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
if (isset($_GET['fieldid'])) {
    $fieldid = passwordDecryption($_GET['fieldid']);
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
    <title>Edit Project | Freeztex | Accounts</title>
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
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/select2.css">
    <style>
        .card .card-body {
            padding: 10px 20px;
        }

        .ellipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ellipsis:hover {
            text-overflow: initial;
            overflow: visible;
            white-space: normal;
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
                                <h3> Project Master</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="./project-list.php"><i data-feather="box"></i></a></li>
                                    <li class="breadcrumb-item">Edit Project </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <form action="./include/_projectController.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="fieldid" value="<?php echo $fieldid; ?>">
                        <?php
                        $productimgUrl = "./assets/images/product/";
                        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_projects_tb` WHERE `project_id` = '$fieldid'");
                        if (mysqli_num_rows($query) > 0) {
                            if ($row = mysqli_fetch_array($query)) {
                                 
                                $name = $row["project_title"];
                                $date = date('d-M-Y', strtotime($row['project_date'])); 
                                $tardate = date('d-M-Y', strtotime($row['project_target_date'])); 
                                $incharge = $row['project_incharge']; 
                        ?>
                                <div class="row">
                                    <div class="col-sm-12 col-xl-6 col-md-6"> 
                                        <div class="card"> 
                                            <div class="card-header text-center">
                                                <h5>Edit Project</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-4">
                                                    <div class="col-6">
                                                        <label class="col-form-label" for="group">Project Start Date *</label>
                                                        <input type="text" id="datepicker1" class="form-control" name="projectDate" value="<?php echo $date; ?>" required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="col-form-label" for="group">Project Target Date *</label>
                                                        <input type="text" id="datepicker2" class="form-control" name="projecttargetDate" value="<?php echo $tardate; ?>"  >
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <label class="form-label" for="name">Project Name</label>
                                                        <input class="form-control" name="name" type="text" value="<?php echo $name; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                <div class="col-12">
                                                    <label class="form-label" for="projectIncharge">Project Incharge</label>
                                                <select class="form-select select2" id="projectIncharge" name="projectIncharge" required>
                                                        <option value="" selected  >----</option>
                                                        <?php
                                                        $query = mysqli_query($dbconnection, "SELECT * FROM `admin_login` WHERE  `emp_status`=1 ");
                                                        while ($rows = mysqli_fetch_assoc($query)) {
                                                        ?>
                                                            <option value="<?php echo $rows['emp_id']; ?>" <?php if($incharge == $rows['emp_id']){echo'selected';} ?>>
                                                                <?php echo ucfirst($rows['emp_name']); ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div> 
                                            </div>
                                                <div class="card-footer text-center ">
                                                    <button class="btn btn-info" type="submit" name="updateProject">Update Project</button>
                                                </div> 
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-sm-12 col-xl-6 col-md-6">
                                    <div class="card">
                                    <div class="card-header text-center">
                                        <h5>Edit Products in this Project</h5>
                                    </div>
                                    <div class="card-body" id="fieldDiv">
                                        <div class="row mt-4">
                                            <div class="col-md-8">
                                                <label for="user_name">Product </label>
                                                <select class="form-select select2" id="prooldId" >
                                                    <option value="" selected>----</option>
                                                    <?php
                                                    $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_master` ORDER BY `product_name` DESC ");
                                                    while ($rows = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                        <option value="<?php echo $rows['product_id']; ?>" class="text-capitalize">
                                                            <?php echo $rows['product_name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Product Qty</label>
                                                <input class="form-control" type="text" id="prooldQty" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                        </div>
                                        <div id="divrow"></div>

                                        <div class="row mt-3">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button id="addRow" type="button" class="btn btn-success mr-4">Add to the list</button> 
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                    <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col"  >Product Name</th>  
                                                        <th scope="col" width="30%">Product Qty</th>
                                                        <th scope="col"  width="30%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                <?php
                                                    $executetableQuery = mysqli_query($dbconnection, "SELECT * FROM `ft_project_details` LEFT JOIN `ft_product_master` ON  `ft_product_master`.`product_id` = `ft_project_details`.`project_product_id` WHERE `ft_project_details`.`project_id` = '$fieldid'");
                                                    while ($rowtable = mysqli_fetch_array($executetableQuery)) {
                                                        ?>
                                                         <tr class="text-center">
                                                        <td>
                                                            <input type="hidden" name="productId[]" value="<?php echo $rowtable["product_id"] ?>"> 
                                                            <p><?php echo $rowtable["product_name"] ?></p>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="productqty[]" value="<?php echo $rowtable["project_product_qty"]; ?>"> 
                                                        </td>
                                                        <td><a href="javascript:void(0);" class="remCF"><button class="btn btn-danger btn-xs" type="button" >Remove</button></a>  </td> 
                                                         </tr>
                                                    <?php
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body d-flex justify-content-around align-items-center">
                                        <a href="./product-list.php">
                                            <p class="h6"><ins>Product Master</ins></p>
                                        </a>
                                        <a href="./supplier-list.php">
                                            <p class="h6"><ins>Supplier Master</ins></p>
                                        </a>
                                    </div>
                                </div>
                                    </div>
                                </div>
                            <?php
                            }
                        } else { ?>
                            Error Loading Page
                        <?php  } ?>
                    </form>
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
    <script src="./assets/js/datepicker/datepicker.js"></script>
    <script src="./assets/js/datepicker/datepicker.en.js"></script>`
    <script src="./assets/js/select2/select2.full.min.js"></script>
    <script src="./assets/js/script.js"></script>
    <script>
        $(function() {
            $(".select2").select2();
            $("#datepicker1,#datepicker2").datepicker({
                Format: 'dd-mm-yyyy'
            });
            
            $("#addRow").click(function() {
                 
                 var proid = $('#prooldId').val();
                 var proname = $("#prooldId option:selected").text();
                 var proqty = $('#prooldQty').val();
 
                 if (proid && proqty ) {
                     var elem = '<tr class="text-center">';
                     elem += '<td> <input type="hidden" name="productId[]" value="' + proid + '"><p>' + proname + '</p> '; 
                     elem += '<td><input type="text" class="form-control" name="productqty[]" value="' + proqty + '"></td> '; 
                     elem += '<td><a href="javascript:void(0);" class="remCF"><button class="btn btn-danger btn-xs" type="button" id="removeRow"  >Remove</button></a>  </td> ';
                     elem += '</tr>'; 
                     $("#tableBody").append(elem); 
                     $("#fieldDiv").load(location.href+" #fieldDiv>*",""); 
                 } else {
                     alert('product & qty cant be empty');
                 }
             });
            
            $("#tableBody").on('click', '.remCF', function() {
                $(this).parent().parent().remove();
                getNetAmount();
            });
        });
    </script>
</body>

</html>