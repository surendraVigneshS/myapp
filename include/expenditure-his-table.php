<table class="display payment-table text-center" id="exportExpenditureHistoryTable">
    <thead>
        <tr>
            <th>Month</th>
            <th>Total Expense Count</th>
            <th>Total Expense Amount</th>
            <th>Total Credit Left</th>
            <th>View Full List</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $customerselect = "SELECT SUM(`exp_amount`) AS totalMonthExp , COUNT(*) AS totalexpCount ,SUM(`exp_credit_left`) AS totalcreditLeft , `exp_month` FROM `expenditures` WHERE `exp_created_by` ='$logged_admin_id'  GROUP BY MONTH(`exp_month`)";
        $custoemrquery = mysqli_query($dbconnection, $customerselect);
        if (mysqli_num_rows($custoemrquery) > 0) {
            while ($row = mysqli_fetch_array($custoemrquery)) {
                $totalMonthExp = $row['totalMonthExp'];
                $totalcreditLeft = $row['totalcreditLeft'];
                $monthName = date('F-Y', strtotime($row['exp_month']));
        ?>
                <tr>
                    <td><?php echo $monthName;  ?></td>
                    <td><?php echo $row["totalexpCount"].' - Expenses';  ?></td>
                    <td><?php echo IND_money_format($totalMonthExp);  ?></td>
                    <td><?php echo IND_money_format(expenditureMonthLeft($row['exp_month'],$dbconnection));  ?></td>
                    <td> 
                    <a href="./view-full-history.php?platform=<?php echo randomString(45); ?>&action=editpurchase&fieldid=<?php echo passwordEncryption($row['exp_month']) ?>" class="btn btn-primary btn-xs" type="button" data-original-title="btn btn-danger" title="" data-bs-original-title="">View Full List</a>
                    </td>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>