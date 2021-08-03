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
    <title>Purchase Order Details | Freeztek | Accounts</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/date-picker.css">
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
                                <h3> Purchase Orders Details </h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="po-list.php"><i data-feather="server"></i></a></li>
                                    <li class="breadcrumb-item">Purchase Orders Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <?php if (isset($_SESSION['createOrderSucc'])) { ?>
                                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                    <p class="text-white"> <?php echo $_SESSION['createOrderSucc']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php }
                            unset($_SESSION['createOrderSucc']);
                            if (isset($_SESSION['createOrderError'])) { ?>
                                <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                                    <p class="text-white"> <?php echo $_SESSION['createOrderError']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php }
                            unset($_SESSION['createOrderError']); ?>
                        </div>
                        <?php
                        $productQrPath = "./assets/qr/product/";
                        $storeqrPath = "./assets/qr/storeroom/";
                        $productimgUrl = "./assets/images/product/";
                        $quotationPath = "./assets/quotations/";
                        $pofilepath = "./assets/pdf/purchase/";

                        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_po` LEFT JOIN `supplier_details` ON `ft_po`.`po_supplier_id` =  `supplier_details`.`cust_id` LEFT JOIN `ft_po_dc` ON `ft_po_dc`.`dc_po_id` =  `ft_po`.`po_id` WHERE  `ft_po`.`po_id` = '$fieldid'");
                        if (mysqli_num_rows($query) > 0) {
                            if ($row = mysqli_fetch_array($query)) {
                                $po_code = $row['po_code'];
                                $po_type = $row['po_type'];
                                $po_file = $row['po_file'];
                                $bill_file = $row['bill_file']; 
                                $supId = $row['cust_id'];
                                $supName = $row['supplier_name'];
                                $supemail = $row['supplier_email'];
                                $supmob = $row['supplier_mobile'];
                                $supgst = $row['supplier_gst'];
                                $supadd = $row['supplier_address'];
                                $supcity = $row['supplier_city'];
                                $suppin = $row['supplier_pincode'];
                                $count = $row['po_product_count'];
                                $finalamount = $row['po_final_amount'];
                                $poDate = date('d-M-Y', strtotime($row['po_date']));
                                $poDueDate = date('d-M-Y', strtotime($row['po_due_date']));
                                $createdby = $row['po_created_by'];
                                $createddate = $row['po_created_time'];
                                $transport_mode = $row['po_transport_mode'];
                                $transport_name = $row['po_transport_name'];
                                $po_dc_entry = $row['po_dc_entry'];
                                $dc_no = $row['dc_no'];
                                $po_dc_entry = $row['po_dc_entry'];
                                $dc_created_by = $row['dc_created_by'];
                                $dc_created_time = $row['dc_created_time'];
                        ?>
                                <div class="col-md-12">
                                    <div class="profile-header">
                                        <div class="row align-items-center">
                                            <div class="col-auto profile-image">
                                                <img class="rounded-circle" alt="User Image" src="./assets/images/product/img-dummy.jpg">
                                            </div>
                                            <div class="col ml-md-n2 profile-user-info">
                                                <h4 class="user-name mb-0"><?php echo $supName; ?></h4>
                                                <!-- <div class="user-Location"><i class="fas fa-map-marker-alt"></i> Chennai</div> -->
                                            </div>
                                            <div class="col-auto profile-btn">
                                                <a href="edit-purchase-order.php?platform=<?php echo randomString(35); ?>&action=edit&fieldid=<?php echo  passwordEncryption($fieldid); ?>">
                                                    <button class="btn btn-primary"><i class="fa fa-edit"></i>
                                                        Edit
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <h4><?php echo number_format(25, 2); ?></h4> -->
                                    <div class="profile-menu">
                                        <ul class="nav nav-pills nav-info" id="pills-infotab" role="tablist">
                                            <li class="nav-item"><a class="nav-link active" id="pills-infohome-tab" data-bs-toggle="pill" href="#pills-infohome" role="tab" aria-controls="pills-infohome" aria-selected="true">
                                                    Purchase Order Details</a></li>
                                            <li class="nav-item"><a class="nav-link" id="pills-supplier-tab" data-bs-toggle="pill" href="#pills-supplier" role="tab" aria-controls="pills-supplier" aria-selected="false">
                                                    Supplier Details</a></li>
                                            <li class="nav-item"><a class="nav-link" id="pills-product-tab" data-bs-toggle="pill" href="#pills-product" role="tab" aria-controls="pills-product" aria-selected="false">
                                                    Product List</a></li>
                                                    <?php if(empty($bill_file)) {?>
                                            <li class="nav-item"><a class="nav-link" id="pills-invoice-tab" data-bs-toggle="pill" href="#pills-invoice" role="tab" aria-controls="pills-invoice" aria-selected="false">
                                            Upload Invoice</a></li>
                                            <?php } ?>
                                                    <?php if(empty($po_dc_entry)){ ?>
                                            <li class="nav-item"><a class="nav-link" id="pills-lrentry-tab" data-bs-toggle="pill" href="#pills-lrentry" role="tab" aria-controls="pills-lrentry" aria-selected="false">
                                                    Transit Entry</a></li>
                                                    <?php } else{  ?>
                                            <li class="nav-item"><a class="nav-link" id="pills-lrdetails-tab" data-bs-toggle="pill" href="#pills-lrdetails" role="tab" aria-controls="pills-lrdetails" aria-selected="false">
                                                    Transit Details</a></li>
                                            <?php } ?>
                                            <li class="nav-item"><a class="nav-link" id="pills-mail-tab" data-bs-toggle="pill" href="#pills-mail" role="tab" aria-controls="pills-mail" aria-selected="false">
                                                    Send Mail</a></li>
                                            <li class="nav-item"><a class="nav-link" id="pills-mailhistory-tab" data-bs-toggle="pill" href="#pills-mailhistory" role="tab" aria-controls="pills-mailhistory" aria-selected="false">
                                                    Mail History</a></li>
                                        </ul>
                                    </div>
                                </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="tab-content" id="pills-infotabContent">
                                <div class="tab-pane fade  active show " id="pills-infohome" role="tabpanel" aria-labelledby="pills-infohome-tab">
                                    <div class="card">
                                        <div class="card-header card-title d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5>Purchase Order </h5>
                                                <p><?php echo '₹ ' . IND_money_format($finalamount); ?> </p>
                                            </div>
                                            <a class="edit-link" href="edit-purchase-order.php?platform=<?php echo randomString(35); ?>&action=edit&fieldid=<?php echo  passwordEncryption($fieldid); ?>"><i class="far fa-edit mr-1"></i></i>Edit</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">PO No :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $po_code; ?></p>
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">PO Type :</p>
                                                <p class="col-md-4 col-sm-3 text-black text-left"><?php echo $po_type; ?></p>
                                            </div>

                                            <div class="row">
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">PO Date :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $poDate; ?></p>
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">PO Amount :</p>
                                                <p class="col-md-4 col-sm-3 text-black text-left"><?php echo '₹ ' . IND_money_format($finalamount); ?></p>
                                            </div>
                                          
                                            <div class="row">
                                            <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">PO Status :</p>
                                                <p class="col-md-9 col-sm-3 text-black text-left">
                                                <span class="badge <?php echo fetchPOStatus($dbconnection,$fieldid)[0]; ?>"><?php echo fetchPOStatus($dbconnection,$fieldid)[1]; ?></span>    
                                                 -  By <strong><?php echo fetchPOStatus($dbconnection,$fieldid)[2]; ?></strong> On <?php echo fetchPOStatus($dbconnection,$fieldid)[3]; ?>  
                                                </p>
                                            </div>

                                        </div>
                                        <div class="card-footer text-end">
                                            <p>PO created by <strong><?php echo getuserName($createdby, $dbconnection); ?></strong> On <?php echo date('D,d M Y  h:i a', strtotime($createddate)); ?> </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="pills-supplier" role="tabpanel" aria-labelledby="pills-supplier-tab">
                                    <div class="card">
                                        <div class="card-header card-title d-flex justify-content-between  align-items-center">
                                            <h5>Supplier Details</h5>
                                            <a class="edit-link" href="edit-purchase-order.php?platform=<?php echo randomString(35); ?>&action=edit&fieldid=<?php echo  passwordEncryption($fieldid); ?>"><i class="far fa-edit mr-1"></i></i>Edit</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3"> Supplier Name :</p>
                                                <p class="col-md-4 col-sm-3 text-black text-left"><?php echo $supName; ?></p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Supplier Mail:</p>
                                                <p class="col-md-4 col-sm-4 text-black text-left"><?php echo $supemail; ?></p>
                                                <p class="col-md-3 col-sm-3 text-muted text-sm-left mb-0 mb-sm-3">Supplier Phone :</p>
                                                <p class="col-md-2 col-sm-4 text-black text-left"><?php echo $supmob; ?></p>
                                            </div>
                                            <div class="row">
                                                <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Supplier Address :</p>
                                                <p class="col-md-9 col-sm-3 text-black text-left"><?php echo $supadd . ' ' . $supcity . ' ' . $suppin; ?></p>
                                            </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <p>PO created by <strong><?php echo getuserName($createdby, $dbconnection); ?></strong> On <?php echo date('D,d M Y  h:i a', strtotime($createddate)); ?> </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="pills-product" role="tabpanel" aria-labelledby="pills-product-tab">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Product Name</th>
                                                        <th scope="col">Product Qty</th>
                                                        <th scope="col">Product Rate</th>
                                                        <th scope="col">Disc %</th>
                                                        <th scope="col">Disc Rs</th>
                                                        <th scope="col">Product Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $slNo = 1;
                                                    $query = mysqli_query($dbconnection, "SELECT * FROM `ft_po_details` LEFT JOIN `ft_product_master` ON `ft_product_master`.`product_id` =  `ft_po_details`.`po_product_id` WHERE  `ft_po_details`.`po_id` = '$fieldid'");
                                                    if (mysqli_num_rows($query) > 0) {
                                                        while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                            <tr class="text-center">
                                                                <th scope="row"><?php echo $slNo; ?></th>
                                                                <td><?php echo $row["po_product_name"] ?></td>
                                                                <td><?php echo $row["po_product_qty"] ?></td>
                                                                <td><?php echo  '₹ ' . IND_money_format($row["po_product_sub_amount"]); ?></td>
                                                                <td><?php echo $row["po_product_disc_per"] ?></td>
                                                                <td><?php echo '₹ ' . IND_money_format($row["po_product_disc_amount"]); ?></td>
                                                                <td><?php echo '₹ ' . IND_money_format($row["po_product_final_amount"]); ?></td>
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
                                <?php if(empty($bill_file)) {?>
                                <div class="tab-pane fade " id="pills-invoice" role="tabpanel" aria-labelledby="pills-invoice-tab">
                                    <div class="card">
                                    <form action="./include/_poController.php" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="poid" value="<?php echo $fieldid; ?>"> 
                                            <div class="card-header">
                                                <h5>Upload Supplier Invoice</h5>
                                            </div>
                                            <div class="card-body"> 
                                                <div class=" row mb-2"> 
                                                    <div class="col-6">
                                                        <label class="col-form-label " for="bilNO">Bill No</label>
                                                        <input class="form-control" type="text" name="bilNO" id="bilNO" required> 
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="col-form-label " for="billFile">Bill File</label>
                                                        <input class="form-control" type="file" name="billFile"  accept="image/jpeg,image/jpg,image/gif,image/png,application/pdf"  required> 
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="card-footer text-center">
                                                <button type="submit" name="addSupInvoice" value="addSupInvoice" class="btn btn-info">
                                                    Upload Bill File 
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php if(empty($po_dc_entry)){ ?>
                                <div class="tab-pane fade" id="pills-lrentry" role="tabpanel" aria-labelledby="pills-lrentry-tab">
                                    <div class="card">
                                        <form action="./include/_poController.php" method="post">
                                            <input type="hidden" name="poid" value="<?php echo $fieldid; ?>">
                                            <input type="hidden" name="finalAmount" value="<?php echo $finalamount; ?>">
                                            <input type="hidden" name="supid" value="<?php echo $supId; ?>"> 
                                            <div class="card-header">
                                                <h5>Enter Transit Details</h5>
                                            </div>
                                            <div class="card-body"> 
                                                <div class=" row mb-2"> 
                                                    <div class="col-6">
                                                        <label class="col-form-label" for="dcNO">DC No</label>
                                                        <input class="form-control" type="text" name="dcNO" id="dcNO" > 
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="col-form-label" for="expectedDate">Delivery Expected Date</label>
                                                        <input class="form-control" type="text" name="expectedDate" id="datepicker1" value="<?php echo date('d-m-Y'); ?>"> 
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="card-footer text-center">
                                                <button type="submit" name="addDcEntry" value="addDcEntry" class="btn btn-info">
                                                    Create Transit 
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php } else{  ?>
                                    <div class="tab-pane fade" id="pills-lrdetails" role="tabpanel" aria-labelledby="pills-lrdetails-tab">
                                        <div class="card">
                                        <div class="card-header card-title d-flex justify-content-between  align-items-center">
                                            <h5>Transit Details</h5>
                                            <a class="edit-link" href="edit-purchase-order.php?platform=<?php echo randomString(35); ?>&action=edit&fieldid=<?php echo  passwordEncryption($fieldid); ?>"><i class="far fa-edit mr-1"></i></i>Edit</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <p class="col-md-2 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3"> DC No :</p>
                                                <p class="col-md-4 col-sm-3 text-black text-left"><?php echo $supName; ?></p>
                                                <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3"> Delivery Date :</p>
                                                <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $supName; ?></p>
                                            </div> 
                                            <div class="row">
                                                    <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Transport Mode :</p>
                                                    <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $transport_mode; ?></p>
                                                    <p class="col-md-3 col-sm-2 text-muted text-sm-left mb-0 mb-sm-3">Transport Name :</p>
                                                    <p class="col-md-3 col-sm-3 text-black text-left"><?php echo $transport_name; ?></p> 
                                                    
                                                </div>
                                        </div>
                                        <div class="card-footer text-end">
                                            <p>Tranist created by <strong><?php echo getuserName($dc_created_by, $dbconnection); ?></strong> On <?php echo date('D,d M Y  h:i a', strtotime($dc_created_time)); ?> </p>
                                        </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="tab-pane fade" id="pills-mail" role="tabpanel" aria-labelledby="pills-mail-tab">
                                    <div class="card">
                                        <form action="./include/_poController.php" method="post">
                                            <input type="hidden" name="supEmail" value="<?php echo $supemail; ?>">
                                            <input type="hidden" name="poid" value="<?php echo $fieldid; ?>">
                                            <!-- <input type="hidden" name="supEmail" value="surendraworkacc@gmail.com"> -->
                                            <div class="card-header">
                                                <h5>Send Mail to Supplier</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-4 row">
                                                    <div class="col-6">
                                                        <label class="col-form-label" for="productType">Email Subject</label>
                                                        <input type="text" name="emailSubject" id="emailSubject" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-4">
                                                    <div class="col-12">
                                                        <label class="col-form-label" for="productType">Email Body</label>
                                                        <textarea name="emailBody" rows="2" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="mb-4 row">
                                                    <div class="col-6">
                                                        <label for="user_name">CC Mail Id</label>
                                                        <input type="email" name="mailccId[]" class="form-control">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="user_name">CC Mail Sender Name</label>
                                                        <input type="text" name="mailccName[]" class="form-control">
                                                    </div>
                                                </div>
                                                <div id="divmailrow"></div>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <button id="addRow" type="button" class="btn btn-success ">Add</button>
                                                        <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-center">
                                                <button type="submit" name="sendMailPO" value="sendMailPO" class="btn btn-info">
                                                    Send Mail
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-mailhistory" role="tabpanel" aria-labelledby="pills-mailhistory-tab">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Mail Subject</th>
                                                        <th scope="col">Mail Body</th>
                                                        <th scope="col">Mail Sent By</th>
                                                        <th scope="col">Mail Sent Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $slNo = 1;
                                                    $query = mysqli_query($dbconnection, "SELECT * FROM `ft_po_mail`  WHERE  `po_id` = '$fieldid'");
                                                    if (mysqli_num_rows($query) > 0) {
                                                        while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                            <tr class="text-center">
                                                                <th scope="row"><?php echo $slNo; ?></th>
                                                                <td><?php echo $row["mail_subject"] ?></td>
                                                                <td><?php echo $row["mail_body"] ?></td>
                                                                <td><?php echo getuserName($row["mail_sent_by"], $dbconnection);  ?></td>
                                                                <td><?php echo date('d-M-Y h:i a', strtotime($row["mail_sent_time"])); ?></td>
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
                        <?php if (!empty($po_file)) { ?>
                            <div class="col-4">
                                <div class="card text-center">
                                    <div class="card-header ">
                                        <h5>PO File</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <a href="<?php echo $pofilepath . $po_file; ?>" target="_blank"> <button type="button" class="btn btn-info"><i class="fas fa-eye mr-2"></i> View </button> </a>
                                                <a href="<?php echo $pofilepath . $po_file; ?>" target="_blank" download=""> <button type="button" class="btn btn-xs btn-success" style="font-size:14px;padding:5px 10px"><i class="fas fa-download"></i> Download</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!empty($bill_file)) { ?> 
                                    <div class="card text-center">
                                    <div class="card-header ">
                                        <h5>Bill File</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <a href="<?php echo $pofilepath . $bill_file; ?>" target="_blank"> <button type="button" class="btn btn-info"><i class="fas fa-eye mr-2"></i> View </button> </a>
                                                <a href="<?php echo $pofilepath . $bill_file; ?>" target="_blank" download=""> <button type="button" class="btn btn-xs btn-success" style="font-size:14px;padding:5px 10px"><i class="fas fa-download"></i> Download</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php  }?>
                            </div>
                    <?php } ?>
                        <?php 
                            } } else { ?>
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
    <script src="./assets/js/datepicker/datepicker.js"></script>
    <script src="./assets/js/datepicker/datepicker.en.js"></script>
    <script src="./assets/js/script.js"></script>
    <script>
        $(function() {

            $("#datepicker1").datepicker({
                Format: 'dd-mm-yyyy'
            });

            $("#addRow").click(function() {

                var elem = '<div class="row my-3">';
                elem += '<div class="col-6">';
                elem += '<input type="email" name="mailccId[]"  class="form-control"  >';
                elem += '</div>';
                elem += '<div class="col-6 ">';
                elem += '<input type="text" name="mailccName[]" class="form-control"  >';
                elem += '</div>';
                elem += '</div>';

                $("#divmailrow").append(elem);
            });

            $("#removeRow").click(function() {
                if ($('#divmailrow div.row').length >= 1) {
                    $('#divmailrow div.row').last().remove();
                } else {
                    alert("You can't remove Rows anymore..!");
                }
            });

        });
    </script>
</body>

</html>