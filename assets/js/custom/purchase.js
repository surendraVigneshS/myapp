        $("#autocomplete").autocomplete({
            source: "./include/searchPurchase.php",  
            focus: function( event, ui ) {
            $( "#autocomplete" ).val( ui.item.name );
            return false;
            },
            select: function( event, ui ) 
            { 
                $("#autocomplete").val(ui.item.label);
                $("#supplierName").val(ui.item.name);  
                $("#supplierEmail").val(ui.item.email);
                $("#supplierMobile").val(ui.item.mobile);
                $("#supplierRef").val(ui.item.ref); 
            }
            
        }
        
        )
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
            if( !$.isArray(item) ||  !item ) {
                return $( "<li>" )
                .append( "<div>" +  " " +item.name+"  ,  Ref No : " + item.ref + "</div>" )
                .appendTo( ul );
            }else{ 
                return $( "<li>" )
                .append( "<div>" +  "No Resulst Found " + "</div>" )
                .appendTo( ul );
            }
         }; 

         $('#ifpodone').change(function() {
            $('#productimageupload').toggle(500);
        });
    
        $('#advencAmount,#totalAmount').keyup(function() {
            var totalAmount =  Number($('#totalAmount').val());

            var advanceAmount =  Number($('#advencAmount').val());
            $('#amountWords').val(inWords($('#totalAmount').val()));

            if(advanceAmount){

                if(totalAmount >= advanceAmount )
                {
                    var balanceAmount =  totalAmount - advanceAmount; 
                    $('#balanceAmount').val(balanceAmount);
                    $('#totalAmount').removeClass('is-invalid');  
                    $("#addPurchase").removeAttr("disabled");
                }
                else
                {
                    $('#totalAmount').addClass('is-invalid');  
                    $("#addPurchase").attr("disabled", "true");
                    $('#balanceAmount').val('');
                } 

            } 
        }); 