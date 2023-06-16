<?php 
include_once 'includes/header.php';
?>

<section class="container pt-5 mt-5">
        <!-- Breadcrumb-->
        
        <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Notification</li>
          </ol>
        </nav>
      </section>

       <div class="container">
       	 <div class="row">
          <!-- Sidebar-->
          <?php include_once 'includes/user_sidebar.php' ?>
          <!-- Content-->
          <div class="col-lg-8 col-md-7 mb-5">
              <?= $this->session->getFlashdata('msg'); ?>
          	<!-- tab5 -->
          <div class="" id="" role="">
            <h1 class="h2">Notifications Settings</h1>
            <p class="pt-1 mb-4">Change Notification setting here</p>

            <div class="py-2" id="notification-settings">
             <div class="d-flex justify-content-between mb-4">
                  <div class="me-2">
                    <h6 class="mb-1">Nearby posts</h6>
                    <p class="fs-sm mb-0">Do you want to recieve notification for nearby added post ?</p>
                  </div>
                  


                  <div class="form-check form-switch">
                   
                    <input class="form-check-input" type="checkbox" id="near_by_ads" onchange="change_notifications(<?= $this->user_id ?> , this , 'near_by_ads')" <?= ($this->user['near_by_ads']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="near_by_ads"></label>
                  </div>

                </div>
                <div class="d-flex justify-content-between mb-4">
                  <div class="me-2">
                    <h6 class="mb-1">Nearby Radius(kms)</h6>
                  </div>
                  


                  <label class="form-check-label" for="near_by_ads"><?php  echo $this->session->get('nearby_radius') < 1 ? (string)($this->session->get('nearby_radius')*1000).' m' : (string)($this->session->get('nearby_radius')).' km' ?></label>
                  </div>

                </div>
                <div class="d-flex justify-content-between mb-4">
                  <div class="me-2">
                    <h6 class="mb-1">Unread Messages</h6>
                    <p class="fs-sm mb-0">Do you want to recieve notification for Unread messages ?</p>
                  </div>
                  


                   <div class="form-check form-switch">
                   
                    <input class="form-check-input" type="checkbox" id="uread_msg" onchange="change_notifications(<?= $this->user_id ?> , this , 'uread_msg')" <?= ($this->user['uread_msg']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="uread_msg"></label>
                  </div>

                </div>
                <div class="d-flex justify-content-between mb-4">
                  <div class="me-2">
                    <h6 class="mb-1">Added in a Group</h6>
                    <p class="fs-sm mb-0">Do you want to recieve notification for added you in a group ?</p>
                  </div>
                  


                  <div class="form-check form-switch">
                   
                    <input class="form-check-input" type="checkbox" id="group_added" onchange="change_notifications(<?= $this->user_id ?> , this , 'group_added')" <?= ($this->user['group_added']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="group_added"></label>
                  </div>
                  

                </div>
                <div class="d-flex justify-content-between mb-4">
                  <div class="me-2">
                    <h6 class="mb-1">New user joined group</h6>
                    <p class="fs-sm mb-0">Do you want to recieve notification for user joined in your group ?</p>
                  </div>
                  

                  <div class="form-check form-switch">
                   
                    <input class="form-check-input" type="checkbox" id="group_joined" onchange="change_notifications(<?= $this->user_id ?> , this , 'group_joined')" <?= ($this->user['group_joined']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="group_joined"></label>
                  </div>
                  

                </div>
                <div class="d-flex justify-content-between mb-4">
                  <div class="me-2">
                    <h6 class="mb-1">Buyer sent you message</h6>
                    <p class="fs-sm mb-0">Do you want to recieve notification for Buyer send you message for first time ?</p>
                  </div>
                  

                  <div class="form-check form-switch">
                    
                    <input class="form-check-input" type="checkbox" id="buyer_chat" onchange="change_notifications(<?= $this->user_id ?> , this , 'buyer_chat')" <?= ($this->user['buyer_chat']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="buyer_chat"></label>
                  </div>
                  
                  

                </div>
            <!--     <div class="d-flex justify-content-between mb-4">
                  <div class="me-2">
                    <h6 class="mb-1">Auction Notification</h6>
                    <p class="fs-sm mb-0">New bid for your <a href="#">Auctions</a></p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rental-update" checked="">
                    <label class="form-check-label" for="rental-update"></label>
                  </div>
                </div>
                <div class="d-flex justify-content-between mb-4">
                  <div class="me-2">
                    <h6 class="mb-1">Email Notification</h6>
                    <p class="fs-sm mb-0">You can on or off your email notifications here </p>
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rental-recomendation">
                    <label class="form-check-label" for="rental-recomendation"></label>
                  </div>
                </div> -->

            </div>
          </div>
     </div>


        </div>
      </div>

<?php
include_once 'includes/footer.php'; ?>



<script type="text/javascript">

  function change_notifications (id , elem , col) 
  {
      status = 0;
      if ($(elem).is(':checked')) 
      {
        status = 1;
      }
      $.ajax({
      url: '<?= base_url() ?>/User/change_notifications',
      type: 'POST',
      data:{'status' : status , 'user_id' : id , 'col' : col},
      dataType: 'json',
      beforeSend: function() {        
        $.blockUI()
      },
      success : function(res){
        $.unblockUI()
        if (res.status == 1) 
        {
            Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
               
               
            })
           
        }
        
      }
    });
return false;
}


</script>



