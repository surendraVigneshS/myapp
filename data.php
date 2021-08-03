<?php
include('./include/dbconfig.php');
include('./include/function.php');
$sql = "SELECT * FROM `purchase_request` WHERE (`orglead_approval` = 1 OR `orglead_approval` = 2) AND ( `first_approval` = 0 AND  `second_approval` = 0 AND `already_purchased` =0 ) ORDER BY `pur_id` DESC"; 
$resultset = mysqli_query($dbconnection, $sql);
$data = array();
$response = array();
while( $row = mysqli_fetch_assoc($resultset) ) {

     
    $newDate = date(' d-M-Y h:i A', strtotime($row['created_date']));
	$data  = [
        'pur_id' => $row['pur_id'],
        'purchase_code' => $row['purchase_code'],
        'pr_name' => $row['pr_name'], 
        'supplier_name' => fetchData($dbconnection,'supplier_name','supplier_details','cust_id',$row['pr_supplier_id']),
        'project_title'=> fetchData($dbconnection,'project_title','ft_projects_tb','project_id',$row['pr_project_id']), 
        'purchase_type'=> $row['purchase_type'], 
        'others'=> $row['others'], 
        'if_po_done'=> $row['if_po_done'],  
        'total_amount'=> $row['total_amount'], 
        'advance_amount'=> $row['advance_amount'], 
        'balance_amount'=> $row['balance_amount'], 
        'amount_words'=> $row['amount_words'], 
        'bill_no'=>$row['bill_no'],   
        'bill_file' => $row['bill_file'],
        'po_no' => $row['po_no'],
        'po_file' => $row['po_file'],
        'first_approval' => $row['first_approval'],
        'first_approved_by' => $row['first_approved_by'],
        'frist_approval_time' => $row['frist_approval_time'],
        'second_approval' => $row['second_approval'],
        'second_approved_by' => $row['second_approved_by'],
        'second_approval_time' => $row['second_approval_time'],
        'third_approval' => $row['third_approval'],
        'third_approved_by' => $row['third_approved_by'],
        'third_approval_time' => $row['third_approval_time'],
        'cancel_reason' => $row['cancel_reason'],
        'cancelled_by' => $row['cancelled_by'],
        'org_name' => $row['org_name'],
        'cancelled_admin_role' => $row['cancelled_admin_role'],
        'created_by' => $row['created_by'], 
        'created_date' => $newDate,
        'purchase_status' => $row['purchase_status'] 
    ]; 
    array_push($response,$data);  
}

$results = array(
	"sEcho" => 1,
    "iTotalRecords" => count($response),
    "iTotalDisplayRecords" => count($response),
    "aaData"=>$response);

echo  json_encode($results);  