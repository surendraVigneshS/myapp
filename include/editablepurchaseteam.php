<div class="card-body">
    
        <h6 class="mb-4">Project Details</h6>
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
            <!-- <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="">PR name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="PRName" name="PRName" value="<?php echo $row['pr_name']; ?>" required readonly>
                </div>
            </div> -->

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
 <form action="./include/_purchaseController.php" method="POST">
 <?php
                     $query = mysqli_query($dbconnection, "SELECT * FROM `supplier_details` WHERE `cust_id`='$currentSupId' ");
        if ($rowss = mysqli_fetch_assoc($query)) {
                        ?>
 <input type="hidden" name="purchaseId"   value="<?php echo $pur_id; ?>">
                <input type="hidden" name="logged_admin_id"   value="<?php echo $logged_admin_id; ?>">
                <input type="hidden" name="logged_admin_role"   value="<?php echo $logged_admin_role; ?>">
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierName">Supplier name</label>
            <div class="col-sm-9">
                <input class="form-control" id="supplierId" name="supplierId" type="hidden" value="<?php echo $rowss['cust_id']; ?>"   >
                <input class="form-control" id="supplierName" name="supplierName" type="text" value="<?php echo $rowss['supplier_name']; ?>"  required>
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierEmail">Supplier email</label>
            <div class="col-sm-9">
                <input class="form-control" id="supplierEmail" name="supplierEmail" type="email" value="<?php echo $rowss['supplier_email']; ?>"  >
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierMobile">Supplier moblie</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="supplierMobile" name="supplierMobile" value="<?php echo $rowss['supplier_mobile']; ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="10"  >
            </div>
        </div>

        <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="companyBranch">Beneficiary Branch</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="companyBranch" name="companyBranch" value="<?php echo $rowss['supplier_branch']; ?>" >
                </div>
        </div>

        <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="accNo">Account No</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="accNo" name="accNo" value="<?php echo $rowss['supplier_acc_no']; ?>"onkeypress="return event.charCode >= 48 && event.charCode <= 57"  >
                </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="ifsccode">IFSC Code </label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="ifsccode" name="ifsccode"  value="<?php echo $rowss['supplier_ifsc_code']; ?>">
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="purchaseType">Purchase Type</label>
            <div class="col-sm-9">
                <select class="form-select digits" id="purchaseType" name="purchaseType">
                    <option selected disabled>Choose...</option> 
                    <option value="Normal" <?php if ($row['purchase_type'] == 'Normal') {
                            echo 'selected';
                        } ?>>Normal</option>
                    <option value="Immediate" <?php if ($row['purchase_type'] == 'Immediate') {
                            echo 'selected';
                        } ?>>Immediate</option>
                </select>
            </div>
        </div>

   

        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="remarks">Remarks</label>
            <div class="col-sm-9">
                <textarea id="remarks" name="remarks" rows="2" class="form-control"  ><?php echo $row['others']; ?></textarea>
            </div>
        </div>

        <div class="m-b-20 m-t-2 row"> 
            <div class="col-md-12 ">
                <button class="btn btn-info f-right"  type="submit" name="saveSupplierDetails">Save Supplier Details</button>
            </div>
        </div> 
        <?php
                    } ?>
        </form>
        <!-- <div class="mb-3 row">
            <label class="col-sm-3 col-form-label">If any PO done?</label>
            <div class="col-sm-9 mt-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="ifpodone" name="ifpodone" value="1" />
                    <label for="ifpodone">Yes/No</label>
                </div>
            </div>
        </div> -->
        <!-- <div id="productimageupload" style="display: none;"> -->
        <div> 
            <hr class="mt-4 mb-4">
            <h6 class="pb-3 mb-3">Billing Information</h6>
            <form action="./include/_purchaseController.php"  method="POST" enctype="multipart/form-data">
            <input type="hidden" name="purchaseId"   value="<?php echo $pur_id; ?>">
                <input type="hidden" name="logged_admin_id"   value="<?php echo $logged_admin_id; ?>">
                <input type="hidden" name="logged_admin_role"   value="<?php echo $logged_admin_role; ?>">

           

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="">Total amount</label>
                <div class="col-sm-9">
                    <input class="form-control" id="totalAmount" name="totalAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9"   value="<?php if(!empty($row['total_amount'])){echo $row['total_amount']; } ?>">
                    <div class="invalid-feedback">Total Amount should be less than  Advance Amount</div>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="amountWords">Amount in words</label>
                <div class="col-sm-9">
                    <textarea id="amountWords" name="amountWords" rows="2" class="form-control"><?php if(!empty($row['amount_words'])){echo $row['amount_words']; } ?></textarea>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for=""></label>
                <div class="col-sm-4">
                    <label for="advencAmount">Advance amount</label>
                    <input class="form-control" type="text"  value="<?php if(!empty($row['advance_amount'])){echo $row['advance_amount']; } ?>"  id="advencAmount" name="advencAmount"   onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9"  >
                </div>
                <div class="col-sm-4">
                    <label for="balanceAmount">Balance amount</label>
                    <input type="text" class="form-control" value="<?php if(!empty($row['balance_amount'])){echo $row['balance_amount']; } ?>"    id="balanceAmount" name="balanceAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9">
                </div>
            </div> 
            <?php if ( empty($pofile) ) { ?> 
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label" for="poNO">PO no</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="poNO" name="poNO"    >
                </div>
            </div> 
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">PO copy</label>
                <div class="col-sm-9">
                    <input class="form-control" type="file" id="pofile" name="pofile" accept="image/x-png, image/jpeg, image/jpg , application/pdf"  >
                </div>
            </div>
            <?php } if($row['mail_sent'] == 0){ ?>
                
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Email Subject</label>
                <div class="col-sm-9"> 
                    <input type="text" class="form-control" id="emailSubject" name="emailSubject"  > 
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-3 col-form-label">Email Body</label>
                <div class="col-sm-9">
                    <textarea id="emailBody" name="emailBody" rows="3" class="form-control"  ></textarea>
                </div>
            </div>
            <?php 
            }if ( !empty($pofile)){ ?>
            <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" for="">PO Details</label>
                    <div class="col-sm-4"> 
                    <input class="form-control" type="text" readonly  value="<?php echo $row['po_no']; ?>"  readonly>
                    </div>
                    <?php if(!empty($pofile)){?>
                    <div class="col-sm-5"> 
                    <a href="<?php echo $uploadedPO.$pofile; ?>"  target="_blank">  <button type="button" class="btn btn-info" ><i class="feather icon-eye mr-2"></i> View Uploaded PO Copy </button> </a>
                    </div> 
                    <?php } ?>
            </div>   
        <?php } ?>

        <div class="row mb-2 m-t-30">
                <label class="col-sm-3 col-form-label pb-0">Set Action</label>
                <div class="col-sm-9">
                    <div class="mb-0">
                    <?php  if($row['mail_sent'] == 0){ ?>
                    <div class="form-check form-check-inline radio radio-primary" >
                        <input class="form-check-input" id="sendMailOnly" value="sendMailOnly" type="radio" name="Action" data-bs-original-title="" title="" required>
                        <label class="form-check-label" for="sendMailOnly">Send Mail</label>
                    </div>
                    <?php } ?> 
                    <?php  if(empty($pofile)){ ?>
                    <div class="form-check form-check-inline radio radio-primary">
                        <input class="form-check-input" id="savePOOnly" value="savePOOnly" type="radio" name="Action" data-bs-original-title="" title="" required>
                        <label class="form-check-label" for="savePOOnly">Save PO File</label>
                    </div>
                    <?php } ?> 
                    <?php  if(empty($row['second_approval'])){ ?>
                    <div class="form-check form-check-inline radio radio-primary">
                        <input class="form-check-input" id="raisePayOnly" value="raisePayOnly" type="radio" name="Action" data-bs-original-title="" title="" required>
                        <label class="form-check-label" for="raisePayOnly">Raise Payment</label>
                    </div>
                    <?php } ?>
                    </div>
                </div>
            </div>

            <div class="card-footer text-center">
                <div class="row">
                    <?php  if($row['mail_sent'] == 0){ ?>
                    <div class="col-6">
                        <button class="btn btn-info" name="sentPOEmail" id="sentPOEmail" type="submit"   >Send Mail</button>
                        <br> <small id="confirm_password" class="form-text text-danger">Only Mail(User & Supplier)</small>         
                    </div>
                        <?php } ?> 
                        <?php  if(empty($pofile)){ ?>
                    <div class="col-6 ">
                        <button class="btn btn-primary" name="savefPOFILE" id="savePOFILE" type="submit" >Save PO File</button>
                        <br> <small id="confirm_password" class="form-text text-danger">Only PO file will be saved</small>         
                    </div>
                        <?php } ?> 
                </div>
                <?php  if(empty($row['second_approval'])){ ?>
                <div class="row mt-4">
                    <div class="col-12"> 
                            <button class="btn btn-success" name="addPurchasePO" id="addPurchasePO"   type="submit">Update & Raise Payment Request</button>
                            <br> 
                            <small class="form-text text-danger">Raise Payment & Mail will not be triggered</small>                                
                        </div>
                    </div>
                    <?php } ?>
                </div>  
            </form>
        </div> 
</div>