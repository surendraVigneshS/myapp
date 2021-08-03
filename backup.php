<?php
include('./include/dbconfig.php');
include('./include/function.php');
include('./include/authenticate.php');
$fieldid = $action = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
if (isset($_GET['fieldid'])) {
    $fieldid = passwordDecryption($_GET['fieldid']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <title>Add New Purchase Order | Freeztex | Accounts</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/date-picker.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/select2.css">
    <style>
        .card .card-body,
        .card .card-footer {
            padding: 10px 20px;
        }
    </style>
</head>

<body>
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include('./include/topbar.php'); ?>
        <div class="page-body-wrapper">
            <?php include('./include/left-sidebar.php'); ?>
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3> Purchase Order</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./home-dashboard.php"><i data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Add Purchase Order</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <form action="./include/_poController.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5>Add New Purchase Order</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="mb-4 row">
                                            <div class="col-6">
                                                <label class="col-form-label" for="purType">Purchase Type *</label>
                                                <select class="form-select" name="purType" required>
                                                    <option value="Purchase Order">Purchase Order</option>
                                                    <option value="Job Order">Job Order</option>
                                                </select>
                                            </div>

                                            <div class="col-6">
                                                <label class="col-form-label" for="group">PO Date *</label>
                                                <input type="text" id="datepicker1" class="form-control" name="poDate" value="<?php echo Date('d-m-Y'); ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label for="user_name">Supplier Name</label>
                                                <select class="form-select select2" name="supplierID" required>
                                                    <option value="" selected disabled>----</option>
                                                    <?php
                                                    $query = mysqli_query($dbconnection, "SELECT * FROM `supplier_details` ORDER BY `supplier_name` ASC ");
                                                    while ($rows = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                        <option value="<?php echo $rows['cust_id']; ?>" class="text-capitalize">
                                                            <?php echo $rows['supplier_name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class=" row mb-4">
                                            <div class="col-6">
                                                <label class="col-form-label " for="itemType">Item Type </label>
                                                <select class="form-select select2" id="itemType" name="itemType" required>
                                                    <option value="Capital Goods"> Capital Goods </option>
                                                    <option value="Cosumables"> Cosumables </option>
                                                    <option value="Instruments"> Instruments </option>
                                                    <option value="Packaging Materials"> Packaging Materials </option>
                                                    <option value="Process Item"> Process Item </option>
                                                    <option value="Raw Material"> Raw Material </option>
                                                    <option value="Tools & Dies"> Tools & Dies </option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label " for="itemGroup">Item Group</label>
                                                <select class="form-select select2" id="itemGroup" name="itemGroup">
                                                    <option value="" selected disabled>---</option>
                                                    <?php
                                                    $executeQuery = mysqli_query($dbconnection, "SELECT * FROM `ft_item_group` WHERE `group_status` = 1");
                                                    while ($row = mysqli_fetch_array($executeQuery)) {
                                                    ?>
                                                        <option value="<?php echo $row["group_id"]; ?>"> <?php echo $row["group_name"] ?> </option>
                                                    <?php  } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <hr>
                                        <h6 class="mb-3">Product List</h6>
                                        <div class="row mb-3 ">
                                            <div class="col-6">
                                                <label class="col-form-label" for="proId">Product Name *</label>
                                                <select class="form-select   productList" id="proId">
                                                    <option value="" selected>---</option>
                                                </select>
                                            </div>

                                            <div class="col-2">
                                                <label class="col-form-label" for="productQty">Product Qty *</label>
                                                <input class="form-control" type="text" id="proQty" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                            <div class="col-4">
                                                <label class="col-form-label" for="productAmount">Product Amount *</label>
                                                <input class="form-control" type="text" id="proAmount" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-end">
                                            <div class="col-4">
                                                <label class="col-form-label" for="discPercen">Discount Percentage </label>
                                                <input class="form-control" type="text" id="discPercen" maxlength="3">
                                            </div>
                                            <div class="col-4">
                                                <label class="col-form-label " for="discAmount">Discount Amount</label>
                                                <input class="form-control" type="text" id="discAmount">
                                            </div>
                                            <div class="col-4">
                                                <label class="col-form-label " for="proFinalAmount">Final Amount</label>
                                                <input class="form-control" type="text" id="proFinalAmount" readonly>
                                            </div>
                                        </div>
                                        <div class="row mt-md-3">
                                            <div class="col-12">
                                                <label class="col-form-label" for="productdesc">Product Description </label>
                                                <textarea id="productdesc" rows="2" placeholder="Remarks if any" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button class="btn btn-success m-4" type="button" id="addRow">Add New Row</button>

                                            </div>
                                        </div>
                                        <input type="hidden" name="finalTotal" id="finalTotal">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">Product Name</th>
                                                        <th scope="col">Product Desc</th>
                                                        <th scope="col">Qty</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Disc %</th>
                                                        <th scope="col">Disc Amount</th>
                                                        <th scope="col">Final Amount</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-4">
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5>Tax/Addition/Deduction</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <div class="col-12">
                                                <label class="col-form-label" for="taxType">Type *</label>
                                                <select class="form-select" id="taxType">
                                                    <option value="">---</option>
                                                    <option value="1">Tax</option>
                                                    <option value="2">Additions</option>
                                                    <option value="3">Deductions</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="col-form-label" for="taxName">Name *</label>
                                                <select class="form-select" id="taxName">
                                                    <option value="" selected>---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-end">
                                            <div class="col-6">
                                                <label class="col-form-label" for="disctaxPercen">Per % </label>
                                                <input class="form-control" type="text" id="disctaxPercen" maxlength="3">
                                            </div>
                                            <div class="col-6">
                                                <label class="col-form-label " for="disctaxAmount">Rs ₹</label>
                                                <input class="form-control" type="text" id="disctaxAmount">
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-end">
                                                <button class="btn btn-success m-4" type="button" id="addTaxRow">Add</button>

                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">Type</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">%</th>
                                                        <th scope="col">Rs</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="taxtableBody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5>Submit Form</h5>
                                    </div>
                                    <div class="card-body">

                                        <div class="row mb-4">
                                            <div class="col-4 text-end">
                                                <label class="col-form-label " for="finalNetAmount">Net Amount</label>

                                            </div>
                                            <div class="col-8">
                                                <input class="form-control" name="finalNetAmount" id="finalNetAmount" required>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-4 text-end">
                                                <label class="col-form-label " for="fileAttach">Attach File</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="file" class="form-control" name="fileAttach">
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <textarea name="remarks" rows="2" placeholder="description if any" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center ">
                                            <button class="btn btn-info" type="submit" name="addProduct">Create New Purchase Order</button>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php include('./include/footer.php'); ?>
    </div>
    </div>
    <script src="./assets/js/jquery-3.5.1.min.js"></script>
    <script src="./assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="./assets/js/icons/feather-icon/feather-icon.js"></script>
    <script src="./assets/js/scrollbar/simplebar.js"></script>
    <script src="./assets/js/scrollbar/custom.js"></script>
    <script src="./assets/js/config.js"></script>
    <script src="./assets/js/sidebar-menu.js"></script>
    <script src="./assets/js/datepicker/datepicker.js"></script>
    <script src="./assets/js/datepicker/datepicker.en.js"></script>
    <script src="./assets/js/select2/select2.full.min.js"></script>
    <script src="./assets/js/script.js"></script>
    <script>
        $('#itemGroup').on('change', function() {
            var groupId = $(this).val();
            if (groupId) {
                $.ajax({
                    type: 'POST',
                    url: './include/ajax-call.php',
                    data: {
                        filterProducts: 1,
                        groupId: groupId
                    },
                    success: function(html) {
                        $('#proId').html(html);
                    }
                });
            } else {
                $('#proId').html('<option value="" selected>Select Modules first</option>');
            }
        }); 

        $('#taxType').on('change', function() {
            var type = $(this).val();
            // var type = 
            if (type) {
                $.ajax({
                    type: 'POST',
                    url: './include/ajax-call.php',
                    data: {
                        filterType: 1,
                        type: type
                    },
                    success: function(html) {
                        $('#taxName').html(html);
                    }
                });
            } else {
                $('#taxName').html('<option value="" selected>Select Type first</option>');
            }
        });
         
        const calculateSale = (listPrice, discount) => {
            listPrice = parseFloat(listPrice);
            discount = parseFloat(discount);
            return (listPrice - (listPrice * discount / 100)).toFixed(2); // Sale price
        }
        const calculateDiscount = (listPrice, salePrice) => {
            listPrice = parseFloat(listPrice);
            salePrice = parseFloat(salePrice);
            return 100 - (salePrice * 100 / listPrice); // Discount percentage
        }

        const   $list = $('#proAmount'),
                $disc = $('#discPercen'),
                $sale = $('#discAmount'),
                $final = $('#proFinalAmount');

        $list.add($disc).on('input', () => {
            let sale = $list.val() ;
            if ($disc.val().length) {
                sale = calculateSale($list.val(), $disc.val());
            }
            $final.val(sale);
            $sale.val($list.val() - sale);
        });

        $sale.on('input', () => {
            let disc = 0;
            let discamount = parseFloat($sale.val());

            if ($sale.val().length) {
                disc = calculateDiscount($list.val(), $sale.val());
            }

            $disc.val(disc);
            var value = $list.val() - discamount;

            $final.val(value);
        });

        $list.trigger('input');


        function GSTCalculate(totalamount, gstpercentage) {
            var calculatedValue = (totalamount * gstpercentage) / 100;
            return calculatedValue;
        }

        function calculatePerc(discountPrice, price) {
            var calcPerc = (price - discountPrice) * 100 / price,
                discountPerc = calcPerc.toFixed(2);
            return discountPerc;
        }



        $("#disctaxPercen").on('keyup', function() {
            const $taxper = $(this).val();
            var total = 0;
            $('input[name="productfinamount[]"]').each(function() {
                total += Number($(this).val());
            });
            var tax = Number(GSTCalculate(total, $taxper));
            $('#disctaxAmount').val(tax);
            checkButtonStatus();
        });

        $("#disctaxAmount").on('keyup', function() {
            $('#disctaxPercen').val('');
            checkButtonStatus();
        });

        function checkButtonStatus() {
            var amount = $('#finalNetAmount').val();
            if (amount) {
                $("#addTaxRow").removeAttr("disabled");
            } else {
                $("#addTaxRow").attr("disabled", "true");
            }
        }

        function getNetAmount() {
            var grandTotal = disctaxAmount = 0;
            $('input[name="productfinamount[]"]').each(function() {
                grandTotal += Number($(this).val());
            });

            if ($('input[name="disctaxAmount[]"]').length > 0) {
                $('input[name="disctaxAmount[]"]').each(function() {
                    disctaxAmount += Number($(this).val());
                });
            }

            var finalNetAmount = Number(grandTotal) + Number(disctaxAmount);
            $('#finalTotal').val(finalNetAmount.toFixed(2));
            $('#finalNetAmount').val(finalNetAmount.toFixed(2));
        }

        function deductionNetAmount(disctaxAmount) {
            var finalamount = $("#finalNetAmount").val();
            var calulatedAmount = Number(finalamount) - Number(disctaxAmount);
            $('#finalNetAmount').val(calulatedAmount);
            // return calulatedAmount; 
        }

        $(function() {
            checkButtonStatus();
            $(".select2").select2();
            $("#datepicker1").datepicker({
                Format: 'dd-mm-yyyy'
            });
            
            
            $("#addRow").click(function() {
                var grandTotal = 0;
                var proid = $('#proId').val();
                var proname = $("#proId option:selected").text();
                var proqty = $('#proQty').val();
                var basicamount = $('#proAmount').val();
                var discamount = $('#discAmount').val();
                var discper = $('#discPercen').val();
                var productdesc = $('#productdesc').val();
                console.log(productdesc);
                var finalamount = $('#proFinalAmount').val();
                if (proid && finalamount) {
                    var elem = '<tr class="text-center">';
                    elem += '<td> <input type="hidden" name="productid[]" value="' + proid + '"><input type="hidden" name="productname[]" value="' + proname + '"> <p>' + proname + '</p> ';
                    elem += '<td><input type="hidden" name="productdesc[]" value="' + productdesc + '"> <p>' + productdesc + '</p> </td> ';
                    elem += '<td><input type="hidden" name="productqty[]" value="' + proqty + '"> <p>' + proqty + '</p> </td> ';
                    elem += '<td><input type="hidden" name="productrate[]" value="' + basicamount + '"> <p>' + basicamount + '</p> </td> ';
                    elem += '<td><input type="hidden" name="productdiscper[]" value="' + discper + '"> <p>' + discper + ' %</p> </td> ';
                    elem += '<td><input type="hidden" name="productdiscamount[]" value="' + discamount + '"> <p>' + discamount + '</p> </td> ';
                    elem += '<td><input type="hidden" name="productfinamount[]" value="' + finalamount + '"> <p>' + finalamount + '</p> </td> ';
                    elem += '<td><a href="javascript:void(0);" class="remCF"><button class="btn btn-danger btn-xs" type="button" id="removeRow"  >Remove</button></a>  </td> ';
                    elem += '</tr>';

                    $("#tableBody").append(elem);

                    $('input[name="productfinamount[]"]').each(function() {
                        grandTotal += Number($(this).val());
                    });
                    
                    $('#discPercen,#discAmount,#proId,#proAmount,#proFinalAmount,#proQty').val('');
                    $('#finalTotal').val(grandTotal);
                    getNetAmount();
                    checkButtonStatus();
                } else {
                    alert('product & amount cant be empty');
                }

            }); 

            $("#addTaxRow").click(function() {
                var taxType = $('#taxType').val();
                var taxTypeText = $('#taxType option:selected').text();
                var taxName = $('#taxName').val();
                var taxNameText = $('#taxName  option:selected').text();
                var disctaxPercen = $('#disctaxPercen').val();
                var disctaxAmount = $('#disctaxAmount').val();
                
                if (taxType && taxName) {
                    var elem = '<tr class="text-center">';
                    elem += '<td> <input type="hidden" name="taxType[]" value="' + taxType + '"> <p>' + taxTypeText + '</p> ';
                    elem += '<td><input type="hidden" name="taxName[]" value="' + taxNameText + '"> <p>' + taxNameText + '</p> </td> ';
                    elem += '<td><input type="hidden" name="disctaxPercen[]" value="' + disctaxPercen + '"> <p>' + disctaxPercen + '</p> </td> ';
                    elem += '<td><input type="hidden" name="disctaxAmount[]" value="' + disctaxAmount + '"> <p>' + disctaxAmount + '</p> </td> ';
                    elem += '<td><a href="javascript:void(0);" class="remTaxCF"><button class="btn btn-danger btn-xs" type="button" >Remove</button></a>  </td> ';
                    elem += '</tr>';
                    $("#taxtableBody").append(elem);
                    if (taxType == 3) {
                        deductionNetAmount(disctaxAmount);
                    } else {
                        getNetAmount();
                    }
                    $('#taxType,#taxName,#disctaxPercen,#disctaxAmount').val('');
                    
                } else {
                    alert("Product & Amount can't be empty");
                }
                
            });
            
            $("#tableBody").on('click', '.remCF', function() {
                $(this).parent().parent().remove();
                getNetAmount();
            });

            $("#taxtableBody").on('click', '.remTaxCF', function() {
                $(this).parent().parent().remove();
                getNetAmount();
            });
        });

        </script>
</body>

</html>