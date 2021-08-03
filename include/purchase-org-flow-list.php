<div class="table-responsive">
    <table class="display payment-table" id="">
        <thead>
            <tr>
                <th>Organization No</th>
                <th>Organization Name</th> 
                <th>Organization Flow</th> 
                <th>Action</th> 
            </tr>
        </thead>
        <tbody>
            <?php
                $customerselect = "SELECT * FROM  `organization` WHERE `organization_name` != 'Other' ORDER BY `id` ASC  ";
                $custoemrquery = mysqli_query($dbconnection, $customerselect);
                if (mysqli_num_rows($custoemrquery) > 0) {
                    $slno= 1;
                while ($row = mysqli_fetch_array($custoemrquery)){
                  $orgId = $row['id'];
                  $orgName = $row['organization_name'];  
                  $orgFlow = $row['org_flow'];
                  $orgColor = $row['org_color'];
                  $flow1 = $row['purchase_orglead_approval'];
                  $flow2 = $row['purchase_fisrt_approval'];
                  $flow3 = $row['purchase_second_approval'];
            ?>
                <tr>
                <td><?php echo $slno  ?></td>
                <td style="color: <?php echo $orgColor ?>;font-weight:550"><?php echo $orgName  ?></td>
                <td class="tabel-icon">User<i data-feather="arrow-right"></i>
                    <?php if(!empty($flow1)){ ?>
                      Organization Lead<i data-feather="arrow-right"></i>
                    <?php } ?>
                    <?php if(!empty($flow2)){ ?>
                      MD<i data-feather="arrow-right"></i>
                    <?php } ?>
                    <?php if(!empty($flow3)){ ?>
                    Purchase Team 
                    <?php } ?>
                </td> 
                <td> 
                  <a href="./add-new-organization.php?platform=<?php echo randomString(45); ?>&action=editorganization&fieldid=<?php echo passwordEncryption($orgId) ?>&flow=purchase" class="btn btn-primary btn-xs" type="button">Edit</a>
                </td>
            </tr>
            <?php  $slno++;} } ?>
        </tbody>
    </table>
</div>