<!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="<?= base_url() ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?= base_url() ?>/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= base_url() ?>/assets/images/logo-dark.png" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="<?= base_url() ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?= base_url() ?>/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= base_url() ?>/assets/images/logo-light.png" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/admin/dashboard" class="nav-link" data-key="t-one-page"><i class="ri-dashboard-2-line"></i>  Dashboard </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-user-2-line"></i> <span data-key="t-dashboards">Users Management</span>
                            </a>
                            <div class="menu-dropdown collapse" id="sidebarDashboards" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?= base_url() ?>/admin/users" class="nav-link" data-key="t-analytics">Customers</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url() ?>/admin/verified" class="nav-link" data-key="t-analytics">Sellers</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                     
                <!--  -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#coupons" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="category">
                                <i class="bx bx-list-ul"></i> <span data-key="t-dashboards">Coupon Management</span>
                            </a>
                            <div class="menu-dropdown collapse" id="coupons" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?= base_url('admin/coupons') ?>" class="nav-link" data-key="t-analytics">View Coupon</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#swaps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="category">
                                <i class="bx bx-list-ul"></i> <span data-key="t-dashboards">Swap Management</span>
                            </a>
                            <div class="menu-dropdown collapse" id="swaps" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?= base_url('admin/swaps') ?>" class="nav-link" data-key="t-analytics">View Coupon</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#category" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="category">
                                <i class="bx bx-list-ul"></i> <span data-key="t-dashboards">Category Management</span>
                            </a>
                            <div class="menu-dropdown collapse" id="category" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?= base_url() ?>/admin/category" class="nav-link" data-key="t-analytics">View Category</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link menu-link" href="#Plan" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Plan">
                             <i class="bx bx-list-ul"></i> <span data-key="t-dashboards">Plan Management</span>
                            </a>
                            <div class="menu-dropdown collapse" id="Plan" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                      <a href="<?= base_url() ?>/admin/plan" class="nav-link" data-key="t-analytics">Plan List</a>
                                   </li>
                                   <li class="nav-item">
                                      <a href="<?= base_url() ?>/admin/plan-subscription" class="nav-link" data-key="t-analytics">Plan Subscription List</a>
                                    </li>
                                </ul>
                            </div>
                        </li>


                         <li class="nav-item">
                            <a class="nav-link menu-link" href="#contactus" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="contactus">
                               <i class="bx bx-book-content"></i> <span data-key="t-dashboards">Contact Requests</span>
                            </a>
                            <div class="menu-dropdown collapse" id="contactus" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                      <a href="<?= base_url() ?>/admin/contactus" class="nav-link" data-key="t-analytics">View</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                         <li class="nav-item">
                            <a class="nav-link menu-link" href="#state" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="state">
                                <i class="bx bx-category"></i> <span data-key="t-dashboards">Post Management</span>
                            </a>
                            <div class="menu-dropdown collapse" id="state" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?= base_url() ?>/admin/post" class="nav-link" data-key="t-analytics">Approved Post List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url() ?>/admin/pending-post" class="nav-link" data-key="t-analytics">Pending Post List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url() ?>/admin/post-subscription" class="nav-link" data-key="t-analytics">Post Subscription</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#aucation" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="state">
                                <i class="bx bx-category"></i> <span data-key="t-dashboards">Auction Management</span>
                            </a>
                            <div class="menu-dropdown collapse" id="aucation" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?= base_url('admin/auction') ?>" class="nav-link" data-key="t-analytics">Auction List</a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#group" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="content">
                               <i class="bx bx-group"></i> <span data-key="t-dashboards">Group Management</span>
                            </a>
                            <div class="menu-dropdown collapse" id="group" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?= base_url() ?>/admin/group-list" class="nav-link" data-key="t-analytics">view</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#content" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="content">
                               <i class="bx bx-cog"></i> <span data-key="t-dashboards">Site Settings</span>
                            </a>
                            <div class="menu-dropdown collapse" id="content" style="">
                                <ul class="nav nav-sm flex-column">
                                  <li class="nav-item">
                                      <a href="<?= base_url() ?>/admin/profile" class="nav-link" data-key="t-analytics">Admin settings</a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="<?= base_url() ?>/admin/content" class="nav-link" data-key="t-analytics">Pages Content</a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="<?= base_url() ?>/admin/social" class="nav-link" data-key="t-analytics">Social Management</a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="<?= base_url() ?>/admin/testimonial" class="nav-link" data-key="t-analytics">Testimonial Management</a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="<?= base_url() ?>/admin/menu" class="nav-link" data-key="t-analytics">Menu Management</a>
                                  </li>
                                  <li class="nav-item">
                                      <a href="<?= base_url() ?>/admin/home_banner" class="nav-link" data-key="t-analytics">Home page banner</a>
                                  </li>
                                </ul>
                            </div>
                        </li>


                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">