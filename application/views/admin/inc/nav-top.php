<!-- Navbar -->

<nav class="main-header navbar navbar-expand-md navbar-dark navbar-navy">
    <div class="container">
      <a href="<?=base_url()?>dashboard" class="navbar-brand">
        <img src="<?=base_url()?>assets/admin/dist/img/AdminLTELogo.png" alt="" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Heirloom - Admin</span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url()?>dashboard" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url()?>home-Screen" class="nav-link">Banners</a>
          </li> 
        
          <!-- 
          <li class="nav-item">
            <a href="#" class="nav-link">Contact</a>
          </li>
          
           
           -----------------Geo----------------- -->
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">GEO</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              
              <li><a href="<?=base_url()?>continent" class="dropdown-item">Continent</a></li>
              <li><a href="<?=base_url()?>country" class="dropdown-item">Country</a></li>
              <li><a href="<?=base_url()?>state" class="dropdown-item">State</a></li>
              <li><a href="<?=base_url()?>city" class="dropdown-item">City</a></li>
              <li><a href="<?=base_url()?>location" class="dropdown-item">Location</a></li>
              </ul>
          </li>
             <!-- -----------------Geo----------------- --> 
            <!-- -----------------Settings----------------- --> 
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Settings</a>
            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">  
            	<li><a href="<?=base_url()?>category_type" class="dropdown-item">Category type</a></li>              
         
	              <!-- <li><a href="<?=base_url()?>category" class="dropdown-item">Category</a></li>              
                <li><a href="<?=base_url()?>sub-category" class="dropdown-item">Sub Category</a></li>               -->
            </ul>
          </li>
          <!-- -----------------Settings----------------- --> 
        <!-- -----------------Events----------------- --> 
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Inventory</a>
            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
            <li><a href="<?=base_url()?>add-inventory" class="dropdown-item">Inventory Add</a></li>
	              <li><a href="<?=base_url()?>inventory" class="dropdown-item">Inventory View</a></li>   
          
            </ul>
          </li>
          <!-- -----------------Events----------------- -->   
          
           <!-- -----------------Users----------------- --> 
         
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Users</a>
            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
           
	              <li><a href="<?=base_url()?>users-view" class="dropdown-item">View Users</a></li>
	              
	              <li><a href="<?=base_url()?>user-deposits" class="dropdown-item">User Deposits</a></li>
                <li class="nav-item">
            <a href="<?=base_url()?>user-filter" class="dropdown-item">User Data</a>
          </li> 
          
             
            </ul>
          </li>
          <li class="nav-item dropdown">
          <a href="<?=base_url()?>chat" class="nav-link">Chat</a>
                      <!-- <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
           
	              <li><a href="<?=base_url()?>chat" class="dropdown-item">Chat</a></li>
             
            </ul> -->
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Notifications</a>
            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
           
	              <li><a href="<?=base_url()?>add-notifications" class="dropdown-item">Add Notifications</a></li>
                <li><a href="<?=base_url()?>notifications" class="dropdown-item">View Notifications</a></li>
            </ul>
          </li>
          <!-- -----------------Users----------------- -->  
          <!----------------------Partners----------------> 
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Partners</a>
            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
           
	              <li><a href="<?=base_url()?>add-partner" class="dropdown-item">Add Partners</a></li>
                <li><a href="<?=base_url()?>partner-view" class="dropdown-item">View Partners</a></li>

             
            </ul>
          </li>
          <!---------------------------partners------------------->

          <!--------------Library--------------------------------->
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Library</a>
            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
           
	              <li><a href="<?=base_url()?>library-view/Tagged" class="dropdown-item">View Tagged</a></li>
                <li><a href="<?=base_url()?>library-view/Project" class="dropdown-item">View Project</a></li>
                <li><a href="<?=base_url()?>library-view/Saved" class="dropdown-item">View Saved</a></li>

             
            </ul>
          </li>
          <!-------------End library------------------------------->
          

          
         <!-- <li class="nav-item">
            <a href="<?=base_url()?>notify_me" class="nav-link">Notify Me</a>
          </li> -->
          
      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Messages Dropdown Menu -->
        <!-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <div class="media">
                <img src="<?=base_url();?>assets/control/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <div class="media">
                <img src="<?=base_url();?>assets/control/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <div class="media">
                <img src="<?=base_url();?>assets/control/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li> -->
        <!-- Notifications Dropdown Menu -->
        <!-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="<?=base_url()?>logout"><i class="fa fa-power-off"></i></a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->