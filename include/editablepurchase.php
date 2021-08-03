<div class="card-body">
    <form action="./include/_purchaseController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="purchaseId" id="purchaseId" value="<?php echo $pur_id; ?>"> 
        <input type="hidden" name="logged_admin_id" id="logged_admin_id" value="<?php echo $logged_admin_id; ?>"> 
        <input type="hidden" name="logged_admin_role" id="logged_admin_role" value="<?php echo $logged_admin_role; ?>"> 
            <h6 class="mb-4">Project Details</h6> 
        
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="">Project title</label>
            <div class="col-sm-9">
            <input type="text" class="form-control" id="projectTitle" name="projectTitle" value="<?php echo $row['project_title']; ?>"  >
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
                <div class="row" >
                    <div class="col-sm-5" > 
                         <input type="hidden" class="form-control"   name="oldproductName[]" value="<?php echo $capacityrows['product_name']; ?>" required  >
                    </div>
                    <div class="col-sm-5"> 
                        <input type="hidden" class="form-control"   name="oldSpecification[]" value="<?php echo $capacityrows['specification']; ?>"  > 
                    </div>
                    <div class="col-sm-2"> 
                        <input type="hidden" class="form-control"   name="oldQty[]"  value="<?php echo $capacityrows['qty']; ?>" maxlength="10"   >
                    </div>
                </div>
            </div> 
            <?php  }  ?>  
            <div id="capacity-div2"></div>
            <div class="row m-b-30 m-t-30   "> 
                <div class="col-md-12"> 
                    <button id="addNewCap2" class="  btn btn-success" type="button">Add Product</button>  
                    <button id="addNewRemove2" class="  btn btn-danger" type="button">Remove Product</button>  
                </div> 
            </div>  
            <?php } ?>
        <hr class="mt-4 mb-4">
         <h6 class="mb-4"> Supplier Details</h6> 
         
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierName">Supplier name</label>
            <div class="col-sm-9">
                <input class="form-control" id="supplierName" name="supplierName" type="text" value="<?php echo $row['supplier_name']; ?>"  >
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierEmail">Supplier email</label>
            <div class="col-sm-9">
                <input class="form-control" id="supplierEmail" name="supplierEmail" type="email" value="<?php echo $row['supplier_email']; ?>"  >
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierMobile">Supplier moblie</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="supplierMobile" name="supplierMobile" value="<?php echo $row['supplier_mobile']; ?>"  onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="10"  >
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="purchaseType">Purchase Type</label>
            <div class="col-sm-9">
                <select class="form-select digits"  id="purchaseType" name="purchaseType"   >
                    <option selected disabled>Choose...</option>
                    <option value="Ordinary" <?php  if($row['purchase_type']=='Normal'){echo'selected';} ?> >Normal</option>  
                    <option value="Immediate" <?php  if($row['purchase_type']=='Immediate'){echo'selected';} ?>>Immediate</option>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="purchaseAgainst">Purchsase Against</label>
            <input type="hidden" value="<?php echo $row['already_purchased']; ?>" name="purchaseAgainst">
            <div class="col-sm-9">
                <select class="form-select digits"  id="purchaseAgainst" name="purchaseAgaisnst" disabled>
                    <option selected>Choose...</option>
                    <option value="0" <?php  if($row['already_purchased']==0){echo'selected';} ?> >Not Yet Purchased</option>
                    <option value="1" <?php  if($row['already_purchased']==1){echo'selected';} ?> >Purchased List</option>  
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="remarks">Remarks</label>
            <div class="col-sm-9">
                <textarea id="remarks" name="remarks"  rows="3" class="form-control"  ><?php echo $row['others']; ?></textarea>
            </div>
        </div> 
        
        <div class="text-center">
            <button class="btn btn-primary" name="editPurchase" id="editPurchase" type="submit">Update Changes</button> 
        </div>
    </form>
</div>