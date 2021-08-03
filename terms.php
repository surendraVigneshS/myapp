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
        <title>Terms & Conditions | Freeztex | Accounts</title>
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
                                    <h3> Terms & Conditions </h3>
                                </div>
                                <div class="col-6">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                                        <li class="breadcrumb-item"><?php if ($action == 'add') {
                                                                        echo 'Add Terms & Conditions';
                                                                    }
                                                                    if ($action == 'edit') {
                                                                        echo 'Edit Terms & Conditions';
                                                                    } ?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12 col-xl-7">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5><?php if ($action == 'add') {
                                                    echo 'Add Terms & Conditions';
                                                } else if ($action == 'edit') {
                                                    echo 'Edit Terms & Conditions';
                                                } ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <?php if ($action == 'add') { ?>
                                                <form action="./include/_storeroom.php" method="POST">

                                                    <div class="mb-3 row">
                                                        <div class="col-6">
                                                            <label class="col-form-label" for="name">Template Heading</label>
                                                            <input type="text" class="form-control" id="name" name="name" required>
                                                        </div> 
                                                        <div class="col-6">
                                                            <label class="col-form-label" for="status">Template status</label>
                                                            <select class="form-select digits" id="status" name="status" required>
                                                                <option value="1"> Active </option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div> 
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="col-form-label" for="content">Terms & Conditions</label>
                                                            <textarea name="content" rows="4" class="form-control" required></textarea>
                                                        </div>  
                                                    </div>
                                                    <div class="card-footer text-center mt-2">
                                                        <button class="btn btn-info" type="submit" name="addTerms">Add New Store</button>
                                                    </div>
                                                </form>
                                                <?php } else if ($action == 'edit') {
                                                $query = mysqli_query($dbconnection, "SELECT * FROM `ft_terms` WHERE `terms_id` = '$fieldid'");
                                                if (mysqli_num_rows($query) > 0) {
                                                    if ($row = mysqli_fetch_array($query)) {
                                                        $name = $row['terms_heading']; 
                                                        $content = $row['terms_remarks']; 
                                                        $status = $row['terms_status'];
                                                ?>
                                                        <form action="./include/_storeroom.php" method="POST">
                                                            <input type="hidden" name="id" id="id" value="<?php echo $fieldid; ?>">
                                                            <div class="mb-3 row">
                                                                <div class="col-6">
                                                                    <label class="col-form-label" for="name">Terms & Conditions Name</label>
                                                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                                                                </div>
                                                                <div class="col-6">
                                                                <label class=" col-form-label" for="status">Terms & Conditions status</label>

<select class="form-select digits" id="status" name="status" required>
    <option value="1" <?php if ($status == 1) {
                            echo 'selected';
                        } ?>> Active </option>
    <option value="0" <?php if ($status == 0) {
                            echo 'selected';
                        } ?>>Inactive</option>
</select>
                                                            </div>

                                                            </div>

                                                            <div class="row">
                                                        <div class="col-12">
                                                            <label class="col-form-label" for="content">Terms & Conditions</label>
                                                            <textarea name="content" rows="4" class="form-control" required><?php echo $content;  ?></textarea>
                                                        </div>  
                                                    </div>
 

                                                            <div class="card-footer text-center mt-2">
                                                                <button class="btn btn-info" type="submit" name="updateTerms" id="updateStore">Save Changes</button>
                                                            </div>
                                                        </form>
                                                    <?php }
                                                } else { ?>
                                                    <h3>Error Loading This Page</h3>
                                                <?php }
                                            } else { ?>
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
    </body>

    </html>