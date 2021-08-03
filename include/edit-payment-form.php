<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Payment From Organization</label>
    <div class="col-sm-8">
      <input class="form-control" type="text" id="orgName" name="orgName" value="<?php if(is_numeric($org_name)){ echo fetchData($dbconnection,'organization_name','organization','id',$org_name); } else{echo $org_name; }   ?>" readonly required>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Company/Beneficiary name</label>
    <div class="col-sm-8">
      <input class="form-control" type="text" id="companyName" name="companyName" value="<?php echo $company_name  ?>">
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="projectName">Project Name</label>
    <div class="col-lg-8">
        <input class="form-control" type="text" id="projectName" name="projectName" placeholder="" value="<?php echo $project_title ?>" readonly>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Beneficiary email</label>
    <div class="col-sm-8">
      <input class="form-control" id="companyEmail" name="companyEmail" type="email" value="<?php echo $supplier_mail ?>">
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Beneficiary moblie</label>
    <div class="col-sm-8">
      <input class="form-control" type="tel" value="<?php echo $supplier_phone ?>" id="companyMobile" name="companyMobile" onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="12">
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="companyBranch">Beneficiary Branch</label>
    <div class="col-sm-8">
        <input type="text" class="form-control" id="companyBranch" name="companyBranch" value="<?php echo $supplier_branch ?>" readonly>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Account No</label>
    <div class="col-sm-8">
      <input class="form-control"  type="number"   value="<?php echo $account_no ?>" id="accNo" name="accNo" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">IFSC <code></code></label>
    <div class="col-sm-8">
      <input class="form-control"  type="text" value="<?php echo $ifsc_code ?>" id="ifsccode" name="ifsccode">
    </div>
</div>
<!-- <div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Reason</label>
    <div class="col-sm-8">
        <textarea id="reason" name="reason" rows="3" class="form-control"><?php echo $reason ?></textarea>
    </div>
</div> -->
<hr class="mt-4 mb-4">
<h6 class="mb-4">Payment Details</h6>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">PO No</label>
    <div class="col-sm-8">
      <input class="form-control"  type="text" value="<?php echo $po_no  ?>" id="PONum" name="PONum">
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Total amount</label>
    <div class="col-sm-8">
      <input class="form-control"  type="text" value="<?php echo $amount ?>" id="totalamount" name="amount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" >
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Amount in words</label>
    <div class="col-sm-8">
        <textarea id="totalamountWords" name="amountWords" rows="3" class="form-control"><?php echo $amount_words ?></textarea>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Payment type</label>
    <div class="col-sm-8">
        <select class="form-select digits" id="paymentType" name="paymentType">
            <option value="Immediate" <?php if($payment_type == 'Immediate'){ echo 'selected';} ?>>Immediate</option>
            <option value="Normal" <?php if($payment_type == 'Normal'){ echo 'selected';} ?>>Normal</option>
        </select>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Payment against</label>
    <div class="col-sm-8">
        <select class="form-select digits" id="paymentAgainst" name="paymentAgainst" disabled>
            <?php 
                $selectpayment = "SELECT * FROM `payment_type` ";
                $executepayment = mysqli_query($dbconnection,$selectpayment);
                if(mysqli_num_rows($executepayment) > 0){
                    while($payment = mysqli_fetch_array($executepayment)){
                        $fetchpayment = $payment['payment_value'];
            ?>
            <option value="<?php echo $payment['payment_value']; ?>" <?php if($fetchpayment == $payment_against){ echo "selected"; } ?>><?php echo $payment['payment_name']; ?></option>
            <?php } } ?>
        </select>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="paymentType">GST *</label>
    <div class="col-sm-8">
        <div class="m-t-10 m-checkbox-inline custom-radio-ml">
            <div class="form-check form-check-inline radio radio-primary">
              <input class="form-check-input" id="gstYes" type="radio" name="gstOption" <?php if($gst == 1){ echo 'checked'; } ?> value="1">
              <label class="form-check-label mb-0" for="gstYes">Yes</label>
            </div>
            <div class="form-check form-check-inline radio radio-primary">
              <input class="form-check-input" id="gstNo" type="radio" name="gstOption" <?php if($gst == 0){ echo 'checked'; } ?> value="0">
              <label class="form-check-label mb-0" for="gstNo">No</label>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="gstNo">GST Number</label>
    <div class="col-sm-8">
        <input type="text" name="gstNo" class="form-control option 1" value="<?php echo $gst_no ?>" id="gstNo">
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Bill no</label>
    <div class="col-sm-8">
      <input class="form-control"  type="text" value="<?php echo $bill_no ?>" id="billNo" name="billNo">
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Remarks</label>
    <div class="col-sm-8">
        <textarea id="remarks" name="remarks" rows="3" class="form-control"><?php echo $remarks ?></textarea>
    </div>
</div>
<?php
    $selectpo = "SELECT * FROM `payment_pdf` WHERE `pay_id` = '$pur_id' ";
    $executepo = mysqli_query($dbconnection, $selectpo);
    if(mysqli_num_rows($executepo) > 0 ){
        if($row = mysqli_fetch_array($executepo)){
            $filetype = $row['uploaded_type']; 
            $filename = $row['po_filename']; 
            $uploadby = $row['uploaded_by']; 
            $uploadtime = $row['uploaded_time']; 
        }
    }
    
?>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label">Bill Copy</label>
    <div class="col-sm-8">
    <?php if(!empty($filename)){?>
      <input class="form-control mb-3" type="file" name="pofile" accept="image/x-png, image/jpeg, image/jpg , application/pdf">
      <a href="<?php echo $uploadedPO.$filename; ?>"  target="_blank">  <button type="button" class="btn btn-info" ><i class="feather icon-eye mr-2"></i> View Uploaded File </button> </a>
    <?php } else{ ?>
      <input class="form-control" type="file" name="pofile" accept="image/x-png, image/jpeg, image/jpg , application/pdf">
    <?php } ?>  
    </div>
</div>
<?php if($logged_admin_role == 6 || $logged_admin_role == 5){ ?>
<div class="card-footer text-center">
    <button class="btn btn-primary" type="submit" name="approvepaymentTeamLeader">Save Changes</button>
</div>
<?php } if(($logged_admin_role == 3 && $firstApproval == 1 ) || ($logged_admin_role == 7 && $firstApproval == 1) || ($logged_admin_role == 9 && $secondApproval == 1)  ){ ?>
<div class="card-footer text-center">
    <button class="btn btn-primary" type="submit" name="approvepaymentTeamLeader">Update Changes</button>
</div>
<?php } ?>