<div class="card-body">
    <form action="./include/_purchaseController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="purchaseId" id="purchaseId" value="<?php echo $pur_id; ?>">
        <input type="hidden" name="logged_admin_id" id="logged_admin_id" value="<?php echo $logged_admin_id; ?>">
        <input type="hidden" name="logged_admin_role" id="logged_admin_role" value="<?php echo $logged_admin_role; ?>">
        <h6 class="mb-4">Project Details</h6>


        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="purchaseAgainst">Purchase Against</label>
            <div class="col-sm-9">
                <input type="hidden" value="<?php echo $row['already_purchased']; ?>" name="purchaseAgainst">
                <select class="form-select digits" id="purchaseAgainst" name="purchaseAgaisnst" disabled>
                    <option selected disabled>Choose...</option>
                    <option value="0" <?php if ($row['already_purchased'] == 0) {
                                            echo 'selected';
                                        } ?>>Not Yet Purchased</option>
                    <option value="1" <?php if ($row['already_purchased'] == 1) {
                                            echo 'selected';
                                        } ?>>Purchased List</option>
                </select>
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
                    <option value="One Time Purchase" <?php if ($row['purchase_type'] == 'One Time Purchase') {
                                                            echo 'selected';
                                                        } ?>>One Time Purchase</option>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="">Organization name</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" id="orgName" name="orgName" value="<?php if (is_numeric($org_name)) {
                                                                                                echo fetchData($dbconnection, 'organization_name', 'organization', 'id', $org_name);
                                                                                            } else {
                                                                                                echo $org_name;
                                                                                            }   ?>" readonly required>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="">Project title</label>
            <div class="col-sm-9">
                <input type="hidden" class="form-control" id="projectID" name="projectID" value="<?php echo $row['project_id']; ?>">
                <input type="text" class="form-control" id="projectTitle" name="projectTitle" value="<?php echo $row['project_title']; ?>">
            </div>
        </div>

        <div class=" m-t-20 row rows" id="rows">
            <div class="col-sm-8 col-md-9" id="">
                <label for="productName">Product Name</label>
            </div> 
            <div class="col-sm-2 col-md-3">
                <label for="">Quantity</label>
            </div>
        </div>
        <?php
        $capacityquery = "SELECT * FROM `purchased_products` LEFT JOIN  `ft_product_master` ON `ft_product_master`.`product_id` = `purchased_products`.`pr_product_id` WHERE  `purchased_products`.`pr_purchase_id`='$pur_id'";
        $capacityresults = mysqli_query($dbconnection, $capacityquery);
        if (mysqli_num_rows($capacityresults) > 0) {
            while ($capacityrows = mysqli_fetch_assoc($capacityresults)) {
        ?>
                <div class="row rows my-3" id="rows">
                    <div class="col-sm-8 col-md-9"> 
                        <select class="form-select  select2" id="projectTitle" name="productID[]" required > 
                            <?php
                            $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_master` ORDER BY `product_name` ASC ");
                            while ($rows = mysqli_fetch_assoc($query)) {
                            ?>
                                <option value="<?php echo $rows['product_id']; ?>" class="text-capitalize" <?php if($capacityrows["pr_product_id"] == $rows["product_id"]){echo'selected';} ?>>
                                    <?php echo  ucfirst($rows['product_name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-3"> 
                        <input type="text" class="form-control" id="Qty" name="productQTY[]" value="<?php echo $capacityrows["pr_qty"]; ?>">
                    </div>
                </div>
            <?php  }  ?>
            <div id="capacity-div2"></div>
            <div class="row m-b-30 m-t-30 ">
                <div class="col-md-12 d-flex justify-content-end">
                    <div>
                        <button id="addNewCap2" class="  btn btn-success" type="button">Add Product</button>  
                        <button id="addNewRemove2" class="  btn btn-danger" type="button">Remove Product</button> 
                    </div>
                </div>
            </div>
        <?php } ?>
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
                <input class="form-control" id="supplierName" name="supplierName" type="text" value="<?php echo $rowss['supplier_name']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierEmail">Supplier email</label>
            <div class="col-sm-9">
                <input class="form-control" id="supplierEmail" name="supplierEmail" type="email" value="<?php echo $rowss['supplier_email']; ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierMobile">Supplier moblie</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="supplierMobile" name="supplierMobile" value="<?php echo $rowss['supplier_mobile']; ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="10">
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
                    <input type="text" class="form-control" id="accNo" name="accNo" value="<?php echo $rowss['supplier_acc_no']; ?>"  onkeypress="return event.charCode >= 48 && event.charCode <= 57"  >
                </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="ifsccode">IFSC Code </label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="ifsccode" name="ifsccode"   value="<?php echo $rowss['supplier_ifsc_code']; ?>" >
            </div>
        </div>
        <?php
                            }?>

        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="remarks">Remarks</label>
            <div class="col-sm-9">
                <textarea id="remarks" name="remarks" rows="3" class="form-control"><?php echo $row['others']; ?></textarea>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-primary" name="editPurchase" id="editPurchase" type="submit">Update Changes</button>
        </div>
    </form>
</div>