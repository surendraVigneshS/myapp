<table class="display payment-table">
    <thead>
        <tr>
            <th>Created Time</th>
            <th>Reminder Date</th>
            <th>Created By</th>
            <th>Incharge Name</th>
            <th>Supplier Name</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $customerselect = "SELECT * FROM `remainder` LEFT JOIN `payment_request` ON `remainder`.`remainder_pay_id` = `payment_request`.`pay_id` WHERE remainder_date <= DATE_ADD(CURDATE(), INTERVAL 5 DAY) ORDER BY `remainder`.`id` DESC";
        $custoemrquery = mysqli_query($dbconnection, $customerselect);
        if (mysqli_num_rows($custoemrquery) > 0) {
            while ($row = mysqli_fetch_array($custoemrquery)) {
                $id = $row['id'];
                $createdBy = $row['remainder_created_by'];
                $supid = $row['remainder_supplier_id'];
                $reminderDate = date('d-M-Y', strtotime($row['remainder_date']));
                $createdTime = date('d-M-Y H:i A', strtotime($row['remainder_created_time']));
                $amount = $row['remainder_amount'];
                if ($row["remainder_type"] == 2) {$incharge_name = $row['incharge_name']; }else{ $incharge_name = getuserName($createdBy, $dbconnection); }
        ?>
                <tr>
                    <td><?php echo $createdTime;  ?></td>
                    <td><?php echo $reminderDate;  ?></td>
                    <td><?php echo getuserName($createdBy, $dbconnection);  ?></td>
                    <td><?php echo $incharge_name;  ?></td>
                    <td><?php echo fetchData($dbconnection, 'supplier_name', 'supplier_details', 'cust_id', $supid);  ?></td>
                    <td><?php echo IND_money_format($amount);  ?></td>
                    <td><a href="./edit-remainder.php?platform=<?php echo randomString(45); ?>&action=editpurchase&fieldid=<?php echo passwordEncryption($id) ?>" class="btn btn-primary btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="" data-bs-original-title="">Edit</a></td>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>