<style type="text/css">
  .sidebar_menu{
    text-decoration: none;
  }

</style>

<aside class="col-lg-4 col-md-5 pe-xl-4 mb-5">
            <!-- Account nav-->
            <div class="card card-body border-0 shadow-sm pb-1 me-lg-1">
              <div class="d-flex d-md-block d-lg-flex align-items-start pt-lg-2 mb-4">
              	<img class="rounded-circle" src="<?= base_url($this->user['image']) ?>" width="48" alt="<?= $this->user['name'] ?>">
                <div class="pt-md-2 pt-lg-0 ps-3 ps-md-0 ps-lg-3">
                  <h2 class="fs-lg mb-0"><?= $this->user['name'] ?></h2>
                  <?php if ($this->user['user_type'] == 2 && $this->user['is_verified'] == 1  ): ?>
                  <!-- <span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i></span> -->
                <?php endif; ?>
                  <ul class="list-unstyled fs-sm mt-3 mb-0">
                    <li><a class="nav-link fw-normal p-0" href="tel:5444646"><i class="fi-phone opacity-60 me-2"></i>+<?= $this->user['phonecode'] ?><?= $this->user['phone'] ?></a></li>
                    <li><a class="nav-link fw-normal p-0 notranslate" href="mailto:<?= $this->user['email'] ?>"><i class="fi-mail opacity-60 me-2"></i><?= $this->user['email'] ?></a></li>
                                      </ul>
                </div>
              </div>
               <?php if ($this->user['user_type'] == 2 && $this->user['is_verified'] == 1  ): ?>
              <a class="btn btn-primary btn-sm btn-lg mb-3" href="<?= base_url('add_post') ?>" ><i class="fi-plus me-2"></i>Post Ad</a>
              <?php endif; ?>
              <a class="btn btn-outline-secondary d-block d-md-none w-100 mb-3" href="#account-nav" data-bs-toggle="collapse"><i class="fi-align-justify me-2"></i>Menu</a>
              <div class="collapse d-md-block mt-3" id="account-nav">
                <div class="card-nav">
                	<ul class="nav nav-tabs flex-column" role="tablist">
                	
                  <li class="nav-item">
                  <a class="sidebar_menu" href="<?= base_url()?>/profile"><i class="fi-user opacity-60 me-2"></i>Personal Info</a>
                  </li>
                
                  <li class="nav-item">
                  <a class="sidebar_menu" href="<?= base_url()?>/update-password"><i class="fi-lock opacity-60 me-2"></i>Password &amp; Security</a></li>
                  <?php if ($this->user['user_type'] == 2 && $this->user['is_verified'] == 1  ): ?>
                	
                  <li class="nav-item">
                  <a class="sidebar_menu" href="<?= base_url()?>/mypost" ><i class="fi-home opacity-60 me-2"></i>My Posts</a></li>
                	<!-- <li class="nav-item">
                	<a href="javascript:(0)" onclick="alert('comming soon'); return false;" class="card-nav-link"  data-bs-toggle="tab" role="tab" href="#review"><i class="fi-star opacity-60 me-2"></i>Reviews</a></li> -->

                  <!-- <li class="nav-item">
                  <a class="sidebar_menu" href="<?= base_url()?>/reviews" onclick="alert('comming soon'); return false;"><i class="fi-star opacity-60 me-2"></i>Reviews</a></li> -->
                  
                	
                   <li class="nav-item">
                  <a class="sidebar_menu" href="<?= base_url()?>/notification" ><i class="fi-bell opacity-60 me-2"></i>Notifications</a></li> 

                  <!-- <li class="nav-item">
                  <a class="card-nav-link"  data-bs-toggle="tab" role="tab" href="#upgradeplan"><i class="fi-bell opacity-60 me-2"></i>Upgrade Plan</a></li> -->
                  <?php
                   $user_id = $this->session->get('user_id'); 
                   $plan_data = check_subscription($user_id , true);
                   
                   if($plan_data['active'] != 0){
                    ?>
                      <li class="nav-item">
                      <a class="sidebar_menu" href="<?= base_url()?>/my-coupons"><i class="fi-gift opacity-60 me-2"></i>Coupons</a></li> 
                      <li class="nav-item">
                      <a class="sidebar_menu" href="<?= base_url()?>/my-swaps"><i class="fi-refresh opacity-60 me-2"></i>Swaps</a></li> 
                      
                  <?php }
                  ?>
                  
                  <li class="nav-item">
                  <a class="sidebar_menu" href="<?= base_url()?>/my-joined-groups"><i class="fi-users opacity-60 me-2"></i>My Groups</a></li>

                  <li class="nav-item">

                  <a class="sidebar_menu btn_chat btn_chatt" href="javascript:void(0);" onclick="refresh_chat_users()"><i class="fi-chat-circle opacity-60 me-2"></i>My Inbox</a></li>
                  
                  <li class="nav-item">
                  <a class="sidebar_menu" href="<?= base_url()?>/upgrade-plan"><i class="fi-bell opacity-60 me-2"></i>Upgrade Plan</a></li>
                  <li class="nav-item">
                  <a class="sidebar_menu" href="<?= base_url()?>/wishlist/post"><i class="fi-heart opacity-60 me-2"></i>Wishlist</a></li>
                  
                	<li class="nav-item">
                  <?php endif ?>
                  <div class="pt-2">
                    <div class="position-relative mb-2 map_div shadow-sm">
                      <!-- <img class="rounded-3" src="img/real-estate/single/map.jpg" alt="Map"> -->
                      
                      <iframe src="//maps.google.com/maps?q=<?= $this->user['lat'] ?>,<?= $this->user['lng'] ?>&z=15&output=embed" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" id="location_preview"></iframe>
                      
                      
                    </div>
                    <p class="mb-0 fs-base text-primary" id="p_address"><?= $this->user['address'] ?></p>
                  </div>
                	<a class="card-nav-link" href="<?= base_url('Home/logout') ?>"><i class="fi-logout opacity-60 me-2"></i>Sign Out</a></li>
                </ul>
                </div>
              </div>
            </div>
          </aside>