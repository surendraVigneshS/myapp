<table class="display payment-table" id="">
    <thead>
        <tr>
            <th>Action</th>
            <th>Created Time</th>
            <th>Expense Name</th>
            <th>Created By</th>
            <th>Expense Amount</th>
            <th>Credit Left</th>
            <th>File Attachment</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        $customerselect = "SELECT * FROM `expenditures` WHERE `exp_approval_1` = 0  ORDER BY `exp_id` DESC  ";
        $custoemrquery = mysqli_query($dbconnection, $customerselect); 
        if (mysqli_num_rows($custoemrquery) > 0) { 
            while ($row = mysqli_fetch_array($custoemrquery)) { 

                $id = $row['exp_id'];  
                $exp_name = $row['exp_name'];  
                $createdTime = date('d-M-Y H:i A', strtotime($row['exp_created_time']));
                $amount = $row['exp_amount'];
                $createdBy = $row['exp_created_by'];
                $fileAttach = $row['exp_files'];
                $creditLeft = $row['exp_credit_left'];
                $filePath = "./assets/pdf/expenditure/";
        ?> 
                <tr>
                <td>
                <button id="approveExp" onclick="approveExp(<?php echo $id; ?> , <?php echo $logged_admin_id; ?>)" class="btn btn-success btn-lg completeexp" type="button">Approve Expense</button>
                </td>
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
                </tr>
        <?php }
        } ?>
    </tbody>
</table>