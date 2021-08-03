<table class="display payment-table" id="">
    <thead>
        <tr>
            <th>Created Time</th>
            <th>Expense Name</th>
            <th>Created By</th>
            <th>Expense Amount</th>
            <th>Credit Left</th>
            <th>File Attachment</th>
            <th>Approved Time</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        switch ($logged_admin_role) {
            case '2':
              //MD
              $customerselect = "SELECT * FROM `expenditures` WHERE `exp_approval_1` = 1 AND `exp_approval1_by` = '$logged_admin_id' ORDER BY `exp_id` DESC ";
            break;
            case '4':
              //Finance
              $customerselect = "SELECT * FROM `expenditures` WHERE `exp_approval_1` = 1 AND `exp_approval1_by` = '$logged_admin_id' ORDER BY `exp_id` DESC";
            break;
        }
        $custoemrquery = mysqli_query($dbconnection, $customerselect); 
        if (mysqli_num_rows($custoemrquery) > 0) { 
            while ($row = mysqli_fetch_array($custoemrquery)) { 
                $exp_name = $row['exp_name'];  
                $amount = $row['exp_amount'];
                $createdBy = $row['exp_created_by'];
                $fileAttach = $row['exp_files'];
                $creditLeft = $row['exp_credit_left'];
                $filePath = "./assets/pdf/expenditure/";
                $createdTime = date('d-M-Y H:i A', strtotime($row['exp_created_time']));
                $approvedTime = date('d-M-Y H:i A', strtotime($row['exp_approval1_time']));
        ?> 
                <tr>
                    <td><?php echo $createdTime;  ?></td>
                    <td><?php echo $exp_name;  ?></td>
                    <td><?php echo getuserName($createdBy, $dbconnection);  ?></td>  
                    <td><?php echo IND_money_format($amount);  ?></td>
                    <td><?php echo IND_money_format($creditLeft);  ?></td>
                    <td>
                    <?php if(!empty($fileAttach)){ ?>
                        <a href="<?php echo $filePath.$fileAttach; ?>" target="_blank" class="btn btn-info btn-xs">View File</a> 
                        <?php }else{
                            echo 'No File Attached';
                        } ?> 
                    </td> 
                    <td><?php echo $approvedTime;  ?></td>
                </tr>
        <?php } } ?>
    </tbody>
</table>