<?php 

    include('./dbconfig.php');
    include('./function.php');
    include('./authenticate.php');  
    $currentTime = date('Y-m-d H:i:s');

    if (isset($_POST['editBeneficiary'])){
        $beneid =  $_POST['beneId'];
        $benename =  $_POST['beneName'];
        $benemail =  $_POST['beneEmail'];
        $benemobile =  $_POST['beneMobile'];
        $benebranch = "";
        if(isset($_POST['beneBranch'])){
            $benebranch =  $_POST['beneBranch'];
        }
        $beneaccno =  $_POST['beneAccno'];
        $beneifsc =  $_POST['beneifsc'];
        $updatequery = "UPDATE `supplier_details` SET `supplier_name` = '$benename', `supplier_email` = '$benemail', `supplier_mobile` = '$benemobile', `supplier_branch` = '$benebranch', `supplier_acc_no` = '$beneaccno', `supplier_ifsc_code` = '$beneifsc' WHERE `cust_id` = '$beneid' ";
        $executeupdate = mysqli_query($dbconnection,$updatequery);
        if($executeupdate){  
            $_SESSION['paymentSuccess']="Beneficiary Details Updated Successfully"; 
             header("location:../beneficiary-list.php"); 
            exit();
        }
        else{
            $_SESSION['paymentError']="Data Submit Error!!"; 
            header("location:../beneficiary-list.php"); 
            exit(); 
        }
    }
    if (isset($_POST['editSupplier'])){
        $supplierid =  $_POST['supplierId'];
        $suppliername =  $_POST['supplierName'];
        $suppliermail =  $_POST['supplierEmail'];
        $suppliermobile =  $_POST['supplierMobile'];
        $updatequery = "UPDATE `supplier_details` SET `supplier_name` = '$suppliername', `supplier_email` = '$suppliermail', `supplier_mobile` = '$suppliermobile'  WHERE `cust_id` = '$supplierid' ";
        $executeupdate = mysqli_query($dbconnection,$updatequery);
        if($executeupdate){  
            $_SESSION['paymentSuccess']="Supplier Details Updated Successfully"; 
             header("location:../supplier-list.php"); 
            exit();
        }
        else{
            $_SESSION['paymentError']="Data Submit Error!!"; 
            header("location:../supplier-list.php"); 
            exit(); 
        }
    }
    
    if(isset($_POST['addSupplier'])){
        $suppliername =  $_POST['supplierName'];
        $suppliermail =  $_POST['supplierEmail'];
        $suppliermobile =  $_POST['supplierMobile'];
        $suppliergst =  $_POST['supplierGST'];
        $supplieraddress =  $_POST['supplierAddress'];
        $suppliercity =  $_POST['supplierCity'];
        $supplierpincode =  $_POST['supplierPincode'];
        $supplierbranch =  $_POST['supplierBranch'];
        $supplieracc =  $_POST['supplierAcc'];
        $supplierifsc =  $_POST['supplierIFSC'];
        
        $addquery = "INSERT INTO `supplier_details` (`supplier_name`, `supplier_gst`, `supplier_email`, `supplier_mobile`, `supplier_branch`, `supplier_acc_no`, `supplier_ifsc_code`, `supplier_address`, `supplier_city`, `supplier_pincode`) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ? )";
        $stmt = $dbconnection->prepare($addquery);
        $stmt->bind_param("ssssssssss", $suppliername, $suppliergst, $suppliermail, $suppliermobile, $supplierbranch, $supplieracc, $supplierifsc, $supplieraddress, $suppliercity, $supplierpincode);
        $executeadd = $stmt->execute();
        $supplierid = $dbconnection->insert_id;


        if(isset($_POST['productId'])){
            foreach ($_POST['productId'] as $key => $value) 
            { 
                 $productAmount = $_POST["productAmount"][$key]; 
                 
                        if(checkproductsupplier($dbconnection,$supplierid,$value)){ 
                            $query = "UPDATE `ft_product_details` SET `details_amount` = ? WHERE `supplier_id` = ? AND `product_id`= ?"  or die($dbconnection->error) ;
                            $stmt = $dbconnection->prepare($query);
                            $stmt->bind_param("sss",$productAmount,$supplierid,$value);
                            $stmt->execute();   
                        }else{
                            $query = "INSERT INTO `ft_product_details`(`product_id`, `supplier_id`,`details_amount`,`deatils_created_by`,`deatils_created_time`) VALUES(? ,? ,? ,? ,? )";   
                            $stmt = $dbconnection->prepare($query);
                            $stmt->bind_param("sssss",$value,$supplierid, $productAmount,$logged_admin_id,$currentTime);   
                            $stmt->execute();   
                        }
                 
            }  
        }
        
        if($executeadd){  
            $_SESSION['paymentSuccess']="Supplier Details Added Successfully"; 
             header("location:../supplier-list.php"); 
            exit();
        }
        else{
            $_SESSION['paymentError']="Data Submit Error!!"; 
            header("location:../supplier-list.php"); 
            exit(); 
        }
        
    }
    
    
    if(isset($_POST['updateSupplier'])){
        $suppliername =  $_POST['supplierName'];
        $suppliermail =  $_POST['supplierEmail'];
        $suppliermobile =  $_POST['supplierMobile'];
        $suppliergst =  $_POST['supplierGST'];
        $supplieraddress =  $_POST['supplierAddress'];
        $suppliercity =  $_POST['supplierCity'];
        $supplierpincode =  $_POST['supplierPincode'];
        $supplierbranch =  $_POST['supplierBranch'];
        $supplieracc =  $_POST['supplierAcc'];
        $supplierifsc =  $_POST['supplierIFSC'];
        $supplierID =  $_POST['supplierid'];
        
        $updatequery = "UPDATE `supplier_details` SET `supplier_name` = '$suppliername', `supplier_gst` = '$suppliergst', `supplier_email` = '$suppliermail', `supplier_mobile` = '$suppliermobile', `supplier_branch` = '$supplierbranch', `supplier_acc_no` = '$supplieracc', `supplier_ifsc_code` = '$supplierifsc', `supplier_address` = '$supplieraddress', `supplier_city` = '$suppliercity', `supplier_pincode` = '$supplierpincode' WHERE `cust_id` = '$supplierID'  ";
        $executeadd = mysqli_query($dbconnection,$updatequery);


        echo 'asdsa';
        if(isset($_POST['productId'])){
            foreach ($_POST['productId'] as $key => $value) 
            { 
                echo $value;
                 $productAmount = $_POST["productAmount"][$key]; 
                 
                        if(checkproductsupplier($dbconnection,$supplierID,$value)){ 
                            $query = "UPDATE `ft_product_details` SET `details_amount` = ? WHERE `supplier_id` = ? AND `product_id`= ?"  or die($dbconnection->error) ;
                            $stmt = $dbconnection->prepare($query);
                            $stmt->bind_param("sss",$productAmount,$supplierID,$value);
                            $stmt->execute();   
                        }else{
                            $query = "INSERT INTO `ft_product_details`(`product_id`, `supplier_id`,`details_amount`,`deatils_created_by`,`deatils_created_time`) VALUES(? ,? ,? ,? ,? )";   
                            $stmt = $dbconnection->prepare($query);
                            $stmt->bind_param("sssss",$value,$supplierID, $productAmount,$logged_admin_id,$currentTime);   
                            $stmt->execute();   
                        }
                 
            }  
        }else{
            mysqli_query($dbconnection,"DELETE FROM `ft_product_details` WHERE `supplier_id` = '$supplierID'");
        }
        

        if($executeadd){  
            $_SESSION['paymentSuccess']="Supplier Details Updated Successfully"; 
             header("location:../supplier-list.php"); 
            exit();
        }
        else{
            $_SESSION['paymentError']="Data Submit Error!!"; 
            header("location:../supplier-list.php"); 
            exit(); 
        }
        
    }

?>