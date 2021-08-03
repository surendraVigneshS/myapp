<table class="display payment-table" id="">
    <thead>
        <tr>
            <th>Created Date</th>
            <th>Incharge Name</th>
            <th>Organization Name</th>
            <th>Company Name</th>
            <th>Amount</th>
            <th>Remarks</th>
            <th>Feedback</th>
            <th>Payment Against</th>
            <th>Priority</th>
            <th>PO File</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        switch ($logged_admin_role) {
            case '2':
                //MD  
                $customerselect = "SELECT * FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 0 ORDER BY `pay_id` DESC ";
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
                if (is_numeric($orgName)){
                    $orgColor = fetchData($dbconnection,'org_color','organization','id',$orgName);
                }else{
                    $orgColor = fetchData($dbconnection,'org_color','organization','id',3);
                }
                if (is_numeric($orgName)){
                  $orgName = fetchData($dbconnection,'organization_name','organization','id',$orgName);
                }
                $paymentRemarks = $row['remarks'];
        ?>
        <tr>
            <td><?php echo date("d-M-Y h:i A", strtotime($createdtime));  ?></td>
            <td><?php echo $incharge_name  ?></td>
            <td style="color: <?php echo $orgColor ?>;"><?php echo $orgName  ?></td>
            <td><?php echo $company_name ?></td>
            <td><?php echo $advancedAmonut ?></td>
            <td><?php echo $paymentRemarks ?></td> 
            <td>
            <?php  if(!empty(feedbackFrom($dbconnection,$customerid)[0])){
                echo feedbackFrom($dbconnection, $customerid)[0].'- Sent by - '.getuserName(feedbackFrom($dbconnection, $customerid)[1], $dbconnection);
            } ?>
          </td>
            <td><?php echo paymentagainst($dbconnection,$paymentAgainst); ?></td>
            <td><?php echo $paymentType ?></td>
            <td><?php if(!empty($pofile)){  ?>
                <a href="<?php echo $target_dir.$pofile ?>" target="_blank" class="btn btn-info btn-xs" >View <?php echo $uploadtype; ?></a> 
                <?php }else{ echo 'No File'; } ?>
            </td>
            <td>
                <?php if ($firstApproval == 1 && $secondApproval == 1) { ?>
                 <label class="badge badge-success"> Approved </label>
                <?php } ?>
            </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>