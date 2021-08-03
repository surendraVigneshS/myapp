<table class="display payment-table" id="exportPaymentTable">
    <thead>
        <tr>
          <th data-exclude="true">Action</th>
          <th data-exclude="true">Action</th>
          <th>Created Date</th>
          <th>Incharge Name</th>
          <th>Organization Name</th>
          <th>Supplier Email</th>
          <th>Supplier Mobile</th>
          <th>Account No</th>
          <th>IFSC Code</th>
          <th>Company Name</th>
          <th>Total Amount</th>
          <th>Advanced Amount</th>
          <th>Balance Amount</th>
          <th>Priority</th>
          <th>Payment Against</th>
          <th>Approval</th>
          <th>Reason</th>
          <th>Remarks</th>
          <th>Feedback</th>
          <th>Po No</th>
          <th>Po File</th>
          <th>Bill No</th>
          <th>Bill File</th>
          <th>UTR No</th>
          <th>ACC Po</th>
        </tr>
    </thead>
    <tbody>
        <?php
        switch ($logged_admin_role) {
            case '1':
              //Admin  
              $customerselect = "SELECT * FROM `payment_request` ORDER BY `pay_id` DESC ";
            break;
        }
        $custoemrquery = mysqli_query($dbconnection, $customerselect);
        if (mysqli_num_rows($custoemrquery) > 0) {
          while ($row = mysqli_fetch_array($custoemrquery)) {
            $customerid = $row['pay_id'];
            $payCode = $row['pay_code'];
            $incharge_name = $row['incharge_name'];
            $company_name = $row['company_name'];
            $amount = $row['amount'];
            $suppliermail = $row['supplier_mail'];
            $suppliermobile = $row['supplier_mobile'];
            $accno = $row['acc_no'];
            $ifsccode = $row['ifsc_code'];
            $advancedAmonut = $row['advanced_amonut'];
            $balanceAmount = $row['balance_amount'];
            $amountWords = $row['amount_words'];
            $reason = $row['reason'];
            $remarks = $row['reason'];
            $pono = $row['po_no'];
            $billno = $row['bill_no'];
            $utrno = $row['utr_no'];
            $accpo = $row['acc_po'];
            $paymentType = $row['payment_type'];
            $paymentAgainst = $row['payment_against'];
            $userCancel = $row['user_cancel'];
            $firstApproval = $row['first_approval'];
            $secondApproval = $row['second_approval'];
            $thirdApproval = $row['third_approval'];
            $fourthApproval = $row['fourth_approval'];
            $createdtime = $row['created_date'];
            $paymentclose = $row['close_pay'];
            $PurchasePayment = $row['purchase_payment'];
            if($PurchasePayment == 1){
              $target_dir = "https://www.vencar.in/accounts/assets/pdf/purchase/";
            }else{
              $target_dir = "https://www.vencar.in/accounts/assets/pdf/payment/";
            }
            $executebillquery = mysqli_query($dbconnection,"SELECT `po_filename` FROM `payment_pdf` WHERE `pay_id` = '$customerid' AND `uploaded_type` = 'PO' "); 
            if(mysqli_num_rows($executebillquery) > 0){
              $po = mysqli_fetch_assoc($executebillquery);
              if(!empty($po['po_filename'])){
                $pofile = $po['po_filename'];
              }else{
                $pofile = '';
              }
            }else{
              $pofile = '';
            }
            $executebillquery = mysqli_query($dbconnection,"SELECT `po_filename` FROM `payment_pdf` WHERE `pay_id` = '$customerid' AND `uploaded_type` = 'Bill'"); 
            if(mysqli_num_rows($executebillquery) > 0){
                $bill = mysqli_fetch_assoc($executebillquery);
                if(!empty($bill['po_filename'])){
                  $billfile = $bill['po_filename'];
                }else{
                  $billfile = '';
                }
            }else{
              $billfile = '';
            }
              
            $orgName = $row['org_name'];
            if(is_numeric($orgName)){
              $orgColor = fetchData($dbconnection,'org_color','organization','id',$orgName);
            }else{
              $orgColor = fetchData($dbconnection,'org_color','organization','id',3);
            }
            if (is_numeric($orgName)){
              $orgName = fetchData($dbconnection,'organization_name','organization','id',$orgName);
            }
            $uploadAcc = "https://www.vencar.in/accounts/assets/pdf/payment/";
        ?>
        <tr style="color: <?php echo $orgColor ?>;" class="fw-500">
            <td data-exclude="true">
              <a href="javascript:void(0)" onclick="deletepayment(<?php echo $customerid; ?>)" class="btn mddisapprove btn-danger mt-2 btn-xs" type="button">Delete</a>
            </td>
            <td data-exclude="true">
              <?php if($logged_admin_role != 2){ ?>
                <a href="./edit-payment-request.php?platform=<?php echo randomString(45); ?>&action=editpayment&fieldid=<?php echo passwordEncryption($customerid) ?>" class="btn btn-primary btn-xs" type="button">Edit</a>
              <?php } ?>
            </td>
            <td><?php echo date("d-M-Y h:i A", strtotime($createdtime));  ?></td>
            <td><?php echo $incharge_name  ?></td>
            <td><?php echo $orgName  ?></td>
            <td><?php if(!empty($suppliermail)){ echo $suppliermail; }else{ echo ""; } ?></td>
            <td><?php if(!empty($suppliermobile)){ echo $suppliermobile; }else{ echo ""; } ?></td>
            <td><?php if(!empty($accno)){ echo $accno; }else{ echo ""; } ?></td>
            <td><?php if(!empty($ifsccode)){ echo $ifsccode; }else{ echo ""; } ?></td>
            <td><?php if(!empty($company_name)){ echo $company_name; }else{ echo ""; } ?></td>
            <td><?php if(!empty($amount)){ echo $amount; }else{ echo ""; } ?></td>
            <td><?php if(!empty($advancedAmonut)){ echo $advancedAmonut; }else{ echo ""; } ?></td>
            <td><?php if(!empty($balanceAmount)){ echo $balanceAmount; }else{ echo ""; } ?></td>
            <td><?php if(!empty($paymentType)){ echo $paymentType; }else{ echo ""; } ?></td>
            <td><?php echo paymentagainst($dbconnection,$paymentAgainst); ?></td>
            <td>
              <?php if (empty($firstApproval) && empty($userCancel)) { ?>
                <label class="badge badge-primary"> Created </label>
              <?php }if (empty($userCancel) && $firstApproval == 1 && $secondApproval == 0) { ?>
                <label class="badge badge-warning"> On Processing </label>
              <?php }if ($userCancel == 4 || $firstApproval == 4 || $secondApproval == 4 || $thirdApproval == 4 || $fourthApproval == 4) { ?>
                <label class="badge badge-danger"> Cancel </label>
              <?php }if (empty($userCancel) && $firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 0) { ?>
                <label class="badge badge-blue"> Preapproved </label>
              <?php }if (empty($userCancel) && $firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 0) { ?>
                <label class="badge badge-info"> Agreed </label>
              <?php }if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 1 && $paymentclose == 0) { ?>
                <label class="badge badge-success"> Approved </label>
              <?php }if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 1 && $paymentclose == 1) { ?>
                <label class="badge badge-voliet"> Completed </label>
              <?php } ?>
              <?php if(empty($userCancel)){ 
                echo 'By-' .paymentprocessuser($dbconnection,$firstApproval,$secondApproval,$thirdApproval,$fourthApproval,$customerid,$payCode,'0');
              }else{
                echo 'By-' .paymentuserCancel($dbconnection,$userCancel,$payCode,$customerid);
              } ?>
            </td>
            <td><?php if(!empty($reason)){ echo $reason; }else{ echo ""; } ?></td>
            <td><?php if(!empty($remarks)){ echo $remarks; }else{ echo ""; } ?></td>
            <td><?php echo feedbackFrom($dbconnection,$customerid)[0].'- Sent by - '.getuserName(feedbackFrom($dbconnection,$customerid)[1],$dbconnection); ?></td> 
            <td><?php if(!empty($pono)){ echo $pono; }else{ echo ""; } ?></td>
            <td <?php if(!empty($pofile)){ ?> data-hyperlink="<?php echo $target_dir.$pofile ?>" <?php }?>> 
                <?php if(!empty($pofile)){ ?>
                  <a href="<?php echo $target_dir.$pofile ?>" target="_blank" class="btn btn-info btn-xs"   >View PO</a> 
                <?php }else  {
                  echo 'No PO';
              } ?>
            </td>
            <td><?php if(!empty($billno)){ echo $billno; }else{ echo ""; } ?></td>
            <td <?php if(!empty($billfile)){ ?> data-hyperlink="<?php echo $target_dir.$billfile ?>" <?php }?>> 
                <?php if(!empty($billfile)){ ?>
                  <a href="<?php echo $target_dir.$billfile ?>" target="_blank" class="btn btn-info btn-xs"   >View Bill</a> 
                <?php }else  {
                  echo 'No Bill';
              } ?>
            </td>
            <td><?php if(!empty($utrno)){ echo $utrno; }else{ echo ""; } ?></td>
            <td <?php if(!empty($accpo)){ ?> data-hyperlink="<?php echo $uploadAcc.$accpo ?>" <?php }?>> 
                <?php if(!empty($accpo)){ ?>
                  <a href="<?php echo $uploadAcc.$accpo ?>" target="_blank" class="btn btn-info btn-xs"   >View File</a> 
                <?php }else  {
                  echo 'No File';
              } ?>
            </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>