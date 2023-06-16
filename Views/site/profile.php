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

          	<div class="show active" id="" role="">
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
                  <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#email-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
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
                    <div id="phone-value"><?= $this->user['phone'] ?></div>
                  </div>
                  <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#phone-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                </div>
                <div class="collapse" id="phone-collapse" data-bs-parent="#personal-info">
                  <input class="form-control mt-3" type="text" name="phone" data-bs-binded-element="#phone-value" data-bs-unset-value="Not specified" value="<?= $this->user['phone'] ?>">
                </div>
              </div>
              <div class="border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                  <div class="pe-2">
                    <label class="form-label fw-bold">Category</label>
                    <div id="interest_edit"><?= $this->user['interested_in'] ?></div>
                  </div>
                  <div class="me-n3" data-bs-toggle="tooltip" title="Edit"><a class="nav-link py-0" href="#interest-collapse" data-bs-toggle="collapse"><i class="fi-edit"></i></a></div>
                </div>
                <div class="collapse" id="interest-collapse" data-bs-parent="#personal-info">
                  <input class="form-control mt-3" type="text" name="phone" data-bs-binded-element="#interest_edit" data-bs-unset-value="Not specified" value="<?= $this->user['phone'] ?>">
                </div>
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
                  <input type="hidden" name="city" id="city" value="<?= $this->user['city'] ?>">
                  <input type="hidden" name="state" id="state" value="<?= $this->user['state'] ?>">
                  <input type="hidden" name="country" id="country" value="<?= $this->user['country'] ?>">
                  <input type="hidden" name="zipcode" id="zipcode" value="<?= $this->user['zipcode'] ?>">
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


