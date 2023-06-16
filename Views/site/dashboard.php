<?php 
include_once 'includes/header.php';
?>

<section class="container pt-5 mt-5">
        <!-- Breadcrumb-->
        <?= $this->session->getFlashdata('msg'); ?>
        <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Profile</li>
          </ol>
        </nav>
      </section>
       <div class="container">
       	 <div class="row">
          <!-- Sidebar-->
          <?php include_once 'includes/user_sidebar.php' ?>
          <!-- Content-->
          <div class="col-lg-8 col-md-7 mb-5">

          	<div class="tab-content">
            
             <div class="tab-pane fade show active" id="home1" role="tabpanel">
              <form action="#" id="do_update" method="post" onsubmit="return do_update(event)">
            <h1 class="h2">Personal Info</h1>
           
            <label class="form-label pt-2" for="account-bio">Profile pic edit</label>
            <div class="row pb-2">
              
              <div class="col-lg-12 col-sm-4 mb-4">
                <input class="form-control" name="image" type="file" accept="image/png, image/jpeg" data-label-idle="&lt;i class=&quot;d-inline-block fi-camera-plus fs-2 text-muted mb-2&quot;&gt;&lt;/i&gt;&lt;br&gt;&lt;span class=&quot;fw-bold&quot;&gt;Change picture&lt;/span&gt;" data-style-panel-layout="compact" data-image-preview-height="160" data-image-crop-aspect-ratio="1:1" data-image-resize-target-width="200" data-image-resize-target-height="200">
              </div>
            </div>
            <div class="border rounded-3 p-3 mb-4" id="personal-info">
              <!-- Name-->
              <div class="border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="pe-2">
                    <label class="form-label fw-bold">Full name</label>
                    <div id="name-value"><?= $this->user['name'] ?></div>
                  </div>
                  <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#name-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                </div>
                <div class="collapse" id="name-collapse" data-bs-parent="#personal-info">
                  <input class="form-control mt-3" name="name" type="text" data-bs-binded-element="#name-value" data-bs-unset-value="Not specified" value="<?= $this->user['name'] ?>">
                </div>
              </div>
              <!-- Email-->
              <div class="border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="pe-2">
                    <label class="form-label fw-bold">Email</label>
                    <div id="email-value" class="notranslate"><?= $this->user['email'] ?></div>
                  </div>
                  <!-- <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#email-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div> -->
                </div>
                <div class="collapse" id="email-collapse" data-bs-parent="#personal-info">
                  <input class="form-control mt-3 notranslate" disabled type="email" data-bs-binded-element="#email-value" data-bs-unset-value="Not specified" value="<?= $this->user['email'] ?>">
                </div>
              </div>
              <!-- Phone number-->
              <div class="border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="pe-2">
                    <label class="form-label fw-bold">Phone number</label>
                    <div id="phone-value"><?= '+'.$this->user['phonecode'].' '.$this->user['phone'] ?></div>

                  </div>
                  <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#phone-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                </div>
                <div class="collapse" id="phone-collapse" data-bs-parent="#personal-info">
                 
                  <div class="input-group mb-3">
                        
                          <select class="form-control mt-0 w-20 select_countries" name="phonecode">
                           
                               <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                              <optgroup label="Other countries">
                                <?php $countries_code = $this->common_model->GetAllData('countries') ?>
                                <?php foreach ($countries_code as $key => $value): ?>
                                  <option <?= ($this->user['phonecode'] == $value['phonecode']) ? 'checked' : '' ?> data-countryCode="<?= $value['iso2'] ?>" value="<?= $value['phonecode'] ?>"><?= $value['name'] ?> (+<?= $value['phonecode'] ?>)</option>
                                <?php endforeach ?>
                                
                                
                              </optgroup>
                          </select>
                        
                         <input class="form-control mt-0" type="text" name="phone" data-bs-binded-element="#phone-value"  value="<?= $this->user['phone'] ?>">
                      </div>
                </div>
              </div>

               <div class="border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="pe-2">
                    <label class="form-label fw-bold">Interested In</label>
                    <div id="interest_edit">
                      <?php 
                      //echo $this->user['interested_in']; die;
                    if($this->user['interested_in'])
                    {
                      if($this->user['interested_in'] != 1){
                          $catData = $this->common_model->GetSingleData('category', "id = ".$this->user['interested_in']."");
                        echo ($catData) ? $catData['title_eng'] : '';
                      }
                      else
                        echo "All";
                    }
                    else
                    {
                      echo 'Others : '.$this->user['other_interest'];
                    }
                    ?></div>
                  </div>
                  <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#interest-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                </div>
                <div class="collapse" id="interest-collapse" data-bs-parent="#personal-info">
                  <?php
                    $category = $this->common_model->GetAllData('category',array('parent_id'=>0),'id','desc');
                    ?>
                    <option <?php echo(1 == $this->user['interested_in']) ? 'selected' : '' ;?> value="1">All</option>
                      <select class="form-control signup_page" name="category[]"  required>
                         <?php 
                         foreach ($category as $key => $catV) {
                           ?>
                           <option <?php echo($catV['id'] == $this->user['interested_in']) ? 'selected' : '' ;?> value="<?= $catV['id']; ?>"><?= $catV['title_eng']; ?></option>
                           <?php
                         }
                         ?>
                         <option <?php echo(0 == $this->user['interested_in']) ? 'selected' : '' ;?> value="0">Others</option>
                         </select>
                          <input style="display: <?php echo(0 == $this->user['interested_in']) ? 'block' : 'none' ;?>;" type="text" name="other_interest" value="<?= $this->user['other_interest'] ?>"  class="form-control mt-3" placeholder="type your own interest">
                </div>
                <div name="category"></div>
              </div>
              
              <!-- Address-->
              <div>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="pe-2">
                    <label class="form-label fw-bold">Address</label>
                    <div id="address-value"><?= $this->user['address'] ?></div>
                  </div>
                  <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#address-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                </div>
                <div class="collapse" id="address-collapse" data-bs-parent="#personal-info">
                  <input class="form-control mt-3" type="text" data-bs-binded-element="#address-value" data-bs-unset-value="Not specified" placeholder="Enter address" name="address" id="address" value="<?= $this->user['address'] ?>">
                  <input type="hidden" name="lat" id="lat" value="<?= $this->user['lat'] ?>">
                  <input type="hidden" name="lng" id="lng" value="<?= $this->user['lng'] ?>">
                  
                  <label class="my-3">country</label>
                  
                  <select  id="country-dd" name="country" class="form-control  ">
                      <option value="">Select Country</option>
                      <?php
                      $state_fetch = [];
                       foreach ($countries_fetch as $key => $data): ?>
                        <?php if ($this->user['country'] == $data['name']) {
                          $state_fetch =  $this->common_model->GetAllData('states' , ["country_id" => $data['id'] ] , 'name' , 'asc' , '' , ["name", "id"]);
                        } ?>
                        <option <?= ($this->user['country'] == $data['name']) ? 'selected' : '' ?> value="<?= $data['name']; ?>" data-id="<?= $data['id']; ?>">
                          <?= $data['name']; ?>
                      </option>
                      <?php endforeach ?>
                      
                  </select>
                  <label class="my-3">state</label>
                  <select  id="state-dd" name="state" class="form-control  ">
                      <option value="">Select State</option>
                      <?php
                      $city_fetch = [];
                       foreach ($state_fetch as $key => $data): ?>
                        <?php if ($this->user['state'] == $data['name']) {
                          $city_fetch =  $this->common_model->GetAllData('cities' , ["state_id" => $data['id'] ] , 'name' , 'asc' , '' , ["name", "id"]);
                        } ?>
                        <option <?= ($this->user['state'] == $data['name']) ? 'selected' : '' ?> value="<?= $data['name']; ?>" data-id="<?= $data['id']; ?>">
                          <?= $data['name']; ?>
                      </option>
                      <?php endforeach ?>
                      
                  </select>
                  <label class="my-3">City</label>
                   <select  id="city-dd" name="city" class="form-control  ">
                      <option value="">Select Country</option>
                  <?php foreach ($city_fetch as $key => $data): ?>
                       
                        <option <?= ($this->user['city'] == $data['name']) ? 'selected' : '' ?> value="<?= $data['name']; ?>" data-id="<?= $data['id']; ?>">
                          <?= $data['name']; ?>
                      </option>
                      <?php endforeach ?>
                   </select>
                  <label class="my-3">zipcode</label><input type="number" class="form-control" name="zipcode" id="zipcode" value="<?= $this->user['zipcode'] ?>">
                  <div class="row justify-content-center">
                          <button class="col-6 btn btn-primary" type="hidden" id="btn_location_modal">Select Location on Map</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Socials-->
            <?php if ($this->user['user_type'] == 2 && $this->user['is_verified'] == 1  ): ?>
            <div class="pt-2">
              <label class="form-label fw-bold mb-3">Socials</label>
            </div>
            <div class="d-flex align-items-center mb-3">
              <div class="btn btn-icon btn-light btn-xs shadow-sm rounded-circle pe-none flex-shrink-0 me-3"><i class="fi-facebook text-body"></i></div>
              <input class="form-control" type="url" placeholder="Your Facebook account" name="facebook" value="<?= $this->user['facebook'] ?>">
            </div>
            <div class="d-flex align-items-center mb-3">
              <div class="btn btn-icon btn-light btn-xs shadow-sm rounded-circle pe-none flex-shrink-0 me-3"><i class="fi-linkedin text-body"></i></div>
              <input class="form-control" type="url" placeholder="Your LinkedIn account"  name="linkedin" value="<?= $this->user['linkedin'] ?>">
            </div>
            <div class="d-flex align-items-center mb-3">
              <div class="btn btn-icon btn-light btn-xs shadow-sm rounded-circle pe-none flex-shrink-0 me-3"><i class="fi-twitter text-body"></i></div>
              <input class="form-control" type="url" placeholder="Your Twitter account"  name="twitter" value="<?= $this->user['twitter'] ?>">
            </div>
            <div class="collapse" id="showMoreSocials">
              <div class="d-flex align-items-center mb-3">
                <div class="btn btn-icon btn-light btn-xs shadow-sm rounded-circle pe-none flex-shrink-0 me-3"><i class="fi-instagram text-body"></i></div>
                <input class="form-control" type="url" placeholder="Your Instagram account"  name="instagram" value="<?= $this->user['instagram'] ?>">
              </div>
              <div class="d-flex align-items-center mb-3">
                <div class="btn btn-icon btn-light btn-xs shadow-sm rounded-circle pe-none flex-shrink-0 me-3"><i class="fi-pinterest text-body"></i></div>
                <input class="form-control" type="url" placeholder="Your Pinterest account" name="pinterest" value="<?= $this->user['pinterest'] ?>">
              </div>
            </div><a class="collapse-label collapsed d-inline-block fs-sm fw-bold text-decoration-none pt-2 pb-3" href="#showMoreSocials" data-bs-toggle="collapse" data-bs-label-collapsed="Show more" data-bs-label-expanded="Show less" role="button" aria-expanded="false" aria-controls="showMoreSocials"><i class="fi-arrow-down me-2"></i></a>
          <?php endif; ?>
            <div class="d-flex align-items-center justify-content-between border-top mt-4 pt-4 pb-1">
              <button class="btn btn-primary px-3 px-sm-4 btn-sm" id="edit_profile_btn" type="submit">Save changes</button>
              <button class="btn btn-link btn-sm px-0" type="button" onclick="do_delete_account(<?= $this->user_id ?>)"><i class="fi-trash me-2"></i>Delete account</button>
            </div>
            </form>
          </div>

           <!-- tab2  -->

          <div class="tab-pane fade" id="passwrod" role="tabpanel">

            
            <h1 class="h2">Password &amp; Security</h1>
            <p class="pt-1">Manage your password settings and secure your account.</p>
            <h2 class="h5">Password</h2>
            <form class="needs-validation pb-4" novalidate="" id="do_change_password" method="post" onsubmit="return do_change_password(event)">
              <div class="row align-items-end mb-2">
                <div class="col-sm-6 mb-2">
                  <label class="form-label" for="account-password">Current password</label>
                  <div class="password-toggle">
                    <input class="form-control" type="password" name="curr_password" id="account-password" required="">
                    <label class="password-toggle-btn" aria-label="Show/hide password">
                      <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                    </label>
                  </div>
                </div>
                <div class="col-sm-6 mb-2"><a class="d-inline-block mb-2" href="#forgot-modal" data-bs-toggle="modal">Forgot password?</a></div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-6 mb-3">
                  <label class="form-label" for="account-password-new">New password</label>
                  <div class="password-toggle">
                    <input class="form-control" type="password" name="password" id="account-password-new" required="">
                    <label class="password-toggle-btn" aria-label="Show/hide password">
                      <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                    </label>
                  </div>
                </div>
                <div class="col-sm-6 mb-3">
                  <label class="form-label" for="account-password-confirm">Confirm password</label>
                  <div class="password-toggle">
                    <input class="form-control" type="password" name="c_password" id="account-password-confirm" required="">
                    <label class="password-toggle-btn" aria-label="Show/hide password">
                      <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
                    </label>
                  </div>
                </div>
              </div>
              <button class="btn btn-outline-primary btn-sm" type="submit" id="c_pswd_btn">Update password</button>
            </form>
          	
          </div>

          <!-- tab3  -->
          <div class="tab-pane fade" id="post" role="tabpanel">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h1 class="h2 mb-0">My Posts</h1>
            </div>
            <p class="pt-1 mb-4">Here you can see your posts and edit them easily.</p>

             
            
            <!-- Item-->
            <?php
for ($x = 0; $x <= 10; $x++) {
  echo '<div class="card card-horizontal shadow-sm card-hover border-0 h-100 tns_height mb-3">
  <div class="dropdown position-absolute zindex-5 top-0 end-0 mt-3 me-3">
    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu1">
      <li>
        <button class="dropdown-item" type="button"><i class="fi-edit opacity-60 me-2"></i>Edit</button>
      </li>
      <li>
        <button class="dropdown-item" type="button"><i class="fi-trash opacity-60 me-2"></i>Delete</button>
      </li>
    </ul>
  </div>
  <div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="#"></a>
    
    <div class="content-overlay end-0 top-0 pt-3 pe-3">
      <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
    </div>
    <div class="tns-carousel-inner"><img src="img/real-estate/catalog/06.jpg" alt="Image"><img src="img/real-estate/catalog/06.jpg" alt="Image"></div>
  </div>
  <div class="card-body position-relative pb-3">
    <div class="d-flex align-items-start justify-content-between">
      <div>
        <h4 class="mb-0 h4 fs-xs text-primary"><i class="fi-map-pin me-2"></i> Makkah <span class="fs-sm m-0 fw-normal text-primary">(2 miles)</span></h4>
        <span class="fs-sm h6 m-0">2 miles</span></div>
        <span class="badge rounded-pill bg-success py-1 px-2 fs-xs me-5">Auction</span>
      </div>
      <h3 class="h6 mb-2 mt-1 fs-base"><a class="nav-link stretched-link" href="#">King Abdullah Economic</a></h3>
      <p class="mb-2 fs-sm text-muted">King Abdullah Economic City Al-Waha District</p>
      <div class="d-flex align-items-center text-decoration-none" href="#"><img class="rounded-circle loaded tns-complete" src="img/avatars/16.png" alt="Avatar" width="44">
        <div class="ps-2">
          <h6 class="fs-sm text-nav lh-base mb-1">Bessie Cooper</h6>
          <div class="d-flex text-body fs-xs"><span class="me-2 pe-1"><i class="fi-calendar-alt opacity-70 mt-n1 me-1 align-middle"></i>May 24</span><span><i class="fi-chat-circle opacity-70 mt-n1 me-1 align-middle"></i>No comments</span></div>
        </div>
      </div>
    </div>
  </div>';
}
?>

          </div>

          <!-- tab4 -->
          <div class="tab-pane fade" id="review" role="tabpanel">
            <h1 class="h2">Reviews</h1>
            <p class="pt-1 mb-4">Lorem ipsum dollar sit amet. lorem ipsum is a dummy text</p>
            
                <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch justify-content-between pb-4 mb-2 mb-md-3">
                  <h3 class="h4 mb-sm-0"><i class="fi-star-filled mt-n1 me-2 lead align-middle text-warning"></i>4,9 (32 reviews)</h3>
                  <div class="d-flex align-items-center ms-sm-4">
                    <label class="fs-sm me-2 pe-1 text-nowrap" for="review-sorting1"><i class="fi-arrows-sort text-muted mt-n1 me-2"></i>Sort by:</label>
                    <select class="form-select form-select-sm" id="review-sorting1">
                      <option>Newest</option>
                      <option>Oldest</option>
                      <option>Popular</option>
                      <option>High rating</option>
                      <option>Low rating</option>
                    </select>
                  </div>
                </div>
                <!-- Review-->
                <div class="mb-4 pb-4 border-bottom">
                  <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex align-items-center pe-2"><img class="rounded-circle me-1" src="img/avatars/06.jpg" alt="Avatar" width="48">
                      <div class="ps-2">
                        <h6 class="fs-base mb-0">John Doe</h6><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i></span>
                      </div>
                    </div><span class="text-muted fs-sm">Jan 17, 2021</span>
                  </div>
                  <p>Elementum ut quam tincidunt egestas vitae elit, hendrerit. Ullamcorper nulla amet lobortis elit, nibh condimentum enim. Aliquam felis nisl tellus sodales lectus dictum tristique proin vitae. Odio fermentum viverra tortor quis.</p>
                  <div class="d-flex align-items-center">
                    <button class="btn-like" type="button"><i class="fi-like"></i><span>(3)</span></button>
                    <div class="border-end me-1">&nbsp;</div>
                    <button class="btn-dislike" type="button"><i class="fi-dislike"></i><span>(0)</span></button>
                  </div>
                </div>
                <!-- Review-->
                <div class="mb-4 pb-4 border-bottom">
                  <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex align-items-center pe-2"><img class="rounded-circle me-1" src="img/avatars/13.png" alt="Avatar" width="48">
                      <div class="ps-2">
                        <h6 class="fs-base mb-0">John Doe</h6><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-half active"></i><i class="star-rating-icon fi-star"></i></span>
                      </div>
                    </div><span class="text-muted fs-sm">Dec 1, 2020</span>
                  </div>
                  <p>Vel dictum nunc ut tristique. Egestas diam amet, ut proin hendrerit. Dui accumsan at phasellus tempus consequat dignissim tellus sodales.</p>
                  <div class="d-flex align-items-center">
                    <button class="btn-like" type="button"><i class="fi-like"></i><span>(0)</span></button>
                    <div class="border-end me-1">&nbsp;</div>
                    <button class="btn-dislike" type="button"><i class="fi-dislike"></i><span>(1)</span></button>
                  </div>
                </div>
                <!-- Review-->
                <div class="mb-4 pb-4 border-bottom">
                  <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex align-items-center pe-2"><img class="rounded-circle me-1" src="img/avatars/05.jpg" alt="Avatar" width="48">
                      <div class="ps-2">
                        <h6 class="fs-base mb-0">John Doe</h6><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i></span>
                      </div>
                    </div><span class="text-muted fs-sm">Oct  28, 2020</span>
                  </div>
                  <p>Viverra nunc blandit sapien non imperdiet sit. Purus tempus elementum aliquam eu urna. A aenean duis non egestas at libero porttitor integer eget. Sed dictum lobortis laoreet gravida.</p>
                  <div class="d-flex align-items-center">
                    <button class="btn-like" type="button"><i class="fi-like"></i><span>(2)</span></button>
                    <div class="border-end me-1">&nbsp;</div>
                    <button class="btn-dislike" type="button"><i class="fi-dislike"></i><span>(1)</span></button>
                  </div>
                </div>
                <!-- Review-->
                <div class="mb-4 pb-4 border-bottom">
                  <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex align-items-center pe-2"><img class="rounded-circle me-1" src="img/avatars/04.jpg" alt="Avatar" width="48">
                      <div class="ps-2">
                        <h6 class="fs-base mb-0">John Doe</h6><span class="star-rating"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star"></i></span>
                      </div>
                    </div><span class="text-muted fs-sm">Sep 14, 2020</span>
                  </div>
                  <p>Elementum nisl, egestas nam consectetur nisl, at pellentesque cras. Non sed ac vivamus dolor dignissim ut. Nisl sapien blandit pulvinar sagittis donec sociis ipsum arcu est. Tempus, rutrum morbi scelerisque tempor mi. Etiam urna, cras bibendum leo nec faucibus velit. Tempor lectus dignissim at auctor integer neque quam amet.</p>
                  <div class="d-flex align-items-center">
                    <button class="btn-like" type="button"><i class="fi-like"></i><span>(0)</span></button>
                    <div class="border-end me-1">&nbsp;</div>
                    <button class="btn-dislike" type="button"><i class="fi-dislike"></i><span>(0)</span></button>
                  </div>
                </div>
                <!-- Pagination-->
                <nav class="mt-2" aria-label="Reviews pagination">
                  <ul class="pagination">
                    <li class="page-item d-sm-none"><span class="page-link page-link-static">1 / 5</span></li>
                    <li class="page-item active d-none d-sm-block" aria-current="page"><span class="page-link">1<span class="visually-hidden">(current)</span></span></li>
                    <li class="page-item d-none d-sm-block"><a class="page-link" href="#">2</a></li>
                    <li class="page-item d-none d-sm-block"><a class="page-link" href="#">3</a></li>
                    <li class="page-item d-none d-sm-block">...</li>
                    <li class="page-item d-none d-sm-block"><a class="page-link" href="#">8</a></li>
                    <li class="page-item"><a class="page-link" href="#" aria-label="Next"><i class="fi-chevron-right"></i></a></li>
                  </ul>
                </nav>
          </div>


          <!-- tab5 -->
          <div class="tab-pane fade" id="notification" role="tabpanel">
            <h1 class="h2">Notifications Settings</h1>
            <p class="pt-1 mb-4">Lorem ipsum dollar sit amet. lorem ipsum is a dummy text</p>

            <div class="py-2" id="notification-settings">
             <div class="d-flex justify-content-between mb-4">
                  <div class="me-2">
                    <h6 class="mb-1">Chat Notification</h6>
                    <p class="fs-sm mb-0">New message for your <a href="#">Posts</a></p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="new-rental" checked="">
                    <label class="form-check-label" for="new-rental"></label>
                  </div>
                </div>
                <div class="d-flex justify-content-between mb-4">
                  <div class="me-2">
                    <h6 class="mb-1">Auction Notification</h6>
                    <p class="fs-sm mb-0">New bid for your <a href="#">Auctions</a></p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rental-update" checked="">
                    <label class="form-check-label" for="rental-update"></label>
                  </div>
                </div>
                <div class="d-flex justify-content-between mb-4">
                  <div class="me-2">
                    <h6 class="mb-1">Email Notification</h6>
                    <p class="fs-sm mb-0">You can on or off your email notifications here </p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rental-recomendation">
                    <label class="form-check-label" for="rental-recomendation"></label>
                  </div>
                </div>

            </div>
          </div>
    <!-- tab 5 -->

    <!-- tab 6 -->
    <div class="tab-pane fade" id="upgradeplan" role="tabpanel">
      <?= $this->session->getFlashdata('msg'); ?>
         <h1 class="h2 mb-4">Upgrade Plan</h1>
         <p class="pb-2 mb-4 ">Select your perfect plan to add more Advertisements</p>
        <div class="row">
         <?php
          $plan_data = $this->common_model->GetSingleData('plan_subscriptions','user_id = "'.$this->user_id.'" AND end_date >= "'.date('Y-m-d').'"  AND post > used_post','id','desc');
          print_r($plan_data);
          if(isset($plan_data) && !empty($plan_data)){

           $plan = $this->common_model->GetSingleData('plan_management','id = "'.$plan_data['plan_id'].'"');
        
          ?>
           <div class="col-sm-4">
              <p class="">
                  <b>Plan Name: </b><?= $plan['title']; ?><br>
                  <b>Post: </b><?= $plan_data['post']; ?><br>
                  <b>Start Date: </b><?= $plan_data['start_date']; ?><br>
                  <b>End Date: </b><?= $plan_data['end_date']; ?><br>
               </p>
            </div>
        <?php }?>
        </div>
        <div class="row">
       <?php 
        $proPlan = $this->common_model->GetAllData('plan_management','id != 1','id','desc');

        foreach($proPlan as $planV)
        {
          $check_plan = $this->common_model->GetSingleData('plan_subscriptions',array('plan_id'=>$planV['id'],'user_id'=>$this->user_id));
        ?>
         <div class="col-sm-6 col-md-4 mb-4">
          <form method="post" enctype="multipart/form-data" action="#">
            <div class="card shadow-sm">
              <div class="card-body"><img class="d-block mx-auto mt-2 mb-4" src="<?= base_url() ?>/assets/site/imgs/premium.png" width="72" alt="Icon">
                <h2 class="h5 fw-normal text-center py-1 mb-0"><?= $planV['title']; ?></h2>
                <div class="d-flex align-items-end justify-content-center mb-4">
                  <div class="h1 mb-0">$<?= $planV['price']; ?></div>
                  <div class="pb-2 ps-2">/month</div>
                  <input type="hidden" name="user_id" id="user_id" value="<?= $this->user_id ?>">
                  <input type="hidden" name="plan_id" id="plan_id" value="<?= $planV['id']; ?>">
                </div>
                <ul class="list-unstyled d-block mb-0 mx-auto" style="max-width: 16rem;">
                  <?php
                    if($planV['chat'] == 1){
                  ?>
                    <li class="d-flex"><i class="fi-check text-primary fs-sm mt-1 me-2"></i><span>Chats</span></li>
                 
                  <?php
                    }else{ ?>
                      <li class="d-flex text-muted"><i class="fi-x fs-xs mt-2 me-2"></i><span>Chats</span></li>
                   <?php 
                    }
                  ?>
                 <?php
                    if($planV['notification'] == 1){
                  ?>
                  <li class="d-flex"><i class="fi-check text-primary fs-sm mt-1 me-2"></i><span>Notifications</span></li>
                    <?php
                    }else{ ?>
                      <li class="d-flex text-muted"><i class="fi-x fs-xs mt-2 me-2"></i><span>Notifications</span></li>
                  <?php 
                    }
                  ?>
                  <li class="d-flex"><i class="fi-check text-primary fs-sm mt-1 me-2"></i><span><?= $planV['description']; ?></span></li>
                </ul>
              </div>
                 
              <div class="card-footer py-2 border-0">
                <div class="border-top text-center pt-4 pb-3">

                  <?php
                    if($plan_data  && $plan_data['plan_id'] != $planV['id']){ 
                ?>
                  <button style="display: none;"  type="hidden"  class="btn btn-danger paypal_btn_btn" data-amt="<?= $planV['price']; ?>" data-plan_id="<?= $planV['id']; ?>" data-duration="<?= $planV['duration']; ?>">Pay With PayPal</button>
                    <div class="pay_btn paypal_btn" id="paypal_btn<?= $planV['id']; ?>">Pay With PayPal</div>
                <?php
                  }else{
                    echo "plan Active";
                  }
                ?>
                  <!--  <button style="display: none;"  type="hidden"  class="btn btn-danger paypal_btn_btn" data-amt="<?= $planV['price']; ?>" data-plan_id="<?= $planV['id']; ?>" data-duration="<?= $planV['duration']; ?>">Pay With PayPal</button>
                   <div class="pay_btn paypal_btn" id="paypal_btn<?= $planV['id']; ?>">Pay With PayPal</div> -->
                </div>
              </div>
            </div>
          </form>
          </div>
         
           <?php
            }
          ?>
          </div>
           
            
          </div>


    <!-- tab 6 -->

 
      </div>
   </div>


        </div>
      </div>
<div class="modal" tabindex="-1" role="dialog" id="location_modal">
        <div class="modal-dialog" role="document" style="max-width:1920px;width:60vw;">
          <div class="modal-content" style="width:60vw; height:80vh;overflow:scroll">
            <div class="modal-header">
              <h5 class="modal-title">Your Current Location</h5>
              <button type="button" class="close" onclick="$('#location_modal').modal('hide');" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <!-- <div id="floating-panel">
                <h2>Insert the current location</h2>
                <input type="text" id="location_search" onchange="change_center(event)"/>
              </div> -->
              <div class="container">
                <div id="modal_map" style="    position: relative;
    overflow: hidden;
    height: 80vh;"></div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary btn-modal-book" id="confirmPosition"  data-dismiss="modal">Select</a>
              <button type="button" class="btn btn-secondary" onclick="$('#location_modal').modal('hide');">Close</button>
            </div>
          </div>
        </div>
      </div>
<?php
include_once 'includes/footer.php'; ?>


<script src="https://www.paypal.com/sdk/js?client-id=AQwoZAAHsmA5vBLj_mZffS3NWJjNJODewuV2WakPm-BQilgsawTtnbLvWHNC73idcfiaHBOjaeTDkAS8"></script>
<script>
$(".paypal_btn_btn").each(function(){
        var amt = $(this).attr('data-amt');
        var planId = $(this).attr('data-plan_id');
        var duration = $(this).attr('data-duration');

         PaymentGetway(amt, 1, planId , duration);
});

function PaymentGetway(amt, type, planId='',duration) {

  $('#paypal_btn'+planId).html('');
 
 paypal.Buttons({ 
  createOrder: function(data, actions) { 
 // This function sets up the details of the transaction, including the amount and line item details. 
 return actions.order.create({ purchase_units: [{ amount: { value: amt } }] }); 
  }, 
 onApprove: function(data, actions) { 
 // This function captures the funds from the transaction. 
 return actions.order.capture().then(function(details) { 
 // This function shows a transaction success message to your buyer. 
 console.log(details); 
//var id = details.id;
//var status = details.status;
//alert(id + + status);

  var trans_id = details.id;
    $.ajax({
    url: "<?php echo base_url(); ?>/User/upgradePlan",
    type:"POST",
   /* cache:false,
    contentType: false,
    processData: false,*/
    data:{amt:amt,planId:planId,trans_id:trans_id,duration:duration},
    dataType:'json',
    success:function(data) {
      if(data.status==1){
        location.reload();  
      } 
      else { 
        //loading(false);
        swal(data.status);
      }
    }
  });



// window.location.href=global_base_url+'checkout/payment_successed?payment=paypal'; 

 //alert('Transaction completed by ' + details.payer.name.given_name); 
  }); 
  } 
  }).render('#paypal_btn'+planId); 
  

  }
 
</script> 

<script>
  
  function do_update (e) 
  {
    e.preventDefault();
      $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/User/do_update',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#do_update')[0]),
      dataType: 'json',
      beforeSend: function() {        
        $('#edit_profile_btn').prop('disabled' , true);
        $('#edit_profile_btn').text('Processing..');
      },
      success : function(res){
        $('#edit_profile_btn').prop('disabled' , false);
        $('#edit_profile_btn').text('Submit');
        if (res.status == 1) 
        {
            Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
              location.reload()
            })
           
        }
        else
        {
          for (var err in res.message) {
            
            $("[name='" + err + "']").parent().siblings().after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
            $("[name='" + err + "']").parent().siblings().find(".nav-link").click();
            $("[name='" + err + "']").focus();
          }
        }
      }
    });
return false;
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABk-0Al27H9Ap_Rtti2t0ePxOLvl5QFzk&libraries=places&callback=initMap" async defer></script>
<script type="text/javascript">
var selected = false;
function initMap() 
{
    //var input = document.getElementById('address');
    var input = document.getElementById('address');

    var autocomplete = new google.maps.places.Autocomplete(input);
   
   // autocomplete.setComponentRestrictions({'country': ['in']});     
    autocomplete.addListener('place_changed', function() 
    {
        var place = autocomplete.getPlace();
        console.log(place);
        selected = true;
          
      // document.getElementById('lattitude').value = place.geometry.location.lat();
      // document.getElementById('longitude').value = place.geometry.location.lng();
      
      if (place) 
      {
          var city = "";
          var state = "";
          var country = "";
          var zipcode = "";
          
         var location = place.geometry.location;
         lat = location.lat();
         lng = location.lng();
          address_components = place.address_components
          for (var i = 0; i < address_components.length; i++) 
          {
             if (address_components[i].types[0] === "administrative_area_level_1" && address_components[i].types[1] === "political") {
                  state = address_components[i].long_name;    
              }
              if (address_components[i].types[0] === "locality" && address_components[i].types[1] === "political" ) {                                
                  city = address_components[i].long_name;   
              }
              
              if (address_components[i].types[0] === "postal_code" && zipcode == "") {
                  zipcode = address_components[i].long_name;

              }
              
              if (address_components[i].types[0] === "country") {
                  country = address_components[i].long_name;

              }
          }
        $('#city').val(city)
        $('#state').val(state)
        $('#country').val(country)
        $('#zip').val(zipcode)
        $('#lat').val(lat)
        $('#lng').val(lng)
     } 
     else 
     {
         window.alert('No results found');
     }
  });
   


}
// $('#address').on('focus', function() {
//   selected = false;
//   }).on('blur', function() {
//     if (!selected) {
//       $(this).val('');
//     }
//   });
  function do_change_password (e) 
  {
    e.preventDefault();
      $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/User/do_change_password',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#do_change_password')[0]),
      dataType: 'json',
      beforeSend: function() {        
        $('#c_pswd_btn').prop('disabled' , true);
        $('#c_pswd_btn').text('Processing..');
      },
      success : function(res){
        $('#c_pswd_btn').prop('disabled' , false);
        $('#c_pswd_btn').text('Submit');
        if (res.status == 1) 
        {
            Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
               
               window.location.href = res.redirect;
            })
           
        }
        else
        {
          for (var err in res.message) {
            
            $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
            
          }
        }
      }
    });
return false;
}

function do_delete_account (id) 
  {
     Swal.fire({
  title: 'Enter your login password',
  input: 'password',
  inputAttributes: {
    autocapitalize: 'off'
  },
  showCancelButton: true,
  confirmButtonText: 'Delete',
  showLoaderOnConfirm: true,
  preConfirm: (login) => {
     if (login.trim() == '') 
     {
          Swal.showValidationMessage(
          `Please insert password`
        )
          return false;
     }
     else
     {
        return $.ajax({
            url: '<?= base_url() ?>/User/do_delete_account',
            type: 'POST',
            data:{'id':id , 'password':login},
            dataType: 'json',
            beforeSend: function() {        
              
            },
            success : function(res){
              
              if (res.status == 1) 
              {
                  Swal.fire(
                    'Deleted!',
                    'Your account has been deleted.',
                    'success'
                  )
                  window.location.href = res.redirect;
                 
                 
              }
              else
              {
                
                Swal.showValidationMessage(
                  `Invalid Password`
                )
                
              }
              
            }
          });
     }
  },
  allowOutsideClick: () => !Swal.isLoading()
})
      
}  
</script>


<script>

$(document).ready(function(){
  lat = parseFloat("<?= $this->user['lat'] ?>");
  lng = parseFloat("<?= $this->user['lat'] ?>");
  modal_map = new google.maps.Map(document.getElementById('modal_map'), {
      center: {lat: lat, lng: lng},
      zoom: 12,
      mapTypeId:google.maps.MapTypeId.ROADMAP,
  });
  var modal_mark;
  modal_mark = new google.maps.Marker({
    position : {lat: lat, lng: lng},
    map : modal_map,
  });
  modal_map.addListener("click",(event) => {
    // if(modal_mark)
      // modal_mark.setMap(null);
    for(var i = 0;i <modal_initial_markers.length;i++)
    {
      modal_initial_markers[i].setMap(null);
    }
    modal_initial_markers = [];
    if(modal_mark)
    {
      modal_mark.setMap(null);
    }
    modal_mark = new google.maps.Marker({
      position : event.latLng,
      map : modal_map,
    });
    cur_location = event.latLng;
    console.log(cur_location);
    
  });
  
});
modal_initial_markers = [];
$('#btn_location_modal').click(function(e){
  e.preventDefault();
console.log('click');
let center_text = $('#address').val() + ',' + $('#city').val() + ',' + $('#state').val() + ',' + $('#country');
service = new google.maps.places.PlacesService(modal_map);
const request = {
query: center_text,
fields: ["name", "geometry"],
};
for(var i = 0;i <modal_initial_markers.length;i++)
{
modal_initial_markers[i].setMap(null);
}
service.findPlaceFromQuery(request, (results, status) => {
if (status === google.maps.places.PlacesServiceStatus.OK && results) {
    modal_mark = new google.maps.Marker({
    position : results[0].geometry.location,
    map : modal_map,
  });
  modal_initial_markers.push(modal_mark);
  modal_map.setCenter(results[0].geometry.location);
  cur_location = results[0].geometry.location;
  $('#lat').val(cur_location.lat());
  $('#lng').val(cur_location.lng());
  $('#location_preview').attr('src','//maps.google.com/maps?q='+cur_location.lat() + ','+ cur_location.lng() + '&z=15&output=embed');
  $('#p_address').val($('#address').val());
}
else
{
  alert('Please insert valid address');
}
});
$('#location_modal').modal('show');
})

$('#confirmPosition').click(function(){
  $('#lat').val(cur_location.lat());
  $('#lng').val(cur_location.lng());
  const geocoder = new google.maps.Geocoder();
  
  $('#location_preview').attr('src','//maps.google.com/maps?q='+cur_location.lat() + ','+ cur_location.lng() + '&z=15&output=embed');
  $('#p_address').html($('#address').val());
  $('#location_modal').modal('hide');
  const latlng = {
    lat: cur_location.lat(),
    lng: cur_location.lng(),
  };
  geocoder
    .geocode({ location: latlng })
    .then((response) => {
      if (response.results[0]) {
        let address = response.results[0];
        console.log(address);
        console.log(address.formatted_address);
        $('#address').val(address.formatted_address);
        $('#p_address').html(address.formatted_address);
      } else {
        window.alert("No results found");
      }
    })
    .catch((e) => window.alert("Geocoder failed due to: " + e));
})
  
  $(document).on("click",".upgrade_Plan",function() {
        //alert($(this).data("userid"));
        //alert($(this).data("planid"));

        var user_id = $(this).data("userid")
        var plan_id = $(this).data("planid");

    $.ajax({
      url: '<?= base_url() ?>/User/upgradePlan',
      type: 'POST',
      data: {user_id:user_id , plan_id:plan_id},
      dataType:'json',
      beforeSend: function() {        
        $('#upgrade_Plan').prop('disabled' , true);
        $('#upgrade_Plan').text('Processing..');
      },
      success : function(res){
       // console.log(res.status);
        $('#upgrade_Plan').prop('disabled' , false);
        $('#upgrade_Plan').text('Submit');
        if (res.status == 1) 
        {
            Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
               
               location.reload();
            })
           
        }
        else
        {
          for (var err in res.message) {
            
            $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
            
          }
        }
      }
    });
     

});

</script>


