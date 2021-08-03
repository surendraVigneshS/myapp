<table class="display payment-table" id="">
    <thead>
        <tr> 
            <th>Processed Date</th>
            <th>Beneficiary</th>
            <th>Project</th>
             <th>Amount</th> 
            <th>Incharge Name</th>
            <th>Purchase Type</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $slno = 1; 
        $customerselect = "SELECT * FROM `purchase_request` WHERE `second_approval` =1 AND  `completed` = 0 ORDER BY `pur_id` DESC";           
        $custoemrquery = mysqli_query($dbconnection, $customerselect);
        if (mysqli_num_rows($custoemrquery) > 0) 
        {
            while ($row = mysqli_fetch_array($custoemrquery)) 
            {
            $newDate = date(' d-M-Y h:i A', strtotime($row['second_approval_time']));
            $id = $row['pur_id'];
            $pur_code = $row['purchase_code'];
            $supplier_name = $row['supplier_name'];
            $incharge_name = $row['pr_name'];
            $company_name = $row['pr_supplier_id'];
                $project_title = $row['pr_project_id'];
            if($row['already_purchased'] == 0){
                $amount = $row['advance_amount'];
            }else if($row['already_purchased'] == 1){
                $amount = $row['total_amount'];
            }
            
                 
    ?>
        <tr> 
            <td><?php echo $newDate ?></td>
            <td><?php echo fetchData($dbconnection,'supplier_name','supplier_details','cust_id',$company_name); ?></td>
                    <td><?php echo fetchData($dbconnection,'project_title','ft_projects_tb','project_id',$project_title); ?></td> 
             <td><?php echo '₹ '.IND_money_format($amount); ?></td> 
            <td><?php echo $incharge_name ?></td>
            <td><?php echo $company_name ?></td>
            <td>
                <label class="badge <?php echo fetchPurchaseStatus($dbconnection, $id)[0]; ?>"> <?php echo fetchPurchaseStatus($dbconnection, $id)[1]; ?></label> <br>
                <?php if (!empty(fetchPurchaseStatus($dbconnection, $id)[2])) {
                    echo  'By-' . getuserName(fetchPurchaseStatus($dbconnection, $id)[2], $dbconnection);
                }     
                ?>
            </td> 
        </tr>
        <?php } } ?>
    </tbody>
</table>