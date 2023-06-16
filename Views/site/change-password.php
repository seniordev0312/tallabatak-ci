<?php 
include_once 'includes/header.php';
?>

<section class="container pt-5 mt-5">
        <!-- Breadcrumb-->
        <?= $this->session->getFlashdata('msg'); ?>
        <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
          </ol>
        </nav>
      </section>

       <div class="container">
       	 <div class="row">
          <!-- Sidebar-->
          <?php include_once 'includes/user_sidebar.php' ?>
          <!-- Content-->
          <div class="col-lg-8 col-md-7 mb-5">

          	
          <!-- tab2  -->

          <div class="" id="" role="">
           
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


