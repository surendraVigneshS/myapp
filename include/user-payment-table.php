<table class="display payment-table" id="basic-2">
    <thead>
        <tr>
          <th>Pay Code</th>
          <th>Incharge Name</th>
          <th>Company Name</th>
          <th>Amount</th>
          <th>Remarks</th>
          <th>Approval</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        switch ($logged_admin_role) {
            case '6':
                //Employee
                $customerselect = "SELECT * FROM `payment_request` WHERE `created_by` = '$logged_admin_id' ORDER BY `pay_id` DESC ";
            break;
            case '3':
              //Team Leader
              $customerselect = "SELECT * FROM `payment_request` WHERE `team_leader` = '$logged_admin_id' ORDER BY `pay_id` DESC ";
            break;
            case '4':
              //Account  
              $customerselect = "SELECT * FROM `payment_request` WHERE `second_approval` = 1 AND `third_approval` = 0 ORDER BY `pay_id` DESC ";
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
            $remarks = $row['remarks'];
            $firstApproval = $row['first_approval'];
            $secondApproval = $row['second_approval'];
            $thirdApproval = $row['third_approval'];
        ?>
        <tr>
          <td><?php echo $payCode  ?></td>
          <td><?php echo $incharge_name  ?></td>
          <td><?php echo $company_name ?></td>
          <td><?php echo $amount ?></td>
          <td><?php echo $remarks; ?></td>
          <td>
            <?php if (empty($firstApproval)) { ?>
              <label class="badge badge-info"> Pending </label>
            <?php }if ($firstApproval == 1 && $secondApproval != 1 && $secondApproval != 4) { ?>
              <label class="badge badge-warning"> On Processing </label>
            <?php }if ($firstApproval == 4 || $secondApproval == 4) { ?>
              <label class="badge badge-danger"> Cancel </label>
            <?php }if ($firstApproval == 1 && $secondApproval == 0) { ?>
              <label class="badge badge-info"> Waiting </label>
            <?php }if ($firstApproval == 1 && $secondApproval == 1) { ?>
              <label class="badge badge-success"> Approved </label>
            <?php } ?>
            <!-- <?php if(!empty(fetchPaymentStatus($dbconnection,$logged_admin_id)[2])){ echo  'By-'.getuserName(fetchPaymentStatus($dbconnection,$id)[2],$dbconnection);}     ?> -->
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