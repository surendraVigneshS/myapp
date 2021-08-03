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
  <title> Purchase Lists |Freeztex | Accounts</title>
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
      background: url('./assets/images/details_open.png') no-repeat center  !important;
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
    <?php include('./include/topbar.php'); ?>
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
              <?php if (isset($_SESSION['purchaseSuccess'])) { ?>
            <div class="col-lg-8">
                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                  <p> <?php echo $_SESSION['purchaseSuccess']; ?> </p>
                  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
              <?php }
              unset($_SESSION['purchaseSuccess']);
              if (isset($_SESSION['purchaseError'])) { ?>
                <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                  <p> <?php echo $_SESSION['purchaseError']; ?> </p>
                  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
              <?php } unset($_SESSION['purchaseError']); ?>
            </div>
            <?php
            $pillspending = $pillsapprove = false;
            switch ($logged_admin_role) {
            case '6':
                $pillspending = true;
                break;
            case '7':
                $pillsapprove = true;
                break;  
              default:
                $pillspending = true;
                break;
            }
            ?>
          
            <div class="col-sm-12">
            <?php if($logged_admin_role != 2){ ?>
              <div class="card height-equal">
                <div class="card-body p-b-10 p-t-10">
                  <ul class="nav nav-pills justify-content-center" id="pills-icontab" role="tablist" aria-controls="pills-icontabContent">
                    <li class="nav-item"><a class="nav-link <?php if($pillspending){echo 'active';}else{echo 'false';}?>" id="pills-pending-tab" data-bs-toggle="pill" href="#pills-pending" role="tab" aria-controls="pills-pending" aria-selected=" <?php if($pillspending){echo 'true';}else{echo 'false';}?>">New Request Raised</a></li>
                    <li class="nav-item"><a class="nav-link" id="pills-olapprove-tab" data-bs-toggle="pill" href="#pills-olapprove" role="tab" aria-controls="pills-olapprove" aria-selected="false">OL Approved</a></li> 
                    <li class="nav-item"><a class="nav-link <?php if($pillsapprove){echo 'active';}else{echo 'false';}?> " id="pills-approve-tab" data-bs-toggle="pill" href="#pills-approve" role="tab" aria-controls="pills-approve" aria-selected="<?php if($pillsapprove){echo 'true';}else{echo 'false';}?>">MD Approved</a></li>
                    <li class="nav-item"><a class="nav-link" id="pills-cancel-tab" data-bs-toggle="pill" href="#pills-cancel" role="tab" aria-controls="pills-cancel" aria-selected="false">Cancelled</a></li>
                    <?php if($logged_admin_role != 6){ ?>
                    <li class="nav-item"><a class="nav-link" id="pills-purpay-tab" data-bs-toggle="pill" href="#pills-purpay" role="tab" aria-controls="pills-purpay" aria-selected="false">Payment Processed</a></li>
                    <?php }?>
                    <li class="nav-item"><a class="nav-link" id="pills-user-tab" data-bs-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-user" aria-selected="false">Purchase With Bill</a></li>
                    <li class="nav-item"><a class="nav-link" id="pills-comp-tab" data-bs-toggle="pill" href="#pills-comp" role="tab" aria-controls="pills-comp" aria-selected="false">Completed</a></li>
                    <li class="nav-item"><a class="nav-link" id="pills-all-tab" data-bs-toggle="pill" href="#pills-all" role="tab" aria-controls="pills-all" aria-selected="false">All</a></li>
                  </ul>
                </div>
              </div>
            <?php }else if($logged_admin_role == 2){ ?>
              <div class="card height-equal">
                <div class="card-body p-b-10 p-t-10">
                  <ul class="nav nav-pills justify-content-center" id="pills-icontabmd" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="pills-mdpending-tab" data-bs-toggle="pill" href="#pills-mdpending" role="tab" aria-controls="pills-mdpending" aria-selected="true">Pending Purchase</a></li>
                    <li class="nav-item"><a class="nav-link" id="pills-user-tab" data-bs-toggle="pill" href="#pills-mduser" role="tab" aria-controls="pills-mdapproved" aria-selected="false">User Purchase Pending</a></li>
                    <li class="nav-item"><a class="nav-link" id="pills-mdapproved-tab" data-bs-toggle="pill" href="#pills-mdapproved" role="tab" aria-controls="pills-mdapproved" aria-selected="false">On Purchase Pending</a></li>
                     <li class="nav-item"><a class="nav-link" id="pills-mdcompleted-tab" data-bs-toggle="pill" href="#pills-mdcompleted" role="tab" aria-controls="pills-mdcompleted" aria-selected="false">Completed Purchase</a></li> 
                 </ul>
                </div>
              </div>
            <?php } ?>
              <div class="card">  
              <?php if($logged_admin_role != 2) { ?>
                <div class="tab-content" id="pills-icontabContent"> 
                  <div class="tab-pane  <?php if($pillspending){echo 'fade show active';}else{echo '';}?>" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">
                    <div class="card-body ">
                      <?php if($logged_admin_role != 2){ ?>
                      <div class="row">
                        <div class="col-md-12 m-b-30">
                          <a href="./new-purchase.php"><button class="btn btn-primary f-right" type="button">New Purchase Request</button> </a>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="table-responsive">
                        <?php
                          if($logged_admin_role != 2){
                            include('./include/purchase-pending-table.php');
                          }
                        ?>
                      </div>
                    </div>
                  </div>
                  <?php if($logged_admin_role != 2) { ?>
                  <div class="tab-pane" id="pills-olapprove" role="tabpanel" aria-labelledby="pills-olapprove-tab">
                    <div class="card-body ">
                      <?php if($logged_admin_role != 2){ ?>
                      <div class="row">
                        <div class="col-md-12 m-b-30">
                          <a href="./new-purchase.php"><button class="btn btn-primary f-right" type="button">New Purchase Request</button> </a>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="table-responsive">
                        <?php
                          if($logged_admin_role != 2){
                            include('./include/purchase-olapprove-table.php');
                          }
                        ?>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                
                  <div class="tab-pane <?php if($pillsapprove){echo 'fade show active';}else{echo '';}?>" id="pills-approve" role="tabpanel" aria-labelledby="pills-approve-tab">
                    <div class="card-body">
                      <?php if($logged_admin_role != 2){ ?>
                      <div class="row">
                        <div class="col-md-12 m-b-30">
                          <a href="./new-purchase.php"><button class="btn btn-primary f-right" type="button">New Purchase Request</button> </a>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="table-responsive">
                        <?php
                          if($logged_admin_role != 2 ){
                            include('./include/purchase-approved-table.php');
                          }
                        ?>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab">
                    <div class="card-body">
                      <?php if($logged_admin_role != 2){ ?>
                      <div class="row">
                        <div class="col-md-12 m-b-30">
                          <a href="./new-purchase.php"><button class="btn btn-primary f-right" type="button">New Purchase Request</button> </a>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="table-responsive">
                        <?php if($logged_admin_role != 2 ){ include('./include/purchase-cancelled-table.php'); } ?>
                      </div>
                    </div>
                  </div>

                  <?php if($logged_admin_role != 6){ ?>
                  <div class="tab-pane" id="pills-purpay" role="tabpanel" aria-labelledby="pills-purpay-tab">
                    <div class="card-body">
                      <?php if($logged_admin_role != 2){ ?>
                      <div class="row">
                        <div class="col-md-12 m-b-30">
                          <a href="./new-purchase.php"><button class="btn btn-primary f-right" type="button">New Purchase Request</button> </a>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="table-responsive">
                        <?php if($logged_admin_role != 2 ){ 
                          include('./include/purchase-onprocess-table.php'); 
                          }
                           ?>
                      </div>
                    </div>
                  </div>
                 <?php } ?>
                 
                 
                  <div class="tab-pane" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
                    <div class="card-body">
                      <?php if($logged_admin_role != 2){ ?>
                      <div class="row">
                      <div class="col-md-6">
                      <?php if($logged_admin_role == 1){ ?>
                      <button class="btn btn-success f-left"  id="exportPurchaseBTN" type="button">Export Table Data</button> 
                      <?php } ?>
                      </div>
                        <div class="col-md-6 m-b-30">
                          <a href="./new-purchase.php"><button class="btn btn-primary f-right" type="button">New Purchase Request</button> </a>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="table-responsive">
                        <?php
                          if($logged_admin_role != 2 && $logged_admin_role != 1 ){
                            include('./include/purchase-all-table.php');
                          }
                          else if($logged_admin_role == 1){
                            include('./include/purchase-all-admin-table.php'); 
                          }
                        ?>
                      </div>
                    </div>
                  </div>


                  <div class="tab-pane" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                    <div class="card-body">
                      <?php if($logged_admin_role != 2){ ?>
                      <div class="row">
                        <div class="col-md-12 m-b-30">
                          <a href="./new-purchase.php"><button class="btn btn-primary f-right" type="button">New Purchase Request</button> </a>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="table-responsive">
                        <?php
                          if($logged_admin_role != 2 ){
                            include('./include/purchase-user-table.php');
                          }
                        ?>
                      </div>
                    </div>
                  </div>
                  
                  <div class="tab-pane" id="pills-comp" role="tabpanel" aria-labelledby="pills-user-comp">
                    <div class="card-body">
                      <?php if($logged_admin_role != 2){ ?>
                      <div class="row">
                        <div class="col-md-12 m-b-30">
                          <a href="./new-purchase.php"><button class="btn btn-primary f-right" type="button">New Purchase Request</button> </a>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="table-responsive">
                        <?php
                          if($logged_admin_role != 2 ){
                            include('./include/purchase-com-table.php');
                          }
                        ?>
                      </div>
                    </div>
                  </div>


                </div> 
                <?php 
              } if($logged_admin_role == 2){?>
                <div class="tab-content" id="pills-icontabmdContent">
                 
                  <div class="tab-pane fade show active" id="pills-mdpending" role="tabpanel" aria-labelledby="pills-mdpending-tab">
                    <div class="card-body"> 
                      <div class="table-responsive">
                        <?php
                          if($logged_admin_role == 2){
                            include('./include/mdpurchasetable.php');
                          }
                        ?>
                      </div>
                    </div>
                  </div>


                  <div class="tab-pane" id="pills-mdapproved" role="tabpanel" aria-labelledby="pills-mdapproved-tab">
                    <div class="card-body"> 
                      <div class="table-responsive">
                        <?php
                          if($logged_admin_role == 2){
                            include('./include/mdpurchasetable-approved.php');
                          }
                        ?>
                      </div>
                    </div>
                  </div>


                  <div class="tab-pane" id="pills-mduser" role="tabpanel" aria-labelledby="pills-user-tab">
                    <div class="card-body"> 
                      <div class="table-responsive">
                        <?php
                          if($logged_admin_role == 2){
                            include('./include/mdupurchase-user.php');
                          }
                        ?>
                      </div>
                    </div>
                  </div>
                  
                  <div class="tab-pane" id="pills-mdcompleted" role="tabpanel" aria-labelledby="pills-mdcompleted-tab">
                    <div class="card-body"> 
                      <div class="table-responsive">
                        <?php
                          if($logged_admin_role == 2){
                            include('./include/mdpurchasetable-completed.php');
                          }
                        ?>
                      </div>
                    </div>
                  </div>
                  


                </div>
                <?php } ?>
              </div>
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
  <script src="./assets/js/script.js"></script>
  <script src="./assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
  <script src="./js/tablleExport.js"></script> 
  <script src="./assets/js/datatable/datatables/datatable.custom.js"></script>
  <script src="./assets/js/sweet-alert/sweetalert.min.js"></script>
  <?php if($logged_admin_role =='2'){ ?>
  <script src="./js/mdpurchsatable.js"></script>
  <?php } ?>
  <script>
  
 function deletePurchaseAdmin(el,purchaseId,adminId,adminRole){
     swal("Are you sure ? Do you want to Delete this request ?", {
      buttons: {
        Delete : "Delete", 
        Cancel: true,
      },
    })
    .then((value) => { 
      if(value =='Delete'){ 
        $.ajax({
                url: "./include/ajax-call.php",
                cache: false,
                type: 'POST',
                data:{adminDeletePurchase:1,purchaseId:purchaseId,adminRole:adminRole,adminId:adminId},
                success : function(data){ 
                    if(data == '1'){
                        swal("Success", "Purchase Request Deleted Successfully", "success", {
                  buttons: {
                    Approve : "DONE",
                  },
                })
                .then((value) => {
                  if(value =='Approve'){
                    window.location.reload();
                  }
                });
                    } 
                }
            });   
      }else{
          $(el).html('Delete');
      } 
    });  
}
 
  $(document).ready(function(){ 
    $("#exportPurchaseBTN").click(function(){
        TableToExcel.convert(document.getElementById("expotusersAllTable"), {
              name: "Purchase_request_list.xlsx",
              sheet: {
                name: "Sheet1"
              }
          });
      }); 
    });
  </script>
</body> 
</html>