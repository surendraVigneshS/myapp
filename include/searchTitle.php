<?php 
include('./dbconfig.php');   
$searchTerm = $_GET['term'];  
$query = mysqli_query($dbconnection,"SELECT * FROM `projects_tb` WHERE `project_title` LIKE '%".$searchTerm."%'");  
$arrayData = array();  
if(mysqli_num_rows($query) > 0){ 
    while($row =  mysqli_fetch_array($query)){  
        $data['id'] = $row['project_id'];
        $data['project_title'] = $row['project_title'];
        array_push($arrayData,$data); 
    } 
} 
echo json_encode($arrayData);  