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

          <div class="" id="" role="">
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
            
            $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
          }
        }
      }
    });
return false;
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcpNpTtV_czTWzF9IJzqDpAnmcMI3yUlY&libraries=places&callback=initMap" async defer></script>
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
$('#address').on('focus', function() {
  selected = false;
  }).on('blur', function() {
    if (!selected) {
      $(this).val('');
    }
  });
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


