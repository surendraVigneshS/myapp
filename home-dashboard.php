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
    <title>Home Dashboard | Vencar Accounts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">  
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/feather-icon.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/animate.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <link id="color" rel="stylesheet" href="./assets/css/color-1.css" media="screen">
    <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">
</head>
<body onload="startTime()">
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
      <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include('./include/topbar.php'); ?>
        <div class="page-body-wrapper">
          <?php  include('./include/left-sidebar.php'); ?> 
          <div class="page-body">
            <div class="container-fluid">
              <div class="page-title">
                <div class="row">
                  <div class="col-6">
                    <h3>Dashboard</h3>
                  </div>
                  <div class="col-6">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="home-dashboard.php"><i data-feather="home"></i></a></li>
                      <li class="breadcrumb-item">Dashboard</li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
            <div class="container-fluid">
              <div class="row second-chart-list third-news-update">
                <div class="col-xl-6 col-lg-6 xl-50 morning-sec box-col-12">
                  <div class="card o-hidden profile-greeting">
                    <div class="card-body">
                      <div class="media">
                        <div class="badge-groups w-100">
                          <div class="badge f-12 badge-dark"><i class="fa fa-clock"></i> <span id="txt"></span></div>
                        </div>
                      </div>
                      <div class="greeting-user text-center">
                        <div class="profile-vector"><img class="img-fluid" src="./assets/images/dashboard/welcome.png" alt=""></div>
                        <h4 class="f-w-600"><span id="greeting">Good Morning</span> </h4>
                        <h6 class="f-w-600" style="color:#fff"><?php echo fetchData($dbconnection,'emp_name','admin_login','emp_id',$logged_admin_id); ?></h6> 
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-6 col-lg-6 xl-50 dashboard-sec box-col-12">
                  <div class="row">
                    <div class="col-xl-12 chart_data_right">
                      <div class="card">
                        <div class="card-body">
                          <div class="media align-items-center">
                            <div class="media-body right-chart-content">
                             <a href="./payment-list.php"> 
                             <h4>
                                <?php
                                     $newDate = date('Y-m-d'); 
                                    //  if($logged_admin_role == 6){
                                    //   echo '#'.IND_money_format(fetchOveraallTotalPaymentCount($dbconnection,$logged_admin_id));  
                                    //  }else{
                                    //   echo '#'.IND_money_format(fetchOveraallTotalPaymentCount($dbconnection,NULL)); 
                                    //  }  
                                    echo '#'.TotalPaymentCount($dbconnection,$logged_admin_id,$logged_admin_role);
                                ?>
                               </h4> <span>Overall Payment Count</span>
                               </a>
                            </div>
                            <div class="f-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xl-12 chart_data_right"> 
                      <div class="card">
                        <div class="card-body">
                          <div class="media align-items-center">
                            <div class="media-body right-chart-content"> 
                            <a href="./purchase-list.php"> 
                            <h4>
                               <?php 
                              echo '#'.fetchOveraallTotalPurchaseCount($dbconnection,$logged_admin_id,$logged_admin_role);   
                              ?>  </h4><span>Overall Purchase Count</span>
                              </a>
                            </div>
                            <div class="f-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database icon-bg"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                            </div>
                          </div>
                        </div> 
                      </div>
                    </div>
                  </div>
                </div>



                <div class="col-xl-6 xl-100 box-col-12">
                <div class="widget-joins payment card card-absolute">
                  <div class="card-header bg-info">
                    <a href="./purchase-list.php">
                        <h5 class="text-white">Purchase Counts</h5>
                    </a>
                  </div>
                  <div class="row mt-3">
                    <div class="col-sm-6 pe-0">
                      <div class="media border-after-xs"> 
                      <a href="./purchase-list.php">
                      <div class="align-self-center me-3">
                        <?php echo '#'.fetchPenDataCount($dbconnection,$logged_admin_id,$logged_admin_role); ?>
                        <i class="fa fa-angle-up ms-2"></i>

                      </div>
                      </a>
                        <div class="media-body details ps-3"><span class="mb-1">New Request</span>
                           <h6 class="mt-2 mb-0 counter"> 
                            <?php 
                            echo fetchPenDataCount($dbconnection,$logged_admin_id,$logged_admin_role);
                            ?>
                          </h6>
                        </div>
                        <div class="media-body align-self-center">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag font-primary float-end ms-2">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                          </svg>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 ps-0">
                      <div class="media">
                       
                        <div class="align-self-center me-3">
                          <?php
                            echo '#'.fetchOnProcessingCount($dbconnection,$logged_admin_id,$logged_admin_role);
                           ?>
                          <i class="fa fa-angle-down ms-2"></i>
                        </div>
                        <div class="media-body details ps-3"><span class="mb-1">MD Approved</span>
                           <h6 class="mt-2 mb-0 counter">
                          <?php
                         echo fetchOnProcessingCount($dbconnection,$logged_admin_id,$logged_admin_role);
                          ?>
                          </h6>
                        </div>
                        <div class="media-body align-self-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle font-primary float-end ms-3">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg></div>
                      </div>
                    </div>
                    <div class="col-sm-6 pe-0">
                      <div class="media border-after-xs">
                        <div class="align-self-center me-3">
                        <?php  echo '#'.fetchOnProcessingCount($dbconnection,$logged_admin_id,$logged_admin_role);   ?>  
                        <i class="fa fa-angle-up ms-2"></i></div>
                        <div class="media-body details ps-3 pt-0"><span class="mb-1">Payment Processed</span>
                           <h6 class="mt-2 mb-0 counter">
                          <?php echo fetchOnProcessingCount($dbconnection,$logged_admin_id,$logged_admin_role);  ?>
                          </h6>
                        </div>
                          <div class="media-body align-self-center">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign font-primary float-end ms-2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6 ps-0">
                      <div class="media">
                        <div class="align-self-center me-3">
                        <?php 
                         echo '#'.fetchComPurchaseCount($dbconnection,$logged_admin_id,$logged_admin_role);
                         ?>    
                        <i class="fa fa-angle-up ms-2"></i></div>
                        <div class="media-body details ps-3 pt-0"><span class="mb-1">Completed Request</span>
                           <h6 class="mt-2 mb-0 counter">
                            <?php 
                            echo fetchComPurchaseCount($dbconnection,$logged_admin_id,$logged_admin_role);
                            ?>
                          </h6>
                        </div>
                        <div class="media-body align-self-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up font-primary float-end ms-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                        </div>
                      </div>
                    </div>
                     <div class="col-sm-6 pe-0">
                      <div class="media border-after-xs">
                        <div class="align-self-center me-3">
                        <?php 
                         echo '#'.fetchCancelledPurchaseCount($dbconnection,$logged_admin_id,$logged_admin_role);
                         ?>    
                        <i class="fa fa-angle-up ms-2"></i></div>
                        <div class="media-body details ps-3 pt-0"><span class="mb-1">Cancelled Requests</span>
                           <h6 class="mt-2 mb-0 counter">
                            <?php 
                            echo fetchCancelledPurchaseCount($dbconnection,$logged_admin_id,$logged_admin_role);
                            ?>
                          </h6>
                        </div>
                        <div class="media-body align-self-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle font-primary float-end ms-3"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Payment Counts -->
              
              <div class="col-xl-6 xl-100 box-col-12">
                <div class="widget-joins payment card card-absolute">
                  <div class="card-header bg-primary">
                    <a href="./payment-list.php">
                      <h5 class="text-white">Payment Counts</h5>
                    </a>
                  </div>
                  <div class="row mt-3">
                    <div class="col-sm-6 pe-0">
                      <div class="media border-after-xs">
                      <a href="./payment-list.php">
                        <div class="align-self-center me-3">
                          <?php
                          if($logged_admin_role != 1 && $logged_admin_role != 2 && $logged_admin_role != 4 ){ 
                            echo TotalPaymentPendingCount($dbconnection,$logged_admin_id,$logged_admin_role); 
                          }else if($logged_admin_role == 11){
                            echo TotalPaymentPendingCount($dbconnection,$logged_admin_id,$logged_admin_role);
                          }else{
                            echo TotalPaymentPendingCount($dbconnection,$logged_admin_id,NULL);  
                          }
                          ?>
                        <i class="fa fa-angle-up ms-2"></i>
                        </div>
                      </a>
                        <div class="media-body details ps-3"><span class="mb-1">New Request Raised</span>
                           <h6 class="mt-2 mb-0 counter"> 
                            <?php 
                              if($logged_admin_role == 6){
                                if(TotalPaymentPendingCount($dbconnection,$logged_admin_id,6) == 0){
                                  echo 'No New Request';
                                }else{
                                  echo '#'.TotalPaymentPendingCount($dbconnection,$logged_admin_id,6);
                                } 
                              }else if($logged_admin_role == 3){
                                if(TotalPaymentPendingCount($dbconnection,$logged_admin_id,3) == 0){
                                  echo 'No New Request';
                                }else{
                                  echo '#'.TotalPaymentPendingCount($dbconnection,$logged_admin_id,3);
                                }  
                              }else if($logged_admin_role == 7){
                                if(TotalPaymentPendingCount($dbconnection,$logged_admin_id,7) == 0){
                                  echo 'No New Request';
                                }else{
                                  echo '#'.TotalPaymentPendingCount($dbconnection,$logged_admin_id,7);
                                }  
                              }else if($logged_admin_role == 5){
                                if(TotalPaymentPendingCount($dbconnection,$logged_admin_id,5) == 0){
                                  echo 'No New Request';
                                }else{
                                  echo '#'.TotalPaymentPendingCount($dbconnection,$logged_admin_id,5);
                                }  
                              }else if($logged_admin_role == 8){
                                if(TotalPaymentPendingCount($dbconnection,$logged_admin_id,8) == 0){
                                  echo 'No New Request';
                                }else{
                                  echo '#'.TotalPaymentPendingCount($dbconnection,$logged_admin_id,8);
                                }  
                              }else if($logged_admin_role == 9){
                                if(TotalPaymentPendingCount($dbconnection,$logged_admin_id,9) == 0){
                                  echo 'No New Request';
                                }else{
                                  echo '#'.TotalPaymentPendingCount($dbconnection,$logged_admin_id,9);
                                }  
                              }else if($logged_admin_role == 11){
                                if(TotalPaymentPendingCount($dbconnection,$logged_admin_id,11) == 0){
                                  echo 'No New Request';
                                }else{
                                  echo '#'.TotalPaymentPendingCount($dbconnection,$logged_admin_id,11);
                                }  
                              }else{
                                if(TotalPaymentPendingCount($dbconnection,$logged_admin_id,NULL) == 0){
                                  echo 'No New Request';
                                }else{
                                  echo '#'.TotalPaymentPendingCount($dbconnection,$logged_admin_id,NULL);
                                }  
                              } 
                            ?>
                          </h6>
                        </div>
                        <div class="media-body align-self-center">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag font-primary float-end ms-2">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                          </svg>
                        </div>
                      </div>
                    </div>
                    <?php if($logged_admin_role != 9){  ?>
                    <div class="col-sm-6 ps-0">
                      <div class="media"> 
                        <div class="align-self-center me-3">
                          <?php
                          if($logged_admin_role == 6){ 
                            echo TotalPaymentOnproCount($dbconnection,$logged_admin_id,6); 
                          }else if($logged_admin_role == 3){
                            echo TotalPaymentOnproCount($dbconnection,$logged_admin_id,3);  
                          }else if($logged_admin_role == 7){
                            echo TotalPaymentOnproCount($dbconnection,$logged_admin_id,7);  
                          }else if($logged_admin_role == 5){
                            echo TotalPaymentOnproCount($dbconnection,$logged_admin_id,5);  
                          }else if($logged_admin_role == 9){
                            echo TotalPaymentOnproCount($dbconnection,$logged_admin_id,9);  
                          }else if($logged_admin_role == 11){
                            echo TotalPaymentOnproCount($dbconnection,$logged_admin_id,11);  
                          }else{
                            echo TotalPaymentOnproCount($dbconnection,$logged_admin_id,NULL);  
                          }
                          ?>
                          <i class="fa fa-angle-down ms-2"></i>
                        </div>
                        <div class="media-body details ps-3"><span class="mb-1">TL Approved</span>
                           <h6 class="mt-2 mb-0 counter">
                            <?php 
                              if($logged_admin_role == 6){ 
                                if(TotalPaymentOnproCount($dbconnection,$logged_admin_id,6) == 0){
                                  echo "No Processing Request";
                                }else{
                                  echo '#'.TotalPaymentOnproCount($dbconnection,$logged_admin_id,6);
                                } 
                              }else if($logged_admin_role == 3){
                                if(TotalPaymentOnproCount($dbconnection,$logged_admin_id,3) == 0){
                                  echo "No Processing Request";
                                }else{
                                  echo '#'.TotalPaymentOnproCount($dbconnection,$logged_admin_id,3);
                                }  
                              }else if($logged_admin_role == 7){
                                if(TotalPaymentOnproCount($dbconnection,$logged_admin_id,7) == 0){
                                  echo "No Processing Request";
                                }else{
                                  echo '#'.TotalPaymentOnproCount($dbconnection,$logged_admin_id,7);
                                }  
                              }else if($logged_admin_role == 5){
                                if(TotalPaymentOnproCount($dbconnection,$logged_admin_id,5) == 0){
                                  echo "No Processing Request";
                                }else{
                                  echo '#'.TotalPaymentOnproCount($dbconnection,$logged_admin_id,5);
                                }  
                              }else if($logged_admin_role == 9){
                                if(TotalPaymentOnproCount($dbconnection,$logged_admin_id,9) == 0){
                                  echo "No Processing Request";
                                }else{
                                  echo '#'.TotalPaymentOnproCount($dbconnection,$logged_admin_id,9);
                                }  
                              }else if($logged_admin_role == 11){
                                if(TotalPaymentOnproCount($dbconnection,$logged_admin_id,11) == 0){
                                  echo "No Processing Request";
                                }else{
                                  echo '#'.TotalPaymentOnproCount($dbconnection,$logged_admin_id,11);
                                }  
                              }else{
                                if(TotalPaymentOnproCount($dbconnection,$logged_admin_id,NULL) == 0){
                                  echo "No Processing Request";
                                }else{
                                  echo '#'.TotalPaymentOnproCount($dbconnection,$logged_admin_id,NULL);
                                }  
                              } 
                            ?>
                          </h6>
                        </div>
                        <div class="media-body align-self-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers font-primary float-end ms-3"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg></div>
                      </div>
                    </div>
                    
                    <div class="col-sm-6 pe-0">
                      <div class="media"> 
                        <div class="align-self-center me-3">
                          <?php
                          if($logged_admin_role == 6){ 
                            echo TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,6); 
                          }else if($logged_admin_role == 3){
                            echo TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,3);  
                          }else if($logged_admin_role == 7){
                            echo TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,7);  
                          }else if($logged_admin_role == 5){
                            echo TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,5);  
                          }else if($logged_admin_role == 11){
                            echo TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,11);  
                          }else{
                            echo TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,NULL);  
                          }
                          ?>
                          <i class="fa fa-angle-down ms-2"></i>
                        </div>
                        <div class="media-body details ps-3"><span class="mb-1">Finance Preapproved</span>
                           <h6 class="mt-2 mb-0 counter">
                            <?php 
                              if($logged_admin_role == 6){ 
                                if(TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,6) == 0){
                                  echo "No Preapproved Request";
                                }else{
                                  echo '#'.TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,6);
                                } 
                              }else if($logged_admin_role == 3){
                                if(TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,3) == 0){
                                  echo "No Preapproved Request";
                                }else{
                                  echo '#'.TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,3);
                                }  
                              }else if($logged_admin_role == 7){
                                if(TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,7) == 0){
                                  echo "No Preapproved Request";
                                }else{
                                  echo '#'.TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,7);
                                }  
                              }else if($logged_admin_role == 5){
                                if(TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,5) == 0){
                                  echo "No Preapproved Request";
                                }else{
                                  echo '#'.TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,5);
                                }  
                              }else if($logged_admin_role == 11){
                                if(TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,11) == 0){
                                  echo "No Preapproved Request";
                                }else{
                                  echo '#'.TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,11);
                                }  
                              }else{
                                if(TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,NULL) == 0){
                                  echo "No Preapproved Request";
                                }else{
                                  echo '#'.TotalPaymentPreapprovedCount($dbconnection,$logged_admin_id,NULL);
                                }  
                              } 
                            ?>
                          </h6>
                        </div>
                        <div class="media-body align-self-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle font-primary float-end ms-3">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                    <div class="col-sm-6 ps-0">
                      <div class="media border-after-xs">
                        <div class="align-self-center me-3">
                          <?php
                            if($logged_admin_role == 6){ 
                            echo TotalPaymentWaitingCount($dbconnection,$logged_admin_id,6); 
                            }else if($logged_admin_role == 3){
                              echo TotalPaymentWaitingCount($dbconnection,$logged_admin_id,3);  
                            }else if($logged_admin_role == 7){
                              echo TotalPaymentWaitingCount($dbconnection,$logged_admin_id,7);  
                            }else if($logged_admin_role == 5){
                              echo TotalPaymentWaitingCount($dbconnection,$logged_admin_id,5);  
                            }else if($logged_admin_role == 9){
                              echo TotalPaymentWaitingCount($dbconnection,$logged_admin_id,9);  
                            }else if($logged_admin_role == 11){
                              echo TotalPaymentWaitingCount($dbconnection,$logged_admin_id,11);  
                            }else{
                              echo TotalPaymentWaitingCount($dbconnection,$logged_admin_id,NULL);  
                            }
                          ?>
                          <i class="fa fa-angle-up ms-2"></i>
                        </div>
                        <div class="media-body details ps-3"><span class="mb-1">MD Approved</span>
                           <h6 class="mt-2 mb-0 counter"> 
                            <?php 
                              if($logged_admin_role == 6){ 
                                if(TotalPaymentWaitingCount($dbconnection,$logged_admin_id,6) == 0){
                                  echo 'No Agreed Request';
                                }else{
                                  echo '#'.TotalPaymentWaitingCount($dbconnection,$logged_admin_id,6);
                                } 
                              }else if($logged_admin_role == 3){
                                if(TotalPaymentWaitingCount($dbconnection,$logged_admin_id,3) == 0){
                                  echo 'No Agreed Request';
                                }else{
                                  echo '#'.TotalPaymentWaitingCount($dbconnection,$logged_admin_id,3);
                                }  
                              }else if($logged_admin_role == 7){
                                if(TotalPaymentWaitingCount($dbconnection,$logged_admin_id,7) == 0){
                                  echo 'No Agreed Request';
                                }else{
                                  echo '#'.TotalPaymentWaitingCount($dbconnection,$logged_admin_id,7);
                                }  
                              }else if($logged_admin_role == 5){
                                if(TotalPaymentWaitingCount($dbconnection,$logged_admin_id,5) == 0){
                                  echo 'No Agreed Request';
                                }else{
                                  echo '#'.TotalPaymentWaitingCount($dbconnection,$logged_admin_id,5);
                                }  
                              }else if($logged_admin_role == 9){
                                if(TotalPaymentWaitingCount($dbconnection,$logged_admin_id,9) == 0){
                                  echo 'No Agreed Request';
                                }else{
                                  echo '#'.TotalPaymentWaitingCount($dbconnection,$logged_admin_id,9);
                                }  
                              }else if($logged_admin_role == 11){
                                if(TotalPaymentWaitingCount($dbconnection,$logged_admin_id,11) == 0){
                                  echo 'No Agreed Request';
                                }else{
                                  echo '#'.TotalPaymentWaitingCount($dbconnection,$logged_admin_id,11);
                                }  
                              }else{
                                if(TotalPaymentWaitingCount($dbconnection,$logged_admin_id,NULL) == 0){
                                  echo 'No Agreed Request';
                                }else{
                                  echo '#'.TotalPaymentWaitingCount($dbconnection,$logged_admin_id,NULL);
                                }  
                              } 
                            ?> 
                          </h6>
                        </div>
                        <div class="media-body align-self-center">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart font-primary float-end ms-2">
                            <circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                          </svg>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6 pe-0">
                      <div class="media">
                          
                        <div class="align-self-center me-3">
                          <?php
                            if($logged_admin_role == 6){ 
                            echo TotalPaymentApprovedCount($dbconnection,$logged_admin_id,6); 
                            }else if($logged_admin_role == 3){
                              echo TotalPaymentApprovedCount($dbconnection,$logged_admin_id,3);  
                            }else if($logged_admin_role == 7){
                              echo TotalPaymentApprovedCount($dbconnection,$logged_admin_id,7);  
                            }else if($logged_admin_role == 5){
                              echo TotalPaymentApprovedCount($dbconnection,$logged_admin_id,5);  
                            }else if($logged_admin_role == 9){
                              echo TotalPaymentApprovedCount($dbconnection,$logged_admin_id,9);  
                            }else if($logged_admin_role == 11){
                              echo TotalPaymentApprovedCount($dbconnection,$logged_admin_id,11);  
                            }else{
                              echo TotalPaymentApprovedCount($dbconnection,$logged_admin_id,NULL);  
                            }
                          ?>
                          <i class="fa fa-angle-down ms-2"></i>
                        </div>
                        <div class="media-body details ps-3"><span class="mb-1">Payment Done</span>
                          <h6 class="mt-2 mb-0 counter">
                            <?php 
                              if($logged_admin_role == 6){ 
                                if(TotalPaymentApprovedCount($dbconnection,$logged_admin_id,6) == 0){
                                  echo 'No Approved Request';
                                }else{
                                  echo '#'.TotalPaymentApprovedCount($dbconnection,$logged_admin_id,6);
                                }
                              }else if($logged_admin_role == 3){
                                if(TotalPaymentApprovedCount($dbconnection,$logged_admin_id,3) == 0){
                                  echo 'No Approved Request';
                                }else{
                                  echo '#'.TotalPaymentApprovedCount($dbconnection,$logged_admin_id,3);
                                }  
                              }else if($logged_admin_role == 7){
                                if(TotalPaymentApprovedCount($dbconnection,$logged_admin_id,7) == 0){
                                  echo 'No Approved Request';
                                }else{
                                  echo '#'.TotalPaymentApprovedCount($dbconnection,$logged_admin_id,7);
                                }  
                              }else if($logged_admin_role == 5){
                                if(TotalPaymentApprovedCount($dbconnection,$logged_admin_id,5) == 0){
                                  echo 'No Approved Request';
                                }else{
                                  echo '#'.TotalPaymentApprovedCount($dbconnection,$logged_admin_id,5);
                                }  
                              }else if($logged_admin_role == 9){
                                if(TotalPaymentApprovedCount($dbconnection,$logged_admin_id,9) == 0){
                                  echo 'No Approved Request';
                                }else{
                                  echo '#'.TotalPaymentApprovedCount($dbconnection,$logged_admin_id,9);
                                }  
                              }else if($logged_admin_role == 11){
                                if(TotalPaymentApprovedCount($dbconnection,$logged_admin_id,11) == 0){
                                  echo 'No Approved Request';
                                }else{
                                  echo '#'.TotalPaymentApprovedCount($dbconnection,$logged_admin_id,11);
                                }  
                              }else{
                                if(TotalPaymentApprovedCount($dbconnection,$logged_admin_id,NULL) == 0){
                                  echo 'No Approved Request';
                                }else{
                                  echo '#'.TotalPaymentApprovedCount($dbconnection,$logged_admin_id,NULL);
                                }  
                              } 
                            ?>
                          </h6>
                        </div>
                        <div class="media-body align-self-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign font-primary float-end ms-2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></div>
                      </div>
                    </div>
                    <div class="col-sm-6 ps-0">
                      <div class="media border-after-xs">
                        <div class="align-self-center me-3">
                          <?php
                            if($logged_admin_role == 6){ 
                            echo TotalPaymentCompleteCount($dbconnection,$logged_admin_id,6); 
                            }else if($logged_admin_role == 3){
                              echo TotalPaymentCompleteCount($dbconnection,$logged_admin_id,3);  
                            }else if($logged_admin_role == 7){
                              echo TotalPaymentCompleteCount($dbconnection,$logged_admin_id,7);  
                            }else if($logged_admin_role == 5){
                              echo TotalPaymentCompleteCount($dbconnection,$logged_admin_id,5);  
                            }else if($logged_admin_role == 9){
                              echo TotalPaymentCompleteCount($dbconnection,$logged_admin_id,9);  
                            }else if($logged_admin_role == 11){
                              echo TotalPaymentCompleteCount($dbconnection,$logged_admin_id,11);  
                            }else{
                              echo TotalPaymentCompleteCount($dbconnection,$logged_admin_id,NULL);  
                            }
                          ?>
                          <i class="fa fa-angle-up ms-2"></i></div>
                          <div class="media-body details ps-3 pt-0"><span class="mb-1">Advance Completed</span>
                            <h6 class="mt-2 mb-0 counter">
                            <?php 
                              if($logged_admin_role == 6){ 
                                if(TotalPaymentCompleteCount($dbconnection,$logged_admin_id,6) == 0){
                                  echo "No Completed Request";
                                }else{
                                  echo '#'.TotalPaymentCompleteCount($dbconnection,$logged_admin_id,6);
                                } 
                              }else if($logged_admin_role == 3){
                                if(TotalPaymentCompleteCount($dbconnection,$logged_admin_id,3) == 0){
                                  echo "No Completed Request";
                                }else{
                                  echo '#'.TotalPaymentCompleteCount($dbconnection,$logged_admin_id,3);
                                }  
                              }else if($logged_admin_role == 7){
                                if(TotalPaymentCompleteCount($dbconnection,$logged_admin_id,7) == 0){
                                  echo "No Completed Request";
                                }else{
                                  echo '#'.TotalPaymentCompleteCount($dbconnection,$logged_admin_id,7);
                                }  
                              }else if($logged_admin_role == 5){
                                if(TotalPaymentCompleteCount($dbconnection,$logged_admin_id,5) == 0){
                                  echo "No Completed Request";
                                }else{
                                  echo '#'.TotalPaymentCompleteCount($dbconnection,$logged_admin_id,5);
                                }  
                              }else if($logged_admin_role == 9){
                                if(TotalPaymentCompleteCount($dbconnection,$logged_admin_id,9) == 0){
                                  echo "No Completed Request";
                                }else{
                                  echo '#'.TotalPaymentCompleteCount($dbconnection,$logged_admin_id,9);
                                }  
                              }else if($logged_admin_role == 11){
                                if(TotalPaymentCompleteCount($dbconnection,$logged_admin_id,11) == 0){
                                  echo "No Completed Request";
                                }else{
                                  echo '#'.TotalPaymentCompleteCount($dbconnection,$logged_admin_id,11);
                                }  
                              }else{
                                if(TotalPaymentCompleteCount($dbconnection,$logged_admin_id,NULL) == 0){
                                  echo "No Completed Request";
                                }else{
                                  echo '#'.TotalPaymentCompleteCount($dbconnection,$logged_admin_id,NULL);
                                }  
                              } 
                            ?>
                            </h6>
                          </div>
                          <div class="media-body align-self-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up font-primary float-end ms-2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6 pe-0">
                      <div class="media">
                        <div class="align-self-center me-3">
                          <?php
                            if($logged_admin_role == 6){ 
                              echo TotalPaymentCancelCount($dbconnection,$logged_admin_id,6); 
                            }else if($logged_admin_role == 3){
                              echo TotalPaymentCancelCount($dbconnection,$logged_admin_id,3);  
                            }else if($logged_admin_role == 7){
                              echo TotalPaymentCancelCount($dbconnection,$logged_admin_id,7);  
                            }else if($logged_admin_role == 5){
                              echo TotalPaymentCancelCount($dbconnection,$logged_admin_id,5);  
                            }else if($logged_admin_role == 9){
                              echo TotalPaymentCancelCount($dbconnection,$logged_admin_id,9);  
                            }else if($logged_admin_role == 11){
                              echo TotalPaymentCancelCount($dbconnection,$logged_admin_id,11);  
                            }else{
                              echo TotalPaymentCancelCount($dbconnection,$logged_admin_id,NULL);  
                            }
                          ?>
                          <i class="fa fa-angle-up ms-2"></i>
                        </div>
                        <div class="media-body details ps-3 pt-0"><span class="mb-1">Cancelled Request</span>
                          <h6 class="mt-2 mb-0 counter">
                            <?php 
                              if($logged_admin_role == 6){ 
                                if(TotalPaymentCancelCount($dbconnection,$logged_admin_id,6) == 0){
                                  echo "No Cancelled Request";
                                }else{
                                  echo '#'.TotalPaymentCancelCount($dbconnection,$logged_admin_id,6);
                                }
                              }else if($logged_admin_role == 3){
                                if(TotalPaymentCancelCount($dbconnection,$logged_admin_id,3) == 0){
                                  echo "No Cancelled Request";
                                }else{
                                  echo '#'.TotalPaymentCancelCount($dbconnection,$logged_admin_id,3);
                                }  
                              }else if($logged_admin_role == 7){
                                if(TotalPaymentCancelCount($dbconnection,$logged_admin_id,7) == 0){
                                  echo "No Cancelled Request";
                                }else{
                                  echo '#'.TotalPaymentCancelCount($dbconnection,$logged_admin_id,7);
                                }  
                              }else if($logged_admin_role == 5){
                                if(TotalPaymentCancelCount($dbconnection,$logged_admin_id,5) == 0){
                                  echo "No Cancelled Request";
                                }else{
                                  echo '#'.TotalPaymentCancelCount($dbconnection,$logged_admin_id,5);
                                }  
                              }else if($logged_admin_role == 9){
                                if(TotalPaymentCancelCount($dbconnection,$logged_admin_id,9) == 0){
                                  echo "No Cancelled Request";
                                }else{
                                  echo '#'.TotalPaymentCancelCount($dbconnection,$logged_admin_id,9);
                                }  
                              }else if($logged_admin_role == 11){
                                if(TotalPaymentCancelCount($dbconnection,$logged_admin_id,11) == 0){
                                  echo "No Cancelled Request";
                                }else{
                                  echo '#'.TotalPaymentCancelCount($dbconnection,$logged_admin_id,11);
                                }  
                              }else{
                                if(TotalPaymentCancelCount($dbconnection,$logged_admin_id,NULL) == 0){
                                  echo "No Cancelled Request";
                                }else{
                                  echo '#'.TotalPaymentCancelCount($dbconnection,$logged_admin_id,NULL);
                                }  
                              } 
                            ?>
                          </h6>
                        </div>
                        <div class="media-body align-self-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0bab64" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle font-primary float-end ms-3"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              
              

              <input type="hidden" id="pendingPayCount" value="<?php 
                if($logged_admin_role == 6){   echo fetchPenPaymentDataCount($dbconnection,$logged_admin_id,$logged_admin_role);}
                else{   echo fetchPenPaymentDataCount($dbconnection,NULL,$logged_admin_role);} ?>"> 
              <input type="hidden" id="onPayCount" value="<?php  if($logged_admin_role == 6){  echo  fetchOnPaymentDataCount($dbconnection,$logged_admin_id,$logged_admin_role);  } else { echo  fetchOnPaymentDataCount($dbconnection,NULL,$logged_admin_role);  }?>"> 
              <input type="hidden" id="aprPayCOunt" value="<?php if($logged_admin_role == 6) { echo fetchComPaymentDataCount($dbconnection,$logged_admin_id,$logged_admin_role); } else{ echo fetchComPaymentDataCount($dbconnection,NULL,$logged_admin_role); } ?>"> 
              <input type="hidden" id="canPayCount" value="<?php 
                            if($logged_admin_role != 1 && $logged_admin_role != 2 && $logged_admin_role != 4){ 
                            echo TotalPaymentCancelCount($dbconnection,$logged_admin_id,$logged_admin_role); 
                            }else{
                              echo TotalPaymentCancelCount($dbconnection,$logged_admin_id,NULL);  
                            } ?>"> 
           
              <input type="hidden" id="pendingCount" value="<?php  echo fetchPenDataCount($dbconnection,$logged_admin_id,$logged_admin_role);?>"> 
              <input type="hidden" id="onprocessingCount" value="<?php  echo fetchOnProcessingCount($dbconnection,$logged_admin_id,$logged_admin_role);  ?>"> 
              <input type="hidden" id="comCount" value="<?php  echo fetchComPurchaseCount($dbconnection,$logged_admin_id,$logged_admin_role);?>"> 
              <input type="hidden" id="canCount" value="<?php echo fetchCancelledPurchaseCount($dbconnection,$logged_admin_id,$logged_admin_role); ?>"> 

              <div class="col-xl-4 xl-50 appointment box-col-6">
                <div class="card">
                  <div class="card-header">
                    <div class="header-top">
                     <a href="./payment-list.php"> <h5 class="m-0">Payment Request Count </h5></a>
                      <div class="card-header-right-icon"> 
                      </div>
                    </div>
                  </div>
                  <div class="card-Body">
                    <div class="mb-5 mt-5">
                    <canvas id="mychart"></canvas>
                    </div>
                  </div>
                  <div class="card-footer text-center">
                    <button id="download-pdf" class="btn btn-primary">Save as PDF</button>
                    <button id="save-btn" class="btn btn-secondary">Save as PNG</button>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 xl-50 appointment box-col-6">
                <div class="card">
                  <div class="card-header">
                    <div class="header-top">
                    <a href="./purchase-list.php"> <h5 class="m-0">Purchase Request Count </h5></a>  
                    </div>
                  </div>
                  <div class="card-Body">
                    <div class="mb-5 mt-5">
                    <canvas id="mychart2"></canvas>
                    </div>
                  </div>
                  <div class="card-footer text-center">
                    <button id="download-pdf2" class="btn btn-primary">Save as PDF</button>
                    <button id="save-btn2" class="btn btn-secondary">Save as PNG</button>
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
  <script src="./assets/js/datatable/datatables/datatable.custom.js"></script>
  <script src="./assets/js/sweet-alert/sweetalert.min.js"></script>
    <script src="js/canvas-toBlob.js"></script>
    <script src="js/FileSaver.js"></script>
    <script type="text/javascript" src="js/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js"></script>
    <script src="js/home-chart.js"></script>
    <script>
            $(document).ready(function () {
                        var pendingPayCount = $('#pendingPayCount').val(); 
                        var onPayCount = $('#onPayCount').val(); 
                        var aprPayCOunt = $('#aprPayCOunt').val();
                        var canPayCount = $('#canPayCount').val();
                        // totalCount
                        var pendingcount = $('#pendingCount').val(); 
                        var onprocessingCount = $('#onprocessingCount').val(); 
                        var comCount = $('#comCount').val();
                        var canCount = $('#canCount').val();
				 
                        showGraph1(pendingPayCount,onPayCount,aprPayCOunt,canPayCount);
                        showGraph2(pendingcount,onprocessingCount,comCount,canCount);
					 
            });
                
                
                function showGraph1(pendingPayCount,onPayCount,aprPayCOunt,canPayCount)
                {  
                  var labels = ["Pending","On Processing","Approved","Cancelled"];
							 
				 
                         var chartdata = {
                         labels:labels ,
                                datasets: 
                                [{
                                    	
                                    data: [pendingPayCount,onPayCount,aprPayCOunt,canPayCount],
                                    backgroundColor: 
                                    [
                                      "rgba(255, 195, 0 , 0.5)",
                                      "rgba(255, 81, 0,0.5)",
                                      "rgba(1, 255, 51, 0.5)",
                                      "rgba(226, 0, 31, 0.5)" 
                                    ],
                                    hoverOffset: 4
                                }]
                            };

                            var graphTarget = $("#mychart");

                            var myLineChart = new Chart(graphTarget, {
                                type: 'doughnut',
                                resize:true,
                                data: chartdata 
                            }); 
                }  


                document.getElementById('download-pdf').addEventListener("click", downloadPDF2); 
                function downloadPDF2() {
                  var newCanvas = document.querySelector('#mychart'); 
                  var newCanvasImg = newCanvas.toDataURL("image/jpeg", 1.0); 
                  var doc = new jsPDF('landscape');
                  doc.setFontSize(20);
                  doc.text(15, 15, "Super Cool Chart");
                  doc.addImage(newCanvasImg, 'JPEG', 10, 10, 280, 150 );
                  doc.save('paymentgrapgh.pdf');
                }
                $("#save-btn").click(function() {
                      $("#mychart").get(0).toBlob(function(blob) {
                        saveAs(blob, "paymentgrapgh.png");
                        }); 
                });


                function showGraph2(pendingcount,onprocessingCount,comCount,canCount)
                { 
								        
                   
                  
                  var labels = ["Pending","Payment Processed","Completed" , "Cancelled"];
							 
				 
                         var chartdata = {
                         labels:labels ,
                                datasets: 
                                [{
                                  data: [pendingcount, onprocessingCount, comCount , canCount],
                                  backgroundColor: 
                                    [
                                      "rgba(255, 195, 0 , 0.5)",
                                      "rgba(255, 81, 0,0.5)",
                                      "rgba(1, 255, 51, 0.5)",
                                      "rgba(255, 0, 0, 0.5)" 
                                    ],
                                    hoverOffset: 4
                                }]
                            };

                            var graphTarget = $("#mychart2");

                            var myLineChart = new Chart(graphTarget, {
                                type: 'doughnut', 
                                data: chartdata 
                            });
               
                }  


                document.getElementById('download-pdf2').addEventListener("click", downloadPDF22); 
                function downloadPDF22() {
                  var newCanvas = document.querySelector('#mychart2'); 
                  var newCanvasImg = newCanvas.toDataURL("image/jpeg", 1.0); 
                  var doc = new jsPDF('landscape');
                  doc.setFontSize(20);
                  doc.text(15, 15, "Super Cool Chart");
                  doc.addImage(newCanvasImg, 'JPEG', 10, 10, 280, 150 );
                  doc.save('purchasegrapgh.pdf');
                }
                $("#save-btn2").click(function() {
                      $("#mychart2").get(0).toBlob(function(blob) {
                        saveAs(blob, "purchasegrapgh.png");
                        }); 
                });

    </script>
</body>
</html>