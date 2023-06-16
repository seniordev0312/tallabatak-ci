<!DOCTYPE html>
<?php 

use App\Models\Common_model;
$this->common_model = new Common_model();
$this->session = \Config\Services::session();
$this->user_id = 0;
$this->user = [];
$countries_fetch = $this->common_model->GetAllData('countries' , '' , 'name' , 'asc' , '' , ["name", "id"]);
if ($this->session->has('user_id')) {
  $this->user_id = $this->session->get('user_id');

  $this->user = $this->common_model->GetSingleData('users' , array('id' =>$this->user_id));
  //print_r($this->auth);

}
$this->subscription = check_subscription($this->user_id);
//print_r($this->session->get('current_location')); die;
 ?>
<html lang="en" >

  <meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>

    <meta charset="UTF-8">

    <title>Tallabatak</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!--  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css" integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N" crossorigin="anonymous"> -->

    <!-- Css Styles-->
    <link rel="stylesheet" id="rtl_css" >

    <link rel="stylesheet" media="screen" href="<?= base_url() ?>/assets/site/css/simplebar.min.css"/>

    <link rel="stylesheet" media="screen" href="<?= base_url() ?>/assets/site/css/nouislider.min.css"/>

    <link rel="stylesheet" media="screen" href="<?= base_url() ?>/assets/site/css/tiny-slider.css"/>
    
    <link rel="stylesheet" media="screen" href="<?= base_url() ?>/assets/site/css/custom.css"/>

    <!-- Main Theme Styles + Bootstrap-->

    <link rel="stylesheet" media="screen" href="<?= base_url() ?>/assets/site/css/theme.min.css">

    <link rel="stylesheet" media="screen" href="<?= base_url() ?>/assets/site/css/filepond.min.css">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.1/css/font-awesome.min.css"  />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
     <script type="text/javascript" id="get_location">
      var device_id = '';
  function getCurrentloc()
  {
    if ("geolocation" in navigator)
    {
        navigator.geolocation.getCurrentPosition(function(position)
        { 
          console.log("Found your location \nLat : "+position.coords.latitude+" \nLang :"+ position.coords.longitude);
          $('#current_location').attr('src','//maps.google.com/maps?q='+ position.coords.latitude + ','+ position.coords.longitude + '&z=15&output=embed');
          UpdateLocation(position.coords.latitude , position.coords.longitude)
        });
    }
    else
    {
      console.log("Browser doesn't support geolocation!");
    }

}
$(function () {
  getCurrentloc()
});

function UpdateLocation(lat , lng) {
   var city = "";
                    var state = "";
                    var country = "";
                    var zipcode = "";
                    var address = "";
                    var route = "";
                    var street_number = "";
  var arabic_countries = "<?php echo Arabic_countries;?>";
  var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&key=<?= google_place_api ?>&sensor=false&language=en";
        $.get(url, function(data) {
        var results = data.results;
            if (data.status === 'OK') 
            {
                //console.log(JSON.stringify(results));
                if (results[0]) 
                {
                   
                    console.log(results[0].address_components);
                   var address_components = results[0].address_components;
                    
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
                        if (address_components[i].types[0] === "route" && route == "") {
                            route = address_components[i].long_name;

                        }
                        if (address_components[i].types[0] === "street_number" && street_number == "") {
                            street_number = address_components[i].long_name;

                        }
                    }
                    // added by matthias
                    $('#signup_country').val(country);
                    $('#signup_state').val(state);
                    $('#signup_city').val(city);
                    $('#signup_zipcode').val(zipcode); 
                    $('#signup_address').val((street_number == "" ? "" : street_number + " , ") + route);
                    var cur_lang = $('.goog-te-combo').val();
                   if(arabic_countries.indexOf(country) != -1 )
                   {
                    $('html').attr('lang','ar');
                    // console.log('ar');
                    // console.log('ar1');
                    // $('.goog-te-combo').val('ar');
                    // $('.goog-te-combo').change();
                   } 
                   else
                   {
                    $('html').attr('lang','en');
                   }
                  var address = {
                        "city": city,
                        "state": state,
                        "country": country,
                        "zipcode": zipcode,
                  };
                  console.log(address)
                  $.ajax({
       url: '<?= base_url('home/update_location') ?>',
       type: 'post',
       data: {'lat' : lat , 'lng' : lng , 'city' : city , 'country' : country},
       dataType: 'json',
       success: function (data) {
        console.log(data)
         

          $('.btn-wrap').append(data.html)
        
       }
     });
               } 
               else 
               {
                   window.alert('No results found');
               }
            } 
            else 
            {
                window.alert('Geocoder failed due to: ' + status);
            
            }
        });
   
}

</script>  
<?php if ($this->user): ?>
  <?php if (!$this->session->get('current_location')  ): ?>
   <?php $curr_lat = '0'; ?>
    <?php $curr_lng = '0'; ?>
    <script>

      function callback(data)
      {
        console.log(data)
          UpdateLocation(data.latitude , data.longitude)
           
          
      }

      var script = document.createElement('script');
      script.type = 'text/javascript';
      script.src = 'https://geolocation-db.com/json/geoip.php?jsonp=callback';
      var h = document.getElementsByTagName('script')[0];
      h.parentNode.insertBefore(script, h);
      
  </script> 
  <?php else: ?>
    <?php $curr_lat = $this->session->get('current_location')['lat']; ?>
    <?php $curr_lng = $this->session->get('current_location')['lng']; ?>
  <?php endif ?>
<?php endif ?>

     <style type="text/css">
      /*.confirm_pass_wrap .password-toggle-btn {
        transform: translateY(-85%);
      }*/
      .pac-container{
        z-index: 999999;
      }
      .confirm_pass_wrap {
        position: relative;
      }

      .confirm_pass_wrap > .password-toggle-btn {
        top: 5px;
        right: 10px;
      }
      .main
      {
        margin-top: 6rem;
      }
      
     .goog-te-banner-frame
     {
      display: none!important;
     }
     .goog-logo-link {
display:none ! important;
}
.goog-te-gadget{
color: transparent ! important;
}
.translated-rtl .img_profile .dropdown-menu.dropdown-menu-end {
    left: 0;
    right: auto;
}
.loggedin .navbar-nav .nav-link {
    padding-right: 5px!Important;
    padding-left: 5px!Important;
    font-size: 20px!Important;
}
.navbar-expand-lg .navbar-nav .nav-link {
    padding-right: 7px;
    padding-left: 7px;
    font-size: 20px;
}
.select2-container{
  z-index: 9999;
}

.password-toggle .label.alert-danger + label.password-toggle-btn {
      right: 30px;
}

.user_page{
      width: 20.75em;
      z-index: 9999;

}
.w-20 {
    width: 20%;
}
     </style>


  </head>

 

  <body>

  

    <main class="page-wrapper">

      <!-- Sign In Modal-->
      <?php if (!$this->user): ?>
        
      
      <div class="modal fade" id="signin-modal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 950px;">

          <div class="modal-content">

            <div class="modal-body px-0 py-2 py-sm-0">

              <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal"></button>

              <div class="row mx-0 align-items-center">

                <div class="col-md-6 border-end-md p-4 p-sm-5">
                  <!-- -->
                  <h2 class="h3 mb-4 mb-sm-5">Hey there!<br>Welcome back.</h2><img class="d-block mx-auto" src="<?= base_url() ?>/assets/site/img/signin-modal/signin.svg" width="344" alt="Illustartion">

                  <div class="mt-4 mt-sm-5">Don't have an account? <a href="#signup-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Sign up here</a></div>

                </div>

                <div class="col-md-6 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5"><a class="btn btn-outline-info w-100 mb-3" href="<?= initGoogleLogin()['btn_url'] ?>" ><i class="fi-google fs-lg me-1"></i>Sign in with Google</a><a class="btn btn-outline-info w-100 mb-3"  href="<?= initFbLogin()['btn_url'] ?>"><i class="fi-facebook fs-lg me-1"></i>Sign in with Facebook</a>

                  <div class="d-flex align-items-center py-3 mb-3">

                    <hr class="w-100">

                    <div class="px-3">Or</div>

                    <hr class="w-100">

                  </div>

                  <form onsubmit="return do_login(event)" id="do_login" class="needs-validation" novalidate>
                    <div id="login_error"></div>
                    <div class="mb-4">

                      <label class="form-label fw-bold mb-2" for="signin-email">Email address</label>

                      <input class="form-control" type="email" name="email1" id="signin-email" placeholder="Enter your email" required>

                    </div>

                    <div class="mb-4">

                      <div class="d-flex align-items-center justify-content-between mb-2">

                        <label class="form-label fw-bold mb-0" for="signin-password">Password</label><a class="fs-sm" href="#forgot-modal" data-bs-toggle="modal">Forgot password?</a>

                      </div>

                      <div class="password-toggle">

                        <input class="form-control" name="password1" type="password" id="signin-password" placeholder="Enter password" required>

                        <label class="password-toggle-btn" aria-label="Show/hide password">

                          <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>

                        </label>

                      </div>

                    </div>

                    <button type="submit" id="sub_btn" class="btn btn-primary btn-lg w-100"  >Sign in</button>

                  </form>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>
       <!-- Forgot password Modal-->

      <div class="modal fade" id="forgot-modal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 950px;">

          <div class="modal-content">

            <div class="modal-body px-0 py-2 py-sm-0">

              <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal"></button>

              <div class="row mx-0 align-items-center">

                <div class="col-md-6 border-end-md p-4 p-sm-5">

                  <h2 class="h3 mb-4 mb-sm-5">Hey there!<br>Reset Your Password.</h2><img class="d-block mx-auto" src="<?= base_url() ?>/assets/site/img/signin-modal/signin.svg" width="344" alt="Illustartion">


                </div>

                <div class="col-md-6 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">


                  <form onsubmit="return do_forgot(event)" id="do_forgot" class="needs-validation" novalidate>
                    <div id="login_error"></div>
                    <div class="mb-4">

                      <label class="form-label fw-bold mb-2" for="signin-email">Email address</label>

                      <input class="form-control" <?= ($this->user) ? 'value="'.$this->user['email'].'" readonly' : '' ?> type="email" name="email2" id="signin-email" placeholder="Enter your email" required>

                    </div>

                    <button type="submit" id="do_forgot_btn" class="btn btn-primary btn-lg w-100"  >Reset</button>

                  </form>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>
      <!-- Sign Up Modal-->

      <div class="modal fade" id="signup-modal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered p-2 my-0 mx-auto" style="max-width: 950px;">

          <div class="modal-content">

            <div class="modal-body px-0 py-2 py-sm-0">

              <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal"></button>
               <form class="needs-validation" novalidate method="post" id="do_signup" onsubmit="return do_signup(event)">
              <div class="row mx-0 align-items-center">





                <div class="col-md-5 border-end-md p-4 p-sm-5">

                  <h2 class="h3 mb-4 mb-sm-5">Join tallabatak.<br>Get premium benefits:</h2>



                  <div class="row">

                  	<!-- <div class="col-md-6">

                      <label class="form-label fw-bold" for="signup-name">Language</label>

                      <div class="mb-4">

                      	<select class="form-select mb-2" name="lang">

                      		<option value="" disabled="">Choose Language</option>

                      		<option value="eng">English</option>

                      		<option value="arab">Arebic</option>

                      	</select>

                      </div>

                  	</div> -->

                  <!-- 	<div class="col-md-6">

                      <label class="form-label fw-bold" for="signup-name">Alert</label>

                      <div class="mb-4">

                      	<select class="form-select mb-2">

                      		<option value="" disabled="">Choose Alert</option>

                      		<option value="Chicago">Alert one</option>

                      		<option value="Dallas">Alert two</option>

                      	</select>

                  	</div>

                  	</div> -->

                  </div>





                  <ul class="list-unstyled mb-4 mb-sm-5">

                    <li class="d-flex mb-2"><i class="fi-check-circle text-primary mt-1 me-2"></i><span>Add and promote your listings</span></li>

                    <li class="d-flex mb-2"><i class="fi-check-circle text-primary mt-1 me-2"></i><span>Easily manage your wishlist</span></li>

                    <li class="d-flex mb-0"><i class="fi-check-circle text-primary mt-1 me-2"></i><span>Leave reviews</span></li>

                  </ul>
                  <div class="pt-2">
                    <div class="position-relative mb-2 map_div shadow-sm">
                      <!-- <img class="rounded-3" src="img/real-estate/single/map.jpg" alt="Map"> -->
                      <iframe src="//maps.google.com/maps?q=47.22,9.40&z=15&output=embed" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" id="current_location"></iframe>
                      
                    </div>
                  </div>

                  <div class="mt-sm-4 pt-md-3">Already have an account? <a href="#signin-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Sign in</a></div>

                </div>





                <div class="col-md-7 px-4 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">



                 

                    <div class="mb-4">

                      <label class="form-label fw-bold" for="signup-name">Full name</label>

                      <input class="form-control" name="full_name" type="text" id="signup-name" placeholder="Enter your full name" required>

                    </div>

                    <div class="mb-4">

                      <label class="form-label fw-bold" for="signup-email">Email address</label>

                      <input class="form-control" name="email" type="email" id="signup-email" placeholder="Enter your email" required>

                    </div>

                    <div class="mb-4">

                      <label class="form-label fw-bold" for="signup-phone">Phone</label>

                      
                      <div class="input-group mb-3">
                        
                          <select class="form-control mt-0 w-20 select_countries" name="phonecode" required>
                           
                               <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                              <optgroup label="Other countries">
                                <?php $countries_code = $this->common_model->GetAllData('countries') ?>
                                <?php foreach ($countries_code as $key => $value): ?>
                                  <option data-countryCode="<?= $value['iso2'] ?>" value="<?= $value['phonecode'] ?>"><?= $value['name'] ?> (+<?= $value['phonecode'] ?>)</option>
                                <?php endforeach ?>
                                
                                
                              </optgroup>
                          </select>
                        
                        <input class="form-control" name="phone" type="number" id="signup-phone" placeholder="Enter your phone" required>
                      </div>
                    </div>



                    <div class="mb-4">

                      <label class="form-label fw-bold" for="signup-email">Upload Profile <span class="fs-sm text-primary">(Profile Pic)</span></label>

                     <input class="form-control" name="image" type="file" accept="image/*" required>

                    </div>   
                    <div class="mb-4 ">
                        
                      <label class="form-label fw-bold" for="signup-email">Interested In</label>
                      <?php
                      $category = $this->common_model->GetAllData('category',array('parent_id'=>0),'id','desc');
                      ?>
                        <select class="form-control signup_page" name="category[]"  required>
                           <option value="1" selected>All</option>
                           <?php 
                           foreach ($category as $key => $catV) {
                             ?>
                             <option value="<?= $catV['id']; ?>"><?= $catV['title_eng']; ?></option>
                             <?php
                           }
                           ?>
                           <option value="0">Others</option>
                           </select>
                           <input style="display: none;" type="text" name="other_interest"  class="form-control mt-3" placeholder="type your own interest">
                           <div name="category"></div>
                    </div>                   
                
                  <div class="mb-4">
                  <label class="form-label fw-bold" for="address">Address</label>
                 
                  <input class="form-control" type="text" placeholder="Enter Your Business Address"  name="address" id="signup_address" readonly>
                  <input type="hidden" name="lat" id="signup_lat" value="">
                  <input type="hidden" name="lng" id="signup_lng" value="">
                  
                </div>
                <div class="mb-4">
                  <label class="form-label fw-bold" for="city">City</label>
                  <input class="form-control" type="text" placeholder="Enter Your City"  name="city" id="signup_city" value="" readonly>
                </div>
                <div class="mb-4">
                  <label class="form-label fw-bold" for="state">State</label>
                  <input class="form-control" type="text" placeholder="Enter Your State"  name="state" id="signup_state" value="" readonly>
                </div>
                <div class="mb-4">
                  <label class="form-label fw-bold" for="country">Country</label>
                  <input class="form-control" type="text" placeholder="Enter Your Country"  name="country" id="signup_country" value="" readonly>
                </div>
                <div class="mb-4">
                  <label class="form-label fw-bold" for="zipcode">Zipcode</label>
                 
                  <input class="form-control" type="text" placeholder="Enter Your Zipcode"  name="zipcode" id="signup_zipcode" value="" readonly>
                  
                </div>


                    <div class="mb-4">

                      <label class="form-label fw-bold" for="signup-password">Password <span class='fs-sm text-muted'>min. 8 char</span></label>

                      <div class="password-toggle">

                        <input class="form-control" name="password" type="password" id="signup-password" minlength="8" required>

                        <label class="password-toggle-btn" aria-label="Show/hide password">

                          <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>

                        </label>

                      </div>

                    </div>

                    <div class="mb-4">
                      <label class="form-label fw-bold" for="signup-password-confirm">Confirm password</label>
                      <div class="password-toggle confirm_pass_wrap">
                        <input class="form-control" name="cnfm_password" type="password" id="signup-password-confirm" minlength="8" required>
                        <label class="password-toggle-btn" aria-label="Show/hide password">
                          <input class="password-toggle-check" type="checkbox">
                          <span class="password-toggle-indicator"></span>
                        </label>
                      </div>
                    </div>

                    <div class="form-check mb-4">

                      <input class="form-check-input" name="terms" type="checkbox" id="agree-to-terms" required>

                      <label class="form-check-label" for="agree-to-terms">By joining, I agree to the <a href='#'>Terms of use</a> and <a href='#'>Privacy policy</a></label>

                    </div>
                    <div class="form-check mb-4">

                      <input class="form-check-input" name="recieve_notifications" type="checkbox" checked id="allow_notifications" value="1" required>

                      <label class="form-check-label" for="allow_notifications">Recieve notifications</label>

                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100" id="signup_btn">Sign up</button>

               



                   <div class="d-flex align-items-center py-3 mb-3">

                    <hr class="w-100">

                    <div class="px-3">Or</div>

                    <hr class="w-100">

                  </div>



                    <div class="d-flex align-items-center justify-content-center">

                  <a  class="btn btn-outline-info w-100 mb-3" href="<?= initGoogleLogin()['btn_url'] ?>" style="font-size: 12px;"><i class="fi-google fs-lg me-1"></i>Sign in with Google</a>

                  <div class="p-1"></div>

                  <a class="btn btn-outline-info w-100 mb-3" style="font-size: 12px;" href="<?= initFbLogin()['btn_url'] ?>"><i class="fi-facebook fs-lg me-1"></i>Sign in with Facebook</a>

                </div>

                 



                </div>

              </div>
            </form>
            </div>

          </div>

        </div>

      </div>
<?php endif ?>
      <!-- Navbar-->

<header class="navbar navbar-expand-lg navbar-light bg-light fixed-top <?= ($this->user) ? 'loggedin' : ''  ?>" data-scroll-header>
  <div class="container-fluid">
    <div class="flex-grow-1 d-flex justify-content-start align-items-center">
      <a class="navbar-brand me-3 me-xl-4" href="<?= base_url() ?>"><img class="d-block" src="<?= base_url() ?>/assets/site/imgs/logo.png" width="116"></a>
      <!-- <a class="btn btn-primary btn-sm ms-2 order-lg-3" href="become_seller.php"><i class="fi-plus me-2"></i>Become a seller</a> -->

      <div class="collapse navbar-collapse order-lg-2" id="navbarNav">
        <ul class="navbar-nav navbar-nav-scroll w-100 d-flex justify-content-between" style="max-height: 35rem;">
          <li class="nav-items">
            <ul class="navbar-nav">
              <li class="nav-item dropdown me-lg-2"><div id="google_translate_element"></div></li>
              <li class="nav-item dropdown"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Group</a>

                <ul class="dropdown-menu">
                  <?php 
                  if($this->session->has('user_id')) { 
                     
                    if ($this->subscription["active"] && $this->subscription['plan']['groups'] == 1) {
                       ?>
                      <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalScroll" id="add_btns">Create Group</a></li>
                      <li><a class="dropdown-item" href="<?= base_url() ?>/groups">List Of Group</a></li>
                       <?php
                    } else {
                      ?>
                    <li><a class="dropdown-item" href="<?= base_url('upgrade-plan?plan=1'); ?>">Create Group</a></li>
                    <li><a class="dropdown-item" href="<?= base_url() ?>/groups">List Of Group</a></li>
                      <?php
                    }
                    ?>
                  <?php } else { ?>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signin-modal" id="add_btns">Create Group</a></li>
                    <li><a class="dropdown-item" href="<?= base_url() ?>/groups">List Of Group</a></li>
                 <?php 
                  } 
                  ?>
<!--                   <li><a class="dropdown-item" href="<?= base_url() ?>/groups">List Of Group</a></li>
 -->                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Coupon</a>

                <ul class="dropdown-menu">


                  <?php 
                  if($this->user_id) { 
                    ?>
                      <li><a class="dropdown-item" href="<?= base_url('add-coupon'); ?>" >Create Coupon</a></li>
                      <li><a class="dropdown-item" target="_blank" href="<?= base_url('coupons') ?>">List Of Coupon</a></li>
                      
                  <?php } else { ?>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signin-modal" id="add_btns">Create Coupon</a></li>
                    <li><a class="dropdown-item" target="_blank" href="<?= base_url('coupons') ?>">List Of Coupon</a></li>
                 <?php 
                  } 
                  ?>

                </ul>
               
              </li>

               <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Swap</a>
                <ul class="dropdown-menu">
                  <?php 
                  if($this->user_id) { 
                    ?>
                      <li><a class="dropdown-item" href="<?= base_url('add-swap'); ?>" >Create Swap</a></li>
                      <li><a class="dropdown-item" target="_blank" href="<?= base_url('swaps') ?>">List Of Swap</a></li>
                      
                  <?php } else { ?>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signin-modal" id="add_btns">Create Swap</a></li>
                    <li><a class="dropdown-item" target="_blank" href="<?= base_url('swaps') ?>">List Of Swap</a></li>
                 <?php 
                  } 
                  ?>
                </ul>
                
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Auction</a>
                <ul class="dropdown-menu">
                  <?php 
                  if($this->user_id) { 
                    ?>
                      <li><a class="dropdown-item" href="<?= base_url('add_post?is_auction=1'); ?>" >Create Auction</a></li>
                    
                      
                  <?php } else { ?>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signin-modal" id="add_btns">Create Auction</a></li>
                    
                 <?php 
                  } 
                  ?>
                  <li><a class="dropdown-item"  href="<?= base_url('shop?is_auction=1') ?>">List Of Auction</a></li>
                </ul>
                
              </li>
              
            </ul>


          </li>
          <?php if (!$this->user){ ?>
          <li class="nav-items">
            <ul class="navbar-nav">
              <li class="nav-item"><a class="nav-link" href="#signin-modal" data-bs-toggle="modal"><i class="fi-user me-2"></i>Sign in</a></li>
              <li class="nav-item"><a class="nav-link" href="#signup-modal" data-bs-toggle="modal"><i class="fi-user me-2"></i>Sign Up</a></li>
            </ul>  
          </li>

        <?php } ?>
          
        </ul>
      </div>
    </div>
    
    <button class="navbar-toggler ms-auto <?php if ($this->user){ ?>d-none<?php }?>" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

    <div class="btn-wrap d-flex justify-content-center">
      <?php if ($this->user): ?>
        <?php if ($this->user['email_verified'] == 1): ?>
          <?php if ($this->user['user_type'] == 1) { ?>
            <a class="btn btn-primary btn-xs me-2 order-lg-3" href="<?= base_url('become-seller') ?>" ><i class="fi-plus me-2"></i>Become a seller</a>
          <?php } else { ?>
            <a class="btn btn-primary me-2 order-lg-3 " href="<?= base_url('add_post') ?>" ><i class="fi-plus me-2"></i>Post Ad</a>
            
          <?php } ?>
          <a class="btn btn-primary btn-xs me-2 order-lg-3" style="display: flex; align-items: center; justify-content: center;" href="<?= base_url('wishlist/post') ?>" ><i class="fa fa-heart-o post_heart_3 "></i></a>
      <div class="dropdown d-none d-lg-block order-lg-3 my-n2 me-3 img_profile" style="display: flex !important; align-items: center; padding: 0 !important;">
        <a class="nav-link ai-icon px-0" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-expanded="true" id="notifi"><i class="fa fa-bell"></i><span class="badge light text-white bg-primary ps-1"><?= getUnreadNotifications($this->user_id)!==null?count(getUnreadNotifications($this->user_id)):0 ?></span></a>
        <div class="dropdown-menu dropdown-menu-end notify" data-bs-popper="none">
          <div id="DZ_W_Notification1" class="widget-media dz-scroll ps" style="height:380px;">
            <?php if (getAllNotifications($this->user_id)): ?>
            <ul class="timeline">
              <?php foreach (getAllNotifications($this->user_id) as $key => $value): ?>
              <li class="p-3 border-bottom">
                <div class="timeline-panel">
                  <a href="javascript:;" data-other='<?= json_encode( unserialize( $value['other'])) ?>' data-id="<?= $this->user_id ?>" >
                    <div class="media-body">
                      <?php if ($value['is_read']): ?>
                      <p class="mb-1 text-muted"><?= $value['message']; ?></p> 
                      <?php else: ?>
                      <p class="mb-1 text-muted"><?= $value['message']; ?></p>
                      <?php endif ?>
                      <small class="d-block"><?= date('d M Y - h:i A'); ?></small>
                    </div>
                  </a>
                </div>
              </li>
              <?php endforeach ?>
            </ul>
          </div>
        
          <?php else: ?>
          <div class="alert alert-info"> No Notification found</div>
          <?php endif ?>
        </div>
      </div>
    </div>

    <div class="dropdown my-n2 d-md-none d-block img_profile">
      <a class="d-block py-2" id="dropdownMenuButton01" data-bs-toggle="dropdown" aria-expanded="false" href="#"><img class="rounded-circle" src="<?= base_url($this->user['image']) ?>" width="40" alt="<?= $this->user['name'] ?>"></a>
      <div class="dropdown-menu dropdown-menu-end" aria-labelledby='dropdownMenuButton01'>
        <div class="d-flex align-items-start border-bottom px-3 py-1 mb-2" style="width: 16rem;"><img class="rounded-circle" src="<?= base_url($this->user['image']) ?>" width="48" alt="<?= $this->user['name'] ?>">
          <div class="ps-2">
            <h6 class="fs-base mb-0"><?= $this->user['name'] ?></h6>
           <!--  <?php if ($this->user['user_type'] == 2 && $this->user['is_verified'] == 1  ): ?>
            <span class="star-rating star-rating-sm"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i></span>
            <?php endif; ?> -->
            <div class="fs-xs py-2">+<?= $this->user['phonecode'] ?><?= $this->user['phone'] ?><br><?= $this->user['email'] ?></div>

          </div>
        </div>
        <a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="fi-user opacity-60 me-2"></i>Personal Info</a>
        <a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="fi-lock opacity-60 me-2"></i>Password &amp; Security</a>
        <a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="fi-home opacity-60 me-2"></i>My Posts</a>
        <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Help</a><a class="dropdown-item" href="<?= base_url('Home/logout') ?>">Sign Out</a>
      </div>
    </div>

    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

    <?php if ($this->user): ?>
      
    <div class="dropdown d-none d-lg-block order-lg-3 my-n2 me-3 img_profile">
      <a class="d-block py-2" href="#" ><img class="rounded-circle" src="<?= base_url($this->user['image']) ?>" width="40" alt="<?= $this->user['name'] ?>"></a>
      <div class="dropdown-menu dropdown-menu-end">
        <div class="d-flex align-items-start border-bottom px-3 py-1 mb-2" style="width: 16rem;"><img class="rounded-circle" src="<?= base_url($this->user['image']) ?>" width="48" alt="<?= $this->user['name'] ?>">
          <div class="ps-2">
            <h6 class="fs-base mb-0"><?= $this->user['name'] ?></h6>
            <!-- <?php if ($this->user['user_type'] == 2 && $this->user['is_verified'] == 1  ): ?>
            <span class="star-rating star-rating-sm"><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i><i class="star-rating-icon fi-star-filled active"></i></span>
            <?php endif; ?> -->
            <div class="fs-xs py-2">+<?= $this->user['phonecode'] ?><?= $this->user['phone'] ?><br><?= $this->user['email'] ?></div>

          </div>
        </div>
        <a class="dropdown-item" href="<?= base_url()?>/profile"><i class="fi-user opacity-60 me-2"></i>Personal Info</a>
        <a class="dropdown-item" href="<?= base_url()?>/update-password"><i class="fi-lock opacity-60 me-2"></i>Password &amp; Security</a>
        <a class="dropdown-item" href="<?= base_url()?>/mypost"><i class="fi-home opacity-60 me-2"></i>My Posts</a>
        <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Help</a><a class="dropdown-item" href="<?= base_url('Home/logout') ?>">Sign Out</a>
      </div>
    </div>
    
    
    <?php else: ?>
    <a class="btn btn-sm text-primary d-none d-lg-block order-lg-3" href="#signin-modal" data-bs-toggle="modal"><i class="fi-user me-2"></i>Login</a>

    <a class="btn btn-primary btn-sm d-none d-lg-block order-lg-3" href="#signup-modal" data-bs-toggle="modal"><i class="fi-user me-2"></i>Sign Up</a>
    <?php endif ?>
  </div>    
        
    <?php endif ?>
    <?php if ($this->user['email_verified'] == 0): ?>
      <a class="btn btn-primary btn-xs me-2 order-lg-3" href="<?= base_url('profile') ?>" >Verify Email</a>
      <a class="btn btn-primary btn-xs me-2 order-lg-3" href="<?= base_url('Home/logout') ?>" >Logout</a>
    <?php endif; ?>
  <?php endif ?>
</header>



  <script>
  $(document).ready(function() {
      // $('.signup_page').select2(
      //   {
      //     width:'100%',
      //     tags: true

      //   }
      //   );
      $('.signup_page').on('change' , function(event) {
        event.preventDefault();
        
        if($(this).val() == 0)
        {
          $(this).siblings('[name="other_interest"]').show()
          $(this).siblings('[name="other_interest"]').attr('required', true);
        }
        else
        {
          $(this).siblings('[name="other_interest"]').hide()
          $(this).siblings('[name="other_interest"]').attr('required', false);
        }
      });
  });
  </script>
