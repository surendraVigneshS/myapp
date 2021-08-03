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
         
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierName">Supplier name</label>
            <div class="col-sm-9">
                <input class="form-control" id="supplierName" name="supplierName" type="text" value="<?php echo $row['supplier_name']; ?>" readonly>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierEmail">Supplier email</label>
            <div class="col-sm-9">
                <input class="form-control" id="supplierEmail" name="supplierEmail" type="email" value="<?php echo $row['supplier_email']; ?>" readonly>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierMobile">Supplier moblie</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="supplierMobile" name="supplierMobile" value="<?php echo $row['supplier_mobile']; ?>"  onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="10" readonly>
            </div>
        </div>
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
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" >If any PO done?</label>
            <div class="col-sm-9 mt-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="ifpodone" name="ifpodone" value="1"  />
                    <label for="ifpodone">Yes/No</label>
                </div>
            </div>
        </div> 
        <div  id="productimageupload"  style="display: none;"> 
                <hr class="mt-4 mb-4">
                <h6 class="pb-3 mb-3">Billing Information</h6>
               
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="">Total amount</label>
                        <div class="col-sm-9">
                        <input class="form-control" id="totalAmount" name="totalAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9"  > 
                        </div>
                    </div>
                
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="amountWords">Amount in words</label>
                        <div class="col-sm-9">
                            <textarea  id="amountWords" name="amountWords" rows="2" class="form-control" ></textarea>
                        </div>
                    </div>
                
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for=""></label>
                        <div class="col-sm-4">
                            <label for="advencAmount">Advance amount</label>
                        <input class="form-control" type="text" id="advencAmount" name="advencAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9"  >
                        </div>
                        <div class="col-sm-4">
                            <label for="balanceAmount">Balance amount</label>
                            <input type="text" class="form-control" id="balanceAmount" name="balanceAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" >
                        </div>
                    </div> 
                   
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="poNO">PO no</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="poNO" name="poNO" >
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">PO copy</label>
                        <div class="col-sm-9">
                        <input class="form-control" type="file" id="pofile"  name="pofile" accept="image/x-png, image/jpeg, image/jpg , application/pdf" >  
                        </div>
                    </div>
                    
                    

                    <div class="card-footer text-center">
                        <button class="btn btn-success" name="addPurchasePO" id="addPurchasePO" type="submit">Update & Rsaise Request</button>  
                    </div>  

                </div>  
    </form>
</div>