<?php include 'includes/header.php'; ?>
<style type="text/css">

  #loading {
    text-align: center;
    background: url(<?= base_url() ?>/assets/site/img/loader.gif) no-repeat center;
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
      <div class="container mt-5 mb-md-4 py-5 vendor_profile_page" >
        <div class="row">
          <!-- Page content-->
          <div class="col-lg-12">
            <!-- Breadcrumb-->
            <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $vendor['name'] ?></li>
              </ol>
            </nav>
            
            <section class="card card-body border-0 shadow-sm p-4 mb-4 vendor_profile" id="location">
              <div class="container">
  <div class="profile-header">
    <div class="profile-img">
      <img src="<?= base_url($vendor['image']) ?>" width="200" alt="Profile Image">
    </div>
    <div class="profile-nav-info">
      <h3 class="user-name"><?= $vendor['name'] ?></h3>
      <div class="address">
        <p id="state" class="state"><?= $vendor['city'] ?>,</p>
        <span id="country" class="country"><?= $vendor['country'] ?>.</span>
      </div>

    </div>
    
  </div>

  <div class="main-bd">
    <div class="left-side">
      <div class="profile-side">
        <p class="mobile-no"><i class="fa fa-phone"></i> <?= $vendor['phone'] ?></p>
        <p class="user-mail"><i class="fa fa-envelope"></i> <?= $vendor['email'] ?></p>
        <div class="user-bio">
          <h3>Bio</h3>
          <p class="bio">
            <?= $vendor['description'] ?>
          </p>
        </div>
        <div class="profile-btn">
          <button class="chatbtn" onclick="open_chat(<?= $vendor['id'] ?> , 1)" id="chatBtn"><i class="fa fa-comment"></i> Chat</button>
          
        </div>
      
      </div>

    </div>
    <div class="right-side">

      <div class="nav">
        <ul>
          <li onclick="tabs('shop' , this)" class="user-shop active">Posts</li>
          <li onclick="tabs('auction' , this)" class="user-auction">Auctions</li>
          <li onclick="tabs('swap'  , this)" class="user-swap"> Swaps</li>
          <li onclick="tabs('coupon'  , this)" class="user-coupon"> Coupons</li>
        </ul>
      </div>
      <div class="profile-body">
        <div  class="row g-4 py-4"id="tab_data"></div>
        <div id="pagination_link"></div>
      </div>
    </div>
  </div>
</div>

               
            </section>
          
          </div>
        </div>
      </div>
    </main>


<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
var active = 'shop';
const tab = document.querySelectorAll(".tab");
  function tabs(type , elem = '.user-shop' , page=1) {
     $('#tab_data').html('<div id="loading" style="" ></div>');
     $('#pagination_link').html('')
    $(elem)
    .addClass("active")
    .siblings()
    .removeClass("active");
     form_data = new FormData();
     active = type;
    form_data.append('user_id' , '<?= $vendor['id'] ?>');

    if(type == 'auction')
    {
      type = 'Shop';
      form_data.append('is_auction' , 1);
    }
  $.ajax({
            url:"<?= base_url() ?>/"+type+"/fetch_data/"+page,
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
               key = Object.keys(data)[1]
              console.log(data)
                $('#tab_data').html(data[key]);
                $('#pagination_link').html(data.pagination_link);
               
            }
        })
}
tabs(active);
$(document).on('click', '.pagination li a', function(event){
      event.preventDefault();
      var page = $(this).data('ci-pagination-page');
      tabs(active , '.user-'+active+'' , page);
  });
</script>