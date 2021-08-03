<?php


use Mpdf\Mpdf;

include('./mpdf18/vendor/autoload.php');
include('./mpdf18/vendor/mpdf/mpdf/src/Mpdf.php');
// For Testing
// include('./dbconfig.php');
// include('./function.php');

function createpofile($dbconnection, $productId){

    $upload_dir = '';
    $query = mysqli_query($dbconnection, "SELECT * FROM `ft_po` LEFT JOIN `supplier_details` ON `ft_po`.`po_supplier_id` =  `supplier_details`.`cust_id` WHERE  `ft_po`.`po_id` = '$productId'");
    if (mysqli_num_rows($query) > 0) {
        if ($row = mysqli_fetch_array($query)) {
            $po_code = $row['po_code'];
            $po_type = $row['po_type']; 
            $supName = $row['supplier_name'];
            $supemail = $row['supplier_email'];
            $supmob = $row['supplier_mobile'];
            $supgst = $row['supplier_gst'];
            $supadd = $row['supplier_address'];
            $supcity = $row['supplier_city'];
            $suppin = $row['supplier_pincode'];
             
            $totalamount = $row['po_total_amount'];
            $finalamount = $row['po_final_amount'];
            $amount_in_words = $row['amount_in_words'];
            // $po_terms = $row['po_terms'];
            $po_remarks = $row['po_remarks'];
            $poDate = date('d/m/Y', strtotime($row['po_date']));
            $createdby =  getuserName($row['po_created_by'], $dbconnection);
            $createdmobile =  fetchData($dbconnection,'emp_mobile','admin_login','emp_id',$createdby);
             
        }
    }
    
    $html = '
    <div class="header-div">
        <div class="div-logo">
            <a href="https://www.freeztek.com/"><img src="../assets/images/logo/logo.png" width="100px" alt="" /></a>
        </div>   
    </div>
    <div class="div-header-right">
        <h1 class="po-title capitalize">'.$po_type.'</h1>
    </div>
    <div class="div-po-from">
        <div class="po-from-details">
            <h4 class="po-from-title">Freeztech</h4>
            <h6 class="po-from-desc">3-E, Chokkampudhur Road, Coimbatore-641001</h6>
            <h6 class="po-from-desc">Mobile : 9443130846</h6>
            <h6 class="po-from-desc">Mail : <a href="mailto:sales@freeztek.com">purchase@svcgpl.com / rama30846@gmail.com</a></h6>
            <h6 class="po-from-desc">Website : <a href="https://www.freeztek.com/">www.freeztek.com</a></h6>
        </div>
        <div class="po-no-details">
            <h4 class="po-from-title">PO Details</h4>
            <h6 class="po-from-desc">PO No : <strong>'.$po_code.'</strong></h6>
            <h6 class="po-from-desc">Date : '.$poDate.'</h6>
            <h6 class="po-from-desc">GSTIN : <strong>33AADFF3185G1ZN</strong></h6>
        </div>
    </div>
    <div class="div-po-to">
        <div class="po-to-details">
            <h4 class="po-to-title">Supplier Details</h4>
            <h4 class="po-from-title capitalize">'.$supName.'</h4>
            <h6 class="po-from-desc">'.$supadd.','.$supcity.'-'.$suppin.'</h6>
            <h6 class="po-from-desc">Mobile : '.$supmob.'</h6>
            <h6 class="po-from-desc">Mail : <a href="mailto:'.$supemail.'">'.$supemail.'</a></h6>
            <h6 class="po-from-desc">GSTIN : '.$supgst.'</h6>
        </div>
        <div class="po-delivery-details">
            <h4 class="po-delivery-title">Delivery Address</h4>
            <div style="padding-left: 50px;">
                <h4 class="po-from-title capitalize">Freeztech</h4>
                <h6 class="po-from-desc">No.1 Govindanaickenpalayam, Thudiyalur To Kovilpalayam Road, Athipalayam (P.O),<br>Coimbatore - 641110</h6>
                <!--<h6 class="po-from-desc">Mobile : 7010749496</h6>-->
            </div>
        </div>
    </div><div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Item Description</th>
                <th>UOM</th>
                <th>Qty</th>
                <th>Rate <br>(Rs.)</th>
                <!-- <th>Disc <br>(%)</th> -->
                <th>Disc <br>(Rs.)</th>
                <th>Amount <br>(Rs.)</th>
            </tr>
        </thead>
        <tbody>';
    
    $slNo = 1;
    $product_list = mysqli_query($dbconnection, "SELECT * FROM `ft_po_details` LEFT JOIN `ft_product_master` ON `ft_product_master`.`product_id` =  `ft_po_details`.`po_product_id` WHERE  `ft_po_details`.`po_id` = '$productId'");
    if (mysqli_num_rows($product_list) > 0) {
        while ($rowproduct = mysqli_fetch_array($product_list)) {
            $html .= '<tr>
                <td>'.$slNo.'</td>
                <td class="capitalize">'.$rowproduct["po_product_name"].'<br>'.$rowproduct["po_product_desc"].'</td>
                <td>'.$rowproduct["product_unit"].'</td>
                <td>'.$rowproduct["po_product_qty"].'</td>
                <td>'.IND_money_format($rowproduct["po_product_sub_amount"]).'</td>
                <!-- <td>0.00%</td> -->
                <td>'.IND_money_format($rowproduct["po_product_disc_amount"]).'</td>
                <td>'.IND_money_format($rowproduct["po_product_final_amount"]).'</td>
            </tr>';    
        }
    }  
    
    $html .= '
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right"><h4>Total Amount Rs.</h4></td>
                <td class="text-right footer-amount">'.IND_money_format($totalamount).'</td>
            </tr>';

    $query = mysqli_query($dbconnection, "SELECT * FROM `ft_po_add_details` LEFT JOIN `ft_po_details` ON `ft_po_add_details`.`po_add_po_id` =  `ft_po_details`.`po_product_id` WHERE  `ft_po_add_details`.`po_add_po_id` = '$productId'");
    if (mysqli_num_rows($query) > 0){
        while ($row = mysqli_fetch_array($query)){
            if(!empty($row["po_add_per"])){
                $disper = $row["po_add_per"].'.00 %';
            }else{
                $disper =  "";
            }
            if($row["po_add_type"] == 3){
                // $discAmount = '( - ) '.$row["po_add_amount"];
                $discAmount = '(-)';
            }else{
                // $discAmount = '( + ) '.$row["po_add_amount"];
                $discAmount = '(+) ';
            }
            $html .= '<tr>
                <td colspan="6" class="text-right"><h4>'.$row["po_add_name"].' ('.$disper.') Rs.</h4></td>
                <td class="text-right footer-amount">'.$discAmount.IND_money_format($row["po_add_amount"]).'</td>
            </tr>';
        }
    }
      
    $html .=' <tr>
            <td colspan="6" class="text-right"><h4>Net Amount Rs.</h4></td>
            <td class="text-right footer-amount">'.IND_money_format($finalamount).'</td>
        </tr>
        </tfoot>
        </table>
    </div>
    <div class="amount-words">
        <h5>Amount in words: <span style="font-weight: normal;font-size: 12px;">'.$amount_in_words.'</span></h5>
    </div>
    <div class="div-signature">
        <div class="div-po-create">
            <div class="po-create-sign">
                <!-- <img src="./author-sign.png" alt="" class="author-sign"> -->
                <h6 class="po-create-name">'.$createdby.'</h6>
                <h6 class="po-create-design">Prepared By</h6>';
                if (!empty($po_remarks)) {
                    $html .='<h6 class="po-from-desc">(Mobile : '.$createdmobile.')</h6>';
                }
       $html .= '</div>
        </div>
        <div class="div-po-author">
            <div class="po-create-sign"> 
            <!-- <img src="./author-sign.png" alt="" class="author-sign"> 
                <h6 class="po-create-name">for FREEZ TECH INNOVATIONS</h6>-->
                <h6 class="po-create-design">Authorised Signatory</h6>
            </div>
        </div>
    </div>
    <div class="div-terms">
    <div class="terms-condition">
        <h4>Terms & Conditions</h4>
        <ol>';

    $query = mysqli_query($dbconnection, "SELECT * FROM `ft_po_terms` WHERE `ft_terms_po_id`= '$productId'");
    if (mysqli_num_rows($query) > 0) {
        $slno = 1;
        while ($row = mysqli_fetch_array($query)) {
            $html .= '<li><h4>'.fetchData($dbconnection,'terms_heading','ft_terms','terms_id',$row["ft_terms_id"]).': <span>'.$row["ft_terms_content"].'.</span></h4></li>'; 
            $slno++;
        }
    }

    $html .= '</ol>
        </div>
        <div class="div-qr-code">
            <!-- <img src="./mpdf18/qr-code-image.png" alt="" class="qr-img" /> -->
        </div>
    </div>';
    if(!empty($po_remarks)){
        $html .= '<div class="remarks">
        <h6>Remarks : <span>'.$po_remarks.'</span></h6>    
    </div>'; } 
    $html .='<div class="footer"></div>';

    $mpdf = new mPDF([
        'default_font_size' => 0,
        'default_font' => '',
        'margin_left' => 0,
        'margin_right' => 0,
        'margin_top' => 15,
        'margin_bottom' => 10,
    ]);

    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;

    $stylesheet = file_get_contents('mpdf18/pdf-style.css');
    $mpdf->SetWatermarkText('Freeztech');
    $mpdf->showWatermarkText = true;
    $mpdf->watermarkTextAlpha = 0.05;

    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($html, 2);

    $filename =  hexdec(uniqid(2)).'_'.strtoupper($supName);
    // Save the file
    $mpdf->Output('../assets/pdf/purchase/'.$filename.'.pdf', 'F');
    // See Output
    // $mpdf->Output();
    return $filename . '.pdf';

}
 
// createpofile($dbconnection, '1');