<table class="display payment-table" id="expensitureCloseTable">
    <thead>
        <tr>
          <th>Created Date</th>
          <th>Created BY</th>
          <th>Bill No</th>
          <th>UTR No</th>
          <th>Upload File</th>
          <th>Approval</th>
          <?php if($logged_admin_role != 6){ ?>
          <th>Action</th>
          <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $customerid = $customerselect="";
        switch ($logged_admin_role) {
            case '6':
            case '5':
              //Employee
              $customerselect = "SELECT * FROM `close_expenditure` WHERE `created_by` = '$logged_admin_id' ORDER BY `close_ID` DESC ";
            break;
            case '3':
            case '10':
              //Team Leader // Reminder Team
              $customerselect = "SELECT * FROM `close_expenditure` WHERE (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND `org_name` = 1 AND `raised_by` = 1 AND `approve_status` = 0 ORDER BY `close_ID` DESC";
            break;
            case '4':
              //Finance
              $customerselect = "SELECT * FROM `close_expenditure` WHERE `created_by` = '$logged_admin_id' OR `approve_status` = 3 ORDER BY `close_ID` DESC ";
              
            break;
            case '7':
              //Purchase Leader  
              $customerselect = "SELECT * FROM `close_expenditure` WHERE (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND `org_name` = 1 AND `raised_by` = 2 ORDER BY `close_ID` DESC ";
            break;
            case '1':
              //Admin  
              $customerselect = "SELECT * FROM `close_expenditure` ORDER BY `close_ID` DESC ";
            break;
            case '8':
              //Accounts  
              $customerselect = "SELECT * FROM `close_expenditure` WHERE `created_by` = '$logged_admin_id' OR `approve_status` = 2 ORDER BY `close_ID` DESC ";
            break;
            case '9':
              //AGEM Accounts  
              $customerselect = "SELECT * FROM `close_expenditure` WHERE `created_by` = '$logged_admin_id' AND ( `org_name`=2 OR `org_name`='Agem') AND `approve_status` = 3 ORDER BY `close_ID` DESC ";
            break; 
            case '11':
               // Organzation Lead
               $customerselect = "SELECT * FROM `close_expenditure` WHERE (`org_name` = '$logged_admin_org' OR `created_by` = '$logged_admin_id') AND `approve_status` = 0 ORDER BY `close_ID` DESC ";
            break;
            case '2':
                // MD
                $customerselect = "SELECT * FROM `close_expenditure` WHERE `approve_status` = 1 OR `approve_status` = 2 ORDER BY `close_ID` DESC ";
             break;
        }
        $custoemrquery = mysqli_query($dbconnection, $customerselect);
        if (mysqli_num_rows($custoemrquery) > 0) {
          while ($row = mysqli_fetch_array($custoemrquery)) {
            $closeid = $row['close_ID'];
            $billno = $row['bill_no'];
            $createdid = $row['created_by'];
            $createdname = fetchData($dbconnection,'emp_name','admin_login','emp_id',$createdid);
            $utrno = $row['UTR_no'];
            $target_dir = "./assets/pdf/expenditure/";
            $file = $row['upload_file'];
            $createdtime = $row['created_date'];
            $orgid = $row['org_name'];
            $status = $row['approve_status'];
            if (is_numeric($orgName)){
              $orgName = fetchData($dbconnection,'organization_name','organization','id',$orgName);
            }
        ?>
        <tr>
            <td><?php echo date("d-M-Y h:i A", strtotime($createdtime));  ?></td>
            <td><?php echo $createdname  ?></td>
            <td><?php echo $billno  ?></td>
            <td><?php echo $utrno ?></td>
            <td <?php if(!empty($file)){ ?> data-hyperlink="<?php echo $target_dir.$file ?>" <?php }?>> 
                <?php if(!empty($file)){ ?>
                  <a href="<?php echo $target_dir.$file ?>" target="_blank" class="btn btn-info btn-xs">View File</a> 
                <?php }else  {
                  echo 'No File';
              } ?>
            </td>
            <td>
                <?php if($status == 0){ ?>
                    <label class="badge badge-primary"> Pending </label>
                    <?php if($orgName == 1){ echo 'By-' . 'Team Leader'; }else{ echo 'By-' . 'Org Leader'; } ?>
                <?php }if($status == 1){ ?>
                    <label class="badge badge-primary"> Pending </label> 
                    <?php echo 'By-' . 'MD'; ?>
                <?php }if($status == 2){ ?>
                    <label class="badge badge-primary"> Pending </label> 
                    <?php echo 'By-' . 'MD'; ?>
                <?php }if($status == 3){ ?>
                    <label class="badge badge-primary"> Pending </label> 
                    <?php echo 'By-' . 'Finance Team'; ?>
                <?php  }if($status == 4){ ?>
                    <label class="badge badge-success"> Approved </label>
                    <?php echo 'By-' . 'Finance Team'; ?>
                <?php } ?>
            </td>
            <?php if($logged_admin_role != 6){ ?>
            <td>
                <?php if(($logged_admin_role == 11 || $logged_admin_role == 3) && $status == 0){ ?>
                <button type="button" class="btn btn-success my-1" id="expenditureBtn" onclick="approveExpenditure(<?php echo $closeid; ?>,<?php echo $logged_admin_id; ?>,<?php echo $logged_admin_role; ?>)"> Approve </button>
                <?php } ?>
                <?php if(($status == 2 || $status == 1) && $logged_admin_role == 2){ ?>
                <button type="button" class="btn btn-success my-1" id="expenditureBtn" onclick="approveExpenditure(<?php echo $closeid; ?>,<?php echo $logged_admin_id; ?>,<?php echo $logged_admin_role; ?>)"> Approve </button>
                <?php } ?>
                <?php if($logged_admin_role == 4 && $status == 3){ ?>
                <button type="button" class="btn btn-success my-1" id="expenditureBtn" onclick="approveExpenditure(<?php echo $closeid; ?>,<?php echo $logged_admin_id; ?>,<?php echo $logged_admin_role; ?>)"> Approve </button>
                <?php } ?>
            </td>
            <?php } ?>
        </tr>
        <?php } } ?>
    </tbody>
</table>