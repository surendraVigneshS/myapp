<?php $activePage = basename($_SERVER['PHP_SELF']); ?>
<div class="sidebar-wrapper compact-wrapper">
  <div>
    <div class="logo-wrapper"><a href="home-dashboard.php"><img class="img-fluid for-light" src="./assets/images/logo/logo.png" width="75px" alt=""></a>
      <div class="back-btn">
        <i class="fa fa-angle-left"></i>
      </div>
      <div class="toggle-sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid status_toggle middle sidebar-toggle">
          <rect x="3" y="3" width="7" height="7"></rect>
          <rect x="14" y="3" width="7" height="7"></rect>
          <rect x="14" y="14" width="7" height="7"></rect>
          <rect x="3" y="14" width="7" height="7"></rect>
        </svg>
      </div>
    </div>
    <div class="logo-icon-wrapper"><a href="home-dashboard.php"><img class="img-fluid" src="./assets/images/logo/logo.png" width="45px" alt=""></a></div>
    <nav class="sidebar-main">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar"> 
          <li class="back-btn"><a href="home-dashboard.php"><img class="img-fluid" src="./assets/images/logo/logo.png" width="25px" alt=""></a>
            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
          </li>
          <li class="sidebar-main-title">
                    <div>
                      <h6 class="lan-8">Finance Menu</h6>
                      <p class="lan-9">Purchase ,Payment request</p>
                    </div>
                  </li>
          <li class="sidebar-list">
            <a class="sidebar-link <?php if ($activePage == 'home-dashboard.php') {
                                      echo 'active';
                                    } ?>" href="./home-dashboard.php"><i data-feather="home"></i><span class="">Dashboard</span></a>
          </li>
          
          <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="javaScript:void(0);" data-bs-original-title="" title="">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
              </svg>
              <span>Purchase Request</span>
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
            <ul class="sidebar-submenu" style="display: none;">
              <li <?php if ($activePage == 'purchase-list.php') {
                echo 'active';
              } ?>>
                <a class="<?php if ($activePage == 'purchase-list.php') {
                  echo 'active';
                } ?>" href="./purchase-list.php" data-bs-original-title="" title="">Purchase List</a>
              </li>
              <?php if ($logged_admin_role != 2) { ?>
                <li>
                  <a href="./new-purchase.php" data-bs-original-title="" title="">New Purchase</a>
                </li>
                <?php } ?>
              </ul>
            </li>
            
            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javaScript:void(0);" data-bs-original-title="" title=""><i data-feather="trending-up"></i><span>Payment Request</span>
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
            <ul class="sidebar-submenu" style="display: none;">
              <li><a href="./payment-list.php" data-bs-original-title="" title="">Payment List</a></li>
              <?php if ($logged_admin_role != 2) { ?>
                <li><a href="./new-payment.php" data-bs-original-title="" title="">New Payment</a></li>
                <?php } ?>
                
              </ul>
            </li>
            
            <?php if ($logged_admin_role == 2) { ?>
              <li class="sidebar-list">
                <a class="sidebar-link" href="./payment-status.php"><i data-feather="credit-card"></i><span class="">Payment Status</span></a>
            </li>
            <li class="sidebar-list">
              <a class="sidebar-link" href="./flow-chart.php"><i data-feather="bar-chart-2"></i><span class="">Flow Chart</span></a>
            </li>
            <?php } ?>
            
            <?php if($logged_admin_role == 8 || $logged_admin_role == 7 || $logged_admin_role == 5 || $logged_admin_role == 9){ ?>
          <li class="sidebar-list">
            <a class="sidebar-link" href="./followups-list.php"><i data-feather="slack"></i><span class="">Followups</span></a>
          </li>
          <?php } ?>
          
          <?php if ($logged_admin_role == 10) { ?>
            <li class="sidebar-list">
            <a class="sidebar-link" href="./remainder-list.php"><i data-feather="clock"></i><span class="">Reminder</span></a>
          </li>
          <?php } ?>
        
          <?php if ($logged_admin_role == 1) { ?>

            <li class="sidebar-list">
              <a class="sidebar-link sidebar-title" href="javaScript:void(0);"><i data-feather="user-plus"></i><span>Employee</span>
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
              <ul class="sidebar-submenu" style="display: none;">
                <li><a href="./employee-list.php">Employee List</a></li>
                <li><a href="./add-new-employee.php?platform=<?php echo randomString(45); ?>&action=addemployee">Add New Employee</a></li>
              </ul>
            </li>
            <li class="sidebar-list">
              <a class="sidebar-link sidebar-title" href="javaScript:void(0);"><i data-feather="file-text"></i><span>Organization</span>
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
              <ul class="sidebar-submenu" style="display: none;">
                <li><a href="./organization-list.php">Organization List</a></li>
                <li><a href="./add-new-organization.php?platform=<?php echo randomString(45); ?>&action=addorganization">Add New Organization</a></li>
              </ul>
            </li>
            
            <li class="sidebar-list">
              <a class="sidebar-link" href="./beneficiary-list.php"><i data-feather="command"></i><span class="">Beneficiary</span></a>
            </li>
            
            <?php } ?>
            
            <li class="sidebar-list">
              <a class="sidebar-link" href="./expenditure-list.php?platform=<?php echo RandomString(50) ?>&action=editemployee"><i data-feather="dollar-sign"></i><span class="">Expenditure</span></a>
            </li>
            
            <!-- ERP MENU -->
            <li class="sidebar-main-title">
              <div>
                <h6 class="lan-8">Inventory Menu</h6>
                <p class="lan-9">Product,Purchase Order </p>
              </div>
            </li>
            <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javaScript:void(0);" ><i data-feather="archive"></i><span>Purchase Order</span>
            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
          </a>
            <ul class="sidebar-submenu" style="display: none;">
              <li><a href="./po-list.php">PO List</a></li> 
              <li><a href="./add-purchase-order.php">New Purchase Order</a></li> 
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javaScript:void(0);" ><i data-feather="server"></i><span>Product Master</span>
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
            <ul class="sidebar-submenu" style="display: none;">
              <li><a href="./product-list.php" >Product List</a></li>  
              <li><a href="./add-product.php" >New Product</a></li>  
            </ul>
          </li>

          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javaScript:void(0);" ><i data-feather="box"></i><span>Project Master</span>
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
            <ul class="sidebar-submenu" style="display: none;">
              <li><a href="./project-list.php" >Project List</a></li>  
              <li><a href="./add-project.php" >New Project</a></li>  
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javaScript:void(0);" ><i data-feather="arrow-right-circle"></i><span>PO Inward</span>
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
            <ul class="sidebar-submenu" style="display: none;">
              <li><a href="./po-inward-list.php" >PO Inward List</a></li>  
              <li><a href="./add-new-inward.php" >New PO Inward</a></li>  
            </ul>
          </li>
          
          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javaScript:void(0);" ><i data-feather="arrow-left-circle"></i><span>General DC</span>
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
            <ul class="sidebar-submenu" style="display: none;">
              <li><a href="./dc-list.php" >DC List</a></li>  
              <li><a href="./add-new-dc.php" >New PO Inward</a></li>  
            </ul>
          </li>


          <li class="sidebar-list">
             <a class="sidebar-link sidebar-title" href="javaScript:void(0);"><i data-feather="aperture"></i><span>Supplier Master</span>
              <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
            <ul class="sidebar-submenu" style="display: none;">
              <li><a href="./supplier-list.php">Supplier List</a></li>
              <li><a href="./add-new-supplier.php?platform=<?php echo randomString(45); ?>&action=addsupplier">Add New Supplier</a></li>
            </ul>
        </li>



          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javaScript:void(0);" ><i data-feather="folder-plus"></i><span>Item Group</span>
          <div class="according-menu"><i class="fa fa-angle-right"></i></div>
            </a>
            <ul class="sidebar-submenu" style="display: none;">
              <li><a href="./item-group-list.php" >Item  Group</a></li>  
              <li><a href="./item-group.php?platform=ZH4o1dAN0pTUbdFWVlEuRQsmYpg4hn&action=add" >New Item  Group</a></li>  
            </ul>
          </li>


          <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javaScript:void(0);" ><i data-feather="thermometer"></i><span>UOM</span>
          <div class="according-menu"><i class="fa fa-angle-right"></i></div>
        </a>
        <ul class="sidebar-submenu" style="display: none;">
          <li><a href="./uom-list.php" >UOM List</a></li>  
          <li><a href="./uom.php?platform=<?php echo RandomString(30) ?>&action=add" >New UOM</a></li>  
        </ul>
      </li>

      
    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javaScript:void(0);" ><i data-feather="list"></i><span>Terms & Conditions</span>
          <div class="according-menu"><i class="fa fa-angle-right"></i></div>
        </a>
        <ul class="sidebar-submenu" style="display: none;">
          <li><a href="./terms-list.php" >Terms List</a></li>  
          <li><a href="./terms.php" >New Item  Group</a></li>  
        </ul>
      </li> 
      
      <li class="sidebar-list">
        <a class="sidebar-link" href="allowances-list.php?platform=6kGZceRCMbWwiQTJCQas7kXiMbItBQhEXS5TZnuRwT4vQ&action=new"><i data-feather="folder-plus"></i><span class="">Additions</span></a>
      </li>
      <li class="sidebar-list">
        <a class="sidebar-link" href="deductions-list.php?platform=mC6usukc4GRjtipIw7XrObN4X9AAtI&action=new"><i data-feather="folder-minus"></i><span class="">Deductions</span></a>
      </li>
      <li class="sidebar-list">
        <a class="sidebar-link" href="tax-list.php?platform=6kGZceRCMbWwiQTJCQas7kXiMbItBQhEXS5TZnuRwT4vQ&action=new"><i data-feather="globe"></i><span class="">Taxes</span></a>
      </li>
        <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javaScript:void(0);" ><i data-feather="map-pin"></i><span>Product Location</span>
          <div class="according-menu"><i class="fa fa-angle-right"></i></div>
        </a>
        <ul class="sidebar-submenu" style="display: none;">
          <li><a href="./store-list.php" >Store Room List</a></li>  
          <li><a href="./store-room.php?platform=<?php echo RandomString(30) ?>&action=add" >New Store Room</a></li>  
          <li><a href="./rack-list.php" >Rack List</a></li>  
          <li><a href="./rack.php?platform=<?php echo RandomString(30) ?>&action=add" >New Rack</a></li>  
          <li><a href="./column-list.php" >Column List</a></li>  
          <li><a href="./column.php?platform=<?php echo RandomString(30) ?>&action=add" >New Column</a></li>  
        </ul>
      </li>

      <li class="sidebar-list">
        <a class="sidebar-link" href="transport.php?platform=6kGZceRCMbWwiQTJCQas7kXiMbItBQhEXS5TZnuRwT4vQ&action=new"><i data-feather="truck"></i><span class="">Transport Master</span></a>
      </li>
       
      
      
      <li class="sidebar-list">
        <a class="sidebar-link" href="./user-profile.php?platform=<?php echo RandomString(50) ?>&action=editemployee"><i data-feather="user"></i><span class="">Profile</span></a>
      </li> 
      
    </ul>
  </div>
</nav>
  </div>
</div>