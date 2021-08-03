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
    <title>New Purchase - Accounts</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css"/>
</head>
<body>
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
      <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php  include('./include/topbar.php'); ?>
        <div class="page-body-wrapper">
          <?php  include('./include/left-sidebar.php'); ?>
          <div class="page-body">
            <div class="container-fluid">
              <div class="page-title">
                <div class="row">
                  <div class="col-6">
                  <h5>Raise a New Purchase Request</h5>
                  </div>
                  <div class="col-6">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                      <li class="breadcrumb-item"><a href="./purchase-list.php"><i data-feather="shopping-bag"></i></a></li>
                      <li class="breadcrumb-item">New Request</li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-xl-9">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card"> 
                                    <div class="card-body">
                                    <form action="./include/_purchaseController.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="logged_admin_id" value="<?php echo $logged_admin_id; ?>"> 
                                    <div class="card-body">
    <!-- <form action="./include/_purchaseController.php" method="POST" enctype="multipart/form-data"> -->
        <input type="hidden" name="logged_admin_id" id="logged_admin_id" value="<?php echo $logged_admin_id; ?>"> 
        <input type="hidden" name="logged_admin_role" id="logged_admin_role" value="<?php echo $logged_admin_role; ?>"> 
            <h6 class="mb-4">Project Details</h6> 
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="">PR name</label>
            <div class="col-sm-9">
            <input type="text"  class="form-control"  id="PRName" name="PRName" value="<?php echo $row['pr_name']; ?>" required readonly>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="">Project title</label>
            <div class="col-sm-9">
            <input type="text"  class="form-control"  id="projectTitle" name="projectTitle" value="<?php echo $row['project_title']; ?>" readonly>
            </div>
        </div> 

        <div class="m-b-20 m-t-20 row rows" id="rows">
            <div class="col-sm-5" id="">
                <label for="productName">Product Name</label> 
            </div>
            <div class="col-sm-5">
                <label for="">Specification / Size</label> 
            </div>
            <div class="col-sm-2">
                <label for="">Quantity</label> 
            </div>
        </div> 
                <?php
                    $capacityquery = "SELECT * FROM `purchased_products` WHERE `pr_purchase_id`='$pur_id'";
					$capacityresults = mysqli_query($dbconnection,$capacityquery);
					if(mysqli_num_rows($capacityresults) > 0){ 
					while ($capacityrows = mysqli_fetch_assoc($capacityresults)){   
				?>
            <div>
                <div class=" m-b-20 row  " >
                    <div class="col-sm-5" > 
                         <input type="text" class="form-control" name="productName[]" value="<?php echo $capacityrows['product_name']; ?>" readonly>
                    </div>
                    <div class="col-sm-5"> 
                        <input type="text" class="form-control" name="Specification[]" value="<?php echo $capacityrows['specification']; ?>" readonly> 
                    </div>
                    <div class="col-sm-2"> 
                        <input type="text" class="form-control" name="Qty[]"  value="<?php echo $capacityrows['qty']; ?>" maxlength="10" readonly >
                    </div>
                </div>
            </div> 
            <?php  }  }  ?>  
        <hr class="mt-4 mb-4">
         <h6 class="mb-4"> Supplier Details</h6>   
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="supplierName">Supplier name</label>
                <div class="col-sm-9">
                    <input  class="form-control"  id="supplierName" name="supplierName" type="text" value="<?php echo $row['supplier_name']; ?>" readonly>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="supplierEmail">Supplier email</label>
                <div class="col-sm-9">
                    <input  class="form-control"  id="supplierEmail" name="supplierEmail" type="email" value="<?php echo $row['supplier_email']; ?>" readonly>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="supplierMobile">Supplier moblie</label>
                <div class="col-sm-9">
                    <input type="text"  class="form-control"  id="supplierMobile" name="supplierMobile" value="<?php echo $row['supplier_mobile']; ?>"  onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="10" readonly>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="purchaseType">Purchase Type</label>
                <div class="col-sm-9">
                    <select class="form-select digits"  id="purchaseType" name="purchaseType" disabled>
                        <option selected disabled>Choose...</option>
                        <option value="Ordinary" <?php  if($row['purchase_type']=='Ordinary'){echo'selected';} ?> >Ordinary</option> 
                <option value="Urgent" <?php  if($row['purchase_type']=='Urgent'){echo'selected';} ?>>Urgent</option> 
                <option value="Immediate" <?php  if($row['purchase_type']=='Immediate'){echo'selected';} ?>>Immediate</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="remarks">Remarks</label>
                <div class="col-sm-9">
                    <textarea id="remarks" name="remarks"  rows="3"  class="form-control"  readonly><?php echo $row['others']; ?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" >If any PO done?</label>
                <div class="col-sm-9 mt-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="ifpodone" name="ifpodone"  disabled <?php if(!empty($row['if_po_done'])){ echo 'checked'; }  ?>  >
                        <label for="ifpodone">Yes/No</label>
                    </div>
                </div>
            </div>
         <?php if(!empty($row['if_po_done'])){ ?>
        <div  id="productimageupload" > 
                <hr class="mt-4 mb-4">
                <h6 class="pb-3 mb-3">Billing Information</h6>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="">Total amount</label>
                    <div class="col-sm-9">
                    <input  class="form-control"  id="totalAmount" name="totalAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" value="<?php echo $row['total_amount']; ?>" readonly> 
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="amountWords">Amount in words</label>
                    <div class="col-sm-9">
                        <textarea  id="amountWords" name="amountWords" rows="2"  class="form-control"  readonly><?php echo $row['amount_words']; ?></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for=""></label>
                    <div class="col-sm-4">
                        <label for="advencAmount">Advance amount</label>
                    <input  class="form-control"  type="text" id="advencAmount" name="advencAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9"  value="<?php echo $row['advance_amount']; ?>" readonly>
                    </div>
                    <div class="col-sm-4">
                        <label for="balanceAmount">Balance amount</label>
                        <input type="text"  class="form-control"  id="balanceAmount" name="balanceAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" value="<?php echo $row['balance_amount']; ?>" readonly>
                    </div>
                </div> 
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="">Bill Details</label>
                    <div class="col-sm-4"> 
                    <input  class="form-control"  type="text"  value="<?php echo $row['bill_no']; ?>" readonly>
                    </div>
                    <?php if(!empty($billfile)){?>
                    <div class="col-sm-5"> 
                    <a href="<?php echo $uploadedPO.$billfile; ?>"  target="_blank">  <button type="button" class="btn btn-info" ><i class="feather icon-eye mr-2"></i> View Uploaded Bill Copy </button> </a>
                    </div> 
                    <?php } ?>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="">PO Details</label>
                    <div class="col-sm-4"> 
                    <input  class="form-control"  type="text" id="poNO"  readonly name="poNO" value="<?php echo $row['po_no']; ?>"  readonly>
                    </div>
                    <?php if(!empty($pofile)){?>
                    <div class="col-sm-5"> 
                    <a href="<?php echo $uploadedPO.$pofile; ?>"  target="_blank">  <button type="button" class="btn btn-info" ><i class="feather icon-eye mr-2"></i> View Uploaded Bill Copy </button> </a>
                    </div> 
                    <?php } ?>
                </div> 
                <!-- <div class="card-footer text-center">
                    <button class="btn btn-success" name="addPurchase" id="approve" type="button" onclick="aprrovePurchase(<?php echo $pur_id; ?>,<?php echo $logged_admin_id; ?>,<?php echo $logged_admin_role; ?>)">Approve Request</button> 
                    <button class="btn btn-danger" name="addPurchase" id="disapprove" type="button">Disapprove Request</button> 
                </div> --> 
            </div> 
        <?php  } ?>
    <!-- </form> -->
</div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
      </div>
      <?php  include('./include/footer.php'); ?>
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
  <script src="./js/functions.js"></script>
  <script src="./js/purchase.js"></script>
  <script>
      	$("#addNewRow").click(function() {
              
				var elem = '<div class="m-b-10 m-t-10 row rows" id="">';
				elem += '<div class="col-sm-5">'; 
				elem += '<input type="text" class="form-control" name="productName[]" required>';
				elem += '</div>';
                elem += '<div class="col-sm-5">'; 
				elem += '<input type="text" class="form-control" name="Specification[]" required>';
				elem += '</div>';
                elem += '<div class="col-sm-2">'; 
				elem += '<input type="text" class="form-control" name="Qty[]" required>';
				elem += '</div>';
				elem += '</div>';
                console.log(elem);
				$("#capacity-div").append(elem);
			});

			$("#removeNewRow").click(function() {
				if ($('#capacity-div .rows').length > 1) {
					$('#capacity-div .rows').last().remove();
				} else {
					alert("You can't remove fields anymore..!");
				}
			});
  </script>
</body>
</html>