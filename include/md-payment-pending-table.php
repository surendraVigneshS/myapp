<table class="display payment-table" id="">
    <thead>
        <tr>
            <th>Action</th>
            <th>Action</th>
            <th>Created Date</th>
            <th>Incharge Name</th>
            <th>Organization Name</th>
            <th>Company Name</th>
            <th>Amount</th>
            <th>Remarks</th> 
            <th>Feedback</th> 
            <th>Priority</th>
            <th>Payment Against</th>
            <th>PO File</th>
        </tr>
    </thead>
    <tbody>
        <?php
        switch ($logged_admin_role) {
            case '2':
                //MD  
                $customerselect = "SELECT * FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 0 ORDER BY `pay_id` DESC ";
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
            if(!empty($row['advanced_amonut'])){
              $advancedAmonut = $row['advanced_amonut'];
            }else{
              $advancedAmonut = $row['amount'];
            }
            $paymentType = $row['payment_type'];
            $paymentAgainst = $row['payment_against'];
            $firstApproval = $row['first_approval'];
            $secondApproval = $row['second_approval'];
            $thirdApproval = $row['third_approval'];
            $fourthApproval = $row['fourth_approval'];
            $createdtime = $row['second_approval_time'];
            $PurchasePayment = $row['purchase_payment'];
            $paymentRemarks = $row['remarks'];
            $executebillquery = mysqli_query($dbconnection,"SELECT * FROM `payment_pdf` WHERE `pay_id` = '$customerid' AND (`uploaded_type` = 'PO' OR `uploaded_type` = 'Bill') "); 
            if(mysqli_num_rows($executebillquery) > 0){
              $po = mysqli_fetch_assoc($executebillquery);
              if(!empty($po['po_filename'])){
                $pofile = $po['po_filename'];
                $uploadtype = $po['uploaded_type'];
              }else{
                $pofile = '';
              }
            }else{
              $pofile = '';
            }
            if($PurchasePayment == 1){
                $target_dir = './assets/pdf/purchase/';
            }else{
                $target_dir = "./assets/pdf/payment/";
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
        ?>
        <tr style="color: <?php echo $orgColor ?>;" class="fw-500">
            <td>
                <?php if($firstApproval == 1 && $secondApproval = 1 && $thirdApproval == 0 && $logged_admin_role == 2){ ?>
                <button type="button" class="btn btn-success my-1 mdapprove" onclick="aprrovePurchase(<?php echo $customerid; ?>,<?php echo $logged_admin_id; ?>,<?php echo $logged_admin_role; ?>)"> Approve </button>
                <?php } ?>
            </td>
            <td>
                <?php if($firstApproval == 1 && $secondApproval = 1 && $thirdApproval == 0 && $logged_admin_role == 2){ ?>
                <button type="button" class="btn btn-danger my-1" onclick="finaldisAprrovePurchase(<?php echo $customerid; ?>,<?php echo $logged_admin_id; ?>,<?php echo $logged_admin_role; ?>)">Cancel</button>
                <?php } ?>
            </td>
            <td><?php echo date("d-M-Y h:i A", strtotime($createdtime));  ?></td>
            <td><?php echo $incharge_name  ?></td>
            <td><?php echo $orgName  ?></td>
            <td><?php echo $company_name ?></td>
            <td><?php echo $advancedAmonut ?></td>
            <td><?php echo $row['remarks'] ?></td> 
            <td>
            <?php  if(!empty(feedbackFrom($dbconnection,$customerid)[0])){
                echo feedbackFrom($dbconnection, $customerid)[0].'- Sent by - '.getuserName(feedbackFrom($dbconnection, $customerid)[1], $dbconnection);
            } ?>
          </td>
            <td><?php echo $paymentType ?></td>
            <td><?php echo paymentagainst($dbconnection,$paymentAgainst); ?></td>
            <td><?php if(!empty($pofile)){  ?>
                <a href="<?php echo $target_dir.$pofile ?>" target="_blank" class="btn btn-info btn-xs" >View <?php echo $uploadtype; ?></a> 
                <?php }else{ echo 'No File'; } ?>
            </td>
           
        </tr>
        <?php } } ?>
    </tbody>
</table>