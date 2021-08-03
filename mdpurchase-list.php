<?php 
    include('./include/dbconfig.php');
    include('./include/function.php');
    include('./include/authenticate.php'); 
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="./assets/images/favicon.png" type="image/x-icon">
    <title> Purchase Lists Freeztex | Accounts</title>
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/sweetalert2.css">
    <style>
    td.details-control{
      background: url('./assets/images/details_open.png') no-repeat center center !important;
      cursor: pointer;
    }

    tr.shown td.details-control{
      background: url('./assets/images/details_close.png') no-repeat center center  !important; 
    }
    </style>
</head>
<body>
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
      <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php  include('./include/topbar.php'); ?>
        <div class="page-body-wrapper">
          <?php include('./include/left-sidebar.php'); ?>
          <div class="page-body">
            <div class="container-fluid">
              <div class="page-title">
                <div class="row">
                  <div class="col-6">
                    <h3>Purchase Request</h3>
                  </div>
                  <div class="col-6">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                      <li class="breadcrumb-item">Purchase List</li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
            <div class="container-fluid">
                <div class="row"> 
                          <div class="col-lg-8"> 
                            <?php if(isset($_SESSION['purchaseSuccess'])){ ?> 
                                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['purchaseSuccess']; ?>  </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php }unset($_SESSION['purchaseSuccess']);if(isset($_SESSION['purchaseError'])){ ?> 
                                <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                                    <p> <?php echo $_SESSION['purchaseError']; ?> </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                </div>
                            <?php }unset($_SESSION['purchaseError']); ?>
                          </div>
                    <div class="col-sm-12">
                        <div class="card">
                          <div class="card-body">
                              <div class="row">
                                <div class="col-md-12 m-b-30"> 
                                  <?php if($logged_admin_role == 6){ ?>                                  
                                    <a href="new-purchase.php"> <button class="btn btn-primary f-right" type="button" title="" data-bs-original-title="btn btn-pill btn-primary" data-original-title="btn btn-pill btn-primary">New Purchase Request</button></a>
                                  <?php } ?>
                                </div> 
                              </div>
                                <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Date</th>
                                            <th>Beneficiary</th>
                                            <th>Project</th>
                                            <th>Amount</th>
                                            <th>Incharge Name</th>
                                            <th>Payment Type</th>
                                            <th>Action</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Date</th>
                                            <th>Beneficiary</th>
                                            <th>Project</th>
                                            <th>Amount</th>
                                            <th>Incharge Name</th>
                                            <th>Payment Type</th>
                                            <th>Action</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
      </div>
      <?php  include('./include/footer.php'); ?>
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
  <script src="./assets/js/script.js"></script>
  <script src="./assets/js/datatable/datatables/jquery.dataTables.min.js"></script> 
  <script src="./assets/js/sweet-alert/sweetalert.min.js"></script>
  <?php if($logged_admin_role =='2'){ ?>

  <?php } ?>
  <script>

function aprrovePurchase(purchaseId,adminId,adminRole){
  console.log(adminId + adminRole + purchaseId );

swal("Are you sure ? Do you want to approve this request ?", {
      buttons: {
        Approve : "Approve", 
        Cancel: true,
      },
    })
    .then((value) => {

      if(value =='Approve'){

        $.ajax({
                url: "./include/ajax-call.php",
                cache: false,
                type: 'POST',
                data:{approvePurchase:1,purchaseId:purchaseId,adminRole:adminRole,adminId:adminId},
                success : function(data){
                  console.log(data);

                    if(data == '1'){
                         swal("Success", "Purchase Request Approved", "success");
                        $("#status-card").load(location.href+" #status-card>*","");
                    } 
                }
            });   
      } 
    }); 
}
    
$(document).ready(function() {
    var table = $('#example').DataTable( {
        "ajax": "./data.php",
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
  
        if (action=='Approve'){
          aprrovePurchase(data['pur_id'],<?php echo $logged_admin_id; ?>,<?php echo $logged_admin_role; ?>); 
        }

        if(action == 'Disapprove'){
          disapprovMDPurchase(data['pur_id'],<?php echo $logged_admin_id; ?>,<?php echo $logged_admin_role; ?>); 
        }
        });
    
    
    
    } ); 
</script>
</body>
</html>