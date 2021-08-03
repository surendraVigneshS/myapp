$(document).ready(function() {
   
  $("#approve").click(function(){
    alert('asds');
      var orderid = $('#orderid').val();  
      var logged_admin = $('#logged_admin').val();  
      var result = confirm("Are you sure you want to  dispatch this order?");  
      if(result)
              {
                  $.ajax({
                      url: "../admins-dashboard/inc/_updateOrder.php",
                  cache: false,
                  type: 'POST',
                  data:{dispatch_order:1,orderid:orderid,logged_admin:logged_admin},
                  success:function(data)
                  {  
                      location.reload();
                  }
                  });   
              } 
    }); 
  
  
    $("#disapprove").click(function(){
      var orderid = $('#orderid').val();  
      var logged_admin = $('#logged_admin').val();  
      var result = confirm("Are you sure you want to  dispatch this order?");  
      if(result)
              {
                  $.ajax({
                      url: "../admins-dashboard/inc/_updateOrder.php",
                  cache: false,
                  type: 'POST',
                  data:{dispatch_order:1,orderid:orderid,logged_admin:logged_admin},
                  success:function(data)
                  {  
                      location.reload();
                  }
                  });   
              } 
    }); 

});