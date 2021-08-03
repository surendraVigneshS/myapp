<table class="display payment-table" id="">
    <thead>
        <tr> 
            <th>Completed Date</th>
            <th>Purchase Code</th>
            <th>Incharge Name</th>
            <th>Organization Name</th>
            <th>Company Name</th>
            <th>Project Title</th>
            <th>Amount</th>
            <th>Purchase Type</th>
            <th>Priority</th>
            <th>Approval</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $slno = 1; 
        $customerselect = "SELECT * FROM `purchase_request` WHERE  `completed` = 1   ORDER BY `pur_id` DESC";
        switch ($logged_admin_role) {
            case '6':
                // user
                $customerselect = "SELECT * FROM `purchase_request` WHERE  `created_by` = '$logged_admin_id' AND `completed` = 1 ORDER BY `pur_id` DESC";
                $editlink = "";
                break; 
                
            
          case '3':
            // TL
            $customerselect = "SELECT * FROM `purchase_request` WHERE (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND `completed` = 1 ORDER BY `pur_id` DESC";
            $editlink = "";
            break;     
        case '9':
            // TL
            $customerselect = "SELECT * FROM `purchase_request` WHERE (`org_name` = '2' OR `org_name` = 'Agem') AND `completed` = 1 ORDER BY `pur_id` DESC";
            $editlink = "";
            break;     
            
        }
        
        $custoemrquery = mysqli_query($dbconnection, $customerselect);
        if (mysqli_num_rows($custoemrquery) > 0) {
            while ($row = mysqli_fetch_array($custoemrquery)) {
                $id = $row['pur_id'];
                $pur_code = $row['purchase_code'];
                $incharge_name = $row['pr_name'];
                $company_name = $row['pr_supplier_id'];
                $project_title = $row['pr_project_id'];
                if($row['already_purchased'] == 0){
                    $purchaseType = 'Not Yet Purchased';
                    $amount = $row['advance_amount'];
                    
                }else{
                    $purchaseType = 'Purchased List';
                    $amount = $row['total_amount']; 
                }
                $orgName = $row['org_name'];
            if (is_numeric($orgName)){
              $orgName = fetchData($dbconnection,'organization_name','organization','id',$orgName);
            }
                  
            ?>
                <tr> 
                    <td><?php echo $newDate = date('d-M-Y h:i A', strtotime($row['completed_time'])); ?></td>
                    <td><?php echo $row["purchase_code"]  ?></td>
                    <td><?php echo $incharge_name  ?></td>
                    <td><?php echo $orgName  ?></td>
                    <td><?php echo $company_name ?></td>
                    <td><?php echo $project_title ?></td>
                    <td><?php echo IND_money_format($amount) ?></td>
                    <td><?php echo $purchaseType ?></td>
                    <td><?php echo $row['purchase_type'] ?></td>
                    <td>
                        <label class="badge <?php echo fetchPurchaseStatus($dbconnection,$id)[0]; ?>"> <?php echo fetchPurchaseStatus($dbconnection,$id)[1]; ?></label> <br>
                        <?php if (!empty(fetchPurchaseStatus($dbconnection,$id)[2])) {
                            echo  'By-'.fetchPurchaseStatus($dbconnection,$id)[2];
                        }     
                        ?>
                    </td>
                    <td><a href="./edit-purchase-request.php?platform=<?php echo randomString(45); ?>&action=editpurchase&fieldid=<?php echo passwordEncryption($id) ?>" class="btn btn-primary btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="" data-bs-original-title="">Edit</a></td>
                </tr>
        <?php } } ?>
    </tbody>
</table> 