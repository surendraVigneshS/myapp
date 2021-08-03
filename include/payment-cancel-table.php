<table class="display payment-table" id="">
    <thead>
        <tr>
          <th>Cancelled Date</th>
          <th>Incharge Name</th>
          <th>Organization Name</th>
          <th>Company Name</th>
          <th>Amount</th>
          <th>Remarks</th> 
          <th>Feedback</th>
          <th>Priority</th>
          <th>Payment Against</th>
          <th>Approval</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        switch ($logged_admin_role) {
            case '6':
                //Employee
                $customerselect = "SELECT * FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND (`user_cancel` = 4 OR `first_approval` = 4 OR `orglead_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) ORDER BY `pay_id` DESC ";
            break;
            case '3':
            case '10':
              //Team Leader
              $customerselect = "SELECT * FROM `payment_request` WHERE (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND (`first_approval` = 4 OR `orglead_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) ORDER BY `pay_id` DESC ";
            break;
            case '4':
              //Finance  
              $customerselect = "SELECT * FROM `payment_request` WHERE (`user_cancel` = 4 OR `first_approval` = 4 OR `orglead_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) ORDER BY `pay_id` DESC ";
            break;
            case '5':
              //Purchase Team  
              $customerselect = "SELECT * FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND (`first_approval` = 4 OR `orglead_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) ORDER BY `pay_id` DESC ";
            break;
            case '7':
              //Purchase Lead 
              $customerselect = "SELECT * FROM `payment_request` WHERE `raised_by` = 2 AND (`first_approval` = 4 OR `orglead_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) ORDER BY `pay_id` DESC ";
            break;
            case '1':
              //Admin  
              $customerselect = "SELECT * FROM `payment_request` WHERE (`user_cancel` = 4 OR `first_approval` = 4 OR `orglead_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) ORDER BY `pay_id` DESC ";
            break;
            case '8':
              //Accounts 
              $customerselect = "SELECT * FROM `payment_request` WHERE (`first_approval` = 4 OR `orglead_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) ORDER BY `pay_id` DESC ";
            break;
            case '9':
              //AGEM Accounts 
              $customerselect = "SELECT * FROM `payment_request` WHERE (`first_approval` = 4 OR `orglead_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) AND ( `org_name`=2 OR `org_name`='Agem')  ORDER BY `pay_id` DESC ";
            break;
            case '11':
              // Organzation Lead
              $customerselect = "SELECT * FROM `payment_request` WHERE (`created_by` = '$logged_admin_id' OR `org_name`= '$logged_admin_org') AND (`first_approval` = 4 OR `orglead_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4)  ORDER BY `pay_id` DESC ";
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
            $userCancel = $row['user_cancel'];
            $firstApproval = $row['first_approval'];
            $secondApproval = $row['second_approval'];
            $thirdApproval = $row['third_approval'];
            $fourthApproval = $row['fourth_approval'];
            if($userCancel == 4){
              $createdtime = $row['user_cancel_time'];
            }
            if($firstApproval == 4){
                $createdtime = $row['first_approval_time'];
            }if($secondApproval == 4){
                $createdtime = $row['second_approval_time'];
            }if($thirdApproval == 4){
                $createdtime = $row['third_approval_time'];
            }if($fourthApproval == 4){
                $createdtime = $row['fourth_approval_time'];
            }
            $paymentclose = $row['close_pay'];

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
          <td>
            <?php if($logged_admin_role != 2){ ?>
              <a href="./edit-payment-request.php?platform=<?php echo randomString(45); ?>&action=editpayment&fieldid=<?php echo passwordEncryption($customerid) ?>" class="btn btn-primary btn-xs" type="button">Edit</a>
            <?php } ?>
          </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>