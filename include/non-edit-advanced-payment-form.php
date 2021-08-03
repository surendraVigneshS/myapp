<?php if(($logged_admin_role == 4 && $thirdApproval == 1 && $fourthApproval == 0) || ($logged_admin_role == 9 && $thirdApproval == 1 && $fourthApproval == 0)){ ?>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label">Ref/UTR No</label>
    <div class="col-sm-8">
      <input class="form-control" type="text" value="" id="refNo" name="refNo">
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label">Payment Slip</label>
    <div class="col-sm-8">
        <input class="form-control" type="file" name="accpofile" id="accpofile" accept="image/x-png, image/jpeg, image/jpg , application/pdf">
    </div>
</div>
<?php }if(!empty($UTR_no)){ ?>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label">Ref/UTR No</label>
    <div class="col-sm-8">
      <input class="form-control" type="text" value="<?php echo $UTR_no ?>" id="refNo" name="refNo" readonly>
    </div>
</div>
<?php } ?>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Payment From Organization</label>
    <div class="col-sm-8">
      <input class="form-control" type="text" id="orgName" name="orgName" value="<?php if(is_numeric($org_name)){ echo fetchData($dbconnection,'organization_name','organization','id',$org_name); } else{echo $org_name; }   ?>" readonly required>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Company/Beneficiary name</label>
    <div class="col-sm-8">
      <input class="form-control" type="text" id="companyName" name="companyName" value="<?php echo $company_name ?>" readonly required>
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
      <input class="form-control" id="companyEmail" name="companyEmail" type="email" value="<?php echo $supplier_mail ?>" readonly required>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Beneficiary moblie</label>
    <div class="col-sm-8">
      <input class="form-control" type="tel" value="<?php echo $supplier_phone ?>" id="companyMobile" name="companyMobile" onkeypress="return event.charCode >= 48 && event.charCode <= 57 " maxlength="12" readonly required>
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
      <input class="form-control"  type="number"   value="<?php echo $account_no ?>" id="accNo" name="accNo" onkeypress="return event.charCode >= 48 && event.charCode <= 57" readonly required>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">IFSC <code></code></label>
    <div class="col-sm-8">
      <input class="form-control"  type="text" value="<?php echo $ifsc_code ?>" id="ifsccode" name="ifsccode" readonly required>
    </div>
</div>
<!-- <div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Reason</label>
    <div class="col-sm-8">
        <textarea id="reason" name="reason" required rows="3" class="form-control" disabled><?php echo $reason ?></textarea>
    </div>
</div> -->
<hr class="mt-4 mb-4">
<h6 class="mb-4">Payment Details</h6>
<?php if(($logged_admin_role == 4 && $thirdApproval == 1 && $fourthApproval == 0) || ($logged_admin_role == 9 && $thirdApproval == 1 && $fourthApproval == 0)){ ?>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Raise Payment Amount</label>
    <div class="col-sm-8">
      <input class="form-control"  type="text" value="<?php echo $advance ?>" readonly>
    </div>
</div>
<?php }else{ ?>
<?php if(!empty($po_no)){ ?>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">PO No</label>
    <div class="col-sm-8">
      <input class="form-control"  type="text" value="<?php echo $po_no  ?>" id="PONum" name="PONum" readonly required>
    </div>
</div>
<?php } if(!empty($bill_no)){ ?>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Bill no</label>
    <div class="col-sm-8">
      <input class="form-control"  type="text" value="<?php echo $bill_no ?>" id="billNo" name="billNo" readonly>
    </div>
</div>
<?php } ?>

<?php if($logged_admin_role == 1) {?>  
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Total amount</label>
    <div class="col-sm-8">
        <input type="hidden" value="<?php echo $amount ?>" id="OriginalTotalAmount" name="OriginalTotalAmount">
      <input class="form-control"  type="text" value="<?php echo $amount ?>" name="adminamount" id="updateAmountsByAdmin" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9"  required>
      <div class="invalid-feedback">Total Amount should be greater than Current Advance Amount</div>
    </div>
</div>
<div class="row mt-4 mb-4">
    <div class="col-4 ">  
    </div>
    <div class="col-4 "> 
            <button class="btn btn-info" id="updateAdminAmount" type="button" onclick="updataAmountByAdmin(<?php echo $logged_admin_id ?>,<?php echo $logged_admin_role?>,<?php echo substr($payCode,4);  ?>)">Update Total Amount</button> 
            <br>
        </div>
    </div>  
<?php }else  { ?>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Total amount</label>
    <div class="col-sm-8">
      <input class="form-control"  type="text" value="<?php echo $amount ?>" id="totalamount" name="amount" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" readonly required>
      <div class="invalid-feedback">Total Amount should be less than  Advance Amount</div>
    </div>
</div>
<?php } ?>



<?php 
    $customerselects = "SELECT * FROM `payment_request` WHERE `pay_code` = '$payCode' ORDER BY `pay_id` ASC";
    $custoemrquerys = mysqli_query($dbconnection, $customerselects);
    $slno = 0;
    if (mysqli_num_rows($custoemrquerys) > 0) {
        while($rows = mysqli_fetch_array($custoemrquerys)) {
            $disadvancedAmonut = $rows['advanced_amonut'];
            $disbalanceAmount = $rows['balance_amount'];
            $slno++;
      
?>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for=""></label>
    <div class="col-sm-4">
        <label for="">Advance Payment :<b><?php echo $slno; ?></b></label>
        <input type="text" name="disadvance" class="form-control" id="disadvance" value="<?php echo $disadvancedAmonut ?>" disabled>
    </div>
    <div class="col-sm-4">
        <label for="" class="opa-0">Balance Payment</label>
        <input type="text" name="disbalance" class="form-control" id="disbalance" value="<?php echo $disbalanceAmount ?>" disabled>
    </div>
</div>
<?php } } ?>
<?php 
    $pendingrequest = pendingrequestcount($dbconnection,$payCode,$pur_id,$logged_admin_id);
    if($createdBy == $logged_admin_id && $balance != 0){
        if($pendingrequest == 1){ ?>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for=""></label>
    <div class="col-sm-4">
        <label for="advencAmount">Advance amount</label>
        <?php if($createdBy == $logged_admin_id){ 
                if($balance != 0){ ?>
        <input class="form-control" type="text" id="advencAmount" name="advencAmount" value="" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" required>
        <?php }else{ ?>
        <input class="form-control" type="text" id="advencAmount" name="advencAmount" value="<?php echo $advance ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" required readonly>
        <?php } }else{ ?>
        <input class="form-control" type="text" id="advencAmount" name="advencAmount" value="<?php echo $advance ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" required readonly>
        <?php }  ?>
        
    </div>
    <div class="col-sm-4">
        <label for="balanceAmount">Balance amount</label>
        <input type="hidden" name="nonbalanceAmount" id="nonbalanceAmount" value="<?php echo pendingrequestBalance($dbconnection,$payCode); ?>">
        <!-- <input type="text" class="form-control" id="balanceAmount" name="balanceAmount" value="<?php echo $balance ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" readonly> -->
        <input type="text" class="form-control" id="balanceAmount" name="balanceAmount" value="<?php echo pendingrequestBalance($dbconnection,$payCode); ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="9" readonly>
    </div>
</div>
<?php } } ?>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Amount in words</label>
    <div class="col-sm-8">
        <textarea id="totalamountWords" name="amountWords" required rows="3" class="form-control" disabled><?php echo $amount_words ?></textarea>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Payment type</label>
    <div class="col-sm-8">
        <select class="form-select digits" id="paymentType" name="paymentType" disabled>
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
              <input class="form-check-input" id="gstYes" type="radio" name="gstOption" <?php if($gst == 1){ echo 'checked'; } ?> value="1" disabled>
              <label class="form-check-label mb-0" for="gstYes">Yes</label>
            </div>
            <div class="form-check form-check-inline radio radio-primary">
              <input class="form-check-input" id="gstNo" type="radio" name="gstOption" <?php if($gst == 0){ echo 'checked'; } ?> value="0" disabled>
              <label class="form-check-label mb-0" for="gstNo">No</label>
            </div>
        </div>
    </div>
</div>
<div class="row mb-3">
    <label class="col-sm-4 col-form-label" for="gstNo">GST Number</label>
    <div class="col-sm-8">
        <input type="text" name="gstNo" class="form-control option 1" value="<?php echo $gst_no ?>" id="gstNo" readonly>
    </div>
</div>
<div class="mb-3 row">
    <label class="col-sm-4 col-form-label" for="">Remarks</label>
    <div class="col-sm-8">
        <textarea id="remarks" name="remarks" required rows="3" class="form-control" disabled><?php echo $remarks ?></textarea>
    </div>
</div>
<input type="hidden" name="purchasepayment" id="purchasepayment" value="<?php echo $PurchasePayment ?>">
<?php 
    $billupload = billupload($dbconnection,$payCode,$pur_id,'1','Bill');
    if($pendingrequest == 1){
        if($createdBy == $logged_admin_id && $fourthApproval == 1 && $balance == 0 && $billupload != 'Bill'){ ?>
    <div class="mb-3 row">
        <label class="col-sm-4 col-form-label" for="">Bill no</label>
        <div class="col-sm-8">
          <input class="form-control"  type="text" value="" id="billNo" name="billNo" required>
        </div>
    </div>
    <div class="mb-3 row">
        <label class="col-sm-4 col-form-label">Bill copy</label>
        <div class="col-sm-8">
            <input class="form-control" type="file" name="pofile" id="billfile" accept="image/x-png, image/jpeg, image/jpg , application/pdf" required>
        </div>
    </div>
<?php } } ?>
<?php } ?>
<hr class="mb-4 mt-4">
<h6 class="mb-4 mt-4">View Uploaded File</h6>
<?php if(!empty($accteampo)){ ?>
<div class="mb-3 row">
    <label class="col-sm-6 col-form-label">Payment Slip</label>
    <div class="col-sm-6">
    <?php if(!empty($accteampo)){?>
      <a href="<?php echo $uploadedPO.$accteampo; ?>"  target="_blank">  <button type="button" class="btn btn-info" ><i class="feather icon-eye mr-2"></i> View Uploaded File </button> </a>
    <?php } ?>  
    </div>
</div>
<?php } ?>
<?php 
    $pofileselect = "SELECT * FROM `payment_pdf` WHERE `pay_id` = '$pur_id'";
    $pofilequery = mysqli_query($dbconnection, $pofileselect);
    if (mysqli_num_rows($pofilequery) > 0) {
        while($row = mysqli_fetch_array($pofilequery)) {
            $filename = $row['po_filename'];
            $advancepoamount = $row['advance_amount'];
            $uploadtype = $row['uploaded_type'];
?>
<?php if(!empty($filename)){?>
<div class="mb-3 row">
    <label class="col-sm-6 col-form-label"><?php echo $uploadtype ?> Copy</label>
    <div class="col-sm-6">
        <a href="<?php echo $uploadedPO.$filename; ?>"  target="_blank">  <button type="button" class="btn btn-info" ><i class="feather icon-eye mr-2"></i> View Uploaded File </button> </a>
        <?php if($uploadtype == 'Bill'){ ?>
        <a href="<?php echo $uploadedPO.$filename; ?>"  target="_blank" download="">  <button type="button" class="btn btn-xs btn-success" style="font-size:14px;padding:5px 10px"><i class="fas fa-download"></i></button></a>
        <?php } ?>
    </div>
</div>
<?php } ?>
<?php } } ?>
<?php if(($createdBy == $logged_admin_id)  && $fourthApproval == 1 && $balance != 0 && $paymentclose == 0){
        if($pendingrequest == 1){ ?> 
<div class="card-footer text-center">
    <?php if(pendingrequestBalance($dbconnection,$payCode) != 0){ ?>
    <button class="btn btn-primary" type="submit" name="updateAdvancepayment" id="updateAdvancepayment">Update Changes & Raise Payment Request</button>
    <?php } ?>
</div>
<?php } }?>
<?php if($createdBy == $logged_admin_id && $fourthApproval == 1 && $balance == 0 && $billupload != 'Bill'){ ?>
<div class="card-footer text-center">
    <button class="btn btn-primary" type="submit" name="uploadbillfile" id="uploadbillfile">Upload Bill</button>
</div>
<?php } ?>
