<table class="display payment-table" id="exportExpenditureMonthTable">
    <thead>
        <tr>
            <th>Created Time</th>
            <th>Expense Name</th>
            <th>Created By</th>
            <th>Expense Amount</th>
            <th>Credit Left</th>
            <th>File Attachment</th>
            <th data-exclude="true">Approval</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $customerselect = "SELECT * FROM `expenditures` WHERE `exp_created_by` ='$logged_admin_id' ORDER BY `exp_id` DESC ";
        $custoemrquery = mysqli_query($dbconnection, $customerselect);
        if (mysqli_num_rows($custoemrquery) > 0) {
            while ($row = mysqli_fetch_array($custoemrquery)) {
                $exp_name = $row['exp_name'];
                $createdTime = date('d-M-Y H:i A', strtotime($row['exp_created_time']));
                $amount = $row['exp_amount'];
                $createdBy = $row['exp_created_by'];
                $fileAttach = $row['exp_files'];
                $creditLeft = $row['exp_credit_left'];
                $filePath = "https://www.vencar.in/accounts/assets/pdf/expenditure/";
                $approval1 = $row['exp_approval_1'];
                $approval1_by = $row['exp_approval1_by'];
        ?>
                <tr>
                    <td><?php echo $createdTime;  ?></td>
                    <td><?php echo $exp_name;  ?></td>
                    <td><?php echo getuserName($createdBy, $dbconnection);  ?></td>
                    <td><?php echo IND_money_format($amount);  ?></td>
                    <td><?php echo IND_money_format($creditLeft);  ?></td>
                    <td>
                        <?php if (!empty($fileAttach)) { ?>
                            <a href="<?php echo $filePath . $fileAttach; ?>" target="_blank" class="btn btn-info btn-xs">View File</a>
                        <?php } else {
                            echo 'No File Attached';
                        } ?>
                    </td>
                    <td data-exclude="true">
                        <?php if (empty($approval1)) { ?>
                            <label class="badge badge-primary">Pending</label> <br>
                            By - M.D
                        <?php } else { ?>
                            <?php if($approval1_by == 2){ ?>
                            <label class="badge badge-success">Approved</label> <br>
                            By - M.D
                            <?php }if($approval1_by == 4){ ?>
                            <label class="badge badge-success">Approved</label> <br>
                            By - Finance
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>