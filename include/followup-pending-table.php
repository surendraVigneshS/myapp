<table class="display payment-table" id="exportPaymentTable">
    <thead>
        <tr> 
          <th data-exclude="true">Action</th>
          <th>Incharge Name</th>
          <th>Organization Name</th>
          <th>Company Name</th>
          <th>Amount</th>
          <th>Remarks</th>
          <th>Feedback</th>
          <th>Priority</th>
          <th>Payment Against</th>
          <th>Approval</th>
        </tr>
    </thead>
    <tbody>
        <?php
        switch ($logged_admin_role) {
            case '6':
                //Employee
                $customerselect = "SELECT * FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND `payment_against` = 3  AND `close_pay` = 1 ORDER BY `pay_id` DESC ";
            break;
            case '3':
            case '10':
              //Team Leader
              $customerselect = "SELECT * FROM `payment_request` WHERE (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND `payment_against` = 3 AND `close_pay` = 1 ORDER BY `pay_id` DESC ";
            break;
            case '4':
              //Finance  
              $customerselect = "SELECT * FROM `payment_request` WHERE `close_pay` = 1 AND `payment_against` = 3 ORDER BY `pay_id` DESC ";
            break;
            case '5':
              // Purchase Lead 
              $customerselect = "SELECT * FROM `payment_request` LEFT JOIN `followup_payments` ON `followup_payments`.`pay_id` = `payment_request`.`pay_id` WHERE `followup_payments`.`followup_type` = 1 AND `followup_payments`.`followup_status`=0 ORDER BY `followup_payments`.`pay_id` DESC";
            break;
            case '7':
              // Purchase Team  
              $customerselect = "SELECT * FROM `payment_request` LEFT JOIN `followup_payments` ON `followup_payments`.`pay_id` = `payment_request`.`pay_id` WHERE `followup_payments`.`followup_type` = 1 AND `followup_payments`.`followup_status`=0 ORDER BY `followup_payments`.`pay_id` DESC ";
            break; 
            case '8':
              //Accounts  
              $customerselect = "SELECT * FROM `payment_request` LEFT JOIN `followup_payments` ON `followup_payments`.`pay_id` = `payment_request`.`pay_id` WHERE `followup_payments`.`followup_type` = 2 AND `followup_payments`.`followup_status`=0 ORDER BY `followup_payments`.`pay_id` DESC ";
            break;
            case '9':
              //AGEM Accounts  
              $customerselect = "SELECT * FROM `payment_request` WHERE `close_pay` = 1 AND `payment_against` = 3 AND ( `org_name`=2 OR `org_name`='Agem') ORDER BY `pay_id` DESC ";
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
            $createdtime = $row['fourth_approval_time'];
            $paymentclose = $row['close_pay'];
            $orgName = $row['org_name'];
            if (is_numeric($orgName)){
              $orgName = fetchData($dbconnection,'organization_name','organization','id',$orgName);
            }
            $followup = feedbackFrom($dbconnection,$customerid)[0];
            $followupuniqueid = $row['id'];
        ?>
        <tr>
            <td> 
              <button id="completeFollowup" onclick="comepleteFollowup(<?php echo $followupuniqueid; ?> , <?php echo $logged_admin_id; ?>)" class="btn btn-primary btn-xs completeFollowup" type="button">Complete Followup</button>              
          </td> 
          <td><?php echo $incharge_name  ?></td>
          <td><?php echo $orgName  ?></td>
          <td><?php echo $company_name ?></td>
          <td><?php echo $advancedAmonut ?></td>
          <td><?php echo $row['remarks'] ?></td> 
          <td>
              <?php 
                if(!empty($followup)) {
                    echo $followup.'- Sent by - '.getuserName(feedbackFrom($dbconnection, $customerid)[1], $dbconnection);
                } 
              ?>
          </td> 
          <td><?php echo $paymentType ?></td>
          <td><?php echo paymentagainst($dbconnection,$paymentAgainst); ?></td>
          <td>
            <?php if (empty($firstApproval)) { ?>
              <label class="badge badge-primary"> Created </label>
            <?php }if ($firstApproval == 1 && $secondApproval == 0) { ?>
              <label class="badge badge-warning"> On Processing </label>
            <?php }if ($firstApproval == 4 || $secondApproval == 4 || $thirdApproval == 4 || $fourthApproval == 4) { ?>
              <label class="badge badge-danger"> Cancel </label>
            <?php }if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 0) { ?>
              <label class="badge badge-blue"> Preapproved </label>
            <?php }if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 0) { ?>
              <label class="badge badge-info"> Agreed </label>
            <?php }if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 1 && $paymentclose == 0) { ?>
              <label class="badge badge-success"> Approved </label>
            <?php }if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 1 && $paymentclose == 1) { ?>
              <label class="badge badge-voliet"> Completed </label>
            <?php } ?>
            <?php echo 'By-' . paymentprocessuser($dbconnection,$firstApproval,$secondApproval,$thirdApproval,$fourthApproval,$customerid,$payCode,$paymentclose); ?>
          </td>
          
        </tr>
        <?php } } ?>
    </tbody>
</table>