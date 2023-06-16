<?php 
include_once 'includes/header.php';
?>
<?php if($this->session->has('user_id')) {
if ($this->user['user_type'] == 1) 
  { 
    header("Location: ".base_url());
die();
  } }?>
<div class="container mt-5 mb-md-4 py-5">
        <div class="row">
          <!-- Page content-->
            <div class="col-lg-8">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Post</li>
                </ol>
                </nav>
                <!-- Title-->
                <div class="mb-4">
                <h1 class="h2 mb-0">Edit Post</h1>
               <!--  <div class="d-lg-none pt-3 mb-2">65% content filled</div>
                <div class="progress d-lg-none mb-4" style="height: .25rem;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                </div> -->
                </div>
                <form action="#" id="update_post" method="post" onsubmit="return update_post(event)">
                    <!-- Basic info-->
                    <section class="card card-body border-0 shadow-sm p-4 mb-4" id="basic-info">
                    
                        <h2 class="h4 mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>Basic info</h2>
                    
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                            <label class="form-label" for="ap-category">Category <span class="text-danger">*</span></label>
                            <?php $cat = $this->common_model->GetAllData('category','','id','desc')?>
                            <select class="form-select" id="ap-category" required="" name="category">
                                <option value="">Choose category</option>
                                <?php foreach($cat as $c) {?>
                                <option value="<?=$c['id']?>" <?= ($c['id']==$edit['category']) ? 'selected' : '' ?>><?=$c['title_eng']?></option>
                            <?php } ?>
                            </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ap-title">Title <span class="text-danger">*</span></label>
                            <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">
                            <input class="form-control" type="text" id="ap-title" placeholder="Title for your product" value="<?= $edit['title'] ?>" required name="title"><span class="form-text">48 characters left</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="ap-description">Description </label>
                            <textarea class="form-control" id="ap-description" rows="5" placeholder="Describe your product" name="description"><?= $edit['description'] ?></textarea><span class="form-text">1500 characters left</span>
                        </div>
                       <!--  <div class="mb-4">
                        <label class="form-label" for="ap-price">Distance (in miles)<span class="text-danger">*</span></label>
                        <div class="range-slider pe-0 pe-sm-3" data-start-min="450" data-min="0" data-max="1000" data-step="1">
                                <div class="range-slider-ui noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr"><div class="noUi-base"><div class="noUi-connects"><div class="noUi-connect" style="transform: translate(0%, 0px) scale(0.45, 1);"></div></div><div class="noUi-origin" style="transform: translate(-55%, 0px); z-index: 4;"><div class="noUi-handle noUi-handle-lower" data-handle="0" tabindex="0" role="slider" aria-orientation="horizontal" aria-valuemin="0.0" aria-valuemax="1000.0" aria-valuenow="450.0" aria-valuetext="450"><div class="noUi-touch-area"></div><div class="noUi-tooltip">450</div></div></div></div></div>
                                <input class="form-control range-slider-value-min" type="hidden" value="450" name="distance">
                                <input type="range" id="vol" name="vol" min="0" max="1000" oninput="this.nextElementSibling.value = this.value">
                                <output></output>
                        </div>
                        </div> -->

                        <div class="mb-4">
                            <label class="form-label d-block fw-bold mb-2 pb-1">Auction</label>
                            <div class="row">
                            <div class="col-sm-4">
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="auction" name="post_type" <?= ($edit['post_type']==1) ? 'checked' : '' ?> value="<?= ($edit['post_type']) ? $edit['post_type'] : '' ?>">
                                <label class="form-check-label" for="auction">Create as Auction</label>
                                </div>
                            </div>
                            </div>
                        </div>

                    </section>
                    <section class="card card-body border shadow p-4 mb-4" style="display: none;" id="auction_show">
                    <h2 class="h4 mb-4"><i class="fi-cash text-primary fs-5 mt-n1 me-2"></i>For Auction</h2>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label" for="ap-price">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="auction_qty" class="form-control" value="<?= $edit['auction_qty'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                            <label class="form-label" for="ap-price">Auction Expire Date<span class="text-danger">*</span></label>
                            <input type="date" name="auction_expire_date" class="form-control" value="<?= $edit['auction_expire_date'] ?>">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="ap-price">Price <span class="text-danger">*</span></label>
                            <div class="d-sm-flex">
                                <select class="form-select w-25 me-2 mb-2" name="auction_currency">
                                <option value="$" <?= ("$"==$edit['auction_currency']) ? 'selected' : '' ?>>$</option>
                                <option value="€" <?= ("€"==$edit['auction_currency']) ? 'selected' : '' ?>>€</option>
                                <option value="£" <?= ("£"==$edit['auction_currency']) ? 'selected' : '' ?>>£</option>
                                <option value="¥" <?= ("¥"==$edit['auction_currency']) ? 'selected' : '' ?>>¥</option>
                                </select>
                                <input class="form-control w-100 me-2 mb-2" type="number" id="ap-price"  min="1" name="auction_price" value="<?= $edit['auction_price'] ?>">
                                <p class="mt-2 w-25">Per product</p>
                            </div>
                        </div>
                    </section>
                    
                    <!-- Location-->
                    <section class="card card-body border-0 shadow-sm p-4 mb-4" id="location">
                        <h2 class="h4 mb-4"><i class="fi-map-pin text-primary fs-5 mt-n1 me-2"></i>Location</h2>
                        <div class="mb-3">
                            <label class="form-label" for="ap-address">Street address <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" placeholder="Enter Your Business Address" required name="address" id="address" value="<?= $edit['address'] ?>">
                            <input type="hidden" name="lat" id="lat" value="<?= $edit['lat'] ?>">
                            <input type="hidden" name="lng" id="lng" value="<?= $edit['lng'] ?>">
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="ap-country">Country / region <span class="text-danger">*</span></label>
                                <select  id="country-dd" name="country" class="form-control  ">
                                  <option value="">Select Country</option>
                                  <?php
                                  $state_fetch = [];
                                   foreach ($countries_fetch as $key => $data): ?>
                                    <?php if ($edit['country'] == $data['name']) {
                                      $state_fetch =  $this->common_model->GetAllData('states' , ["country_id" => $data['id'] ] , 'name' , 'asc' , '' , ["name", "id"]);
                                    } ?>
                                    <option <?= ($edit['country'] == $data['name']) ? 'selected' : '' ?> value="<?= $data['name']; ?>" data-id="<?= $data['id']; ?>">
                                      <?= $data['name']; ?>
                                  </option>
                                  <?php endforeach ?>
                                  
                              </select>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="ap-district">State <span class="text-danger">*</span></label>
                                <select  id="state-dd" name="state" class="form-control  ">
                                  <option value="">Select State</option>
                                  <?php
                                  $city_fetch = [];
                                   foreach ($state_fetch as $key => $data): ?>
                                    <?php if ($edit['state'] == $data['name']) {
                                      $city_fetch =  $this->common_model->GetAllData('cities' , ["state_id" => $data['id'] ] , 'name' , 'asc' , '' , ["name", "id"]);
                                    } ?>
                                    <option <?= ($edit['state'] == $data['name']) ? 'selected' : '' ?> value="<?= $data['name']; ?>" data-id="<?= $data['id']; ?>">
                                      <?= $data['name']; ?>
                                  </option>
                                  <?php endforeach ?>
                                  
                              </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 mb-3">
                                
                                <label class="form-label" for="ap-city">City <span class="text-danger">*</span></label>
                                <select  id="city-dd" name="city" class="form-control  ">
                                  <option value="">Select City</option>
                              <?php foreach ($city_fetch as $key => $data): ?>
                                   
                                    <option <?= ($edit['city'] == $data['name']) ? 'selected' : '' ?> value="<?= $data['name']; ?>" data-id="<?= $data['id']; ?>">
                                      <?= $data['name']; ?>
                                  </option>
                                  <?php endforeach ?>
                               </select>
                                <!-- <input type="text" name="district"> -->
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label" for="ap-zip">Zip code  <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" placeholder="Enter Your Zipcode" required name="zipcode" id="zipcode" value="<?= $edit['zipcode'] ?>">
                            </div>
                        </div>
                        
                    </section>

                    <!-- Price-->
                    <section class="card card-body border-0 shadow-sm p-4 mb-4" id="price">
                    <h2 class="h4 mb-4"><i class="fi-cash text-primary fs-5 mt-n1 me-2"></i>Price</h2>
                    <label class="form-label" for="ap-price">Price <span class="text-danger">*</span></label>
                    <div class="d-sm-flex">
                        <select class="form-select w-25 me-2 mb-2" name="currency">
                        <option value="$" <?= ("$"==$edit['currency']) ? 'selected' : '' ?>>$</option>
                        <option value="€" <?= ("€"==$edit['currency']) ? 'selected' : '' ?>>€</option>
                        <option value="£" <?= ("£"==$edit['currency']) ? 'selected' : '' ?>>£</option>
                        <option value="¥" <?= ("¥"==$edit['currency']) ? 'selected' : '' ?>>¥</option>
                        </select>
                        <input class="form-control w-100 me-2 mb-2" type="number" id="ap-price" min="1"  required="" name="price" value="<?= $edit['price'] ?>">
                        <select class="form-select w-50 mb-2" name="duration">
                        <option value="day" <?= ("day"==$edit['duration']) ? 'selected' : '' ?> >per day</option>
                        <option value="week" <?= ("week"==$edit['duration']) ? 'selected' : '' ?>>per week</option>
                        <option value="month" <?= ("month"==$edit['duration']) ? 'selected' : '' ?> >per month</option>
                        <option value="year" <?= ("year"==$edit['duration']) ? 'selected' : '' ?>>per year</option>
                        </select>
                    </div>
                    </section>
                    <!-- Photos / video-->
                    <section class="card card-body border-0 shadow-sm p-4 mb-4" id="photos">
                    <h2 class="h4 mb-4"><i class="fi-image text-primary fs-5 mt-n1 me-2"></i>Photos / video</h2>
                    <input class="file-uploader file-uploader-grid" type="file" name="file[]" multiple="" data-max-file-size="10MB" accept="image/png, image/jpeg" data-label-idle="<div class=&quot;btn btn-primary mb-3&quot;><i class=&quot;fi-cloud-upload me-1&quot;></i>Upload photos</div><br>or drag them in">

                    <div class="alert alert-info mb-4" role="alert">
                        <div class="d-flex"><i class="fi-alert-circle me-2 me-sm-3"></i>

                        <p class="fs-sm mb-1">The maximum photo size is 8 MB. Formats: jpeg, jpg, png. Put the main picture first.<!-- <br>The maximum video size is 10 MB. Formats: mp4, mov. --></p>
                        </div>
                    </div>
                    <?php 
                    $img = $this->common_model->GetAllData('post_images',array('post_id' =>$edit['id']));
                    if($img){
                    foreach($img as $images) {?>
                        <div class="item">
                            <img style="height: 100px;width: 100px;" src="<?php echo base_url().'/'.$images["file"]?>">
                            <button type="button" class="btn  btn-sm btn-danger" id="delete_btn" onclick="delete_image(<?= $images['id'] ?>)">Remove</button>

                        </div>
                    <?php }} ?>
                    </section>
                    
                    <!-- Action buttons -->
                    <section class="d-sm-flex justify-content-between pt-2">
                    <!--  <a class="btn btn-outline-primary btn-lg d-block mb-3 mb-sm-2" href="#preview-modal" data-bs-toggle="modal"><i class="fi-eye-on ms-n1 me-2"></i>Preview</a> -->
                    
                    </section>
                    <button class="btn btn-primary btn-lg d-block mb-2" id="update_post_btn" type="submit">Save and continue</button>
                </form>
            
            </div>
          <!-- Progress of completion-->
          <aside class="col-lg-3 offset-lg-1 d-none d-lg-block">
            <div class="sticky-top pt-5">
              <h6 class="pt-5 mt-3 mb-2">content</h6>
              <div class="progress mb-4" style="height: .25rem;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <ul class="list-unstyled">
                <li class="d-flex align-items-center"><i class="fi-check text-primary me-2"></i><a class="nav-link fw-normal ps-1 p-0" href="#basic-info" data-scroll="" data-scroll-offset="20">Basic info</a></li>
                <li class="d-flex align-items-center"><i class="fi-check text-primary me-2"></i><a class="nav-link fw-normal ps-1 p-0" href="#location" data-scroll="" data-scroll-offset="20">Location</a></li>
                <li class="d-flex align-items-center"><i class="fi-check text-muted me-2"></i><a class="nav-link fw-normal ps-1 p-0" href="#price" data-scroll="" data-scroll-offset="20">Price</a></li>
                <li class="d-flex align-items-center"><i class="fi-check text-muted me-2"></i><a class="nav-link fw-normal ps-1 p-0" href="#photos" data-scroll="" data-scroll-offset="20">Photos / video</a></li>
              </ul>
            </div>
          </aside>
        </div>
      </div>
      <?php
include_once 'includes/footer.php'; ?>
<script>
      function delete_image(id) {
        // event.preventDefault();
    if(confirm('Are you sure ?'))
    {
        $.ajax({
      url: '<?= base_url() ?>/Post/deleteImage',
      type: 'POST',
      cache:false,
      data:{'id':id},
      dataType: 'json',
      beforeSend: function() {
        $('#delete_btn'+id).prop('disabled' , true);
      },
      success : function(res){
        console.log(res);
        $('#delete_btn'+id).prop('disabled' , false);
        if (res.status == 1) {
           Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
            location.reload();
            })
        }
        
      }
    });
    }
    
}

    $(document).ready(function() {
          $("#auction").change()
        });
  function update_post(e) 
  {
  
    e.preventDefault();
      $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/Post/update_post',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#update_post')[0]),
      dataType: 'json',
      beforeSend: function() {        
        $('#update_post_btn').prop('disabled' , true);
        $('#update_post_btn').text('Processing..');
      },
      success : function(res){
        $('#update_post_btn').prop('disabled' , false);
        $('#update_post_btn').text('Updated');
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
            
            $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
          }
        }
      }
    });
return false;
}
</script>


<script src="https://www.paypal.com/sdk/js?client-id=AQwoZAAHsmA5vBLj_mZffS3NWJjNJODewuV2WakPm-BQilgsawTtnbLvWHNC73idcfiaHBOjaeTDkAS8"></script>

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

</script>