  <?php include 'includes/header.php'; ?>
  <?php if ($this->user['user_type'] == 2) 
  { 
    header("Location: ".base_url());
die();
  }?>
  <main class="page-wrapper">
      <!-- Page content-->
      <div class="container-fluid d-flex h-100 align-items-center justify-content-center py-4 py-sm-5 mt-5">
        <div class="card card-body" style="max-width: 940px"><a class="position-absolute top-0 end-0 nav-link fs-sm py-1 px-2 mt-3 me-3" href="#" onclick="window.history.go(-1); return false;"><i class="fi-arrow-long-left fs-base me-2"></i>Go back</a>
          <div class="row mx-0 align-items-start">
            <div class="col-md-6 border-end-md p-2 p-sm-5">
              <div class="sticky-top top100">
             <img class="d-block mb-5" src="<?= base_url() ?>/assets/site/imgs/logo.png" width="200" alt="Illustartion">
              <h2 class="h3 mb-4 mb-sm-5">Become a seller<br>Get premium benefits:</h2>
              <ul class="list-unstyled mb-4 mb-sm-5">
                <li class="d-flex mb-2"><i class="fi-check-circle text-primary mt-1 me-2"></i><span>Add your own Ads</span></li>
                <li class="d-flex mb-2"><i class="fi-check-circle text-primary mt-1 me-2"></i><span>Easily manage your Post</span></li>
                <li class="d-flex mb-0"><i class="fi-check-circle text-primary mt-1 me-2"></i><span>Get Reviews</span></li>
              </ul>
              </div>
              <!-- <img class="d-block mx-auto" src="img/signin-modal/signup.svg" width="344" alt="Illustartion"> -->
            </div>
            <div class="col-md-6 px-2 pt-2 pb-4 px-sm-5 pb-sm-5 pt-md-5">
              <?php if ($this->user['is_verified'] == 2): ?>
                <div class="alert alert-info"> Currently, your request to become a seller is under review, and it will take more than 24 hours for us to verify your documents. Please wait until we finish reviewing them </div>
             
              <?php else: ?>
                <?php
                $style = 'style="display:block"';
                 if($this->user['is_verified'] == 3): 
                   $style = 'style="display:none"';
                  ?>
                  <div class="alert alert-primary" id="rejected_msg"> Unfortunately, we were unable to verify your document due to a <?= $this->user['reject_reason'] ?> . You can  resubmit your seller document from below button. 
                    <div class="text-center mt-4">
                    <button onclick="show_seller_from()" class="btn btn-primary">Resubmit Documents</button>
                  </div>
                  </div>
                <?php endif ?>

              <form <?= $style ?> onsubmit="return do_become_seller(event)" id="do_become_seller"  class="needs-validation" novalidate>
                <div class="mb-4">
                  <label class="form-label" for="company_name">Company Name</label>
                  <input class="form-control" type="text" id="company_name" name="company_name" placeholder="Company Name" required>
                </div>
                <div class="mb-4">
                  <label class="form-label" for="email">Email</label>
                  <input class="form-control" type="email" name="email" id="email" readonly value="<?= $this->user['email'] ?>" placeholder="Enter email" required>
                </div>
                <div class="mb-4">

                      <label class="form-label fw-bold" for="document_id">Upload Document <span class="fs-sm text-primary">(Verification Document)</span></label>

                     <input class="form-control" name="document_id" id="document_id" type="file" required accept="image/*">

                    </div> 
                <div class="mb-4">
                  <label class="form-label" for="address">Business Address</label>
                 
                  <input class="form-control" type="text" placeholder="Enter Your Business Address" required name="address" id="address" value="<?= $this->user['address'] ?>">
                  <input type="hidden" name="lat" id="lat" value="<?= $this->user['lat'] ?>">
                  <input type="hidden" name="lng" id="lng" value="<?= $this->user['lng'] ?>">
                  
                </div>
                
                
                 <div class="mb-4">
                  <label class="form-label" for="country">Country</label>
                 
                  <select  id="country-dd" name="country" class="form-control  ">
                      <option value="">Select Country</option>
                      <?php
                      $state_fetch = [];
                       foreach ($countries_fetch as $key => $data): ?>
                        <?php 
                        
                        if ($this->user['country'] == $data['name']) {
                          $state_fetch =  $this->common_model->GetAllData('states' , ["country_id" => $data['id'] ] , 'name' , 'asc' , '' , ["name", "id"]);
                        } ?>
                        <option <?= ($this->user['country'] == $data['name']) ? 'selected' : '' ?> value="<?= $data['name']; ?>" data-id="<?= $data['id']; ?>">
                          <?= $data['name']; ?>
                      </option>
                      <?php endforeach ?>
                      
                  </select>
                  
                  
                </div>
                <div class="mb-4">
                  <label class="form-label" for="state">State</label>
                 
                  <select  id="state-dd" name="state" class="form-control  ">
                      <option value="">Select State</option>
                      <?php
                      $city_fetch = [];
                      
                      $state = $this->user['state'];
                      $state = str_replace(" Province","",$state);
                      
                       foreach ($state_fetch as $key => $data): ?>
                        <?php if ($state == $data['name']) {
                          $city_fetch =  $this->common_model->GetAllData('cities' , ["state_id" => $data['id'] ] , 'name' , 'asc' , '' , ["name", "id"]);
                        } ?>
                        <option <?= ($state == $data['name']) ? 'selected' : '' ?> value="<?= $data['name']; ?>" data-id="<?= $data['id']; ?>">
                          <?= $data['name']; ?>
                      </option>
                      <?php endforeach ?>
                      
                  </select>
                  
                  
                </div>
                <div class="mb-4">
                  <label class="form-label" for="city">City</label>
                 
                  <select  id="city-dd" name="city" class="form-control  ">
                      <option value="">Select Country</option>
                  <?php foreach ($city_fetch as $key => $data): ?>
                       
                        <option <?= ($this->user['city'] == $data['name']) ? 'selected' : '' ?> value="<?= $data['name']; ?>" data-id="<?= $data['id']; ?>">
                          <?= $data['name']; ?>
                      </option>
                      <?php endforeach ?>
                   </select>
                
                  
                </div>
                <div class="mb-4">
                  <label class="form-label" for="zipcode">Zipcode</label>
                 
                  <input class="form-control" type="text" placeholder="Enter Your Zipcode" required name="zipcode" id="zipcode" value="<?= $this->user['zipcode'] ?>">
                  
                </div>

              <!--    
                <label class="form-label" for="ap-price">Distance (in miles)<span class="text-danger">*</span></label>
              <div class="range-slider pe-0 pe-sm-3" data-start-min="450" data-min="0" data-max="1000" data-step="1">
                      <div class="range-slider-ui"></div>
                      <input class="form-control range-slider-value-min" type="hidden">
                    </div> -->

                 <div class="mb-4">
                  <label class="form-label" for="description">Brief description about business</label>
                  <textarea class="form-control" rows="3" id="description" name="description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100"  id="do_become_seller_btn">Become A Seller</button>
              </form>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </main>
    <?php include 'includes/footer.php'; ?>
    <script type="text/javascript">
      function do_become_seller (e) 
      {
        e.preventDefault();
          $('.alert-danger').remove();
          $.ajax({
          url: '<?= base_url() ?>/User/do_become_seller',
          type: 'POST',
          cache:false,
          contentType: false,
          processData: false,
          data:new FormData($('#do_become_seller')[0]),
          dataType: 'json',
          beforeSend: function() {        
            $('#do_become_seller_btn').prop('disabled' , true);
            $('#do_become_seller_btn').text('Processing..');
          },
          success : function(res){
            $('#do_become_seller_btn').prop('disabled' , false);
            $('#do_become_seller_btn').text('Sign Up');
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
          var short_code = "";
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
                  short_code = address_components[i].short_name;
              }
          }
          console.log(city,state,country,zipcode,lat,lng);
        $('#country').val(short_code);
        $('#state').val(state);
        $('#city').val(city);
        $('#zip').val(zipcode);
        $('#lat').val(lat);
        $('#lng').val(lng);
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
  function show_seller_from() 
  {
    $('#do_become_seller').show();
    $('#rejected_msg').hide();
  }
</script>