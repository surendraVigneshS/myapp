
function aprrovePurchase(purchaseId,adminId,adminRole,table){
  $(this).attr('disabled',true);
  $.ajax({
    url: "./include/ajax-call.php",
    cache: false,
    type: 'POST',
    data:{approvePurchase:1,purchaseId:purchaseId,adminRole:adminRole,adminId:adminId},
    success : function(data){ 
        if(data == '1'){ 
             table.ajax.reload( null, false );  
        } 
    }
  });
 
}

function aprroveMDUserPurchase(purchaseId,adminId,adminRole,table2){
   
  $.ajax({
    url: "./include/ajax-call.php",
    cache: false,
    type: 'POST',
    data:{approveAlreadyPurchase:1,purchaseId:purchaseId,adminRole:adminRole,adminId:adminId},
    success : function(data){ 
      console.log(data);
        if(data == '1'){
          table2.ajax.reload( null, false );   
        } 
    }
  });
 
}


function disapprovMDPurchase(purchaseId,adminId,adminRole,table){
  swal("Are you sure ? Do you want to approve this request ?", {
    buttons: {
      Disapprove: "Disapprove",
      Cancel: true,
    },
            content: {
              element: "input",
              attributes: {
                placeholder: "Reason To Cancel",
                type: "text",
                idName: "inputfiledcustom",
              },
            },
            closeOnClickOutside: false,
            closeOnEsc: false,
  })
  .then((value) => {
    if (value == 'Disapprove') {
        var cancelReason = $('.swal-content__input').val();
                $.ajax({
                  url: "./include/ajax-call.php",
                  cache: false,
                  type: 'POST',
                  data:{disapprovMDPurchase:1,purchaseId:purchaseId,adminRole:adminRole,adminId:adminId,cancelReason:cancelReason},
                  success : function(data){ 
                      if(data == '1'){
                          // swal("Success", "Purchase Request Cancelled", "success");
                          table.ajax.reload( null, false );  
                      } 
                  }
                });
              }
            });
}


function disapprovMDUserPurchase(purchaseId,adminId,adminRole,table2){
  swal("Are you sure ? Do you want to approve this request ?", {
    buttons: {
      Disapprove: "Disapprove",
      Cancel: true,
    },
            content: {
              element: "input",
              attributes: {
                placeholder: "Reason To Cancel",
                type: "text",
                idName: "inputfiledcustom",
              },
            },
            closeOnClickOutside: false,
            closeOnEsc: false,
  })
  .then((value) => {
    if (value == 'Disapprove') {
                $.ajax({
                  url: "./include/ajax-call.php",
                  cache: false,
                  type: 'POST',
                  data:{disapprovMDPurchase:1,purchaseId:purchaseId,adminRole:adminRole,adminId:adminId,cancelReason:cancelReason},
                  success : function(data){ 
                      if(data == '1'){ 
                          table2.ajax.reload( null, false );  
                      } 
                  }
                });
              }
            });
}
    
$(document).ready(function() {

  $(document).ajaxStart(function() {  
    $(".Approve").attr('disabled','disabled'); 
    $(".Approves").attr('disabled','disabled');
  }).ajaxStop(function() {
    $(".Approve").removeAttr('disabled');
    $(".Approves").removeAttr('disabled');
  });
 
  
    var table = $('#example').DataTable( {
        "ajax": "./data.php",
        "processing": true,
        "pageLength": 50,
        "columns": [
            {
                "className":'details-control',
                "orderable":false,
                "data":null,
                "defaultContent": ''
            },
            { "data": "created_date" },
            { "data": "supplier_name" },
            { "data": "project_title" } ,
            // { "data": "total_amount" },
            { "data": "pr_name" } ,
            { "data": "purchase_type" } ,
            {"data": null,
            "defaultContent": '<button class="btn btn-success Approve" name="Approve">Approve</button>'
            },
            {"data": null,
            "defaultContent": '<button class="btn btn-danger Disapprove" name="disApprove">Cancel</button>'
            }  
            ] 
    } );
      
      $('#example tbody').on('click', 'td.details-control', function () {

        var tr = $(this).closest('tr');
        var row = table.row( tr );
         
        if ( row.child.isShown() ) {
              row.child.hide();
              tr.removeClass('shown');
            
            }else 
            {
              var val = row.data()['pur_id'];   

              $.ajax({
              url: "./include/ajax-call.php", 
              method:"POST",
              data:{ajaxData:1,purchaseId:val},  
              success:function(data)
              {  
                  row.child(data).show();
              }
              })  
              tr.addClass('shown');
            }
      } );

      $('#example tbody').on( 'click', 'button', function () { 
         
        
        var action = $(this).attr('class').split(' ').pop(); 
        var data = table.row( $(this).parents('tr') ).data();
        var logged_admin_id = $('#logged_admin_id').val();
        var logged_admin_role = $('#logged_admin_role').val();

        if (action=='Approve') { aprrovePurchase(data['pur_id'],logged_admin_id,logged_admin_role,table);  }
        if(action == 'Disapprove'){ disapprovMDPurchase(data['pur_id'],logged_admin_id,logged_admin_role,table);  }

        });   

        var table2 = $('#example2').DataTable( {
          "ajax": "./data2.php", 
          "pageLength": 50,
          "columns": [
              {
                  "className":'details-control',
                  "orderable":false,
                  "data":null,
                  "defaultContent": ''
              },
              { "data": "created_date" },
              { "data": "supplier_name" },
              { "data": "project_title" } ,
              { "data": "total_amount" },
              { "data": "pr_name" } ,
              { "data": "purchase_type" } ,
              {"data": null,
              "defaultContent": '<button class="btn btn-success Approves" name="Approves">Approve</button>'
              },
              {"data": null,
              "defaultContent": '<button class="btn btn-danger Disapproves" name="disApprove">Cancel</button>'
              }  
              ] 
      } );


        $('#example2 tbody').on('click', 'td.details-control', function () {

          var tr = $(this).closest('tr');
          var row = table2.row( tr );
           
          if ( row.child.isShown() ) {
                row.child.hide();
                tr.removeClass('shown');
              
              }else 
              {
                var val = row.data()['pur_id'];   
  
                $.ajax({
                url: "./include/ajax-call.php", 
                method:"POST",
                data:{ajaxData:1,purchaseId:val},  
                success:function(data)
                {  
                    row.child(data).show();
                }
                })  
                tr.addClass('shown');
              }
        } );
        
        

        $('#example2 tbody').on( 'click', 'button', function () { 
          var action = $(this).attr('class').split(' ').pop();
           
          var data = table2.row( $(this).parents('tr') ).data();
          var logged_admin_id = $('#logged_admin_id').val();
          var logged_admin_role = $('#logged_admin_role').val();
    
          if (action=='Approves'){
            console.log('aprroveMDUserPurchase');
            aprroveMDUserPurchase(data['pur_id'],logged_admin_id,logged_admin_role,table2); 
          }
  
          if(action == 'Disapproves'){
            disapprovMDUserPurchase(data['pur_id'],logged_admin_id,logged_admin_role,table2); 
          }
          }); 
          
          
          
            var table3 = $('#mdpurchaseCompletedTable').DataTable( {
              "ajax": "./include/mdpurchasecompleted-data.php", 
              "pageLength": 50,
              "columns": [
                      { "className":'details-control',
                          "orderable":false,
                          "data":null,
                          "defaultContent": '' 
                          
                      },
                      { "data": "created_date" },
                      { "data": "supplier_name" },
                      { "data": "project_title" },
                      { "data": "total_amount" },
                      { "data": "pr_name" },
                      { "data": "purchase_type" } 
                  ] 
            });
      
        $('#mdpurchaseCompletedTable tbody').on('click', 'td.details-control', function () { 
          var tr = $(this).closest('tr');
          var row = table3.row( tr ); 
          if ( row.child.isShown() ) 
          {
                row.child.hide();
                tr.removeClass('shown');
              
          }else{
            var val = row.data()['pur_id'];    
            $.ajax({
            url: "./include/ajax-call.php", 
            method:"POST",
            data:{ajaxData:1,purchaseId:val},  
            success:function(data)
            {  
                row.child(data).show();
            }
            })  
            tr.addClass('shown');
          }
        });

}); 