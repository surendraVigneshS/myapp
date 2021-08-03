<div class="card mb-0">
    <div class="card-body p-0">
        <div class="taskadd">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <?php 
                            switch ($logged_admin_role) {
                                case '2':
                                    $expenditureselect = mysqli_query($dbconnection, "SELECT * FROM `expenditures` WHERE `exp_approval_1` = 0 GROUP BY `exp_created_by` ");
                                    $case = 2;
                                break;
                                case '4':
                                    $expenditureselect = mysqli_query($dbconnection, "SELECT * FROM `expenditures` WHERE `exp_approval_1` = 0 GROUP BY `exp_created_by` ");
                                    $case = 4;
                                break;
                            }

                            
                            if(mysqli_num_rows($expenditureselect)){
                                while($rowexp = mysqli_fetch_array($expenditureselect)){
                                    $createdid = $rowexp['exp_created_by'];
                                    $exp_approval_1 = $rowexp['exp_approval_1'];
                                    $name = fetchData($dbconnection, 'emp_name', 'admin_login','emp_id',$createdid);
                                    $emproleid = fetchData($dbconnection, 'emp_role', 'admin_login','emp_id',$createdid);
                                    $emprole = fetchData($dbconnection,'user_role','user_roles','id',$emproleid);
                                    $count = expenditurePendingCount($dbconnection,$createdid,'1',$exp_approval_1);
                                    $expense = expenditurePendingCount($dbconnection,$createdid,'2',$exp_approval_1);
                                    $expensebalance = getPreviousExp($dbconnection, $createdid);
                        ?>
                        <tr>
                            <td>
                                <h6 class="task_title_0"><?php echo $name ?></php></h6>
                                <p class="project_name_0"><?php echo $emprole ?></p>
                            </td>
                            <td>
                                <h6 class="task_title_1">Pending Expense <br>Count : <span><?php echo $count ?></span></h6>
                            </td>
                            <td>
                                <h6 class="task_title_1">Total Expense <br>Amount : <span class="add">₹<?php echo IND_money_format($expense) ?></span></h6>
                            </td>
                            <td>
                                <h6 class="task_title_1">Total Credit <br>Left : <span class="left">₹<?php echo IND_money_format($expensebalance)  ?></span></h6>
                            </td>
                            <td>
                                <a href="./expenditure-md-list.php?Flatform=<?php echo RandomString(50) ?>&fieldid=<?php echo passwordEncryption($createdid) ?>" class="btn btn-primary btn-sm mr-2">View All</a>
                                <button class="btn btn-info btn-sm" type="button" name="closeallexpense" id="closeallexpense" onclick="closeAllExpense(<?php echo $logged_admin_role ?>,<?php echo $logged_admin_id ?>,<?php echo $createdid ?>)">Close All</button>
                            </td>
                        </tr>
                        <?php } }else{ ?>
                        <div class="text-center">
                            <h6>No data available in table !!</h6>
                        </div>
                        <?php }  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>