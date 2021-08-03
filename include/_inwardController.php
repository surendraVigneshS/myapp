<?php
include('./dbconfig.php');
include('./function.php');
include('./authenticate.php');
 
$poqrpath = "../assets/qr/po/";
$currentTime = date('Y-m-d H:i:s');
if (isset($_POST['addinward'])){ 
    $curyear =  date("y");
    $poId =  $_POST["poNo"];
    $remarks =  $_POST["remarks"];
    $curyear1 =  date("y") + 1;
    $inDate = date('Y-m-d', strtotime($_POST['poDate'])); 
    $lastcode = fetchlastestPICode($dbconnection); 
    $arg1 = 'PIN';
    
    if (empty($lastcode)) {  $lastcode =1; $arg2 = str_pad($lastcode, 4, "0",  STR_PAD_LEFT);  
    } else {  $lastcode++;  $arg2 = str_pad($lastcode, 4, "0", STR_PAD_LEFT);    } 
    $arg3 = $curyear.'-'.$curyear1;  
    $finalinCode =  $arg1.'/'.$arg2.'/'.$arg3;  
    $porductcount = count($_POST['productId']);
    $partialPO = false;
    
    $totalreceivedqty =  array_sum($_POST["receivedqty"]);

        $addquery = "INSERT INTO `ft_inward`(`pi_po_id`, `pi_code`, `pi_short_code`, `pi_date`, `pi_product_count`, `pi_total_qty`,`pi_remarks`, `pi_created_by`, `pi_created_time`) VALUES (?,?,?,?,?,?,?,?,?)"; 
        $stmt = $dbconnection->prepare($addquery);
        $stmt->bind_param("sssssssss", $poId, $finalinCode,$lastcode,$inDate, $porductcount, $totalreceivedqty,$remarks,$logged_admin_id,$currentTime);
        $executeadd = $stmt->execute();
        $piId = $dbconnection->insert_id;

        $storeid =  $rackid = $columnid = '';
        foreach ($_POST['productId'] as $key => $value) 
        { 
            $productPOQty = $_POST['productPOQty'][$key];
            $receivedqty = $_POST['receivedqty'][$key];
            $pendingqty = $_POST['pendingqty'][$key];
            $storeid = $_POST['storeid'][$key];
            
            if(isset($_POST['rackid'][$key])){ $rackid = $_POST['rackid'][$key];   }
            if(isset($_POST['columnid'][$key])){ $columnid = $_POST['columnid'][$key];  }
            
            $addquery2 = "INSERT INTO `ft_inward_details`(`pi_id`,`pi_po_id`, `pi_product_id`, `pi_po_product_qty`, `pi_received_qty`, `pi_pending_qty`) VALUES (?,?,?,?,?,?)";
            $stmt2 = $dbconnection->prepare($addquery2);
            $stmt2->bind_param("ssssss", $piId , $poId, $value,$productPOQty,$receivedqty,$pendingqty);
            $executeadd2 = $stmt2->execute();  
            $proGroup = fetchData($dbconnection,'product_group','ft_product_master','product_id',$value);
          
          
            $addquery5 = "INSERT INTO `ft_location`(`lo_store_room_id`, `lo_rack_id`, `lo_column_id`, `lo_product_id`) VALUES  ( ?,?,?,?) ";
            $stmt5 = $dbconnection->prepare($addquery5);
            $stmt5->bind_param("ssss",$storeid,$rackid,$columnid,$value);
            $stmt5->execute();  
            $location_id = $dbconnection->insert_id;


            mysqli_query($dbconnection,"UPDATE `ft_product_master` SET `location_id` = '$location_id' WHERE `product_id`='$value'");
             
 
            if(checkproductQty($dbconnection,$value)){
                $currentqty = fetchData($dbconnection,'product_current_qty','ft_stock_master','product_id',$value);
                $finalqty = $receivedqty  + $currentqty;
                $addquery2 = "UPDATE `ft_stock_master` SET `product_current_qty` = ? WHERE `product_id` = ? ";
                $stmt2 = $dbconnection->prepare($addquery2);
                $stmt2->bind_param("ss",$finalqty,$value);
                // $stmt2->execute();  
            } else { 
                $addquery2 = "INSERT INTO `ft_stock_master`(`product_group`, `product_id`, `product_current_qty`) VALUES (?,?,?)";
                $stmt2 = $dbconnection->prepare($addquery2);
                $stmt2->bind_param("sss", $proGroup,$value,$receivedqty);
                // $stmt2->execute();
            }

            if($productPOQty != $receivedqty){
                $partialPO = true;
            }

             
         }

         mysqli_query($dbconnection,"UPDATE `ft_po` SET `po_status` = 3 WHERE `po_id`='$poId'");
         if($partialPO){ mysqli_query($dbconnection,"UPDATE `ft_inward` SET `pi_status` = 2 WHERE `pi_id`='$piId'");  }
         mysqli_query($dbconnection, "INSERT INTO `ft_po_status`(`po_id`, `po_status_text`, `po_status`, `status_added_by`, `status_added_time`) VALUES ('$poId','Inward Done',3,'$logged_admin_id','$currentTime')");

        if($executeadd){
        $_SESSION['poInwardSuccess'] = "New PO Inward Created Successfully";
        header("location:../po-inward-list.php"); 
        exit();
    } else {
        $_SESSION['poInwardError'] = "Data Submit Error!!";
        header("location:../po-inward-list.php"); 
        exit(); 
    } 
        
}