<table class="display payment-table" id="">
    <thead>
        <tr class="text-center">
          <th>New Feedback</th>
        </tr>
    </thead>
    <tbody>
        <?php
        switch ($logged_admin_role) {
            case '6':
                //Employee
                $customerselect = "SELECT * FROM `message` WHERE `sender` != 6 AND `trigger_to` = '$logged_admin_id' ORDER BY `pay_id` DESC ";
            break;
        }
        $custoemrquery = mysqli_query($dbconnection, $customerselect);
        if (mysqli_num_rows($custoemrquery) > 0) {
          while ($row = mysqli_fetch_array($custoemrquery)) {
            $slno = $row['sl_no'];
            $message = $row['message_content'];
            $sendfrom = $row['trigger_from'];
            $sendtime = $row['trigger_from_time'];
            $sender = $row['sender'];
            $payCode = $row['pay_code'];
            $customerid = $row['pay_id'];
        ?>
        <tr>
            <td>
                <a href="./edit-payment-request.php?platform=<?php echo randomString(45); ?>&action=editpayment&fieldid=<?php echo passwordEncryption($customerid) ?>" class="table-href-link">
                    <li class="d-flex justify-content-between align-items-center">
                            <b class="pl-1"><?php echo date("d-M-Y h:i A", strtotime($sendtime));  ?></b>
                            <span><b><?php echo  fetchData($dbconnection,'company_name','payment_request','pay_code',$payCode); ?></b></span>
                            <span>Message From <b><?php echo messageby($dbconnection,$slno) ?></b></span>
                            <span class="badge badge-primary rounded-pill"><?php echo timeAgo($sendtime); ?></span>
                            <span class="badge badge-danger rounded-pill"><?php if(fetchData($dbconnection,'visit_status','user_visit','pay_id',$customerid) != 1){ echo 'New'; } ?></span>
                    </li>
                </a>
            </td>
        </tr>
        <?php } } ?>
    </tbody>
</table>