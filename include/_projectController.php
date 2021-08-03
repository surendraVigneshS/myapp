<?php

include('./dbconfig.php');
include('./function.php');  
include('./createQR.php');
include('./authenticate.php');  

$currentTime = date('Y-m-d H:i:s');
 

if (isset($_POST['addProject']))
{  
    $projectDate = date('Y-m-d', strtotime($_POST['projectDate']));
    $name = $_POST['name']; 
    $targetdate = "";
    if( isset($_POST['projecttargetDate'])){
        $targetdate = date('Y-m-d', strtotime($_POST['projecttargetDate']));   
    }
    $incharge = $_POST['projectIncharge']; 
    $name = $_POST['name']; 
    $itemCount = 0; 
    
    $addquery = "INSERT INTO `ft_projects_tb`(`project_title`,`project_date`,`project_target_date`,`project_incharge`,`created_by`,`created_time`) VALUES( ? ,? ,? ,?,?,?)";  

    $stmt = $dbconnection->prepare($addquery);
    $stmt->bind_param("ssssss",$name,$projectDate,$targetdate,$incharge,$logged_admin_id,$currentTime);   
    $executeadd = $stmt->execute(); 
    $projecttid = $dbconnection->insert_id;
                if(isset($_POST["productId"])){
                    $itemCount  = count($_POST['productId']); 
                    foreach ($_POST['productId'] as $key => $value) 
                    {  
                        $proid = $_POST['productId'][$key];  
                        $proqty = $_POST['productqty'][$key];  
                            $insertProducts ="INSERT INTO `ft_project_details`(`project_id`, `project_product_id`, `project_product_qty`,`added_by`,`added_time`) VALUES  (?,?,?,?,?)";
                            $stmt = $dbconnection->prepare($insertProducts);  
                            $stmt->bind_param("sssss", $projecttid, $proid ,$proqty,$logged_admin_id,$currentTime);  
                            $executecust = $stmt->execute();
                    }    
                }
        mysqli_query($dbconnection,"UPDATE `ft_projects_tb` SET `items_count`='$itemCount' WHERE `project_id` ='$projecttid'");

            if($executeadd){  
                $_SESSION['projectSuccess']="New Project Created Successfully";  
                header("location:../project-list.php"); 
                exit();
            }
            else{
                $_SESSION['projectError']="Data Submit Error!!"; 
                header("location:../project-list.php"); 
                exit(); 
            }
}

if (isset($_POST['updateProject']))
{ 
     $fieldid = $_POST['fieldid']; 
    $projectDate = date('Y-m-d', strtotime($_POST['projectDate']));
    $name = $_POST['name']; 
    $projecttargetDate = date('Y-m-d', strtotime($_POST['projecttargetDate'])); 
    $incharge = $_POST['projectIncharge']; 
    $itemCount = 0; 
    
    $addquery = "UPDATE `ft_projects_tb` SET  `project_title` = ?,`project_date` = ? , `project_target_date` = ?  , `project_incharge` = ?  WHERE `project_id` = ? ";   
    $stmt = $dbconnection->prepare($addquery);
    $stmt->bind_param("sssss",$name,$projectDate,$projecttargetDate,$incharge,$fieldid);   
    $executeadd = $stmt->execute(); 
    
            if($executeadd){  

                mysqli_query($dbconnection,"DELETE FROM `ft_project_details`  WHERE `project_id` ='$fieldid'") or mysqli_error($dbconnection); 
                if(isset($_POST["productId"])){
                    $itemCount  = count($_POST['productId']);  
                  for ($i=0; $i < count($_POST['productId']); $i++) { 
                     $proid = $_POST['productId'][$i];  
                    $proqty = $_POST['productqty'][$i];  
                    $insertProducts ="INSERT INTO `ft_project_details`(`project_id`, `project_product_id`, `project_product_qty`,`added_by`,`added_time`) VALUES  (?,?,?,?,?)";
                    $stmt = $dbconnection->prepare($insertProducts);
                    $stmt->bind_param("sssss", $fieldid, $proid ,$proqty,$logged_admin_id,$currentTime);
                    $executecust = $stmt->execute();
                  }
                  
                }
        
                    mysqli_query($dbconnection,"UPDATE `ft_projects_tb` SET `items_count`='$itemCount' WHERE `project_id` ='$fieldid'");



                $_SESSION['projectSuccess']="Project Updated Successfully";  
                header("location:../project-list.php"); 
                exit();
            }
            else{
                $_SESSION['projectError']="Data Submit Error!!"; 
                header("location:../project-list.php"); 
                exit(); 
            }
}