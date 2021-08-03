<?php

    function passwordEncryption($password){
        $ciphering = "AES-128-CTR"; 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0; 
        $encryption_iv = '1234567891011121';
        $encryption_key = "GeeksforGeeks";
        $encryption = openssl_encrypt($password, $ciphering, $encryption_key, $options, $encryption_iv);
        return $encryption;
    }
    function passwordDecryption($hash_pawssord){
        $ciphering = "AES-128-CTR"; 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0; 
        $decryption_iv = '1234567891011121';
        $decryption_key = "GeeksforGeeks";
        $decryption=openssl_decrypt ($hash_pawssord, $ciphering, $decryption_key, $options, $decryption_iv);
        return $decryption;
    }

    function checkUser($tableName, $email, $accesslevel,$dbconnection){
        $query = mysqli_query($dbconnection, "SELECT * FROM `$tableName` WHERE `emp_email` = '$email' AND  `emp_role` = '$accesslevel'");
        if(mysqli_num_rows($query) > 0){
            return true;
        }else{
            return false;
        }
    } 


    function checkEmailUser($email,$dbconnection){
        $query = mysqli_query($dbconnection, "SELECT * FROM `admin_login` WHERE `emp_email` = '$email'");
        if(mysqli_num_rows($query) > 0){
            return true;
        }else{
            return false;
        }
    } 



    function checkCompanyName($companyname,$tableName,$columnName,$dbconnection){
        $query = mysqli_query($dbconnection, "SELECT * FROM $tableName WHERE $columnName = '$companyname'");
        if(mysqli_num_rows($query) > 0){
            return true;
        }else{
            return false;
        }
    }   

    function getuserName($adminid , $dbconnection){ 
            
        $categorytable = "SELECT * FROM `admin_login` WHERE `emp_id`  = '$adminid'";	
        $result = mysqli_query($dbconnection, $categorytable);
        if($row = mysqli_fetch_array($result)){ 
            return  ucfirst($row['emp_name']);
        }  
    }
   
    function fetchData($dbconnection,$columnName,$tableName,$columnID,$conditionValue){
        $query = mysqli_query($dbconnection, "SELECT `$columnName` FROM $tableName WHERE `$columnID`='$conditionValue'");
         $row = mysqli_fetch_assoc($query);
         if(!empty($row[$columnName])){
            return  $row[$columnName];
        }else{
            return false;
        }  
    } 
    function fetchlastestCode($dbconnection,$group){
        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_master` WHERE `product_group` ='$group' ORDER BY `product_id` DESC LIMIT 1");
         $row = mysqli_fetch_assoc($query);
         if(!empty($row['product_shortcode'])){
            return  $row['product_shortcode'];
        }else{
            return 0;
        }  
    } 
     
    function fetchlastestPOCode($dbconnection){
        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_po` ORDER BY `po_id` DESC LIMIT 1");
         $row = mysqli_fetch_assoc($query);
         if(!empty($row['po_short_code'])){
            return  $row['po_short_code'];
        }else{
            return 0;
        }   
    } 
    function fetchlastestPICode($dbconnection){
        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_inward` ORDER BY `pi_id` DESC LIMIT 1");
         $row = mysqli_fetch_assoc($query);
         if(!empty($row['pi_short_code'])){
            return  $row['pi_short_code'];
        }else{
            return 0;
        }   
    } 
    function fetchlastestDCCode($dbconnection){
        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_dc` ORDER BY `dc_id` DESC LIMIT 1");
         $row = mysqli_fetch_assoc($query);
         if(!empty($row['dc_short_code'])){
            return  $row['dc_short_code'];
        }else{
            return 0;
        }   
    } 

    function generateItemCode($string){
        $expr = '/(?<=\s|^)[a-z]/i';
        preg_match_all($expr, $string, $matches); 
        $result = implode('', $matches[0]); 
        $result = strtoupper($result); 
        return  $result;
    }
    function  fetchDatawocon($dbconnection,$columnName,$tableName){
        $query = mysqli_query($dbconnection, "SELECT `$columnName` FROM $tableName");
        $row = mysqli_fetch_assoc($query);
        if(!empty($row[$columnName])){
           return  $row[$columnName];
       }else{
           return ;
       }  
    }


    function fetchOveraallTotalPaymentCount($dbconnection,$logged_admin_id){
        if(empty($logged_admin_id)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else{
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  `created_by` = '$logged_admin_id' ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
    }

    function fetchOveraallTotalPurchaseCount($dbconnection,$logged_admin_id,$logged_admin_role){
        
        switch ($logged_admin_role) {
            case '6':
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE  `created_by` = '$logged_admin_id' ");
              break;
            case '3':
            case '10':    
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE  (`created_by` = '$logged_admin_id' OR `team_leader` = '$logged_admin_id')");
              break; 
            case '9':
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `org_name` = 2");
              break; 
            default:
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` ");
              break;
          } 
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           }  
         
    }


    // Payment Functions

    function fetchPenPaymentDataCount($dbconnection,$logged_admin_id,$logged_admin_role)
    {
        if(empty($logged_admin_id)){
            if($logged_admin_role == 9){
                $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 0 AND `org_name` = 2 "); 
            }else{
                $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval`= 0 "); 
            }
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else{
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 0  AND `created_by` = '$logged_admin_id' ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
        
    }




    function fetchOnPaymentDataCount($dbconnection,$logged_admin_id,$logged_admin_role)
    {
        if(empty($logged_admin_id)){
            if($logged_admin_role == 9){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval`= 1 AND `second_approval` = 0 AND `org_name`=2 "); 
            }else{
                $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval`= 1 AND `second_approval` = 0 ");
            }
                
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else{
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval`= 1 AND `second_approval` = 0 AND `created_by` = '$logged_admin_id'");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
        
    }

    function fetchComPaymentDataCount($dbconnection,$logged_admin_id,$logged_admin_role)
    {
        if(empty($logged_admin_id)){
            if($logged_admin_role == 9){
                $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval`=1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1  AND `org_name` = 2"); 
            }else{
                $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval`=1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1  "); 
            }
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return 0;
           } 
           
        }else{
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval`=1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1 AND `created_by` = '$logged_admin_id'");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
        
    }


    function fetchCanPaymentDataCount($dbconnection,$logged_admin_id,$logged_admin_role)
    {
        if(empty($logged_admin_id)){
            if($logged_admin_role == 9){
                $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND `org_name` = 2 AND (`first_approval`= 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4)  "); 
            }else{
                $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND (`first_approval`= 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) " );  
            }
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else{
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval`= 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4 AND `created_by` = '$logged_admin_id'");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
        
    }



 
     function fetchPurchaseStatus($dbconnection,$purchaseid){  
        $query = mysqli_query($dbconnection, "SELECT `approve_status_text` , `approved_by` FROM `purchase_history`  WHERE `purchase_id`='$purchaseid' ORDER BY `sl_no` DESC LIMIT 1 ");
        $row = mysqli_fetch_assoc($query);
        if(!empty($row['approve_status_text'])){

            if($row['approve_status_text'] == 'Approved'){
                $approvalColor = 'badge-success';
                $statustext = 'Pending';
                $pendingnBy = 'Purchase Team';
            }else if($row['approve_status_text'] == 'Cancelled'){
                $approvalColor = 'badge-danger';
                $statustext = 'Cancelled';
                $pendingnBy =  getuserName($row['approved_by'],$dbconnection);
            }else if($row['approve_status_text'] == 'Created'){
                $approvalColor = 'badge-warning';
                $statustext = 'Pending';
                $pendingnBy = 'MD';
            }else if($row['approve_status_text'] == 'Completed'){
                $approvalColor = 'badge-success';
                $statustext = 'Completed';
                $pendingnBy = getuserName($row['approved_by'],$dbconnection);
            }if($row['approve_status_text'] == 'Payment Processed'){ 
                $approvalColor = 'badge-warning';
                $statustext = 'Payment Processed';
                $pendingnBy =  getuserName($row['approved_by'],$dbconnection);
            }

           return array($approvalColor,$statustext,$pendingnBy) ;
           
       }else{
          return array('badge-info','Pending','MD') ;
       } 
    }



    function RandomNumber($n) { 
        $characters = '0123456789'; 
        $randomString = ''; 
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
        return $randomString; 
    }
     
    function RandomString($n) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
        return $randomString; 
    }
 
    function uniqidReal($lenght = 13) { 
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        }  
        return substr(bin2hex($bytes), 0, $lenght);
    }
 
     

    
    
    
    function fetchPaymentStatus($dbconnection,$purchaseid){ 
        $query = mysqli_query($dbconnection, "SELECT `approve_status_text` , `approved_by` FROM `payment_history`  WHERE `payment_id`='$purchaseid' ORDER BY `sl_no` DESC LIMIT 1 ");
        $row = mysqli_fetch_assoc($query);
        if(!empty($row['approve_status_text'])){

            if($row['approve_status_text'] == 'Approved'){
                    $approvalColor = 'badge-success';
            }else if($row['approve_status_text'] == 'Cancelled'){
                $approvalColor = 'badge-danger';
            }else if($row['approve_status_text'] == 'Pending'){
                $approvalColor = 'badge-warning';
            }if($row['approve_status_text'] == 'On Processing'){ 
                $approvalColor = 'badge-warning';
            }

           return array($approvalColor, $row['approve_status_text'] , $row['approved_by']) ;
           
       }else{
          return array('badge-info', 'Pending','') ;
       } 
    }
    


    function IND_money_format($number)
{
    $decimal = (string)($number - floor($number));
    $money = floor($number);
    $length = strlen($money);
    $delimiter = '';
    $money = strrev($money);

    for($i=0;$i<$length;$i++){
        if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
            $delimiter .=',';
        }
        $delimiter .=$money[$i];
    }

    $result = strrev($delimiter);
    $decimal = preg_replace("/0\./i", ".", $decimal);
    $decimal = substr($decimal, 0, 3);

    if( $decimal != '0'){
        $result = $result.$decimal;
    }

    return $result;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
    function fetchPurchaseTotal($logged_admin_id,$dbconnection)
    {
        if(empty($logged_admin_id)){
            $sql = "SELECT SUM(total_amount) AS totalsales FROM purchase_request";
            $result = mysqli_query($dbconnection, $sql);
            $row = mysqli_fetch_array($result);
            return $row['totalsales'];

        }else{
            $sql = "SELECT SUM(total_amount) AS totalsales FROM purchase_request WHERE `created_by`='$logged_admin_id'";
            $result = mysqli_query($dbconnection, $sql);
            $row = mysqli_fetch_array($result);
            return $row['totalsales'];
 
        }
    }
   
    function fetchPurchaseTodayTotal($todaydate,$logged_admin_id,$dbconnection)
    {
        if(empty($logged_admin_id)){
            $sql = "SELECT SUM(total_amount) AS `totalsales` FROM `purchase_request` WHERE `created_date`  BETWEEN '$todaydate  00:00:00' AND '$todaydate 23:59:59'";
            $result = mysqli_query($dbconnection, $sql) or die(mysqli_error($dbconnection));
            $row = mysqli_fetch_array($result);
            $rowcount = mysqli_num_rows($result);
            if( $rowcount > 0){
                return $row['totalsales'];
            } else {
                return $rowcount;
            }
        }else{
            $sql = "SELECT SUM(total_amount) AS `totalsales` FROM `purchase_request` WHERE `created_date`  BETWEEN '$todaydate  00:00:00' AND '$todaydate 23:59:59' AND `created_by` = $logged_admin_id";
            $result = mysqli_query($dbconnection, $sql) or die(mysqli_error($dbconnection));
            $row = mysqli_fetch_array($result);
            $rowcount = mysqli_num_rows($result);
            if( $rowcount > 0){
                return $row['totalsales'];
            } else {
                return $rowcount;
            }
        }
       
    }

    function fetchPaymentTotal($dbconnection)
    {
        $sql = "SELECT SUM(total_amount) AS totalsales FROM purchase_request";
        $result = mysqli_query($dbconnection, $sql);
        $row = mysqli_fetch_array($result);
        return $row['totalsales'];
    }

    function fetchDataCount($dbconnection,$logged_admin_id,$tableName,$columnID,$conditionValue)
    {
        if(empty($logged_admin_id)){
        $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS totalCount FROM $tableName WHERE `$columnID`='$conditionValue'");
        $row = mysqli_fetch_assoc($query);
        if(!empty($row['totalCount'])){
           return  $row['totalCount'];
       }else{
           return '0';
       }  
    }else{
        $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS totalCount FROM $tableName WHERE `$columnID`='$conditionValue' AND `created_by` = '$logged_admin_id'");
        $row = mysqli_fetch_assoc($query);
        if(!empty($row['totalCount'])){
           return  $row['totalCount'];
       }else{
           return '0';
       }  
    }
    }


    function fetchDataSum($dbconnection,$logged_admin_id,$columnValue,$tableName,$columnID,$conditionValue)
    {
        if(empty($logged_admin_id)){
            $query = mysqli_query($dbconnection, "SELECT SUM($columnValue) AS `totalCount` FROM $tableName WHERE `$columnID`='$conditionValue'");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else{
            $query = mysqli_query($dbconnection, "SELECT SUM($columnValue) AS `totalCount` FROM $tableName WHERE `$columnID`='$conditionValue'  AND `created_by` = '$logged_admin_id' ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
        
    }
    
    
    function fetchOnProcessingCount($dbconnection,$logged_admin_id,$logged_admin_role)
    {
          switch ($logged_admin_role) {
            case '6':
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE  `first_approval`=1 AND `second_approval` =1 AND `created_by` ='$logged_admin_id' ");
              break;
            case '3':
            case '10':
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE  (`created_by` = '$logged_admin_id' OR `team_leader` = '$logged_admin_id') AND   `first_approval`=1 AND `second_approval` = 1 ");
              break; 
              case '9':
                $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `org_name` = 2");
                break; 
            default:
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE  `first_approval`=1 AND `second_approval` =1 ");
              break;
          } 
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           }  
          
    }
    
    
    
    // On Processing Function
    function fetchOnDataCount($dbconnection,$logged_admin_id)
    {
        if(empty($logged_admin_id)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=1 AND `second_approval` =0");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else{
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=1 AND `second_approval` =0 AND `created_by` = '$logged_admin_id'");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
        
    }
    
    function fetchOnDataSum($dbconnection,$logged_admin_id)
    {
        if(empty($logged_admin_id)){
            $query = mysqli_query($dbconnection, "SELECT SUM(total_amount) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=1 AND `second_approval` =0");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           }  
        }else{
            $query = mysqli_query($dbconnection, "SELECT SUM(total_amount) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=1 AND `second_approval` =0  AND `created_by`='$logged_admin_id'");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           }  
        }
    }

    // Completed Purchase
   
    function fetchComPurchaseCount($dbconnection,$logged_admin_id,$logged_admin_role)
    {
          switch ($logged_admin_role) {
            case '6':
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `completed`=1 AND `created_by` ='$logged_admin_id' ");
              break;
            case '3':
                case '10':
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE  (`created_by` = '$logged_admin_id' OR `team_leader` = '$logged_admin_id') AND  `completed`=1 ");
              break; 
              case '9':
                $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `org_name` = 2");
                break; 
            default:
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `completed`=1 ");
              break;
          } 
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           }  
          
    }
   
    
    function fetchComDataCount($dbconnection,$logged_admin_id)
    {
        if(empty($logged_admin_id)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `completed`=1 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 

        }else{
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `completed`=1 AND `created_by` ='$logged_admin_id' " );
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
        }

    }
    
    function fetchComDataSum($dbconnection,$logged_admin_id)
    {
        if(empty($logged_admin_id)){
            $query = mysqli_query($dbconnection, "SELECT SUM(total_amount) AS `totalCount` FROM `purchase_request` WHERE `completed`=1");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           }  
        }else{
            $query = mysqli_query($dbconnection, "SELECT SUM(total_amount) AS `totalCount` FROM `purchase_request` WHERE `completed`=1 AND `created_by` = '$logged_admin_id'");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           }
        }
    }
    
    
     function fetchCancelledPurchaseCount($dbconnection,$logged_admin_id,$logged_admin_role)
    {
          switch ($logged_admin_role) {
            case '6':
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=4 AND `created_by` ='$logged_admin_id' ");
              break;
            case '3':
                case '10':
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE  (`created_by` = '$logged_admin_id' OR `team_leader` = '$logged_admin_id') AND  `first_approval`=4 ");
              break; 
              case '9':
                $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `org_name` = 2");
                break; 
            default:
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=4 ");
              break;
          } 
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           }  
          
    }

    //  Cancelled Purchase request
    function fetchCanDataCount($dbconnection,$logged_admin_id)
    {
        if(empty($logged_admin_id)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=4 AND `second_approval` =4");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           }  
        }else{
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=4 AND `second_approval` =4 AND `created_by`='$logged_admin_id'");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           }
        }
    }

    function fetchPenDataCount($dbconnection,$logged_admin_id,$logged_admin_role)
    {
        
         switch ($logged_admin_role) {
            case '6':
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=0 AND `second_approval` =0 AND `created_by` = '$logged_admin_id'");
              break;
            case '3':
                case '10':
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE  (`created_by` = '$logged_admin_id' OR `team_leader` = '$logged_admin_id') AND `first_approval`=0 AND `second_approval` =0 ");
              break; 
              case '9':
                $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `org_name` = 2");
                break; 
            default:
              $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=0 AND `second_approval` =0");
              break;
          } 
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           }  
    }
   
    function fetchCanDataSum($dbconnection)
    {

        $query = mysqli_query($dbconnection, "SELECT SUM(total_amount) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=4 OR `second_approval` =4");
        $row = mysqli_fetch_assoc($query);
        if(!empty($row['totalCount'])){
           return  $row['totalCount'];
       }else{
           return '0';
       } 
    }

    function fetchPendingSum($dbconnection)
    {

        $query = mysqli_query($dbconnection, "SELECT SUM(total_amount) AS `totalCount` FROM `purchase_request` WHERE `first_approval`=0 AND `second_approval` =0");
        $row = mysqli_fetch_assoc($query);
        if(!empty($row['totalCount'])){
           return  $row['totalCount'];
       }else{
           return '0';
       } 
    }

    function triggremailWA($payid,$dbconnection){
        $userid = fetchData($dbconnection,'created_by','payment_request','pay_id',$payid);
        $paycode = fetchData($dbconnection,'pay_code','payment_request','pay_id',$payid);
        $useremail = fetchData($dbconnection,'emp_email','admin_login','emp_id',$userid);
        $supplieremail = fetchData($dbconnection,'supplier_mail','payment_request','pay_id',$userid);
        $message = "Your Payment Request Has Been Accepted for the Payment ID: ".$paycode;
        $to = "$useremail,$supplieremail";
        $subject = "Updated on Payment Request";
        $body = ''; 
        $headers = '';

        if (isset($_FILES)){

            $files = array();
            foreach ($_FILES as $name => $file) {
                $file_name = $file['name'];
                $temp_name = $file['tmp_name'];
                $file_type = $file['type'];
                $path_parts = pathinfo($file_name);
                $ext = $path_parts['extension'];
                array_push($files, $file);
            }

            $semi_rand = md5(time());   
            $boundary = "==Multipart_Boundary_x{$semi_rand}x";
            $eol = "\r\n";

            $headers = 'From: VENCAR Accounts<no-reply@vencar.com>' . "\r\n";
	        $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"";

            $body = "This is a multi-part message in MIME format.\n\n" . "--{$boundary}\n" . "Content-Type:text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message. "\n\n";
            $body .= "--{$boundary}\n";

            $path = pathinfo($_SERVER['PHP_SELF']);

            for ($x = 0; $x < count($files); $x++) {
                $file = fopen($files[$x]['tmp_name'], "rb");
                $data = fread($file, filesize($files[$x]['tmp_name']));
                fclose($file);
                $data = chunk_split(base64_encode($data));
                $name = $files[$x]['name'];
                $body .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$name\"\n" .
                        "Content-Disposition: attachment;\n" . " filename=\"$name\"\n" .
                        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                $body .= "--{$boundary}\n";
            } 

            $mailsent=mail($to,$subject,$body,$headers);

        }
    }


    function triggremail($payid, $dbconnection,$options){
        if($options == 'Payment'){
            $userid = fetchData($dbconnection,'created_by','payment_request','pay_id',$payid);
            $paycode = fetchData($dbconnection,'pay_code','payment_request','pay_id',$payid);
            $useremail = fetchData($dbconnection,'emp_email','admin_login','emp_id',$userid);
            $message = "Your Payment Request Has Been Approved by MD for the Payment ID: ".$paycode;
            $to = $useremail;
            $subject = "Updated on Payment Request";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: VENCAR Accounts<no-reply@vencar.com>' . "\r\n";
            $mailsent = mail($to,$subject,$message,$headers);
        }
        if($options == 'Purchase'){
            $userid = fetchData($dbconnection,'created_by','purchase_request','pur_id',$payid);
            $purchase_code = fetchData($dbconnection,'purchase_code','purchase_request','pur_id',$payid);
            $useremail = fetchData($dbconnection,'emp_email','admin_login','emp_id',$userid);
            $message = "Your Purchase Request Has Been Approved by MD for the Purchase Request ID: ".$purchase_code;
            $to = $useremail;
            $subject = "Updated on Purchase Request";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: VENCAR Accounts<no-reply@vencar.com>' . "\r\n";
            $mailsent = mail($to,$subject,$message,$headers);
        }
    }


    function verifytoken($userID, $token,$dbconnection){ 
        if(!empty($userID) && !empty($token)){
            $query = mysqli_query($dbconnection, "SELECT `valid` FROM `recovery_keys` WHERE `customer_ID` = $userID AND `token` = '$token'");
            $row = mysqli_fetch_assoc($query);
            if(mysqli_num_rows($query) > 0){
                if($row['valid'] == 1){
                    return 1;
                }else{
                    return 0;
                }
            }else	{
                return 0;
            }
        }
            
    }  

    function timeAgo($time_ago){
        $time_ago = strtotime($time_ago);
        $cur_time   = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed ;
        $minutes    = round($time_elapsed / 60 );
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400 );
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640 );
        $years      = round($time_elapsed / 31207680 );
        // Seconds
        if($seconds <= 60){
            return "just now";
        }
        //Minutes
        else if($minutes <=60){
            if($minutes==1){
                return "one minute ago";
            }
            else{
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if($hours <=24){
            if($hours==1){
                return "an hour ago";
            }else{
                return "$hours hrs ago";
            }
        }
        //Days
        else if($days <= 7){
            if($days==1){
                return "yesterday";
            }else{
                return "$days days ago";
            }
        }
        //Weeks
        else if($weeks <= 4.3){
            if($weeks==1){
                return "a week ago";
            }else{
                return "$weeks weeks ago";
            }
        }
        //Months
        else if($months <=12){
            if($months==1){
                return "a month ago";
            }else{
                return "$months months ago";
            }
        }
        //Years
        else{
            if($years==1){
                return "one year ago";
            }else{
                return "$years years ago";
            }
        }
    }

    function pendingrequestcount($dbconnection,$paycode,$payid,$logged_admin_id){
        $selectquery = "SELECT  *  FROM `payment_request` WHERE `pay_code` = '$paycode' ORDER BY `pay_id` DESC LIMIT 1 "; 
        $executequery = mysqli_query($dbconnection,$selectquery);
        $row = mysqli_fetch_assoc($executequery);
        // $count = $row['totalCount'];
        return $row['fourth_approval'] ;
        

    }

    function pendingrequestBalance($dbconnection,$paycode){
        $selectquery = "SELECT  *  FROM `payment_request` WHERE `pay_code` = '$paycode' ORDER BY `pay_id` DESC LIMIT 1 "; 
        $executequery = mysqli_query($dbconnection,$selectquery);
        $row = mysqli_fetch_assoc($executequery);
        // $count = $row['totalCount'];
        return $row['balance_amount'] ;
        

    }

    function billupload($dbconnection,$paycode,$payid,$getstatus,$uploadmethod){
        if($uploadmethod == 'Bill'){ 
            $selectupload = "SELECT * FROM `payment_pdf` WHERE `pay_code` = '$paycode' AND `uploaded_type` = '$uploadmethod' ";  
            if($getstatus == 1){
                $executeuploadquery = mysqli_query($dbconnection,$selectupload);
                $row = mysqli_fetch_assoc($executeuploadquery);
                if(!empty($row['uploaded_type'])){
                    return $row['uploaded_type'];
                }else{
                    return '0';
                }
            }
            if($getstatus == 2){
                $executeuploadquery = mysqli_query($dbconnection,$selectupload);
                $row = mysqli_fetch_assoc($executeuploadquery);
                if(!empty($row['uploaded_by'])){
                    $uploadBY = $row['uploaded_by'];
                    $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$uploadBY'");
                    $rows = mysqli_fetch_assoc($executeuserquery);
                    return $rows['emp_name'];
                }else{
                    return '0';
                }
            }
            if($getstatus == 3){
                $executeuploadquery = mysqli_query($dbconnection,$selectupload);
                $row = mysqli_fetch_assoc($executeuploadquery);
                if(!empty($row['uploaded_time'])){
                    return $row['uploaded_time'];
                }else{
                    return '0';
                }
            }
        }
    }

    
    function paymentprocessuser($dbconnection,$firstApproval,$secondApproval,$thirdApproval,$fourthApproval,$payid,$paycode,$paymentclose){
        if(empty($firstApproval)){
            $executequery = mysqli_query($dbconnection,"SELECT `created_by` FROM `payment_request` WHERE `pay_code` = '$paycode' AND `pay_id` = '$payid'");
            $row = mysqli_fetch_assoc($executequery);
            if(!empty($row['created_by'])){
                $createdBY = $row['created_by'];
                $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
                $rows = mysqli_fetch_assoc($executeuserquery);
                return $rows['emp_name'];
            }
        }
        if($firstApproval == 1 && $secondApproval != 1 && $secondApproval != 4){
            $executequery = mysqli_query($dbconnection,"SELECT `first_approval_by` FROM `payment_request` WHERE `pay_code` = '$paycode' AND `pay_id` = '$payid'");
            $row = mysqli_fetch_assoc($executequery);
            if(!empty($row['first_approval_by'])){
                $createdBY = $row['first_approval_by'];
                $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
                $rows = mysqli_fetch_assoc($executeuserquery);
                return $rows['emp_name'];
            }
        }
        if ($firstApproval == 4 || $secondApproval == 4 || $thirdApproval == 4 || $fourthApproval == 4) {
            if($firstApproval == 4){
                $executequery = mysqli_query($dbconnection,"SELECT `first_approval_by` FROM `payment_request` WHERE `pay_code` = '$paycode' AND `pay_id` = '$payid'");
                $row = mysqli_fetch_assoc($executequery);
                $createdBY = $row['first_approval_by'];
                $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
                $rows = mysqli_fetch_assoc($executeuserquery);
                return $rows['emp_name'];
            }else if($secondApproval == 4){
                $executequery = mysqli_query($dbconnection,"SELECT `second_approval_by` FROM `payment_request` WHERE `pay_code` = '$paycode' AND `pay_id` = '$payid'");
                $row = mysqli_fetch_assoc($executequery);
                $createdBY = $row['second_approval_by'];
                $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
                $rows = mysqli_fetch_assoc($executeuserquery);
                return $rows['emp_name'];
            }else if($thirdApproval == 4){
                $executequery = mysqli_query($dbconnection,"SELECT `third_approval_by` FROM `payment_request` WHERE `pay_code` = '$paycode' AND `pay_id` = '$payid'");
                $row = mysqli_fetch_assoc($executequery);
                $createdBY = $row['third_approval_by'];
                $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
                $rows = mysqli_fetch_assoc($executeuserquery);
                return $rows['emp_name'];
            }
            else if($fourthApproval == 4){
                $executequery = mysqli_query($dbconnection,"SELECT `fourth_approval_by` FROM `payment_request` WHERE `pay_code` = '$paycode' AND `pay_id` = '$payid'");
                $row = mysqli_fetch_assoc($executequery);
                $createdBY = $row['fourth_approval_by'];
                $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
                $rows = mysqli_fetch_assoc($executeuserquery);
                return $rows['emp_name'];
            }
        }
        if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 0) {
            $executequery = mysqli_query($dbconnection,"SELECT `second_approval_by` FROM `payment_request` WHERE `pay_code` = '$paycode' AND `pay_id` = '$payid'");
            $row = mysqli_fetch_assoc($executequery);
            if(!empty($row['second_approval_by'])){
                $createdBY = $row['second_approval_by'];
                $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
                $rows = mysqli_fetch_assoc($executeuserquery);
                return $rows['emp_name'];
            }
        }
        if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 0) {
            $executequery = mysqli_query($dbconnection,"SELECT `third_approval_by` FROM `payment_request` WHERE `pay_code` = '$paycode' AND `pay_id` = '$payid'");
            $row = mysqli_fetch_assoc($executequery);
            if(!empty($row['third_approval_by'])){
                $createdBY = $row['third_approval_by'];
                $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
                $rows = mysqli_fetch_assoc($executeuserquery);
                return $rows['emp_name'];
            }
        }
        if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 1 && $paymentclose == 0) {
            $executequery = mysqli_query($dbconnection,"SELECT `fourth_approval_by` FROM `payment_request` WHERE `pay_code` = '$paycode' AND `pay_id` = '$payid'");
            $row = mysqli_fetch_assoc($executequery);
            if(!empty($row['fourth_approval_by'])){
                $createdBY = $row['fourth_approval_by'];
                $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
                $rows = mysqli_fetch_assoc($executeuserquery);
                return $rows['emp_name'];
            }
        }
        if ($firstApproval == 1 && $secondApproval == 1 && $thirdApproval == 1 && $fourthApproval == 1 && $paymentclose == 1){
            $executequery = mysqli_query($dbconnection,"SELECT `closed_by` FROM `payment_request` WHERE `pay_code` = '$paycode' AND `pay_id` = '$payid'");
            $row = mysqli_fetch_assoc($executequery);
            if(!empty($row['closed_by'])){
                $createdBY = $row['closed_by'];
                $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
                $rows = mysqli_fetch_assoc($executeuserquery);
                return $rows['emp_name'];
            }

        }

    }
    
    
    function TotalPaymentPendingCount($dbconnection,$logged_admin_id,$role){
        if($role == 6){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND `user_cancel` = 0 AND `first_approval` = 0 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }elseif($role == 5 || $role == 8){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND `first_approval` = 0 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else if($role == 3 || $role == 10){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND `first_approval` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if($role == 7){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`raised_by` = 2 OR `purchase_payment` = 1 OR `created_by` = '$logged_admin_id') AND `first_approval` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 9){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 0 AND `org_name` = 2 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 11){
            $orgname = fetchData($dbconnection,'emp_org','admin_login','emp_role',$role);
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 0 AND `org_name` = '$orgname' ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if(empty($role)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 0");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
    }

    function TotalPaymentOnproCount($dbconnection,$logged_admin_id,$role){
        if($role == 6 || $role == 5){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND `first_approval` = 1 AND `second_approval` = 0 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else if($role == 3 || $role == 10){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND `first_approval` = 1 AND `second_approval` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if($role == 7){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`raised_by` = 2 OR `purchase_payment` = 1 OR `created_by` = '$logged_admin_id') AND `first_approval` = 1 AND `second_approval` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 9){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `org_name`=2 AND `first_approval` = 1 AND `second_approval` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 11){
            $orgname = fetchData($dbconnection,'emp_org','admin_login','emp_role',$role);
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 0 AND `org_name` = '$orgname'");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if(empty($role)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 0");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
    }

    function TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,$role){
        if($role == 6 || $role == 5){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 0 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else if($role == 3 || $role == 10){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if($role == 7){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`raised_by` = 2 OR `purchase_payment` = 1 OR `created_by` = '$logged_admin_id') AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 11){
            $orgname = fetchData($dbconnection,'emp_org','admin_login','emp_role',$role);
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 0 AND `org_name` = '$orgname'");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if(empty($role)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 0 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
    }

    function TotalPaymentWaitingCount($dbconnection,$logged_admin_id,$role){
        if($role == 6 || $role == 5){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 0 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else if($role == 3 || $role == 10){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if($role == 7){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`raised_by` = 2 OR `purchase_payment` = 1 OR `created_by` = '$logged_admin_id') AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 9){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  `org_name` = 2 AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 11){
            $orgname = fetchData($dbconnection,'emp_org','admin_login','emp_role',$role);
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 0 AND `org_name` = '$orgname'");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if(empty($role)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 0 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
    }

    function TotalPaymentApprovedCount($dbconnection,$logged_admin_id,$role){
        if($role == 6 || $role == 5){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1 AND `close_pay` = 0 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else if($role == 3 || $role == 10){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1 AND `close_pay` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if($role == 7){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`raised_by` = 2 OR `purchase_payment` = 1 OR `created_by` = '$logged_admin_id') AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1 AND `close_pay` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 9){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  `org_name` = 2 AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1 AND `close_pay` = 0 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 11){
            $orgname = fetchData($dbconnection,'emp_org','admin_login','emp_role',$role);
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1 AND `org_name` = '$orgname'");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if(empty($role)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1 AND `close_pay` = 0 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
    }

    function TotalPaymentCompleteCount($dbconnection,$logged_admin_id,$role){
        if($role == 6 || $role == 5){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1 AND `close_pay` = 1 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else if($role == 3 || $role == 10){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1 AND `close_pay` = 1 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if($role == 7){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`raised_by` = 2 OR `purchase_payment` = 1 OR `created_by` = '$logged_admin_id') AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1  AND `fourth_approval` = 1 AND `close_pay` = 1 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 9){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `org_name` = 2  AND `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1  AND `fourth_approval` = 1 AND `close_pay` = 1 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 11){
            $orgname = fetchData($dbconnection,'emp_org','admin_login','emp_role',$role);
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1 AND `close_pay` = 1 AND `org_name` = '$orgname'");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if(empty($role)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `first_approval` = 1 AND `second_approval` = 1 AND `third_approval` = 1 AND `fourth_approval` = 1 AND `close_pay` = 1 ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
    }


    function TotalPaymentCancelCount($dbconnection,$logged_admin_id,$role){
        if($role == 6){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND (`user_cancel` = 4 OR `first_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else if($role == 5){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND (`first_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else if($role == 3 || $role == 10){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') AND (`first_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4 OR `fourth_approval` = 4) ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if($role == 7){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`raised_by` = 2 OR `purchase_payment` = 1 OR `created_by` = '$logged_admin_id') AND (`first_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4  OR `fourth_approval` = 4) ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 9){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE (`first_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4  OR `fourth_approval` = 4) AND `org_name` = 2 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if($role == 11){
            $orgname = fetchData($dbconnection,'emp_org','admin_login','emp_role',$role);
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE (`first_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4  OR `fourth_approval` = 4) AND `org_name` = '$orgname'");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if(empty($role)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE (`first_approval` = 4 OR `second_approval` = 4 OR `third_approval` = 4  OR `fourth_approval` = 4) ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }
    }


    function paymentagainst($dbconnection,$paymentvalue){
        $query = mysqli_query($dbconnection, "SELECT `payment_name` FROM `payment_type` WHERE `payment_value` = '$paymentvalue' ");
        $row = mysqli_fetch_assoc($query);
        if(!empty($row['payment_name'])){
            return  $row['payment_name'];
        }else{
            return '0';
        }
    }

    function noneditbalance($dbconnection,$paycode){
        $query = mysqli_query($dbconnection,"SELECT COUNT(*) as TotalCount FROM `payment_request` WHERE `pay_code` = '$paycode'");
        $row = mysqli_fetch_assoc($query);
        if(!empty($row['TotalCount'])){
            return  $row['TotalCount'];
        }else{
            return '0';
        }
    }

    function pendingrequestEditBalance($dbconnection,$paycode){
        $selectquery = "SELECT  *  FROM `payment_request` WHERE `pay_code` = '$paycode' ORDER BY `pay_id` DESC LIMIT 1 "; 
        $executequery = mysqli_query($dbconnection,$selectquery);
        $row = mysqli_fetch_assoc($executequery);
        // $count = $row['totalCount'];
        return $row['balance_amount'] ;
    }


    function existapproved($dbconnection,$payid,$approve_option){
        $selectquery = "SELECT COUNT(*) as TotalCount FROM `payment_history` WHERE `payment_id` = '$payid' AND `approval_type` = '$approve_option'";
        $executequery = mysqli_query($dbconnection,$selectquery);
        $row = mysqli_fetch_assoc($executequery);
        if(!empty($row['TotalCount'])){
            return  $row['TotalCount'];
        }else{
            return '0';
        }
    }

    function messagecount($dbconnection,$payid,$paycode,$logged_role){
        $executemessage = mysqli_query($dbconnection,"SELECT COUNT(*) as TotalCount FROM `message` WHERE `sender` = '$logged_role' AND `pay_id` = '$payid' ");
        $row = mysqli_fetch_assoc($executemessage);
        if(!empty($row['TotalCount'])){
            return  $row['TotalCount'];
        }else{
            return '0';
        }
    }

    function messageby($dbconnection,$payid){
        $executemessage = mysqli_query($dbconnection,"SELECT `trigger_from` FROM `message` WHERE `sl_no` = '$payid' ");
        $row = mysqli_fetch_assoc($executemessage);
        if(!empty($row['trigger_from'])){
            $createdBY = $row['trigger_from'];
            $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
            $rows = mysqli_fetch_assoc($executeuserquery);
            return $rows['emp_name'];
        }
    }
    
    
    function TotalPaymentCount($dbconnection,$logged_admin_id,$role){
        if($role == 6 || $role == 5){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `created_by` = '$logged_admin_id'");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
               return  $row['totalCount'];
           }else{
               return '0';
           } 
           
        }else if($role == 3  || $role == 10){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`team_leader` = '$logged_admin_id' OR `created_by` = '$logged_admin_id') ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if($role == 7){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE  (`raised_by` = 2 OR `purchase_payment` = 1 OR `created_by` = '$logged_admin_id') ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }else if(($role == 1 || $role == 2 || $role == 4  || $role == 8)){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` ");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            } 
        }else if($role == 9){
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE   `org_name` = 2 ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }
        else if($role == 11){
            $orgname = fetchData($dbconnection,'emp_org','admin_login','emp_role',$role);
            $query = mysqli_query($dbconnection, "SELECT COUNT(*) AS `totalCount` FROM `payment_request` WHERE `org_name` = '$orgname' ");
                $row = mysqli_fetch_assoc($query);
                if(!empty($row['totalCount'])){
                return  $row['totalCount'];
            }else{
                return '0';
            }
        }
    }
    
    
    
    function getPurchaseCompletedName($dbconnection,$purid){
         $selectquery = "SELECT  *  FROM `purchase_history` WHERE `purchase_id` = '$purid' AND `approve_status_text` = 'Completed'"; 
        $executequery = mysqli_query($dbconnection,$selectquery);
        $row = mysqli_fetch_assoc($executequery); 
        return $row['approved_by'] ;
        
    }
    
     
    function fetchBalanceAmountChangeAdmin($dbconnection,$step,$amount,$payid){
        
        if($step == 0){
            $query = mysqli_query($dbconnection,"SELECT `advanced_amonut` FROM `payment_request` WHERE `advance_step` = '$step' AND `pay_id`= '$payid'");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['advanced_amonut'])){
                return $amount-$row['advanced_amonut'];
            }else{
                return  0;
            } 
        }else{
            $query = mysqli_query($dbconnection,"SELECT `advanced_amonut` FROM `payment_request` WHERE `advance_step` = '$step' AND `pay_id` = '$payid'");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['advanced_amonut'])){
                return  $row['advanced_amonut'];
            }else{
                return  0;
            } 
        }
             
    }
    
    
    function AmountChangeAdmin($dbconnection,$amount,$payid){
         $query = mysqli_query($dbconnection,"SELECT `balance_amount` FROM `payment_request` WHERE `pay_id`= '$payid'");
            $row = mysqli_fetch_assoc($query);
            if(!empty($row['balance_amount'])){
                return $row['balance_amount'];
            }else{
                return  0;
            } 
    }  

    function checkOrgStatus($dbconnection,$logged_id){
        $orgId = fetchData(
            $dbconnection,
            'emp_org',
            'admin_login',
            'emp_id',
            $logged_id
        );
        $query = mysqli_query($dbconnection,"SELECT `org_flow` FROM `organization` WHERE `id`= '$orgId'");
        $row = mysqli_fetch_assoc($query);
        if(!empty($row['org_flow'])){
            return true;
        }else{
            return  false;
        } 
    }


    function feedbackFrom($dbconnection,$payid){
        $query = mysqli_query($dbconnection,"SELECT `message_content` , `trigger_from` FROM `message` WHERE `pay_id`= '$payid' ORDER BY `sl_no` DESC");
        if($row = mysqli_fetch_assoc($query)){
            if(!empty($row['message_content'])){
                return array($row['message_content'],$row['trigger_from']);
           }else{
            return array(0,0);
           }
        } 
        else{
            return array(0,0);
           }
   }  
    
   function expenditureTotal($logged_admin_id,$dbconnection){
        if(!empty($logged_admin_id)){
            $sql = "SELECT SUM(`expenditure_amount`) AS totalExpenditure , `pay_id` FROM `payment_request` WHERE `created_by` = '$logged_admin_id' AND `third_approval` = 1 AND `expenditure_status` = 1";
            $result = mysqli_query($dbconnection, $sql);
            if($row = mysqli_fetch_array($result)){
               return  array($row['totalExpenditure'], $row["pay_id"]);   
            }else{
               return  array(0,0);
            }
        } 
   }    
  
   function expenditureMonthLeft($month,$dbconnection){
       if(!empty($month)){
           $sql = "SELECT `exp_credit_left` FROM `expenditures` WHERE `exp_month` = '$month' ORDER BY `exp_credit_left` ASC";
           $result = mysqli_query($dbconnection, $sql);
           if($row = mysqli_fetch_array($result)){
               return  $row['exp_credit_left'];   
           }else{
               return false;
           }
       } 
    } 

    function expenditurePendingCount($dbconnection, $empid, $options, $exp_approval_1){
        if($options == 1){
            if(!empty($empid)){
                if(empty($exp_approval_1)){
                    $sql = "SELECT COUNT(*) AS `totalexpCount` FROM `expenditures` WHERE `exp_created_by` = '$empid' AND `exp_approval_1` = 0";
                    $result = mysqli_query($dbconnection, $sql);
                    if($row = mysqli_fetch_array($result)){
                        return  $row['totalexpCount'];   
                    }else{
                        return 0;
                    }
                }
            }
        }
        if($options == 2){
            if(!empty($empid)){
                if(empty($exp_approval_1)){
                    $sql = "SELECT SUM(`exp_amount`) AS `totalMonthExp` FROM `expenditures` WHERE `exp_created_by` = '$empid' AND `exp_approval_1` = 0";
                    $result = mysqli_query($dbconnection, $sql);
                    if($row = mysqli_fetch_array($result)){
                        return  $row['totalMonthExp'];   
                    }else{
                        return false;
                    }
                }
            }
        }
        if($options == 3){
            if(!empty($empid)){
                $sql = "SELECT * FROM `expenditures` WHERE `exp_created_by` = '$empid' AND `exp_approval_1` = 0 ORDER BY `exp_id` DESC";
                $result = mysqli_query($dbconnection, $sql);
                if($row = mysqli_fetch_array($result)){
                    return  $row['exp_credit_left'];   
                }else{
                    return false;
                }
            }
        }
        if($options == 4){
            if(!empty($empid)){
                $sql = "SELECT * FROM `expenditures` WHERE `exp_created_by` = '$empid' AND `exp_approval_1` = 0 ORDER BY `exp_id` DESC";
                $result = mysqli_query($dbconnection, $sql);
                if($row = mysqli_fetch_array($result)){
                    return  $row['exp_credit'];   
                }else{
                    return false;
                }
            }
        }
    }

    function paymentuserCancel($dbconnection,$usercancel,$paycode,$payid){
        if($usercancel == 4){
            $executequery = mysqli_query($dbconnection,"SELECT `user_cancel_by` FROM `payment_request` WHERE `pay_code` = '$paycode' AND `pay_id` = '$payid'");
            $row = mysqli_fetch_assoc($executequery);
            $createdBY = $row['user_cancel_by'];
            $executeuserquery = mysqli_query($dbconnection,"SELECT *  FROM `admin_login` WHERE `emp_id` = '$createdBY'");
            $rows = mysqli_fetch_assoc($executeuserquery);
            return $rows['emp_name'];
        }
    }

    function randomColor(){
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
    
    function checkUserflow($dbconnection,$empid){
        $selectflow = mysqli_query($dbconnection, "SELECT * FROM `payment_user_flow` WHERE `emp_id` = '$empid'");
        if(mysqli_num_rows($selectflow) > 0){
            return true;
        }else{
            return false;
        }
    }

    function checkUserPurchaseflow($dbconnection,$empid){
        $selectflow = mysqli_query($dbconnection, "SELECT * FROM `purchase_user_flow` WHERE `emp_id` = '$empid'");
        if(mysqli_num_rows($selectflow) > 0){
            return true;
        }else{
            return false;
        }
    }

    function fetchOrgflow($dbconnection, $orgId, $options){
        if($options == 1){
            $selectflow = mysqli_query($dbconnection, "SELECT * FROM `organization` WHERE `id` = '$orgId'");
            if(mysqli_num_rows($selectflow) > 0){
                if($row = mysqli_fetch_array($selectflow)){
                    $response['approval1']  = $row['first_approval'];     
                    $response['approval2']  = $row['orglead_approval'];     
                    $response['approval3']  = $row['second_approval'];     
                    $response['approval4']  = $row['third_approval'];     
                    $response['approval5']  = $row['fourth_apporval'];     
                    if(!empty($response)){
                        return $response;
                    }
                    else{
                       return "";
                    }
                }
            }
        }
        if($options == 2){
            $selectflow = mysqli_query($dbconnection, "SELECT * FROM `organization` WHERE `id` = '$orgId'");
            if(mysqli_num_rows($selectflow) > 0){
                if($row = mysqli_fetch_array($selectflow)){
                    $response['approval1']  = $row['purchase_orglead_approval'];     
                    $response['approval2']  = $row['purchase_fisrt_approval'];     
                    $response['approval3']  = $row['purchase_second_approval'];  
                    if(!empty($response)){
                        return $response;
                    }
                    else{
                       return "";
                    }
                }
            }
        }
    }
    
    
    function existapprovedexpenditure($dbconnection,$closeid,$approve_option){
        $selectquery = "SELECT COUNT(*) as `TotalCount` FROM `expenditure_history` WHERE `close_ID` = '$closeid' AND `aprrove_status` = '$approve_option'";
        $executequery = mysqli_query($dbconnection, $selectquery);
        $row = mysqli_fetch_assoc($executequery);
        if(!empty($row['TotalCount'])){
            return $row['TotalCount'];
        }else{
            return '0';
        }
    }

    function getPreviousExp($dbconnection, $logged_admin_id){
        if(!empty($logged_admin_id)){
            $sql = "SELECT `total_credit` FROM `expenditure_amount` WHERE `rasisd_for` = '$logged_admin_id' AND `status` = 1 ORDER BY `amount_ID` DESC";
            $result = mysqli_query($dbconnection, $sql);
            if($row = mysqli_fetch_assoc($result)){
               return $row['total_credit']; 
            }else{
               return  0;
            }
        }
    }

    function getIndianCurrency($number){
        $no = (int)floor($number);
        $decimal = (int)round(($number - $no) * 100);
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees Only' : '');
    }

    function expenditurePending($dbconnection,$empid){
        if(!empty($empid)){
            $sql = "SELECT COUNT(*) AS `totalexpCount` FROM `expenditures` WHERE `exp_created_by` = '$empid' AND `exp_approval_1` = 0";
            $result = mysqli_query($dbconnection, $sql);
            if($row = mysqli_fetch_array($result)){
                return  $row['totalexpCount'];   
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    function numtowords($num)
    { 
        $decones = array( 
                    '01' => "One", 
                    '02' => "Two", 
                    '03' => "Three", 
                    '04' => "Four", 
                    '05' => "Five", 
                    '06' => "Six", 
                    '07' => "Seven", 
                    '08' => "Eight", 
                    '09' => "Nine", 
                    10 => "Ten", 
                    11 => "Eleven", 
                    12 => "Twelve", 
                    13 => "Thirteen", 
                    14 => "Fourteen", 
                    15 => "Fifteen", 
                    16 => "Sixteen", 
                    17 => "Seventeen", 
                    18 => "Eighteen", 
                    19 => "Nineteen" 
                    );
        $ones = array( 
                    0 => " ",
                    1 => "One",     
                    2 => "Two", 
                    3 => "Three", 
                    4 => "Four", 
                    5 => "Five", 
                    6 => "Six", 
                    7 => "Seven", 
                    8 => "Eight", 
                    9 => "Nine", 
                    10 => "Ten", 
                    11 => "Eleven", 
                    12 => "Twelve", 
                    13 => "Thirteen", 
                    14 => "Fourteen", 
                    15 => "Fifteen", 
                    16 => "Sixteen", 
                    17 => "Seventeen", 
                    18 => "Eighteen", 
                    19 => "Nineteen" 
                    ); 
        $tens = array( 
                    0 => "",
                    2 => "Twenty", 
                    3 => "Thirty", 
                    4 => "Forty", 
                    5 => "Fifty", 
                    6 => "Sixty", 
                    7 => "Seventy", 
                    8 => "Eighty", 
                    9 => "Ninety" 
                    ); 
        $hundreds = array( 
                    "Hundred", 
                    "Thousand", 
                    "Million", 
                    "Billion", 
                    "Trillion", 
                    "Quadrillion" 
                    ); //limit t quadrillion 
        $num = number_format($num,2,".",","); 
        $num_arr = explode(".",$num); 
        $wholenum = $num_arr[0]; 
        $decnum = $num_arr[1]; 
        $whole_arr = array_reverse(explode(",",$wholenum)); 
        krsort($whole_arr); 
        $rettxt = ""; 
        foreach($whole_arr as $key => $i){ 
            if($i < 20){ 
                $rettxt .= $ones[$i]; 
            }
            elseif($i < 100){ 
                $rettxt .= $tens[substr($i,0,1)]; 
                $rettxt .= " ".$ones[substr($i,1,1)]; 
            }
            else{ 
                $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
                $rettxt .= " ".$tens[substr($i,1,1)]; 
                $rettxt .= " ".$ones[substr($i,2,1)]; 
            } 
            if($key > 0){ 
                $rettxt .= " ".$hundreds[$key]." "; 
            } 
        
        } 
        $rettxt = $rettxt." Rupees ";
        
        if($decnum > 0){ 
            $rettxt .= " and "; 
            if($decnum < 20){ 
                $rettxt .= $decones[$decnum]; 
            }
            elseif($decnum < 100){ 
                $rettxt .= $tens[substr($decnum,0,1)]; 
                $rettxt .= " ".$ones[substr($decnum,1,1)]; 
            }
            $rettxt = $rettxt." paise"; 
        } 
        return $rettxt;
    }
    
    function checkproductQty($dbconnection,$productid){ 
        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_stock_master` WHERE `product_id` = '$productid'")  or die(mysqli_error($dbconnection));
        if(mysqli_num_rows($query) > 0){
            return true;
        }else{
            return false;
        } 
    }



    function fetchPOStatus($dbconnection,$poid){  
        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_po_status`  WHERE `po_id`='$poid' ORDER BY `status_id` DESC LIMIT 1 ");
        $row = mysqli_fetch_assoc($query);
        if(!empty($row['po_status'])){

            if($row['po_status'] == '1'){
                $approvalColor = 'badge-success';
                $statustext = 'PO Generated'; 
                $addedby = getuserName($row['status_added_by'],$dbconnection);
                $addedtime = date('D,d M Y  h:i a', strtotime($row['status_added_time']));
            }else if($row['po_status'] == '2'){
                $approvalColor = 'badge-warning text-dark';
                $statustext = 'Transit Done'; 
                $addedby = getuserName($row['status_added_by'],$dbconnection);
                $addedtime = date('D,d M Y  h:i a', strtotime($row['status_added_time']));
            }else if($row['po_status'] == '3'){
                $approvalColor = 'badge-success';
                $statustext = 'Inward Done';
                $addedby = getuserName($row['status_added_by'],$dbconnection);
                $addedtime = date('D,d M Y  h:i a', strtotime($row['status_added_time']));
            }if($row['po_status'] == '4'){ 
                $approvalColor = 'badge-warning';
                $statustext = 'Payment Processed';
                $addedby =  getuserName($row['status_added_by'],$dbconnection);
                $addedtime = date('D,d M Y  h:i a', strtotime($row['status_added_time']));
            }

           return array($approvalColor,$statustext,$addedby,$addedtime) ;
           
       }else{
          return array('badge-info','Pending','No One','') ;
       } 
    }


    function getProductLocation($dbconnection,$location_id){
            $final = ''; 
            $sql = "SELECT * FROM `ft_location` LEFT JOIN `ft_store_room` ON `ft_store_room`.`store_id` = `ft_location`.`lo_store_room_id` LEFT JOIN `ft_rack` ON `ft_rack`.`rack_id` = `ft_location`.`lo_rack_id` LEFT JOIN `ft_column` ON `ft_column`.`column_id` = `ft_location`.`lo_column_id` WHERE `location_id` = '$location_id'";
            $result = mysqli_query($dbconnection, $sql);
            if($row = mysqli_fetch_array($result)){
                $store =   $row['store_name'];   
                $rack =   $row['rack_name'];   
                $column =   $row['column_name'];   
            } 
            if(!empty($store)){
                $final = $store;
            }
            if(!empty($rack)){
                $final .= ' , '.$rack; 
            }
            if(!empty($column)){
                $final .= ' , '.$column;
            } 
            return $final; 
    }
    
    function getProductLocationQR($dbconnection,$location_id){
            $final = 0; 
            $sql = "SELECT * FROM `ft_location` LEFT JOIN `ft_store_room` ON `ft_store_room`.`store_id` = `ft_location`.`lo_store_room_id` LEFT JOIN `ft_rack` ON `ft_rack`.`rack_id` = `ft_location`.`lo_rack_id` LEFT JOIN `ft_column` ON `ft_column`.`column_id` = `ft_location`.`lo_column_id` WHERE `location_id` = '$location_id'";
            $result = mysqli_query($dbconnection, $sql);
            if($row = mysqli_fetch_array($result)){
                $store =   $row['lo_store_room_id'];   
                $rack =   $row['lo_rack_id'];   
                $column =   $row['lo_column_id'];   
                $storeqr =   $row['store_qr'];   
                $rackqr =   $row['rack_qr'];   
                $columnqr =   $row['column_qr'];   
            } 
            if(!empty($store)){
                $final = $storeqr;
                $finalpath = "./assets/qr/storeroom/";
            } 
            if(!empty($rack)){
                $final =   $rackqr;
                $finalpath  = "./assets/qr/rack/";
            }
            if(!empty($column)){
                $final =  $columnqr;
                $finalpath = "./assets/qr/column/";
            } 
            return array($finalpath,$final) ;
    }




    function checkproductsupplier($dbconnection,$supid,$productid){
        $query = mysqli_query($dbconnection, "SELECT * FROM `ft_product_details`  WHERE `supplier_id` = '$supid' AND `product_id`= '$productid'");
        if(mysqli_num_rows($query) > 0){
            return true;
        }else{
            return false;
        } 
    }