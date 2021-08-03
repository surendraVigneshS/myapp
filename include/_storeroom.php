<?php 

    include('./dbconfig.php');
    include('./function.php');
    include('./createQR.php');
    $storepath = "../assets/qr/storeroom/"; 
    $rackpath = "../assets/qr/rack/"; 
    $columnpath = "../assets/qr/column/"; 
    $itempath = "../assets/qr/item-group/"; 
    
    session_start();
    if (isset($_POST['addStore'])){
         
        $storename =  $_POST['storename']; 
        $status =  $_POST['status']; 
        
        $addquery = "INSERT INTO `ft_group_room`( `group_name` , `group_status`) VALUES ( ? , ? ) " ;
        $stmt = $dbconnection->prepare($addquery) ;
        $stmt->bind_param("ss",$storename,$status);
        $executeadd = $stmt->execute();
        $storeid = $dbconnection->insert_id;

        $storeqr = createProductqr($storepath,$storeid);
        mysqli_query($dbconnection,"UPDATE `ft_group_room` SET `group_qr` = '$storeqr' WHERE `group_id`='$storeid'");

        if($executeadd){  
            $_SESSION['storeSuccess']="Store Room Updated Successfully";  
            header("location:../store-list.php"); 
            exit();
        }
        else{
            $_SESSION['storeError']="Data Submit Error!!"; 
            header("location:../store-list.php"); 
            exit(); 
        }
        
         
    } 
    
    
    if (isset($_POST['updateStore'])){
        $id =  $_POST['id']; 
        $storename =  $_POST['storename']; 
        $status =  $_POST['status']; 
        
        $updatequery = "UPDATE `ft_group_room` SET  `group_name` = '$storename', `group_status` = '$status' WHERE `group_id` = '$id' ";
        $executeupdate = mysqli_query($dbconnection,$updatequery); 
        
        if($executeupdate){  
            $_SESSION['storeSuccess']="Store Room Updated Successfully";  
            header("location:../store-list.php"); 
            exit();
        }
        else{
            $_SESSION['storeError']="Data Submit Error!!"; 
            header("location:../store-list.php"); 
            exit(); 
        }
        
    }


    if (isset($_POST['addRack'])){
         
        $storename =  $_POST['storeRoom']; 
        $rackName =  $_POST['rackName'];  
        $status =  $_POST['status'];  
        
            $addquery = "INSERT INTO `ft_rack`(`store_id`, `rack_name`,`rack_status`) VALUES ( ? , ?  , ?) " ;
        $stmt = $dbconnection->prepare($addquery) ;
        $stmt->bind_param("sss",$storename,$rackName,$status);
        $executeadd = $stmt->execute();
        $rackid = $dbconnection->insert_id;

        $rackqr = createProductqr($rackpath,$rackid);
        mysqli_query($dbconnection,"UPDATE `ft_rack` SET `rack_qr` = '$rackqr' WHERE `rack_id`='$rackid'");

        if($executeadd){  
            $_SESSION['rackSuccess']="Rack Created Successfully";  
            header("location:../rack-list.php"); 
            exit();
        }
        else{
            $_SESSION['rackError']="Data Submit Error!!"; 
            header("location:../rack-list.php"); 
            exit(); 
        }
        
         
    } 

    if (isset($_POST['updateRack'])){
        $id =  $_POST['id']; 
        $name =  $_POST['name']; 
        $status =  $_POST['status']; 
        
        $updatequery = "UPDATE `ft_rack` SET  `rack_name` = '$name', `rack_status` = '$status' WHERE `rack_id` = '$id' ";
        $executeupdate = mysqli_query($dbconnection,$updatequery); 
        
        if($executeupdate){  
            $_SESSION['rackSuccess']="Rack Updated Successfully";  
            header("location:../rack-list.php"); 
            exit();
        }
        else{
            $_SESSION['rackError']="Data Submit Error!!"; 
            header("location:../rack-list.php"); 
            exit(); 
        }
        
    }
    
    
    if (isset($_POST['addColumn'])){
        
   
        $storename =  $_POST['storeRoom']; 
        $rackRoom =  $_POST['rackRoom'];  
        $ColumnName =  $_POST['ColumnName'];  
        $status =  $_POST['status'];  
        
            $addquery = "INSERT INTO `ft_column`(`rack_id`, `store_id`, `column_name`, `column_status`) VALUES( ? , ? , ?, ?) " ;
        $stmt = $dbconnection->prepare($addquery) ;
        $stmt->bind_param("ssss",$rackRoom,$storename,$ColumnName,$status);
        $executeadd = $stmt->execute();
        $columnid = $dbconnection->insert_id;

        $columnqr = createProductqr($columnpath,$columnid);
        mysqli_query($dbconnection,"UPDATE `ft_column` SET `column_qr` = '$columnqr' WHERE `column_id`='$columnid'");

        if($executeadd){  
            $_SESSION['columnSuccess']="Column Created Successfully";  
            header("location:../column-list.php"); 
            exit();
        }
        else{
            $_SESSION['columnError']="Data Submit Error!!"; 
            header("location:../column-list.php"); 
            exit(); 
        }
        
         
    } 


    if (isset($_POST['updatecolumn'])){
        $id =  $_POST['id']; 
        $name =  $_POST['name']; 
        $status =  $_POST['status']; 
        
        $updatequery = "UPDATE `ft_column` SET  `column_name` = '$name', `column_status` = '$status' WHERE `column_id` = '$id' ";
        $executeupdate = mysqli_query($dbconnection,$updatequery); 
        
        if($executeupdate){  
            $_SESSION['columnSuccess']="column Updated Successfully";  
            header("location:../column-list.php"); 
            exit();
        }
        else{
            $_SESSION['columnError']="Data Submit Error!!"; 
            header("location:../column-list.php"); 
            exit(); 
        }
        
    }
    
    
    // Group Controller - starts
    if (isset($_POST['addGroup'])){ 
        $groupname =  $_POST['groupname']; 
        $shortcode =  $_POST['shortcode']; 
        $status =  $_POST['status']; 
        
        $addquery = "INSERT INTO `ft_item_group`(`group_name`, `group_short_code`, `group_status`) VALUES (?,?,?)";
        $stmt = $dbconnection->prepare($addquery) ;
        $stmt->bind_param("sss",$groupname,$shortcode,$status);
        $executeadd = $stmt->execute();
        $groupid = $dbconnection->insert_id;
        
        $groupqr = createProductqr($itempath,$groupid);
        mysqli_query($dbconnection,"UPDATE `ft_item_group` SET `group_qr` = '$groupqr' WHERE `group_id`='$groupid'");
        
        if($executeadd){  
            $_SESSION['itemSuccess']="Group Created Successfully";  
            header("location:../item-group-list.php"); 
            exit();
        }
        else{
            $_SESSION['itemError']="Data Submit Error!!"; 
            header("location:../item-group-list.php"); 
            exit(); 
        }
        
        
    } 
    
    
    if (isset($_POST['updateGroup'])){
        $id =  $_POST['id']; 
        $groupname =  $_POST['groupname']; 
        $shortcode =  $_POST['shortcode']; 
        $status =  $_POST['status']; 
        
        $updatequery = "UPDATE `ft_item_group` SET  `group_name` = '$groupname',`group_short_code` = '$shortcode',`group_status` = '$status' WHERE `group_id` = '$id' ";
        $executeupdate = mysqli_query($dbconnection,$updatequery); 
        
        if($executeupdate){  
            $_SESSION['itemSuccess']="Group Details Updated Successfully";  
            header("location:../item-group-list.php"); 
            exit();
        }
        else{
            $_SESSION['itemError']="Data Submit Error!!"; 
            header("location:../item-group-list.php"); 
            exit(); 
        }
        
    }
    // Group Controller - Ends 
    
    
    // uom Controller - Starts 

    if (isset($_POST['addUOM'])){ 
        $name =  $_POST['name'];  
        $status =  $_POST['status']; 
        
        $addquery = "INSERT INTO `ft_uom`(`uom_name`, `uom_status`) VALUES (?,?)";
        $stmt = $dbconnection->prepare($addquery) ;
        $stmt->bind_param("ss",$name,$status);
        $executeadd = $stmt->execute();
        
        if($executeadd){  
            $_SESSION['uomSuccess']="UOM Created Successfully";  
              header("location:../uom-list.php");   
            exit();
        }
        else{
            $_SESSION['uomError']="Data Submit Error!!"; 
            header("location:../uom-list.php"); 
            exit(); 
        }
        
        
    } 


    if (isset($_POST['updateUOM'])){
        $id =  $_POST['id']; 
        $name =  $_POST['name'];  
        $status =  $_POST['status']; 
        
        $updatequery = "UPDATE `ft_uom` SET  `uom_name` = '$name',`uom_status` = '$status' WHERE `uom_id` = '$id' ";
        $executeupdate = mysqli_query($dbconnection,$updatequery); 
        
        if($executeupdate){  
            $_SESSION['uomSuccess']="UOM Updated Successfully";  
            header("location:../uom-list.php"); 
            exit();
        }
        else{
            $_SESSION['uomError']="Data Submit Error!!"; 
            header("location:../uom-list.php"); 
            exit(); 
        }
        
        
    }
    // UOM ENds here



    // Terms Start here
    
    if (isset($_POST['addTerms'])){ 
        $name =  $_POST['name'];  
        $content =  $_POST['content'];  
        $status =  $_POST['status']; 
        
        $addquery = "INSERT INTO `ft_terms`(`terms_heading`, `terms_remarks`, `terms_status`) VALUES(?,?,?)";
        $stmt = $dbconnection->prepare($addquery) ;
        $stmt->bind_param("sss",$name,$content,$status);
        $executeadd = $stmt->execute();
        
        if($executeadd){  
            $_SESSION['termsSuccess']="Terms & Conditions Created Successfully";  
              header("location:../terms-list.php");   
            exit();
        }
        else{
            $_SESSION['termsError']="Data Submit Error!!"; 
            header("location:../terms-list.php"); 
            exit(); 
        }
        
        
    } 


    if (isset($_POST['updateTerms'])){
        $id =  $_POST[' ']; 
        $name =  $_POST['name'];  
        $content =  $_POST['content'];  
        $status =  $_POST['status']; 
        
        $updatequery = "UPDATE `ft_terms` SET `terms_heading`= ?  , `terms_remarks`=?,`terms_status`= ? WHERE `terms_id` =  ? ";
        $stmt = $dbconnection->prepare($updatequery) ;
        $stmt->bind_param("ssss",$name,$content,$status,$id);
        $executeadd = $stmt->execute();
        
        if($executeadd){  
            $_SESSION['termsSuccess']="Terms & Conditions Created Successfully";  
              header("location:../terms-list.php");   
            exit();
        }
        else{
            $_SESSION['termsError']="Data Submit Error!!"; 
            header("location:../terms-list.php"); 
            exit(); 
        }
        
    }