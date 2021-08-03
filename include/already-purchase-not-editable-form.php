<div class="card-body"> 
        <input type="hidden" name="logged_admin_id" id="logged_admin_id" value="<?php echo $logged_admin_id; ?>"> 
        <input type="hidden" name="logged_admin_role" id="logged_admin_role" value="<?php echo $logged_admin_role; ?>"> 
            <h6 class="mb-4">Project Details</h6> 
            
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
        while ($rowss = mysqli_fetch_assoc($query)) {
            ?>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierName">Supplier name</label>
            <div class="col-sm-9">
                <input class="form-control" id="supplierId" name="supplierId" type="hidden" value="<?php echo $rowss['cust_id']; ?>">
                <input class="form-control" id="supplierName" name="supplierName" type="text" value="<?php echo $rowss['supplier_name']; ?>" readonly>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierEmail">Supplier email</label>
            <div class="col-sm-9">
                <input class="form-control" id="supplierEmail" name="supplierEmail" type="email" readonly value="<?php echo $rowss['supplier_email']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierMobile">Supplier moblie</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="supplierMobile" name="supplierMobile" value="<?php echo $rowss['supplier_mobile']; ?>" readonly onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="10">
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
                    <input type="text" class="form-control" id="accNo" name="accNo" value="<?php echo $rowss['supplier_acc_no']; ?>"  onkeypress="return event.charCode >= 48 && event.charCode <= 57"  readonly>
                </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="ifsccode">IFSC Code </label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="ifsccode" name="ifsccode"   value="<?php echo $rowss['supplier_ifsc_code']; ?>" readonly>
            </div>
        </div>
        <?php
                            }?>
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
            <label class="col-sm-3 col-form-label" for="purchaseAgainst">Purchase Against</label>
            <div class="col-sm-9">
                <select class="form-select digits"  id="purchaseAgainst" name="purchaseAgainst" disabled>
                    <option selected disabled>Choose...</option>
                    <option value="0" <?php  if($row['already_purchased']==0){echo'selected';} ?> >Not Yet Purchased</option>
                    <option value="1" <?php  if($row['already_purchased']==1){echo'selected';} ?> >Purchased List</option>  
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="remarks">Remarks</label>
            <div class="col-sm-9">
                <textarea id="remarks" name="remarks"  rows="3" class="form-control" readonly><?php echo $row['others']; ?></textarea>
            </div>
        </div>
        
        <div  id="productimageupload" > 
                <hr class="mt-4 mb-4">
                <h6 class="pb-3 mb-3">Billing Information</h6>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="">Total amount</label>
                    <div class="col-sm-9">
                    <input class="form-control" id="totalAmount" name="totalAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" value="<?php echo $row['total_amount']; ?>" readonly> 
                    </div>
                </div> 
                <?php if(!empty($row['bill_file'])){?>
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="">Bill Details</label>
                    <div class="col-sm-4"> 
                    <input class="form-control" type="text" id="poNO"  readonly name="poNO" value="<?php echo $row['bill_no']; ?>"  readonly>
                    </div>
                    <?php if(!empty($row['bill_file'])){?>
                    <div class="col-sm-5"> 
                    <a href="<?php echo $uploadedPO.$row['bill_file']; ?>"  target="_blank">  <button type="button" class="btn btn-info" ><i class="feather icon-eye mr-2"></i> View Uploaded Bill Copy </button> </a>
                    </div> 
                    <?php } ?>
                </div>   
        <?php  } ?>  
            </div> 
</div>