       $('#ifpodone').change(function () {
           $('#productimageupload').toggle(500);
       });

       $('#advencAmount,#totalAmount').keyup(function () {
           var totalAmount = Number($('#totalAmount').val());

           var advanceAmount = Number($('#advencAmount').val());
           $('#amountWords').val(inWords($('#totalAmount').val()));

           if (advanceAmount) {

               if (totalAmount >= advanceAmount) {
                   var balanceAmount = totalAmount - advanceAmount;
                   $('#balanceAmount').val(balanceAmount);
                   $('#totalAmount').removeClass('is-invalid');
                   $("#addPurchase").removeAttr("disabled");
               } else {
                   $('#totalAmount').addClass('is-invalid');
                   $("#addPurchase").attr("disabled", "true");
                   $('#balanceAmount').val('');
               }

           }
       });

if ($("#autocomplete").length > 0) {
    $("#autocomplete").autocomplete({
        source: "./include/searchPurchase.php",
        focus: function (event, ui) {
            $("#autocomplete").val(ui.item.name);
            return false;
        },
        select: function (event, ui) {
            $("#autocomplete").val(ui.item.label);
            $("#supplierID").val(ui.item.id);
            $("#supplierName").val(ui.item.name);
            $("#supplierEmail").val(ui.item.email);
            $("#supplierMobile").val(ui.item.mobile);
            $("#accNo").val(ui.item.accNo);
            $("#ifsccode").val(ui.item.ifscCode);
        }

    }).autocomplete("instance")._renderItem = function (ul, item) {
        if (!$.isArray(item) || !item) {
            return $("<li>")
                .append("<div>" + " " + item.name + "  ,  Mobile No : " + item.mobile + "</div>")
                .appendTo(ul);
        } else {
            return $("<li>")
                .append("<div>" + "No Resulst Found " + "</div>")
                .appendTo(ul);
        }
    }; 
       }
      