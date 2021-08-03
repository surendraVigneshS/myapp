<?php

include('./dbconfig.php');
include('./function.php');  
include('./createQR.php');
include('./authenticate.php');  

$productpath = "../assets/qr/product/"; 
$currentTime = date('Y-m-d H:i:s');
 

if (isset($_POST['addProduct']))
{ 
    $productType = $_POST['productType']; 
    $name = $_POST['name']; 
    $group = $_POST['group'];  
    $uom = $_POST['uom']; 
    $projectid = $_POST['projectid']; 
    $specification = $_POST['specification']; 
    $minqty = $_POST['minqty']; 
    $maxqty = $_POST['maxqty']; 
    $remarks = $_POST['remarks']; 
    $consumable = $_POST['consumable'];
     
    $pofile="";
    

    $shortCode = fetchData($dbconnection,'group_short_code','ft_item_group','group_id',$group);
    $lastcode = fetchlastestCode($dbconnection,$group); 
    if(empty($lastcode)){ 
        $lastcode = 1;
        $code = str_pad($lastcode, 3, "0", STR_PAD_LEFT); 
        $finalcode = $shortCode.'-'.$code;
    }else{
        $lastcode++;
        $code = str_pad($lastcode, 3, "0", STR_PAD_LEFT); 
        $finalcode = $shortCode.'-'.$code;
    }
    

    $addquery = "INSERT INTO `ft_product_master`(`product_group`, `product_name`,`product_shortcode`,`product_code`,`product_specification`, `product_unit`, `product_type`, `min_qty`, `max_qty`,`product_consumable` ,`created_by`,`created_time`,`product_remarks`) VALUES( ? ,? ,? ,? ,? ,?,? ,? ,? ,? ,? ,?  ,? )";  

    $stmt = $dbconnection->prepare($addquery);
    $stmt->bind_param("sssssssssssss",$group,$name,$code,$finalcode,$specification,$uom,$productType,$minqty,$maxqty,$consumable,$logged_admin_id,$currentTime,$remarks);   
    $executeadd = $stmt->execute(); 
    $productid = $dbconnection->insert_id;
    
    $productqr = createProductqr($productpath,$productid);
    mysqli_query($dbconnection,"UPDATE `ft_product_master` SET `product_qr`='$productqr' WHERE  `product_id`='$productid' ");
    
    if (!empty($_FILES['productImage']['name'])) {  
        $image_name = $_FILES['productImage']['name'];
        $pofile = uniqidReal(5).'_'.$image_name;
        $target_dir = "../assets/images/product/";
        $target_file = $target_dir . basename($pofile);
        $upload_success = move_uploaded_file($_FILES['productImage']['tmp_name'], $target_dir.$pofile); 
        mysqli_query($dbconnection,"UPDATE `ft_product_master` SET `product_image`='$pofile' WHERE  `product_id`='$productid' ");
    }
    
    foreach ($_POST['supplierID'] as $key => $value) 
    { 
        if(!empty($value)){
            $productAmount = $_POST["productAmount"][$key]; 
             
                $query = "INSERT INTO `ft_product_details`(`product_id`, `supplier_id`,`details_amount`,`deatils_created_by`,`deatils_created_time`) VALUES(? , ? ,? ,? ,?  )";   
                $stmt = $dbconnection->prepare($query);
                $stmt->bind_param("sssss",$productid,$value, $productAmount,$logged_admin_id,$currentTime);   
                $stmt->execute();   
        }
    }   
            
            if($executeadd){ 
                
                if(!empty($projectid) && $projectid != "" ){
                    $productQty = $_POST["projectqty"];
                    $itemscount = fetchData($dbconnection,'items_count','ft_projects_tb','project_id',$projectid) + 1; 
                    mysqli_query($dbconnection,"UPDATE `ft_projects_tb` SET `items_count` = '$itemscount' WHERE `project_id` ='$projectid'");
                    $insertproject ="INSERT INTO `ft_project_details`(`project_id`,`project_product_id`,`project_product_qty`,`added_by`,`added_time`) VALUES(?,?,?,?,?)";
                    $stmt = $dbconnection->prepare($insertproject);
                    $stmt->bind_param("sssss",$projectid,$productid,$productQty,$logged_admin_id,$currentTime);   
                    $executeadd = $stmt->execute();  
                }
                
                $_SESSION['productSuccess']="New Product Added Successfully";  
                header("location:../product-list.php"); 
                exit();
            }
            else{
                $_SESSION['productError']="Data Submit Error!!"; 
                header("location:../product-list.php"); 
                exit(); 
            }
}

if (isset($_POST['updateProduct']))
{ 
    $fieldid = $_POST['fieldid']; 
    $productType = $_POST['productType']; 
    $name = $_POST['name']; 
    $group = $_POST['group'];  
    $uom = $_POST['uom']; 
    $specification = $_POST['specification']; 
    $minqty = $_POST['minqty']; 
    $maxqty = $_POST['maxqty']; 
    $remarks = $_POST['remarks']; 
    $consumable = $_POST['consumable']; 
    // $storeroom = $_POST['storeroom']; 
    $pofile = $productAmount =""; 
    
    $addquery = "UPDATE `ft_product_master`  SET `product_group` = ? , `product_name` = ?,`product_specification`  = ?, `product_unit`  = ?, `product_type`  = ?, `min_qty`  = ?, `max_qty`  = ?,`product_consumable`  = ? , `product_remarks`  = ? WHERE  `product_id`= ? "  or die($dbconnection->error) ;    

    $stmt = $dbconnection->prepare($addquery)  or die($dbconnection->error) ;   
    $stmt->bind_param("ssssssssss",$group,$name,$specification,$uom,$productType,$minqty,$maxqty,$consumable,$remarks,$fieldid) or die($dbconnection->error) ;   
    $executeadd = $stmt->execute()  or die($dbconnection->error) ;   
    

    if (!empty($_FILES['productImage']['name'])) {  
        $image_name = $_FILES['productImage']['name'];
        $pofile = uniqidReal(5).'_'.$image_name;
        $target_dir = "../assets/images/product/";
        $target_file = $target_dir . basename($pofile);
        $upload_success = move_uploaded_file($_FILES['productImage']['tmp_name'], $target_dir.$pofile); 
        mysqli_query($dbconnection,"UPDATE `ft_product_master` SET `product_image`='$pofile' WHERE  `product_id`='$fieldid' ");
   }

             if(isset($_POST['supplierID'])){
                 foreach ($_POST['supplierID'] as $key => $value) 
                 { 
                     $productAmount = $_POST["productAmount"][$key]; 
                      
                             if(checkproductsupplier($dbconnection,$value,$fieldid)){ 
                                 $query = "UPDATE `ft_product_details` SET `details_amount` = ? WHERE `supplier_id` = ? AND `product_id`= ?"  or die($dbconnection->error) ;
                                 $stmt = $dbconnection->prepare($query);
                                 $stmt->bind_param("sss",$productAmount,$value,$fieldid);
                                 $stmt->execute();   
                             }else{
                                 $query = "INSERT INTO `ft_product_details`(`product_id`, `supplier_id`,`details_amount`,`deatils_created_by`,`deatils_created_time`) VALUES(? ,? ,? ,? ,? )";   
                                 $stmt = $dbconnection->prepare($query);
                                 $stmt->bind_param("sssss",$fieldid,$value, $productAmount,$logged_admin_id,$currentTime);   
                                 $stmt->execute();   
                             }
                      
                 }      
             }else{
                 mysqli_query($dbconnection,"DELETE FROM `ft_product_details` WHERE `product_id` = '$fieldid'");
             }

            if($executeadd){  
                $_SESSION['productSuccess']="Product Details Updated Successfully";  
                header("location:../product-list.php"); 
                exit();
            }
            else{
                $_SESSION['productError']="Data Submit Error!!"; 
                header("location:../product-list.php"); 
                exit(); 
            }
}