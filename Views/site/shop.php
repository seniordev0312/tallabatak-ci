<?php include 'includes/header.php'; ?>
<style type="text/css">
  #loading {
    text-align: center;
    background: url(<?= base_url('assets') ?>/site/img/loader.gif) no-repeat center;
    height: 150px;
    width: 100%;
}
.tns-carousel-wrapper .tns-carousel-inner {
    opacity: 1;
}

  #timer {
  font-family: Arial, sans-serif;
  font-size: 14px;
  color: #999;
  letter-spacing: -1px;
}
#timer span {
  font-size: 20px;
  color: #333;
  margin: 0 3px 0 2px;
}
#timer span:first-child {
  margin-left: 0;
}

</style>
<!-- Page content-->
<!-- Page container-->
<div class="container-fluid mt-5 pt-5 p-0">
  <div class="row g-0 mt-n3">
    <!-- Filters sidebar (Offcanvas on mobile)-->
    <aside class="col-lg-4 col-xl-3 border-top-lg border-end-lg shadow-sm px-3 px-xl-4 px-xxl-5 pt-lg-2">
      <div class="offcanvas offcanvas-start offcanvas-collapse" id="filters-sidebar">
        <div class="offcanvas-header d-flex d-lg-none align-items-center">
          <h2 class="h5 mb-0">Filters</h2>
          <button class="btn-close" type="button" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body py-lg-4">
          <form action="#" method="post" id="search_product" onsubmit=" return search_product(e)">
            <div class="pb-4 mb-2">
              <h3 class="h6">Keyword</h3>
              <input type="text" placeholder="Enter any keyword" value="<?= @$_GET['keyword'] ?>" class="form-control" name="search_keyword" id="search_keyword">
              <input type="hidden" name="is_auction" id="is_auction" value="<?= @$_GET['is_auction'] ?>">
            </div>
            <div class="pb-4 mb-2">
              <h3 class="h6">Location</h3>
              <input type="text" placeholder="Enter near by location" class="form-control" name="search_address" id="search_address">
              <input type="hidden" name="search_lat" id="search_lat">
              <input type="hidden" name="search_lng" id="search_lng">
            </div>
            <div class="pb-4 mb-2">
              <h3 class="h6">Category</h3>
              <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false" style="height: 11rem;">
                <?php foreach ($categories as $key => $value): ?>
                  <div class="form-check">
                    <input class="form-check-input filter" name="category[]" type="checkbox" id="<?= base_url('shop/'.slugify($value['title_eng']).'-'.$value['id']) ?>" <?= ($active_cat == $value['id']) ? 'checked' : '' ?> value="<?= $value['id'] ?>" >
                    <label class="form-check-label fs-sm" for="<?= base_url('shop/'.slugify($value['title_eng']).'-'.$value['id']) ?>"><?= $value['title_eng'] ?></label>
                  </div>
                <?php endforeach ?>
                
              </div>
            </div>
            <div class="pb-4 mb-2">
              <h3 class="h6">Price</h3>
              <div class="range-slider" data-start-min="1" data-start-max="10000" data-min="1" data-max="10000" data-step="1">
                <div class="range-slider-ui"></div>
                  <div class="d-flex align-items-center">
                    <div class="w-50 pe-2">
                      <div class="input-group"><span class="input-group-text fs-base">$</span>
                        <input class="form-control range-slider-value-min filter" name="min_price" id="min_price" type="text">
                      </div>
                    </div>
                    <div class="text-muted">&mdash;</div>
                    <div class="w-50 ps-2">
                      <div class="input-group"><span class="input-group-text fs-base">$</span>
                        <input class="form-control range-slider-value-max filter" name="max_price" id="max_price" type="text">
                      </div>
                    </div>
                  </div>
              </div>

            </div>
          </form>
      <div class="border-top py-4">
        <a class="btn btn-outline-primary btn-xs" href="<?= base_url('shop') ?>"><i class="fi-rotate-right me-2"></i>Reset filters</a>
      </div>
    </div>
  </div>
</aside>
<!-- Page content-->
<div class="col-lg-8 col-xl-9 position-relative overflow-hidden pb-5 pt-4 px-3 px-xl-4 px-xxl-5">
  <!-- Map popup-->
  <div class="map-popup invisible" id="map">
    <button class="btn btn-icon btn-light btn-sm shadow-sm rounded-circle" type="button" data-bs-toggle-class="invisible" data-bs-target="#map"><i class="fi-x fs-xs"></i></button>
    <div class="interactive-map" data-map-options-json="json/map-options-real-estate-rent.json"></div>
  </div>
  <!-- Breadcrumb-->
  <nav class="mb-3 pt-md-2" aria-label="Breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= (@$_GET['is_auction']) ? 'Auctions' : 'Shop' ?></li>
    </ol>
  </nav>
  <!-- Title-->
  <div class="d-sm-flex align-items-center justify-content-between pb-3 pb-sm-4">
    <h1 class="h2 mb-sm-0"><?= (@$_GET['is_auction']) ? 'Auctions' : 'Shop' ?></h1>
    <!--  <a class="d-inline-block fw-bold text-decoration-none py-1" href="#" data-bs-toggle-class="invisible" data-bs-target="#map"><i class="fi-map me-2"></i>Map view</a> -->
  </div>
  <!-- Sorting-->
  <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch my-2">
    <div class="d-flex align-items-center flex-shrink-0">
      <label class="fs-sm me-2 pe-1 text-nowrap" for="sortby"><i class="fi-arrows-sort text-muted mt-n1 me-2"></i>Sort by:</label>
      <select class="form-select form-select-sm filter" id="sortby">
        <option value="id_desc">Latest </option>
        <option value="price_asc">Price : High to Low </option>
        <option value="price_desc">Price : Low to high </option>
      </select>
    </div>
    <hr class="d-none d-sm-block w-100 mx-4">
    <div class="d-none d-sm-flex align-items-center flex-shrink-0 text-muted"><i class="fi-check-circle me-2"></i><span class="fs-sm mt-n1" id="total_product"></span></div>
  </div>
  <!-- Catalog grid-->
  <div class="row g-4 py-4" id="filter_data"></div>
<!-- Pagination-->
<nav class="border-top pb-md-4 pt-4 mt-2" aria-label="Pagination" id="pagination_link">
 
</nav>
</div>
</div>
</div>
</main>
<button class="btn btn-primary btn-sm w-100 rounded-0 fixed-bottom d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#filters-sidebar"><i class="fi-filter me-2"></i>Filters</button>

<!-- Footer-->
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
/*Filter Search Function START =========================*/

  function search_product(e=null , page=1)
    {
      if(e){ e.preventDefault() }
      
        $('#filter_data').html('<div id="loading" style="" ></div>');
        //$.blockUI();
        form_data = new FormData($('#search_product')[0]);
        search = '';
        sortby = $('#sortby').val()
        form_data.append('search' , search);
        form_data.append('sortby' , sortby);
        $.ajax({
            url:"<?= base_url() ?>/Shop/fetch_data/"+page,
            method:"POST",
            dataType:"JSON",
            cache:false,
            contentType: false,
            processData: false,
            data:form_data,
            
            success:function(data)
            {
               //$.unblockUI();
              //console.log(data)
                $('#filter_data').html(data.post_list);
                $('#pagination_link').html(data.pagination_link);
                $('#total_product').html(data.total);
            }
        })
    }

   $(document).on('click', '.pagination li a', function(event){
      event.preventDefault();
      var page = $(this).data('ci-pagination-page');
      search_product(event , page);
  });
$(document).ready(function() {
  search_product(null , 1);
});
$(document).on('keyup', '#search_key', function(event) {
  if($(this).val().length > 3)
  {
    search_product(null , 1);
  }
  if($(this).val() == '')
  {
    search_product(null , 1);
  }
});
// $( ".filter" ).slider({
//     change: function( event, ui ) {
//        search_product(null , 1);
//     }
// });
$('.filter').on('change' , function(){
  search_product(null , 1);
})
$('.noUi-handle').on('click', function(event, ui) 
{
  $('.noUi-handle').on('mousemove  mouseleave' , function(event, ui) {
    search_product(null , 1);
    $('.noUi-handle').off('mousemove  mouseleave')
  })
   
});

/*Filter Search Function END =========================*/
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABk-0Al27H9Ap_Rtti2t0ePxOLvl5QFzk&libraries=places&callback=search_initMap" async defer></script>
<script type="text/javascript">
var selected = false;
function search_initMap() 
{
    //var input = document.getElementById('address');
    var input = document.getElementById('search_address');

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
        // $('#city').val(city)
        // $('#state').val(state)
        // $('#country').val(country)
        // $('#zip').val(zipcode)
        $('#search_lat').val(lat)
        $('#search_lng').val(lng)
        search_product(null , 1);
     } 
     else 
     {
         window.alert('No results found');
     }
  });
   


}
$('#search_address').on('focus', function() {
  selected = false;
  }).on('blur', function() {

    if (!selected) {
      $(this).val('');
      $('#search_lat').val('')
        $('#search_lng').val('')
        search_product(null , 1);
    }
  });

 const delay = 1000;

let timer;

const inText = document.getElementById('search_keyword')
inText.addEventListener('input', code => {
  clearTimeout(timer);
  timer = setTimeout(x => {
   search_product(null , 1);
  }, delay, code)
})
</script>