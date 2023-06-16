<?php include_once 'includes/header.php'; ?>

<style type="text/css">
  #loading {
    text-align: center;
    background: url(<?= base_url('assets') ?>/site/img/loader.gif) no-repeat center;
    height: 150px;
    width: 100%;
}

</style>
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
              <input type="text" placeholder="Enter any keyword" value="" class="form-control" name="search_keyword" id="search_keyword">  
            </div>

            <div class="pb-4 mb-2">
              <h3 class="h6">Price</h3>
              <div class="range-slider" data-start-min="1" data-start-max="10000" data-min="1" data-max="10000" data-step="1">
                <div class="range-slider-ui noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr"></div>
                  <div class="d-flex align-items-center">
                    <div class="w-50 pe-2">
                      <div class="input-group"><span class="input-group-text fs-base">$</span>
                        <input class="form-control range-slider-value-min filter" name="min_price" id="min_price" type="text">
                      </div>
                    </div>
                    <div class="text-muted">—</div>
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
        <a class="btn btn-outline-primary btn-xs" href="javascript:;" onclick="location.reload()"><i class="fi-rotate-right me-2"></i>Reset filters</a>
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
      <li class="breadcrumb-item active" aria-current="page">Coupons</li>
    </ol>
  </nav>
  <!-- Title-->
  <div class="d-sm-flex align-items-center justify-content-between pb-3 pb-sm-4">
    <h1 class="h2 mb-sm-0">Coupons</h1>
    <!--  <a class="d-inline-block fw-bold text-decoration-none py-1" href="#" data-bs-toggle-class="invisible" data-bs-target="#map"><i class="fi-map me-2"></i>Map view</a> -->
  </div>
  <!-- Sorting-->
  <div class="d-flex flex-sm-row flex-column align-items-sm-center align-items-stretch my-2">
    <div class="d-flex align-items-center flex-shrink-0">
      <label class="fs-sm me-2 pe-1 text-nowrap" for="sortby"><i class="fi-arrows-sort text-muted mt-n1 me-2"></i>Sort by:</label>
      <select class="form-select form-select-sm filter" id="sortby">
        <option value="id_desc">Latest </option>
        <option value="price_desc">Price : High to Low </option>
        <option value="price_asc">Price : Low to high </option>
      </select>
    </div>
    <hr class="d-none d-sm-block w-100 mx-4">
  <div class="d-none d-sm-flex align-items-center flex-shrink-0 text-muted"><i class="fi-check-circle me-2"></i><span class="fs-sm mt-n1" id="total_product">There are 4 Coupons.</span></div>
  </div>
  <!-- Catalog grid-->
    <div class="row g-4 py-4" id="filter_data"><!-- DEBUG-VIEW START 2 APPPATH/Views/loop/post.php -->
         

     </div>
<!-- Pagination-->
<nav class="border-top pb-md-4 pt-4 mt-2" aria-label="Pagination" id="pagination_link"><!-- DEBUG-VIEW START 1 SYSTEMPATH/Pager/Views/ajax_full.php -->
                
<nav aria-label="Page navigation">
    <ul class="pagination">
        
        
            </ul>
</nav>

<!-- DEBUG-VIEW ENDED 1 SYSTEMPATH/Pager/Views/ajax_full.php -->
</nav>
</div>
</div>
</div>

<!-- container-fluid -->

<?php include_once 'includes/footer.php'; ?>

<script type="text/javascript">
/*Filter Search Function START =========================*/

  function search_product(e=null , page=1)
    {
      //alert('hello1');
      if(e){ e.preventDefault() }
      
        $('#filter_data').html('<div id="loading" style="" ></div>');
        //$.blockUI();
        form_data = new FormData($('#search_product')[0]);
        console.log(form_data);
        search = '';
        sortby = $('#sortby').val()
        form_data.append('search' , search);
        form_data.append('sortby' , sortby);
        $.ajax({
            url:"<?= base_url() ?>/Coupon/fetch_data/"+page,
            method:"POST",
            dataType:"JSON",
            cache:false,
            contentType: false,
            processData: false,
            data:form_data,
            
            success:function(data)
            {
               //$.unblockUI();
               //alert('hello');
              console.log(data)
                $('#filter_data').html(data.coupon_list);
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
const delay = 1000;

let timer;

const inText = document.getElementById('search_keyword')
inText.addEventListener('input', code => {
  clearTimeout(timer);
  timer = setTimeout(x => {
   search_product(null , 1);
  }, delay, code)
})

/*Filter Search Function END =========================*/
</script>


