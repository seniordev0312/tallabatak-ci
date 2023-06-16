<?php 
include_once 'includes/header.php';
?>
<?php if($this->session->has('user_id')) {
if ($this->user['user_type'] == 1) 
  { 
    header("Location: ".base_url());
die();
  } }

  ?>
  <link href = "<?= base_url()?>/assets/css/jquery.dm-uploader.min.css" rel="stylesheet">
<div class="container mt-5 mb-md-4 py-5">
        <div class="row">
          <!-- Page content-->
            <div class="col-lg-8">
                <!-- Breadcrumb-->
                <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Post</li>
                </ol>
                </nav>
                <!-- Title-->
                <div class="mb-4">
                <h1 class="h2 mb-0">Add Post</h1>
               <!--  <div class="d-lg-none pt-3 mb-2">65% content filled</div>
                <div class="progress d-lg-none mb-4" style="height: .25rem;">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                </div> -->
                <div class="badge alert-warning my-2">Available Posts : <?= $this->subscription['available_post'] .'/'.$this->subscription['plan']['post'] ?></div>
                <?php if ($this->subscription['available_post'] == 0): ?>
                    
                         <div class="alert alert-danger">You have reached your limit for adding posts, please upgrade your plan in order to add more</div>
                         <a href="<?= base_url('upgrade-plan') ?>" class="btn btn-primary">Upgrade Plan </a>
                  
                   
                <?php endif ?>

                </div>
                <form action="#" id="add_post" method="post" onsubmit="return add_post(event)">
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
                                <option value="<?=$c['id']?>"><?=$c['title_eng']?></option>
                            <?php } ?>
                            </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="ap-title">Title <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="ap-title" placeholder="Title for your product" value="" required name="title"><span class="form-text">48 characters left</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="ap-description">Description </label>
                            <textarea class="form-control" id="ap-description" rows="5" placeholder="Describe your product" name="description"></textarea><span class="form-text">1500 characters left</span>
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
                                <input class="form-check-input" type="checkbox" <?= ($this->subscription['plan']['auction'] == 0 ) ? 'disabled' : ((@$_GET['is_auction']) ? 'checked' : '')  ?> id="auction" name="post_type">
                                
                                <label class="form-check-label" for="auction">Create as Auction</label>
                                </div>
                                
                            </div>
                            <div class="col-md-8">
                                <?php if($this->subscription['plan']['auction'] == 0): ?>
                                <p class="alert alert-danger">There is no auction feature available in your current plan. Please upgrade to get the auction feature</p>
                                <?php endif; ?>
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
                                    <input type="number" name="auction_qty" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                            <label class="form-label" for="ap-price">Auction Expire Date<span class="text-danger">*</span></label>
                            <input type="date" min="<?= date('Y-m-d' , strtotime('+1 Day')) ?>" name="auction_expire_date" class="form-control">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="ap-price">Price <span class="text-danger">*</span></label>
                            <div class="d-sm-flex">
                                <select class="form-select w-25 me-2 mb-2" name="auction_currency">
                                <option value="$">$</option>
                                <option value="€">€</option>
                                <option value="£">£</option>
                                <option value="¥">¥</option>
                                </select>
                                <input class="form-control w-100 me-2 mb-2" type="number" id="ap-price"  min="1" name="auction_price">
                                <p class="mt-2 w-25">Per product</p>
                            </div>
                        </div>
                    </section>
                    <!-- Location-->
                    <section class="card card-body border-0 shadow-sm p-4 mb-4" id="location">
                        <h2 class="h4 mb-4"><i class="fi-map-pin text-primary fs-5 mt-n1 me-2"></i>Location</h2>
                        <div class="mb-3">
                            <label class="form-label" for="ap-address">Street address <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" placeholder="Enter Your Business Address" required name="address" id="address" value="<?= $this->user['address'] ?>">
                            <input type="hidden" name="lat" id="lat" value="<?= ($this->user['lat']) ? $this->user['lat'] : 02  ?>">
                            <input type="hidden" name="lng" id="lng" value="<?= ($this->user['lng']) ? $this->user['lng'] : 02 ?>">
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="ap-country">Country / region <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" placeholder="Enter Your Country" required name="country" id="country" value="<?= $this->user['country'] ?>">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="ap-city">City <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" placeholder="Enter Your City" required name="city" id="city" value="<?= $this->user['city'] ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 mb-3">
                                <label class="form-label" for="ap-district">State <span class="text-danger">*</span></label>
                  <input class="form-control" type="text" placeholder="Enter Your State" required name="state" id="state" value="<?= $this->user['state'] ?>">
                                <!-- <input type="text" name="district"> -->
                            </div>
                            <div class="col-sm-4 mb-3">
                                <label class="form-label" for="ap-zip">Zip code  <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" placeholder="Enter Your Zipcode" required name="zipcode" id="zipcode" value="<?= $this->user['zipcode'] ?>">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                          <button class="col-6 btn btn-primary" type="button" id="btn_location_modal">Select Location on Map</button>
                                </div>
                    </section>

                    <!-- Price-->
                    <section class="card card-body border-0 shadow-sm p-4 mb-4" id="price">
                    <h2 class="h4 mb-4"><i class="fi-cash text-primary fs-5 mt-n1 me-2"></i>Price</h2>
                    <label class="form-label" for="ap-price">Price <span class="text-danger">*</span></label>
                    <div class="d-sm-flex">
                        <select class="form-select w-25 me-2 mb-2" name="currency">
                        <option value="$">$</option>
                        <option value="€">€</option>
                        <option value="£">£</option>
                        <option value="¥">¥</option>
                        </select>
                        <input class="form-control w-100 me-2 mb-2" type="number" id="ap-price" min="1"  required="" name="price">
                        <select class="form-select w-50 mb-2" name="duration">
                        <option value="day">per day</option>
                        <option value="week">per week</option>
                        <option value="month" selected="">per month</option>
                        <option value="year">per year</option>
                        </select>
                    </div>
                    </section>
                    <!-- Photos / video-->
                    <section class="card card-body border-0 shadow-sm p-4 mb-4" id="photos">
                    <h2 class="h4 mb-4"><i class="fi-image text-primary fs-5 mt-n1 me-2"></i>Photos / video</h2>
                    <div class="alert alert-info mb-4" role="alert">
                        <div class="d-flex"><i class="fi-alert-circle me-2 me-sm-3"></i>
                        <p class="fs-sm mb-1">The maximum photo size is 30 MB. Put the main picture first.<!-- <br>The maximum video size is 10 MB. Formats: mp4, mov. --></p>
                        </div>
                    </div>
                    <div id="drag-and-drop-zone" class="dm-uploader p-5">
                        <h3 class="mb-5 mt-5 text-muted">Drag &amp; drop files here</h3>

                        <div class="btn btn-primary btn-block mb-5">
                            <span>Open the file Browser</span>
                            <input type="file" title='Click to add Files' />
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="card h-100">
                            <div class="card-header">
                            File List
                            </div>

                            <ul class="list-unstyled p-2 d-flex flex-column col" id="files">
                                <li class="text-muted text-center empty">No files uploaded.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- <input class="file-uploader file-uploader-grid" required type="file" name="file[]" multiple="" data-max-file-size="10MB" accept="image/*" data-label-idle="<div class=&quot;btn btn-primary mb-3&quot;><i class=&quot;fi-cloud-upload me-1&quot;></i>Upload photos</div><br>or drag them in"> -->
                    </section>
                    
                    <!-- Action buttons -->
                    <section class="d-sm-flex justify-content-between pt-2">
                    <!--  <a class="btn btn-outline-primary btn-lg d-block mb-3 mb-sm-2" href="#preview-modal" data-bs-toggle="modal"><i class="fi-eye-on ms-n1 me-2"></i>Preview</a> -->
                    
                    </section>
                    <button class="btn btn-primary btn-lg d-block mb-2" id="add_post_btn" <?= ($this->subscription['available_post'] == 0) ? 'disabled' : '' ?> type="submit">Save and continue</button>
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
                <li class="d-flex align-items-center"><i class="fi-check text-muted me-2"></i><a class="nav-link fw-normal ps-1 p-0" href="#photos" data-scroll="" data-scroll-offset="20">Photos </a></li>
              </ul>
              <div class="pt-2">
                <div class="position-relative mb-2 map_div shadow-sm">
                  <!-- <img class="rounded-3" src="img/real-estate/single/map.jpg" alt="Map"> -->
                  
                  <iframe src="//maps.google.com/maps?q=<?= $this->user['lat'] ?>,<?= $this->user['lng'] ?>&z=15&output=embed" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" id="location_preview"></iframe>
                  
                  
                </div>
                <p class="mb-0 fs-base text-primary" id="p_address"><?= $this->user['address'] ?></p>
              </div>
            </div>
            
          </aside>
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
    height: 60vh;"></div>
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
<script src="<?= base_url() ?>/assets/js/jquery.dm-uploader.min.js"></script>
<script type="text/html" id="files-template">
      <li class="media">
        <div class="media-body mb-1">
          <p class="mb-2">
            <strong>%%filename%%</strong>
          </p>
          <hr class="mt-1 mb-1" />
        </div>
      </li>
    </script>
<script>
  var files = [];
  var modal_initial_markers= new Array();
  var cur_location;
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

$('#btn_location_modal').click(function(){

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

// function change_center(event)
// {
//   let center_text = event.target.value;
//   service = new google.maps.places.PlacesService(modal_map);
//   const request = {
//     query: center_text,
//     fields: ["name", "geometry"],
//   };
//   service.findPlaceFromQuery(request, (results, status) => {
//     if (status === google.maps.places.PlacesServiceStatus.OK && results) {
//       modal_initial_markers = [];
//       for (let i = 0; i < results.length; i++) {
//         modal_mark = new google.maps.Marker({
//         position : results[i].geometry.location,
//         map : modal_map,
//       });
//       modal_initial_markers.push(modal_mark);
//         // createMarker(results[i]);
//       }
//       // console.log(results[0]);
//       modal_map.setCenter(results[0].geometry.location);
//       cur_location = results[0].geometry.location;
//     }
//   });
// }
  
  function add_post(e) 
  {
    e.preventDefault();
      $('.alert-danger').remove();
      let formdata = new FormData($('#add_post')[0]);
      for(let i =0;i<files.length;i++){
        formdata.append('file[]',files[i]);
      }
      console.log(formdata);
      formdata.append('file[]',files);
      $.ajax({
      url: '<?= base_url() ?>/Post/add_post',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data: formdata,
      dataType: 'json',
      beforeSend: function() {        
        $('#add_post_btn').prop('disabled' , true);
        $('#add_post_btn').text('Processing..');
      },
      success : function(res){
        $('#add_post_btn').prop('disabled' , false);
        $('#add_post_btn').text('Submit');
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

function add_file(id,file){
    files.push(file);
    var template = $('#files-template').text();
    template = template.replace('%%filename%%', file.name);

    template = $(template);
    template.prop('id', 'uploaderFile' + id);
    template.data('file-id', id);

    $('#files').find('li.empty').fadeOut(); // remove the 'no files yet'
    $('#files').prepend(template);
}
$(document).ready(function() {
    
$('#auction').trigger('change')
$('textarea').on('keyup keypress', function() {
        $(this).height(0);
        $(this).height(this.scrollHeight);
    }); 
    
    $("textarea").each(function(textarea) {
         $(this).height(0);
        $(this).height(this.scrollHeight);
    });

$('#drag-and-drop-zone').dmUploader({
    auto: false,
    maxFileSize : 30000000,
    allowedTypes : "image/*",
    onNewFile: function(id, file){
      // When a new file is added using the file selector or the DnD area
      console.log(file);
      add_file(id, file);
    },
});

});


</script>