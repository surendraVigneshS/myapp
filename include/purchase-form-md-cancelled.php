<div class="card-body">
    <form action="./include/_purchaseController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="purchaseId" id="purchaseId" value="<?php echo $pur_id; ?>"> 
        <input type="hidden" name="logged_admin_id" id="logged_admin_id" value="<?php echo $logged_admin_id; ?>"> 
        <input type="hidden" name="logged_admin_role" id="logged_admin_role" value="<?php echo $logged_admin_role; ?>"> 
            <h6 class="mb-4">Project Details</h6> 
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="">PR name</label>
            <div class="col-sm-9">
            <input type="text" class="form-control" id="PRName" name="PRName" value="<?php echo $row['pr_name']; ?>" required readonly>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="">Organization name</label>
            <div class="col-sm-9">
            <input class="form-control" type="text" id="orgName" name="orgName" value="<?php if(is_numeric($org_name)){ echo fetchData($dbconnection,'organization_name','organization','id',$org_name); } else{echo $org_name; }   ?>" readonly required>
            </div>
        </div>
        
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="">Project title</label>
            <div class="col-sm-9">
            <input type="text" class="form-control" id="projectTitle" name="projectTitle" value="<?php echo $row['project_title']; ?>" readonly>
            </div>
        </div> 

        <div class="m-b-20 m-t-20 row rows" id="rows">
                    <div class="col-8" id="">
                        <label for="productName">Product Name</label> 
                    </div> 
                    <div class="col-4">
                        <label for="">Quantity</label> 
                    </div>
        </div> 
        
                <?php
                    $capacityquery = "SELECT * FROM `purchased_products` LEFT JOIN  `ft_product_master` ON `ft_product_master`.`product_id` = `purchased_products`.`pr_product_id` WHERE  `purchased_products`.`pr_purchase_id`='$pur_id'";
					$capacityresults = mysqli_query($dbconnection,$capacityquery);
					if(mysqli_num_rows($capacityresults) > 0){ 
					while ($capacityrows = mysqli_fetch_assoc($capacityresults)){   
				?>

               
            <div>
                <div class=" m-b-20 row  " >
                    <div class="col-sm-8" > 
                         <input type="text" class="form-control"   name="productName[]" value="<?php echo $capacityrows['product_name']; ?>" required readonly>
                    </div> 
                    <div class="col-sm-4"> 
                        <input type="text" class="form-control"   name="Qty[]"  value="<?php echo $capacityrows['pr_qty']; ?>" maxlength="10" readonly >
                    </div>
                </div>
            </div> 
            <?php  }  }  ?>  
        <hr class="mt-4 mb-4">
         <h6 class="mb-4"> Supplier Details</h6> 
         <?php
                     $query = mysqli_query($dbconnection, "SELECT * FROM `supplier_details` WHERE `cust_id`='$currentSupId' ");
        if ($rowss = mysqli_fetch_assoc($query)) {
            ?>
         <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierName">Supplier name</label>
            <div class="col-sm-9">
                <input class="form-control" id="supplierId" name="supplierId" type="hidden" value="<?php echo $rowss['cust_id']; ?>"   >
                <input class="form-control" id="supplierName" name="supplierName" type="text" value="<?php echo $rowss['supplier_name']; ?>"  readonly>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierEmail">Supplier email</label>
            <div class="col-sm-9">
                <input class="form-control" id="supplierEmail" name="supplierEmail" type="email" value="<?php echo $rowss['supplier_email']; ?>"  readonly>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierMobile">Supplier moblie</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="supplierMobile" name="supplierMobile" value="<?php echo $rowss['supplier_mobile']; ?>" readonly onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="10"  >
            </div>
        </div>

        <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="companyBranch">Beneficiary Branch</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="companyBranch" name="companyBranch" value="<?php echo $rowss['supplier_branch']; ?>" readonly>
                </div>
        </div>

        <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="accNo">Account No</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="accNo" name="accNo" value="<?php echo $rowss['supplier_acc_no']; ?>" readonly onkeypress="return event.charCode >= 48 && event.charCode <= 57"  >
                </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="ifsccode">IFSC Code </label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="ifsccode" name="ifsccode"  value="<?php echo $rowss['supplier_ifsc_code']; ?>" readonly>
            </div>
        </div>
<?php
        } ?>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="purchaseType">Purchase Type</label>
            <div class="col-sm-9">
                <select class="form-select digits"  id="purchaseType" name="purchaseType" disabled>
                        <option selected disabled>Choose...</option>
                        <option value="Normal" <?php  if($row['purchase_type']=='Normal'){echo'selected';} ?>>Normal</option>
                        <option value="Immediate" <?php  if($row['purchase_type']=='Immediate'){echo'selected';} ?>>Immediate</option> 
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="remarks">Remarks</label>
            <div class="col-sm-9">
                <textarea id="remarks" name="remarks"  rows="3" class="form-control" readonly><?php echo $row['others']; ?></textarea>
            </div>
        </div> 
    </form>
</div>