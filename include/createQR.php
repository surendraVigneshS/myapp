<?php
    require_once('./phpqrcode/qrlib.php'); 
    
    function createProductqr($productpath,$productid){
        $fileName  = uniqid().".png";
        $fullpath = $productpath.$fileName; 
        QRcode::png($productid, $fullpath); 
        return $fileName;
    }
    
     