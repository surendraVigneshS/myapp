<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');
$productId = "";
if (isset($_GET['fieldid'])) {
    $productId = $_GET['fieldid'];
    $productId = passwordDecryption($productId);
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
    <title>Product Details | Freeztek | Accounts</title>
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
    <link rel="stylesheet" type="text/css" href="./assets/css/view.css">
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
                                <h3> Product Details </h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="product-list.php"><i data-feather="server"></i></a></li>
                                    <li class="breadcrumb-item">Product Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $productQrPath = "./assets/qr/product/";
                        $storeqrPath = "./assets/qr/storeroom/";
                        $rackqrPath = "./assets/qr/rack/";
                        $columnqrPath = "./assets/qr/column/";
                        $productimgUrl = "./assets/images/product/";
                        $quotationPath = "./assets/quotations/";

                        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_master` LEFT JOIN `ft_store_room` ON `ft_store_room`.`store_id` =  `ft_product_master`.`location_id` WHERE `product_id` = '$productId'");
                        if (mysqli_num_rows($query) > 0) {
                            if ($row = mysqli_fetch_array($query)) {
                                $proName = $row['product_name'];
                                $proImg = $row['product_image'];
                                $proqr = $row['product_qr'];
                                $storeqr = $row['store_qr'];
                                $location_id = $row['location_id'];
                                $storename = $row['store_name'];
                                $specification = $row['product_specification'];
                                $productcode = $row['product_code'];
                                $uom = $row['product_unit'];
                                $minqty = $row['min_qty'];
                                $maxqty = $row['max_qty'];
                                $producttype = $row['product_type'];
                                $productgroup = fetchData($dbconnection, 'group_name', 'ft_item_group', 'group_id', $row['product_group']);
                                $createdby = $row['created_by'];
                                $createddate = $row['created_time'];
                                $producttype = $row['product_type'];
                                $productconsumable = $row['product_consumable'];

                                if (empty($proImg)) {
                                    $proImg = 'img-dummy.jpg';
                                } ?>
                                <div class="col-md-12">

                                    <div class="profile-header">
                                        <div class="row align-items-center">
                                            <div class="col-auto profile-image">
                                                <img class="rounded-circle" alt="User Image" src="<?php echo $productimgUrl . $proImg; ?>">
                                            </div>
                                            <div class="col ml-md-n2 profile-user-info">
                                                <h4 class="user-name mb-0"><?php echo $proName; ?></h4>
                                                <?php if (!empty($location_id)) { ?>
                                                    <div class="user-Location"><i class="fas fa-map-marker-alt"></i> <?php echo getProductLocation($dbconnection,$location_id); ?></div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-auto profile-btn">
                                                <a href="edit-product.php?platform=EDFsmTAnnc2vAUJPD7wfyVRay6FNTNMTKLp&action=edit&fieldid=<?php echo passwordEncryption($productId); ?>" class="btn btn-primary">
                                                    Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile-menu">
                                        <ul class="nav nav-pills nav-info" id="pills-infotab" role="tablist">
                                            <li class="nav-item"><a class="nav-link active" id="pills-infohome-tab" data-bs-toggle="pill" href="#pills-infohome" role="tab" aria-controls="pills-infohome" aria-selected="true">
                                                    Product Details</a></li>
                                            <li class="nav-item"><a class="nav-link" id="pills-supplier-tab" data-bs-toggle="pill" href="#pills-supplier" role="tab" aria-controls="pills-infoprofile" aria-selected="false">
                                                    Supplier List</a></li>
                                            <li class="nav-item"><a class="nav-link" id="pills-project-tab" data-bs-toggle="pill" href="#pills-project" role="tab" aria-controls="pills-infoprofile" aria-selected="false">
                                                    Project List</a></li>
                                        </ul>
                                    </div>
                                </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="tab-content" id="pills-infotabContent">
                                <div class="tab-pane fade active show" id="pills-infohome" role="tabpanel" aria-labelledby="pills-infohome-tab">
                                    <div class="card">
                                        <div class="card-header card-title d-flex justify-content-between">
                                            <h5>Product Details</h5>
                                            <a class="edit-link" href="edit-product.php?platform=EDFsmTAnnc2vAUJPD7wfyVRay6FNTNMTKLp&action=edit&fieldid=<?php echo passwordEncryption($productId); ?>" class="btn btn-primary"><i class="far fa-edit mr-1"></i>Edit</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3"> Product Name :</p>
                                                <p class="col-md-4 col-sm-3 text-black text-left"><?php echo $proName; ?></p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Specification :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $specification; ?></p>
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Item Code :</p>
                                                <p class="col-md-4 col-sm-3 text-black text-left"><?php echo $productcode; ?></p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">UOM :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $uom; ?></p>
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Max Qty :</p>
                                                <p class="col-md-4 col-sm-3 text-black text-left"><?php echo $maxqty; ?></p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Product Group :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $productgroup; ?></p>
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Min Qty :</p>
                                                <p class="col-md-4 col-sm-3 text-black text-left"><?php echo $minqty; ?></p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Product Type :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $producttype; ?></p>
                                                <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Product Consumable :</p>
                                                <p class="col-md-2 col-sm-3 text-black text-left"><?php echo $productconsumable; ?></p>
                                            </div>

                                            <div class="row">
                                                <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Product Location :</p>
                                                <?php if (!empty($location_id)) {
                                                 echo getProductLocation($dbconnection,$location_id); 
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <p>Product created by <strong><?php echo getuserName($createdby, $dbconnection); ?></strong> On <?php echo date('D,d M Y  h:i a', strtotime($createddate)); ?> </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="pills-supplier" role="tabpanel" aria-labelledby="pills-supplier-tab">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Supplier Name</th>
                                                        <th scope="col">Supplier Amount</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $slNo = 1;
                                                    $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_details` LEFT JOIN `supplier_details` ON `ft_product_details`.`supplier_id` =  `supplier_details`.`cust_id` WHERE  `ft_product_details`.`product_id` = '$productId'") or die(mysqli_error($dbconnection));
                                                    if (mysqli_num_rows($query) > 0) {
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            $quo_file = $row["quo_file"];
                                                    ?>
                                                            <tr class="text-center">
                                                                <th scope="row"><?php echo $slNo; ?></th>
                                                                <td><?php echo $row["supplier_name"] ?></td>
                                                                <td><?php echo '₹ '.IND_money_format($row["details_amount"])  ?></td>  
                                                            </tr>
                                                    <?php $slNo++;
                                                        }
                                                    }else {?>
                                                        <tr class="text-center">
                                                            <td colspan="4"><h6>No supplier present for this product</h6></td>
                                                        </tr>
                                                        <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="pills-project" role="tabpanel" aria-labelledby="pills-project-tab">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Project Name</th>
                                                        <th scope="col">Project Qty</th> 
                                                        <th scope="col">Project Incharge</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $slNo = 1;
                                                    $query = mysqli_query($dbconnection, "SELECT * FROM `ft_project_details` LEFT JOIN `ft_projects_tb` ON `ft_projects_tb`.`project_id` = `ft_project_details`.`project_id` WHERE `ft_project_details`.`project_product_id` = '$productId'") or die(mysqli_error($dbconnection)) ;
                                                    if (mysqli_num_rows($query) > 0) {
                                                        while ($row = mysqli_fetch_array($query)) { 
                                                    ?>
                                                            <tr class="text-center">
                                                                <th scope="row"><?php echo $slNo; ?></th>
                                                                <td><?php echo $row["project_title"]; ?></td>
                                                                <td><?php echo $row["project_product_qty"] ?></td>
                                                                <td><?php echo getuserName($row["added_by"],$dbconnection); ?></td> 
                                                            </tr>
                                                    <?php $slNo++;
                                                        }
                                                    }else {?>
                                                    <tr class="text-center">
                                                        <td colspan="4"><h6>No project present for this product</h6></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card"> 
                                <div class="card-body text-center">
                                    <div class="row">
                                        <div class="col">
                                            <p>Product QR</p>
                                            <img id="productQR" src="<?php echo $productQrPath . $proqr; ?>">
                                            <br>
                                            <button type="button " id="productqrprint" class="btn btn-info my-1">Print</button>
                                        </div>
                                        <?php if (!empty($location_id)) { ?>
                                            <div class="col">
                                                <p>Location QR</p>
                                                <img id="storeQR" src="<?php echo getProductLocationQR($dbconnection,$location_id)[0].getProductLocationQR($dbconnection,$location_id)[1]; ?>">
                                                <br>
                                                <button type="button" id="storeqrprint" class="btn btn-info my-1">Print</button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                            }
                        } else { ?>
                    <div class="card">
                        <div class="card-body text-center">
                            <p>You Can't Access This Page</p>
                        </div>
                    </div>
                <?php } ?>
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
    <script src="./assets/js/printThis.js"></script>
    <script src="./assets/js/config.js"></script>
    <script src="./assets/js/sidebar-menu.js"></script>
    <script src="./assets/js/script.js"></script>
    <script>
        $('#productqrprint').on("click", function() {
            $('#productQR').printThis({
                importCSS: false,
                loadCSS: false,
                header: "<h1>Product QR Code</h1>",
                base: "http://localhost/freeztek/v2/"
            });
        });

        if ($("#storeqrprint").length > 0) {
            $('#storeqrprint').on("click", function() {
                $('#storeQR').printThis({
                    importCSS: false,
                    loadCSS: false,
                    header: "<h1>Store Room QR Code</h1>",
                    base: "http://localhost/freeztek/v2/"
                });
            });
        }
    </script>
</body>

</html>