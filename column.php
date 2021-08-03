<?php 
    include('./include/dbconfig.php');
    include('./include/function.php');
    include('./include/authenticate.php'); 
    $fieldid = $action =""; 
    if(isset($_GET['action'])) { $action = $_GET['action']; }
    if(isset($_GET['fieldid'])) { $fieldid = passwordDecryption($_GET['fieldid']); }
?> 
<!DOCTYPE html>
<html lang="en">  
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <title>Column | Freeztex | Accounts</title>
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
                                <h3> Column </h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><?php if($action == 'add'){ echo 'Add Column'; }if($action == 'edit'){ echo 'Edit Column'; } ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-xl-6"> 
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php if($action == 'add'){ echo 'Add Column'; }else if($action == 'edit'){
                                                echo 'Edit Column';
                                            } ?></h5>
                                        </div>
                                        <div class="card-body"> 
                                            <?php if($action == 'add'){ ?>
                                                <form action="./include/_storeroom.php" method="POST">
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="storename">Store Name</label>
                                                    <div class="col-sm-8">
                                                    <select class="form-select select2" id="storeRoom" name="storeRoom" required>
                                                        <option value="" selected disabled>----</option>
                                                        <?php
                                                        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_store_room` ORDER BY `store_name` ASC ");
                                                        while ($rows = mysqli_fetch_assoc($query)) {
                                                        ?>
                                                            <option value="<?php echo $rows['store_id']; ?>" class="text-capitalize">
                                                                <?php echo $rows['store_name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="rackRoom">Rack Name</label>
                                                    <div class="col-sm-8">
                                                    <select class="form-select select2" id="rackRoom" name="rackRoom" required>
                                                        <option value="" selected disabled>----</option> 
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="status">Column Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="ColumnName" name="ColumnName" required> 
                                                    </div>
                                                </div>


                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="storename">Column Status</label>
                                                    <div class="col-sm-8">
                                                    <select class="form-select select2" id="status" name="status" required>
                                                        <option value="1" selected>Active</option>
                                                        <option value="0">In Active</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="card-footer text-center mt-2">
                                                    <button class="btn btn-info" type="submit" name="addColumn" >Add New Column</button>
                                                </div>
                                            </form>
                                            <?php }else if($action == 'edit'){  
                                                $query = mysqli_query($dbconnection, "SELECT * FROM `ft_column` WHERE `column_id` = '$fieldid'");
                                                if (mysqli_num_rows($query) > 0) {
                                                    if($row = mysqli_fetch_array($query)){ 
                                                        $name = $row['column_name'];
                                                        $status = $row['column_status'];     
                                            ?>
                                            <form action="./include/_storeroom.php" method="POST">
                                                <input type="hidden" name="id" id="id" value="<?php echo $fieldid; ?>"> 
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="name">Column Name</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>" required>
                                                    </div>
                                                </div>
                                                 
                                                <div class="mb-3 row">
                                                    <label class="col-sm-4 col-form-label" for="status">Column status</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-select digits" id="status" name="status" required>
                                                            <option value="1" <?php if($status == 1){ echo 'selected'; } ?>> Active </option>
                                                            <option value="0" <?php if($status == 0){ echo 'selected'; } ?>>Inactive</option> 
                                                        </select>
                                                    </div>
                                                </div> 
                                                <div class="card-footer text-center mt-2">
                                                    <button class="btn btn-info" type="submit" name="updatecolumn" id="updatecolumn">Save Changes</button>
                                                </div>
                                            </form>
                                            <?php } }else{ ?> 
                                            <h3>Error Loading sdThis Page</h3> 
                                            <?php } }else { ?>
                                            <h3>Error Loading This Page</h3>
                                            <?php } ?>
                                        </div>
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
    <script>
        $('#storeRoom').on('change', function() {
            var storeRoom = $(this).val();
            if (storeRoom) {
                $.ajax({
                    type: 'POST',
                    url: './include/ajax-call.php',
                    data: {
                        filterRacking: 1,
                        storeRoom: storeRoom
                    },
                    success: function(html) {
                        $('#rackRoom').html(html);
                    }
                });
            } else {
                $('#rackRoom').html('<option value="" selected>Select Modules first</option>');
            }
        });
    </script>
</body>

</html>