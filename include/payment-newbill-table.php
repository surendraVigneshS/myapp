<table class="display payment-table" id="">
    <thead>
        <tr class="text-center">
          <th>New Bill Upload</th>
        </tr>
    </thead>
    <tbody>
        <?php
        switch ($logged_admin_role) {
            case '4':
                //Account
                $customerselect = "SELECT * FROM `payment_request` LEFT JOIN `payment_pdf` ON `payment_pdf`.`pay_code` =  `payment_request`.`pay_code` WHERE `payment_request`.`balance_amount` = 0 AND `payment_request`.`balance_amount` <>''  AND `payment_request`.`close_pay` = 0 AND `payment_request`.`payment_against` = 3 AND `payment_pdf`.`uploaded_type`= 1";
            break;
            case '9':
                //Account
                $customerselect = "SELECT * FROM `payment_request` WHERE `balance_amount` = 0 AND `close_pay` = 0 AND `payment_against` = 3 AND ( `org_name`=2 OR `org_name`='Agem') ORDER BY `pay_id` DESC ";
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
            $remarks = $row['remarks'];
            $firstApproval = $row['first_approval'];
            $secondApproval = $row['second_approval'];
            $thirdApproval = $row['third_approval'];
            $fourthApproval = $row['fourth_approval'];
            $createdBY = $row['created_by'];
            $createdtime = $row['fourth_approval_time'];
        ?>
        <tr>
            <td>
                <a href="./edit-payment-request.php?platform=<?php echo randomString(45); ?>&action=editpayment&fieldid=<?php echo passwordEncryption($customerid) ?>" class="table-href-link">
                    <li class="d-flex justify-content-between align-items-center"><?php echo $payCode ?><b class="pl-1"><?php echo date("d-M-Y h:i A", strtotime($createdtime));  ?></b><span>Upload By <b><?php echo billupload($dbconnection,$payCode,$customerid,'2','Bill') ?></b></span><span class="badge badge-primary rounded-pill"><?php $uploadtime = billupload($dbconnection,$payCode,$customerid,'3','Bill'); echo timeAgo($uploadtime); ?></span><span class="badge badge-danger rounded-pill"><?php if(fetchData($dbconnection,'visit_status','user_visit','pay_id',$customerid) != 1){ echo 'New'; } ?></span></li>
                </a>
            </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>