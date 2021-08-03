<table class="display payment-table" id="expotusersAllTable">
    <thead>
        <tr> 
            <th data-exclude="true">Delete</th>
            <th data-exclude="true">Edit</th> 
            <th>Purchase Code</th>
            <th>Incharge Name</th>
            <th>Organization Name</th>
            <th>Supplier Name</th>  
            <th>Project Title</th>
            <th>Purchase Type</th>
            <th>Priority</th>
            <th>Status</th>
            <th>PO NO</th>
            <th>PO File</th>
            <th>Bill No</th>
            <th>Bill File</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        $slno = 1; 
        $uploadedPO = 'https://www.vencar.in/accounts/assets/pdf/purchase/';

        $customerselect = "SELECT * FROM `purchase_request` ORDER BY `pur_id` DESC";
        switch ($logged_admin_role) {
            case '6': 
                $customerselect = "SELECT * FROM `purchase_request` WHERE  `created_by` = '$logged_admin_id' ORDER BY `pur_id` DESC"; 
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
                
            $orgName = $row['org_name'];
            if (is_numeric($orgName)){
              $orgName = fetchData($dbconnection,'organization_name','organization','id',$orgName);
            }
                  
                $purchaseStatusText =fetchPurchaseStatus($dbconnection, $id)[1];
                switch ($purchaseStatusText) {
                    case 'Pending':
                        $newDate = date('d-M-Y h:i A', strtotime($row['created_date']));
                        break;
                case 'Processed':
                    $newDate = date('d-M-Y h:i A', strtotime($row['frist_approval_time']));
                    break;
                case 'Approved':
                    $newDate = date('d-M-Y h:i A', strtotime($row['second_approval_time']));
                    break; 
                case 'Completed':
                    $newDate = date('d-M-Y h:i A', strtotime($row['completed_time']));
                    break; 
                case 'Cancelled':
                    $newDate = date('d-M-Y h:i A', strtotime($row['cancelled_time']));
                    break; 
                    }
                    if($row['already_purchased'] == 0){
                        $purchaseType = 'Not Yet Purchased';
                    }else{
                        $purchaseType = 'Purchased List';
    
                    } 
            ?>
                <tr> 
                <td data-exclude="true"><button class="btn btn-danger btn-xs" type="button"  onclick="deletePurchaseAdmin(this, <?php echo $id;  ?> , <?php echo $logged_admin_id; ?>  , <?php echo $logged_admin_role; ?>)" >Delete</button></td>
                    <td data-exclude="true"><a href="./edit-purchase-request.php?platform=<?php echo randomString(45); ?>&action=editpurchase&fieldid=<?php echo passwordEncryption($id) ?>" class="btn btn-primary btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="" data-bs-original-title="">Edit</a></td> 
                    <td><?php echo $row["purchase_code"]  ?></td>
                    <td><?php echo $incharge_name  ?></td>
                    <td><?php echo $orgName  ?></td> 
                    <td><?php echo fetchData($dbconnection,'supplier_name','supplier_details','cust_id',$company_name); ?></td>
                    <td><?php echo fetchData($dbconnection,'project_title','ft_projects_tb','project_id',$project_title); ?></td> 
                    <td><?php echo $purchaseType ?></td>
                    <td><?php echo $row['purchase_type'] ?></td>
                    <td>
                        <label class="badge <?php echo fetchPurchaseStatus($dbconnection, $id)[0]; ?>"> 
                            <?php echo fetchPurchaseStatus($dbconnection, $id)[1]; ?>
                        </label><br>
                        <?php if (!empty(fetchPurchaseStatus($dbconnection, $id)[2])) { echo  'By-' . getuserName(fetchPurchaseStatus($dbconnection, $id)[2], $dbconnection); }else{
                            echo  'By-'.fetchData($dbconnection,'created_by','purchase_request','pur_id',$id);
                        } ?>
                    </td>
                    <td><?php echo $row['po_no'] ?></td>
                    <td <?php if(!empty($row['po_file'])){ ?> data-hyperlink="<?php echo $uploadedPO.$row['po_file'] ?>" <?php }?>>
                    <?php if(!empty($row['po_file'])){ ?>
                        <a href="<?php echo $uploadedPO.$row['po_file'] ?>" target="_blank" class="btn btn-info btn-xs"   >View PO</a> 
                        <?php }else{
                            echo 'No PO File';
                        } ?>
                    </td>
                    <td><?php echo $row['bill_no'] ?></td>
                    <td  <?php if(!empty($row['bill_file'])){ ?> data-hyperlink="<?php echo $uploadedPO.$row['bill_file'] ?>" <?php }?>> 
                    <?php if(!empty($row['bill_file'])){ ?>
                        <a href="<?php echo $uploadedPO.$row['bill_file'] ?>" class="btn btn-info btn-xs"   target="_blank" >View Bill</a> 
                        <?php }else  {
                            echo 'No Bill File';
                        } ?>
                        </td>
                    
                </tr>
        <?php } } ?>
    </tbody>
</table> 