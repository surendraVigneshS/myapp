<div class="card-body">
    <div class="row">
        <div class="col-md-12 m-b-30">
            <?php if ($logged_admin_role == 6) { ?>
                <a href="new-purchase.php"> <button class="btn btn-primary f-right" type="button" title="" data-bs-original-title="btn btn-pill btn-primary" data-original-title="btn btn-pill btn-primary">New Purchase Request</button></a>
            <?php } ?>
        </div>
    </div>
    <div class="table-responsive">
        <table class="display" id="basic-2">
            <thead>
                <tr> 
                    <th>Purchase Code</th>
                    <th>Incharge Name</th>
                    <th>Company Name</th>
                    <th>Project Title</th>
                    <th>Approval</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $slno = 1; 
                switch ($logged_admin_role) {
                    case '6':
                        // user
                        $customerselect = "SELECT * FROM `purchase_request` WHERE `created_by` = '$logged_admin_id'  ORDER BY `pur_id` DESC";
                        $editlink = "";
                        break;
                    case '5':
                        // Purchase Team 
                        $customerselect = "SELECT * FROM `purchase_request` WHERE (`first_approval` = 0 OR `first_approval` = 4 OR `first_approval` = 1)  ORDER BY `pur_id` DESC";
                        $editlink = "";
                        break;
                    case '2':
                        // MD
                        $customerselect = "SELECT * FROM `purchase_request` WHERE (`first_approval` = 1 AND  `second_approval` = 0) ORDER BY `pur_id` DESC";
                        $editlink = "";
                        break;
                    case '4':
                        // Accounts
                        $customerselect = "SELECT * FROM `purchase_request` WHERE (`first_approval` =1 AND `second_approval` = 1 AND  `third_approval` = 0 OR `third_approval` = 1 OR `third_approval` = 4)  ORDER BY `pur_id` DESC";
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
                        $project_title = $row['project_title']; 
                    ?>
                        <tr> 
                            <td><?php echo $pur_code ?></td>
                            <td><?php echo $incharge_name  ?></td>
                            <td><?php echo $company_name ?></td>
                            <td><?php echo $project_title ?></td>
                            <td>
                                <label class="badge <?php echo fetchPurchaseStatus($dbconnection, $id)[0]; ?>"> <?php echo fetchPurchaseStatus($dbconnection, $id)[1]; ?></label> <br>
                                <?php if (!empty(fetchPurchaseStatus($dbconnection, $id)[2])) {
                                    echo  'By-' . getuserName(fetchPurchaseStatus($dbconnection, $id)[2], $dbconnection);
                                }     
                                ?>
                            </td>
                            <td><a href="./edit-purchase-request.php?platform=<?php echo randomString(45); ?>&action=editpurchase&fieldid=<?php echo passwordEncryption($id) ?>" class="btn btn-primary btn-xs" type="button" data-original-title="btn btn-danger btn-xs" title="" data-bs-original-title="">Edit</a></td>
                        </tr>
                <?php   }
                } ?>
            </tbody>
        </table>
    </div>
</div>