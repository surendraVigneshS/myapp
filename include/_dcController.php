<?php

include('./dbconfig.php');
include('./function.php');
include('./authenticate.php');
include('./createQR.php');
include('./createPDF.php');
$poqrpath = "../assets/qr/po/";
$currentTime = date('Y-m-d H:i:s');


if (isset($_POST['addDcEntry'])){ 
      
        $curyear =  date("y");
        $curyear1 =  date("y") + 1;
        $dcType = $_POST['dcType'];
        $dcDate = date('Y-m-d', strtotime($_POST['dcDate']));
        
        $issuedTo = $_POST['issuedTo'];
        $issuedBy = $logged_admin_id;
         
        $remarks = $_POST['remarks'];   
        
        if($dcType == "1"){ $arg1  = 'GDCR';  }
        else if($dcType == "2"){ $arg1  = 'GDCNR'; }
        else if($dcType == "3"){ $arg1  = 'GDCAR'; }

        $lastcode = fetchlastestDCCode($dbconnection);
    
        
        if (empty($lastcode)) { 
            $lastcode =1;
            $arg2 = str_pad($lastcode, 4, "0", STR_PAD_LEFT);  
        } else { 
            $lastcode++; 
            $arg2 = str_pad($lastcode, 4, "0", STR_PAD_LEFT);   
        }
        
        $arg3 = $curyear.'-'.$curyear1;  
        echo $finalPOCode =  $arg1.'/'.$arg2.'/'.$arg3; 
    
        $porductcount = count($_POST['productid']);
         

        var_dump($_POST);

        
    
        $addquery = "INSERT INTO `ft_dc`(`dc_date`, `dc_code`,`dc_product_count`, `dc_short_code`, `dc_type`, `dc_issued_to`, `dc_issued_by`, `dc_issued_time`) VALUES ( ?,?,?,?,?,?,?,?)" or die($dbconnection->error) ;
        $stmt = $dbconnection->prepare($addquery) or die($dbconnection->error) ;
        $stmt->bind_param("ssssssss",$dcDate,$finalPOCode,$porductcount,$lastcode,$dcType,$issuedTo,$issuedBy,$currentTime) or die($dbconnection->error) ;
        $executeadd = $stmt->execute() or die($dbconnection->error) ;
        $dcid = $dbconnection->insert_id;
        
          
        
        if (!empty($_FILES['dcAttachment']['name'])) {
            $image_name = $_FILES['dcAttachment']['name'];
            $pofile = uniqidReal(5) . '_' . $image_name;
            $target_dir = "../assets/pdf/dcattachments/";
            $target_file = $target_dir . basename($pofile);
            $upload_success = move_uploaded_file($_FILES['dcAttachment']['tmp_name'], $target_dir . $pofile);
            mysqli_query($dbconnection, "UPDATE `ft_dc` SET `dc_file`='$pofile' WHERE  `dc_id`='$dcid' ");
        } 
    
                foreach ($_POST['productid'] as $key => $value) 
                {  
                    $productdesc = $_POST['productdesc'][$key];
                    $issuedqty = $_POST['productqty'][$key];
                    
                    $addquery2 = "INSERT INTO `ft_dc_details`(`dc_id`, `dc_product_id`, `dc_product_remarks`, `dc_issued_qty`) VALUES (?,?,?,?)"; 
                    $stmt2 = $dbconnection->prepare($addquery2); 
                    $stmt2->bind_param("ssss", $dcid, $value,$productdesc,$issuedqty); 
                    $executeadd2 = $stmt2->execute();  
                }
                $currentQty = fetchData($dbconnection,'product_current_qty','ft_stock_master','product_id',$value);
                

                if(!empty($currentQty)){
                    $balanceQty = $currentQty - $issuedqty;
                    mysqli_query($dbconnection, "UPDATE `ft_stock_master` SET `product_current_qty`='$balanceQty',`product_issued_qty` = '$issuedqty'  WHERE  `product_id`='$value' ");
                }
                
    
               
                
        if ($executeadd) {
            
            echo $_SESSION['poOrderSuccess'] = "New Purchase Created Successfully";
            // header("location:../po-list.php"); 
            exit();
        } else {
            echo $_SESSION['poOrderError'] = "Data Submit Error!!";
            // header("location:../po-list.php"); 
            exit(); 
        }
    
}
 