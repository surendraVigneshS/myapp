<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');
$fieldid = "";
if (isset($_GET['fieldid'])) {
    $fieldid = $_GET['fieldid'];
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
    <title>Dc Details | Freeztek | Accounts</title>
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
                                <h3> Dc Details </h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="dc-list.php"><i data-feather="arrow-left-circle"></i></a></li>
                                    <li class="breadcrumb-item">Dc Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <?php 
                        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_dc`  WHERE  `dc_id` = '$fieldid'");
                        if (mysqli_num_rows($query) > 0) {
                            if ($row = mysqli_fetch_array($query)) {                                  
                                $dcCode = $row['dc_code'];
                                $dcDate = date('d-M-Y', strtotime($row['dc_date']));
                                $dcType = $row['dc_type'];
                                $issued_to =  $row['dc_issued_to'];
                                $issued_by =  $row['dc_issued_by'];
                                $issuedTime = date('D,d M Y  h:i a', strtotime($row['dc_issued_time']));
                                $productCount = $row['dc_product_count']; 
                                $dc_remarks = $row['dc_remarks']; 
                        ?>
                                <div class="col-md-12"> 
                                    <div class="profile-menu">
                                        <ul class="nav nav-pills nav-info" id="pills-infotab" role="tablist">
                                            <li class="nav-item"><a class="nav-link active" id="pills-infohome-tab" data-bs-toggle="pill" href="#pills-infohome" role="tab" aria-controls="pills-infohome" aria-selected="true">
                                            Dc Details</a></li> 
                                            <li class="nav-item"><a class="nav-link" id="pills-product-tab" data-bs-toggle="pill" href="#pills-product" role="tab" aria-controls="pills-product" aria-selected="false">
                                            Product List</a></li>
                                        </ul>
                                    </div>
                                </div>
                    </div>
                    <div class="row">
                        <div class="col-9">
                            <div class="tab-content" id="pills-infotabContent">
                                <div class="tab-pane fade  active show" id="pills-infohome" role="tabpanel" aria-labelledby="pills-infohome-tab">
                                    <div class="card">
                                        <div class="card-header card-title d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5>Dc Details </h5> 
                                            </div>
                                            <a class="edit-link" href="edit-project.php?platform=<?php echo randomString(35); ?>&action=edit&fieldid=<?php echo  passwordEncryption($fieldid); ?>"><i class="far fa-edit mr-1"></i></i>Edit</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <p class="col-md-2 col-sm-2 text-muted text-left mb-0 mb-sm-3">DC Code :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $dcCode; ?></p>
                                                <p class="col-md-2 col-sm-2 text-muted text-left mb-0 mb-sm-3">DC Date :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $dcDate; ?></p>
                                            </div>  
                                            <div class="row">
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Issued To :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo fetchData($dbconnection, 'supplier_name', 'supplier_details', 'cust_id', $issued_to);; ?></p>
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Product Count :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $productCount; ?></p>
                                            </div>  
                                            <div class="row">
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Issued By :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo getuserName($issued_by,$dbconnection) ; ?></p>
                                            </div>   
                                            <div class="row">
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Remarks :</p>
                                                <p class="col-md-10 col-sm-3 text-black text-left"><?php echo $dc_remarks; ?></p>
                                            </div>   
                                        </div>
                                        <div class="card-footer text-end">
                                            <p>DC created by <strong><?php echo getuserName($issued_by, $dbconnection); ?></strong> On <?php echo $issuedTime; ?> </p>
                                        </div>
                                    </div>
                                </div> 
                                <div class="tab-pane fade " id="pills-product" role="tabpanel" aria-labelledby="pills-product-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="display payment-table">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th scope="col">Sl No</th>
                                                            <th scope="col">Product Name</th>
                                                            <th scope="col">Product Issued Qty</th> 
                                                            <th scope="col">Product Available Qty</th>  
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $slNo = 1;
                                                        $executetableQuery = mysqli_query($dbconnection, "SELECT * FROM `ft_dc_details` LEFT JOIN `ft_product_master` ON  `ft_product_master`.`product_id` = `ft_dc_details`.`dc_product_id` WHERE `ft_dc_details`.`dc_id` = '$fieldid'");
                                                        if (mysqli_num_rows($executetableQuery) > 0) { 
                                                            while ($rowtable = mysqli_fetch_array($executetableQuery)) {
                                                        ?>
                                                                <tr class="text-center">
                                                                    <td scope="row"><?php echo $slNo; ?></td>
                                                                    <td><?php echo $rowtable["product_name"] ?></td>
                                                                    <td><?php echo $rowtable["dc_issued_qty"] ?></td>
                                                                    <td><?php echo fetchData($dbconnection,'product_current_qty','ft_stock_master','product_id',$rowtable["product_id"]); ?></td> 
                                                                </tr>
                                                            <?php $slNo++;
                                                            }
                                                        } else {  ?>
                                                            <tr class="text-center">
                                                                <th colspan="7">No Products Found</th>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-4">
                            <div class="card">
                                <div class="card-header text-center">
                                    <h5>PO File</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php if (!empty($po_file)) { ?>
                                            <div class="col">
                                                <a href="<?php echo $pofilepath . $po_file; ?>" target="_blank"> <button type="button" class="btn btn-info"><i class="fas fa-eye mr-2"></i> View </button> </a>
                                                <a href="<?php echo $pofilepath . $po_file; ?>" target="_blank" download=""> <button type="button" class="btn btn-xs btn-success" style="font-size:14px;padding:5px 10px"><i class="fas fa-download"></i> Download</button></a>
                                            </div>
                                        <?php } else { ?>
                                            <form action="./include/_poController.php" method="POST">
                                                <input type="hidden" name="poid" value="<?php echo $fieldid; ?>">
                                                <div class="row mb-2">
                                                    <div class="col-12">
                                                        <div class="form-check form-check-inline  radio radio-primary">
                                                            <input class="form-check-input" id="radio11" type="radio" name="mailOption" value="1" required>
                                                            <label class="form-check-label" for="radio11">Terms Template</label>
                                                        </div>
                                                        <div class="form-check form-check-inline  radio radio-primary">
                                                            <input class="form-check-input" id="radio22" type="radio" name="mailOption" value="2" required>
                                                            <label class="form-check-label" for="radio22">Custom Terms</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="mailTemplateDiv2" style="display:none;">
                                                    <div class="col-12 mb-3">
                                                        <label class="col-form-label" for="selecttermsConditions">Choose Template</label>
                                                        <select class="form-select" id="selectTerms" name="selecttermsConditions" required>
                                                            <option value="" selected disabled>----</option>
                                                            <?php
                                                            $query = mysqli_query($dbconnection, "SELECT * FROM `ft_terms` WHERE `terms_status` = 1");
                                                            while ($rows = mysqli_fetch_assoc($query)) {
                                                            ?>
                                                                <option value="<?php echo $rows['terms_remarks']; ?>">
                                                                    <?php echo $rows['terms_heading']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="customMailDiv" style="display:none;">
                                                    <div class="col-12 mb-3">
                                                        <textarea rows="3" id="textterms" placeholder="Terms & Conditions" class="form-control" name="termsConditions" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center mt-4">
                                                    <button type="submit" name="createPOFile" value="createPOFile" class="btn btn-primary">
                                                        Create PO File
                                                    </button>
                                                </div>
                                            </form>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div> -->
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
    <script src="./assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="./assets/js/datatable/datatables/datatable.custom.js"></script> 
</body>

</html>