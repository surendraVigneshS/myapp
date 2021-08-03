<div class="card-body">
    <form action="./include/_remainderController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="logged_admin_id" value="<?php echo $logged_admin_id; ?>">
        <input type="hidden" name="remainderId" value="<?php echo $remainderId; ?>">
        <h6 class="mb-4">Project Details</h6>


        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="remainderDate">Reminder Date</label>
            <div class="col-sm-9">
                <input class="datepicker-here form-control digits" value="<?php echo $remainder_date; ?>" type="text" name="remainderDate" required>
            </div>
        </div>
        

        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="supplierId">Select Supplier</label>
            <div class="col-sm-9">
                <select class="form-select digits" id="supplierId" name="supplierId" required>
                    <option selected disabled>Choose...</option>
                    <?php
                    $selectOrganization = "SELECT * FROM `supplier_details` WHERE `supplier_name` <>'' GROUP BY `supplier_name`";
                    $executeOrganization = mysqli_query($dbconnection, $selectOrganization);
                    while ($supplierRow = mysqli_fetch_array($executeOrganization)) {
                    ?>
                        <option value="<?php echo  $supplierRow['cust_id']; ?>" <?php if ($remainder_supplier_id == $supplierRow['cust_id']) {
                                                                                    echo 'selected';
                                                                                }  ?> ><?php echo  $supplierRow['supplier_name']; ?></option>
                    <?php
                    } ?>
                </select>
            </div>
        </div>
 
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="amount">Total amount *</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="totalamount" name="amount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $remainder_amount; ?>" maxlength="9" required>
            </div>
        </div>

 
        <div class="mb-3 row">
            <label class="col-sm-3 col-form-label" for="remainderStatus">Reminder Status</label>
            <div class="col-sm-9"> 
                <select class="form-select digits" id="remainderStatus" name="remainderStatus" required> 
                        <option value="1" <?php if ($remainder_status == 1) { echo 'selected'; }  ?> >Pending</option> 
                        <option value="2" <?php if ($remainder_status == 2) { echo 'selected'; }  ?> >Completed</option> 
                     
                </select>
            </div>
        </div>

        <div class="card-footer text-center">
            <button class="btn btn-primary" name="updateRemainder" id="updateRemainder" type="submit">Update Reminder</button>
        </div>
</div>