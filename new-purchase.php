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
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/date-picker.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css"> 
    <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/select2.css">
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
                    <div class="col-sm-12 col-xl-7 col-md-7 col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card"> 
                                    <div class="card-body">
                                    <form action="./include/_purchaseController.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="logged_admin_id" value="<?php echo $logged_admin_id; ?>"> 
                                    <input type="hidden" id="PRName" name="PRName" value="<?php  echo $logged_admin_name; ?>"> 
                                        <h6 class="mb-4">Project Details</h6>  

                                        <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="purchaseAgainst">Purchase Against</label>
                                                <div class="col-sm-9">
                                                    <select class="form-select digits"  id="purchaseAgainst" name="purchaseAgainst" required>
                                                        <option selected disabled>Choose...</option>
                                                        <option value="0">New Purchase</option>
                                                        <option value="1">Purchase With Bill</option>  
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label" for="orgName">Organization</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select digits" id="orgName" name="orgName" required>
                                                        <?php 
                                                                $selectOrganization = "SELECT * FROM `organization` WHERE `id` <> 3 ";
                                                                $executeOrganization = mysqli_query($dbconnection,$selectOrganization); 
                                                                while($Organization = mysqli_fetch_array($executeOrganization)){
                                                            ?> 
                                                            <option value="<?php echo  $Organization['id']; ?>" <?php if($Organization['id']  == 5){echo 'selected';} ?> ><?php echo $Organization['organization_name']; ?></option> 
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <div id="othername"></div>
                                                    </div>
                                                </div>
                                            
                                            
                                             <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="purchaseType">Purchase Type</label>
                                                <div class="col-sm-9">
                                                    <select class="form-select "  id="purchaseType" name="purchaseType"  required>
                                                        <option selected disabled>Choose...</option>
                                                        <option value="Normal">Normal</option>  
                                                        <option value="Immediate">Immediate</option>
                                                        <option value="One Day Purchase">One Day Purchase</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="minMaxExample">Expected Date</label>
                                                <div class="col-sm-9">
                                                <input class="datepicker-here form-control"  type="text" name="expectedDate" autocomplete="off" >
                                                </div>
                                            </div> 
                                            
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="">Project title</label>
                                                <div class="col-sm-9">
                                                <select class="form-select  select2" id="projectTitle" name="projectTitle" required>
                                                    <option value="" selected disabled>----</option>
                                                    <option value="$">New Project</option>
                                                    <?php
                                                    $query = mysqli_query($dbconnection, "SELECT * FROM `ft_projects_tb` ORDER BY `project_title` ASC ");
                                                    while ($rows = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                        <option value="<?php echo $rows['project_id']; ?>" class="text-capitalize">
                                                            <?php echo $rows['project_title']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                                </div>
                                            </div> 
                                            <div class="mb-3 row" style="display: none;" id="projectDiv">
                                                <label class="col-sm-3 col-form-label" for="">New Project title</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" id="newproject"  type="text" name="newproject" required>
                                                </div>
                                            </div>   
                                            
                                        <div id="capacity-div">
                                            <div class="m-b-10 m-t-10 row rows" id="rows">
                                                <div class="col-sm-8 col-md-9">
                                                    <label for="productName">Product Name</label> 
                                                      <select class="form-select  select2" id="projectTitle" name="productID[]" required>
                                                    <option value="" selected disabled>----</option>
                                                    <?php
                                                    $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_master` ORDER BY `product_name` ASC ");
                                                    while ($rows = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                        <option value="<?php echo $rows['product_id']; ?>" class="text-capitalize">
                                                            <?php echo  ucfirst($rows['product_name']); ?>
                                                        </option>
                                                    <?php } ?> 
                                                </select>
                                                </div> 
                                                <div class="col-sm-2 col-md-3">
                                                    <label for="">Quantity</label>
                                                    <input type="text" class="form-control" id="Qty" name="productQTY[]" >
                                                </div>
                                            </div>
                                        </div>

                                            

                                            <div class="m-b-30 m-t-30 row"> 
                                                <div class="col-md-12 text-end"> 
                                                  <button id="addNewRow" class="  btn btn-success" type="button">Add Product</button>  
                                                  <button id="removeNewRow" class="  btn btn-danger" type="button">Remove Product</button>  
                                                </div> 
                                            </div>  
                                            
                                            <hr class="mt-4 mb-4">
                                            <h6 class="mb-4">Supplier Details</h6> 
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="supplierName">Select Supplier</label>
                                                <div class="col-sm-9"> 
                                                    <select class="form-select  select2" id="supplierID" name="supplierID" required>
                                                    <option value="" selected disabled>----</option>
                                                    <option value="$">New Supplier</option>
                                                    <?php
                                                    $query = mysqli_query($dbconnection, "SELECT * FROM `supplier_details` WHERE `supplier_name`<>'' ORDER BY `supplier_name` ASC ");
                                                    while ($rows = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                        <option value="<?php echo $rows['cust_id']; ?>">
                                                            <?php echo  ucfirst($rows['supplier_name']); ?>
                                                        </option>
                                                        <?php } ?> 
                                                    </select>
                                                </div>
                                            </div>
                                            <hr class="my-4">
                                            <div id="supplierDiv" style="display: none;"> 
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="supplierName">Supplier Name</label>
                                                <div class="col-sm-9">
                                                  <input class="form-control" id="supplierName" name="supplierName" type="text" >
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="supplierEmail">Supplier Email</label>
                                                <div class="col-sm-9">
                                                  <input class="form-control" id="supplierEmail" name="supplierEmail" type="email" >
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="supplierMobile">Supplier Moblie</label>
                                                <div class="col-sm-9">
                                                  <input type="text" class="form-control" id="supplierMobile" name="supplierMobile" onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="10" >
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label" for="companyBranch">Beneficiary Branch</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="companyBranch" name="companyBranch">
                                                    </div>
                                            </div>
                                            <div class="mb-3 row">
                                                    <label class="col-sm-3 col-form-label" for="accNo">Account No</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="accNo" name="accNo" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  >
                                                    </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="ifsccode">IFSC Code </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="ifsccode" name="ifsccode"  >
                                                </div>
                                            </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="remarks">Remarks</label>
                                                <div class="col-sm-9">
                                                    <textarea id="remarks" name="remarks"  rows="3" class="form-control"></textarea>
                                                </div>
                                            </div> 
                                            <div id="alreadypurchased" style="display: none;">
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="">Total amount</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" id="totalAmount" name="totalAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9"  >
                                                    <div class="invalid-feedback">Total Amount should be less than  Advance Amount</div>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="amountWords">Amount in words</label>
                                                <div class="col-sm-9">
                                                    <textarea id="amountWords" name="amountWords" rows="2" class="form-control"></textarea>
                                                </div>
                                            </div> 
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label" for="billNO">Bill no</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="billNO" name="billNO" >
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label class="col-sm-3 col-form-label">Bill copy</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" id="billfile" type="file" name="billfile" accept="image/x-png, image/jpeg, image/jpg , application/pdf">
                                                </div>
                                            </div> 
                                            </div> 
                                            <div class="card-footer text-center">
                                              <button class="btn btn-primary" name="addPurchase" id="addPurchase" type="submit">Raise Purchase Request</button> 
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!-- <div class="col-lg-4 col-xl-5 col-md-5 col-sm-12" id="status-card">
                        <div class="card m-b-30"> 
                            <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-12">
                                <h5 class="card-title mb-0 text-center">Upload Product List</h5>
                                </div> 
                            </div>
                            </div>
                            <div class="card-body text-right"> 
                            <div class="mb-3 row"> 
                                <div class="col-sm-12 text-center">
                                accept=".csv" 
                                    <input class="form-control" type="file" name="excelFile" id="excelFile"   onchange="fileValidation()" >
                                    <small class="form-text text-primary text-center">(Only CSV File Allowed)</small>                                
                                </div>
                            </div> 
                            </div>
                            <div class="card-footer text-right"> 
                            <div class="row"> 
                                <div class="col-sm-12 text-center">
                            <a href="./assets/excel/Vencar_Accounts_Purchase_Product.csv" download> <button class="btn btn-success" type="button">Allowed File Type</button> </a>
                                </div>
                            </div> 
                            </div>
                        
                        </div>
                       </div>
                     --> 
                </form>
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
  <script src="./assets/js/select2/select2.full.min.js"></script>
  <script src="./assets/js/script.js"></script>
  <script src="./assets/js/datepicker/datepicker.js"></script>
  <script src="./assets/js/datepicker/datepicker.en.js"></script> 
  <script src="./js/functions.js"></script>
  <script src="./js/purchase.js"></script> 
  <script>
    $('#purchaseAgainst').on('change',function(){
        var selection = $(this).val();
        switch(selection){
        case "1":
            $("#alreadypurchased").show(500);
            $('#poFile').attr("required","true"); 
            $('#totalAmount').attr("required","true"); 
            $('#poNO').attr("required","true"); 
        break;
        default:
            $("#alreadypurchased").hide(500);
            $('#poFile').removeAttr("required"); 
            $('#totalAmount').removeAttr("required"); 
            $('#poNO').removeAttr("required"); 
        }
    });
    $('#projectTitle').on('change',function(){
        var selection = $(this).val(); 
        if(selection == "$"){ 
                $("#projectDiv").show(200);
                $('#newproject').attr("required","true"); 
        }else{
            $("#projectDiv").hide(200);
            $('#newproject').removeAttr("required")
        }
    });
    $('#supplierID').on('change',function(){
        var selection = $(this).val(); 
        if(selection == "$"){ 
                $("#supplierDiv").show(200);
                // $('#supplierName').attr("required","true");  
        }else{
            $("#supplierDiv").hide(200);
            $('#newproject').removeAttr("required")
        }
    });
    
    $( function(){
        $("#addNewRow").click(function() {
            
              var elem = '<div class="m-b-10 m-t-10 row rows" id="">';
              elem += '<div class="col-sm-8 col-md-9">'; 
              elem += '<select class="form-select  select2 lastclass" id="projectTitle" name="productID[]" required>';
              elem += '<option value="" selected disabled>----</option>';
              <?php
                $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_master`  ORDER BY `product_name` ASC ");
                while ($rows = mysqli_fetch_assoc($query)) {
                    ?>
                    elem += '<option value="<?php echo $rows['product_id']; ?>">';
                    elem += '<?php echo  ucfirst($rows['product_name']); ?>';
                    elem += '</option>'; 
                <?php } ?> 
              elem += '</select>'; 
              elem += '</div>'; 
              elem += '<div class="col-sm-2 col-md-3">'; 
              elem += '<input type="text" class="form-control" name="productQTY[]"  required>';
              elem += '</div>';
              elem += '</div>'; 
              $("#capacity-div").append(elem);
              $('.lastclass:last').select2();
          });

          $("#removeNewRow").click(function() {
              if ($('#capacity-div .rows').length > 1) {
                  $('#capacity-div .rows').last().remove();
              } else {
                  alert("You can't remove fields anymore..!");
              }
          });
         
          function fileValidation() {   
          var fileInput = document.getElementById('excelFile');
          
          var filePath = fileInput.value;
      
          // Allowing file type
          var allowedExtensions = /(\.csv)$/i;
          
          if (!allowedExtensions.exec(filePath)) {
              alert('File Type Not Allowed');
              fileInput.value = '';
              return false;
          }
           
      }   
    });
        
  </script>
</body>
</html>