$("#autocomplete").autocomplete({
    source: "./include/search.php",  
    focus: function( event, ui ) {
    $( "#autocomplete" ).val( ui.item.name );
    return false;
    },
    select: function( event, ui ) 
    { 
         
             
            $("#autocomplete").val(ui.item.label);
            $("#companyName").val(ui.item.name);  
            $("#companyEmail").val(ui.item.email);
            $("#companyMobile").val(ui.item.mobile);
            $("#companyBranch").val(ui.item.branch);
            $("#accNo").val(ui.item.accNo);
            $("#ifsccode").val(ui.item.ifscCode);
      
     
    }
    
}

)
.autocomplete( "instance" )._renderItem = function( ul, item ) {
    if(item.name){
        return $( "<li>" )
        .append( "<div>" +  " " +item.name  +"  ,  Acc No : " + item.accNo + "</div>" )
        .appendTo( ul );
    }else{
        console.log('asds');
        return $( "<li>" )
        .append( "<div>" +  "No Resulst Found " + "</div>" )
        .appendTo( ul );
    }

        
    

};