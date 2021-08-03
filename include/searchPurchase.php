<?php 
include('./dbconfig.php'); 
 
$searchTerm = $_GET['term']; 
 
$query = mysqli_query($dbconnection,"SELECT * FROM `supplier_details` WHERE `supplier_name` LIKE '%".$searchTerm."%' OR `supplier_email` LIKE '%".$searchTerm."%' "); 
  
$arrayData = array(); 

if(mysqli_num_rows($query) > 0){ 
    while($row =  mysqli_fetch_array($query)){ 
        $data['id'] = $row['cust_id']; 
        $data['name'] = $row['supplier_name']; 
        $data['email'] = $row['supplier_email']; 
        $data['mobile'] = $row['supplier_mobile'];   
        $data['accNo'] = $row['supplier_acc_no']; 
        $data['ifscCode'] = $row['supplier_ifsc_code'];       
        array_push($arrayData, $data); 
    } 
} 
echo json_encode($arrayData);  