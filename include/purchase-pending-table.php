<table class="display payment-table" id="">
    <thead>
        <tr> 
            <th>Created Date</th>
            <th>Purchase Code</th>
            <th>Incharge Name</th>
            <th>Organization Name</th>
            <th>Company Name</th>
            <th>Project Title</th>
            <th>Purchase Type</th>
            <th>Priority</th>
            <th>Approval</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $slno = 1; 
        $customerselect = "SELECT * FROM `purchase_request` WHERE `first_approval` = 0 AND `orglead_approval` = 2 ORDER BY `pur_id` DESC";
        switch ($logged_admin_role) {
            case '6':
                $customerselect = "SELECT * FROM `purchase_request` WHERE  `created_by` = '$logged_admin_id' AND `orglead_approval` = 2 AND `first_approval` = 0 ORDER BY `pur_id` DESC";
                $editlink = "";
            break; 
            case '3':
                // TL
                $customerselect = "SELECT * FROM `purchase_request` WHERE  (`created_by` = '$logged_admin_id' OR `team_leader` = '$logged_admin_id') AND `orglead_approval` = 2 AND `org_name` = 1 AND `first_approval` = 0 ORDER BY `pur_id` DESC";
                $editlink = "";
                break;     
            case '9':
                // Finance
                $customerselect = "SELECT * FROM `purchase_request` WHERE  (`org_name` = '2' OR `org_name` = 'Agem') AND `orglead_approval` = 2 AND `first_approval` = 0 ORDER BY `pur_id` DESC";
                $editlink = "";
                break; 
            case '11':
                // OL
                $customerselect = "SELECT * FROM `purchase_request` WHERE (`created_by` = '$logged_admin_id' OR `org_name` = '$logged_admin_org') AND `orglead_approval` = 2 AND `first_approval` = 0 ORDER BY `pur_id` DESC";
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
                }else{
                    $purchaseType = 'Purchased List';

                }
                $orgId = $row['org_name'];
                $leadApproval = $row['orglead_approval'];
                if(is_numeric($orgId)){
                    $orgColor = fetchData($dbconnection,'org_color','organization','id',$orgId);
                  }else{
                    $orgColor = fetchData($dbconnection,'org_color','organization','id',3);
                }
                if(is_numeric($orgId)){
                    $orgName = fetchData($dbconnection,'organization_name','organization','id',$orgId);
                }else{
                    $orgName = $row['org_name'];
                }
                  
            ?>
                <tr style="color: <?php echo $orgColor ?>;" class="fw-500"> 
                    <td><?php echo $newDate = date('d-M-Y h:i A', strtotime($row['created_date'])); ?></td>
                    <td><?php echo $row["purchase_code"]  ?></td>
                    <td><?php echo $incharge_name  ?></td>
                    <td><?php echo $orgName   ?></td>
                    <td><?php echo fetchData($dbconnection,'supplier_name','supplier_details','cust_id',$company_name); ?></td>
                    <td><?php echo fetchData($dbconnection,'project_title','ft_projects_tb','project_id',$project_title); ?></td> 
                    <td><?php echo $purchaseType ?></td>
                    <td><?php echo $row['purchase_type'] ?></td>
                    <td>
                        <?php if($orgId == 1){ ?>
                        <label class="badge <?php echo fetchPurchaseStatus($dbconnection,$id)[0]; ?>"> <?php echo fetchPurchaseStatus($dbconnection,$id)[1]; ?></label> <br>
                        <?php if (!empty(fetchPurchaseStatus($dbconnection,$id)[2])) {
                            echo  'By-'.fetchPurchaseStatus($dbconnection,$id)[2];
                        }else{
                            echo  'By-'.fetchData($dbconnection,'created_by','purchase_request','pur_id',$id);
                        }     
                        ?>
                        <?php }if($leadApproval == 2 && $orgId != 1){ ?>
                        <label class="badge badge-primary">Pending</label> <br>
                        By- Organzation Lead
                        <?php }else if($leadApproval == 1 && $orgId != 1){ ?>
                            <label class="badge badge-info">Pending</label> <br>
                        By- MD
                        <?php } ?>
                    </td>
                    <td>
                    <a href="./edit-purchase-request.php?platform=<?php echo randomString(45); ?>&action=editpurchase&fieldid=<?php echo passwordEncryption($id) ?>" class="btn btn-primary btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="" data-bs-original-title="">Edit</a>
                    </td>
                </tr>
        <?php } } ?>
    </tbody>
</table>