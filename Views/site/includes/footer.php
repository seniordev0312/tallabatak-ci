<?php 
      $footer_data = $this->common_model->GetSingleData('admin', array('id'=>1));
      $footer_social = $this->common_model->GetAllData('social_management','','id','desc');
      UpdateActivity($this->user_id);
 ?>

    <!-- Footer-->

    <footer class="footer bg-secondary pt-5">
<!-- <pre><?php print_r(chat_users($this->user_id));  ?></pre> -->
      <div class="container pt-lg-4 pb-4">

        <!-- Links-->

        <div class="row mb-5 pb-md-3 pb-lg-4">

          <div class="col-lg-8 mb-lg-0 mb-4">

            <div class="d-flex flex-sm-row flex-column justify-content-start mx-n2">

              <div class="mb-sm-0 mb-4 px-2 col-md-4"><a class="d-inline-block mb-4" href="#"><img src="<?= base_url() ?>/assets/site/imgs/logo.png" width="116" alt="logo"></a>

                <ul class="nav flex-column mb-sm-4 mb-2">

                  <li class="nav-item mb-2"><a class="nav-link p-0 fw-normal" href="<?= $footer_data['footer_email']; ?>"><i class="fi-mail mt-n1 me-2 align-middle opacity-70"></i><?= $footer_data['footer_email']; ?></a></li>

                  <li class="nav-item"><a class="nav-link p-0 fw-normal" href="tel:<?= $footer_data['footer_phone']; ?>"><i class="fi-device-mobile mt-n1 me-2 align-middle opacity-70"></i><?= $footer_data['footer_phone']; ?></a></li>

                </ul>

               

              </div>

              <div class="mb-sm-0 mb-4 px-2 col-md-4">

                <h4 class="h5">Quick Links</h4>

                <ul class="nav flex-column">

                  <li class="nav-item mb-2"><a class="nav-link p-0 fw-normal" href="#">Home</a></li>
                  <?php $data = $this->common_model->GetSingleData('header_menu','id=1','id','desc');  ?>
                  <?php  if ($data):
                    $category = $this->common_model->GetAllData('category','id in('.$data['menu_items'].')' ,'','')?>
                    <?php if($category) {  ?>
                      <?php foreach($category as $cat) {  ?>
                        <li class="nav-item mb-2"><a class="nav-link p-0 fw-normal" href="<?= base_url('shop/'.slugify($cat['title_eng']).'-'.$cat['id']) ?>" ><?= $cat['title_eng'] ?></a></li>
                  <?php } } ?>
              
                  <?php endif; ?> 
                  

                </ul>

              </div>

              <div class="px-2 col-md-4">

                <h4 class="h5">About</h4>

                <ul class="nav flex-column">

                  <li class="nav-item mb-2"><a class="nav-link p-0 fw-normal" href="#">About Us</a></li>

                  <li class="nav-item mb-2"><a class="nav-link p-0 fw-normal" href="<?= base_url(); ?>/contactus">Contact Us</a></li>

                   <li class="nav-item mb-2"><a class="nav-link p-0 fw-normal" href="<?= base_url(); ?>/privacy">Privacy Policy</a></li>

                   <li class="nav-item mb-2"><a class="nav-link p-0 fw-normal" href="<?= base_url(); ?>/terms">Term Condition</a></li>

                </ul>

              </div>

            </div>

          </div>

          <?php
            if($footer_social){
          ?>

          <div class="col-xl-4 col-lg-4">

            <h4 class="h5">Follow Us</h4>

             <div class="pt-2">
              <?php 
                foreach ($footer_social as $key => $value) {
              ?>
                 <a class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle me-2 mb-2" href="<?= $value['link']; ?>"><img width="80px" src="<?= base_url($value['image']) ?>"></a>
              <?php
                }
              ?>
             

            </div>

          </div>
<?php } ?>
        </div>

        <!-- Banner-->

        <div class="text-center fs-sm pt-4 mt-3 pb-2">&copy; All rights reserved. Made by <a href='#' class='d-inline-block nav-link p-0' target='_blank' rel='noopener'>Webwiders softwere solutions</a></div>

      </div>

    </footer>



<div class="modal fade" id="modalScroll" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content" style="max-height: inherit; overflow: unset;">
      <div class="modal-header">
        <h4 class="h5 modal-title">Create New Group</h4>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="#" onsubmit="return do_create_group(event , this)" id="do_create_group">
        <div class="modal-body fs-sm">
          <div class="mb-3">
            <div class="mb-3">
              <label class="form-label fw-bold fs-sm" for="ap-title">Group Name<span class="text-danger">*</span></label>
              <input class="form-control form-control-sm" type="text" id="ap-title" name="group_name" placeholder="Enter group name" value="" required="">
            </div>
            <div class="mb-3">
              <label for="country">Country</label>
              <select class="form-control country-dropdown" name="country" id="" data-id="" data-selected="0">
              <option value="">Select Country</option>
                <?php
               $countries = $this->common_model->GetAllData('countries' , '' , 'name' , 'asc');
                foreach($countries as $row) {
                ?>
                    <option value="<?php echo $row['id'];?>"><?php echo $row["name"];?></option>
                <?php
                }
                ?>
                 
              </select>
            </div>
            <div class="mb-3">
              <label for="state">State</label>
              <select class="form-control state-dropdown" data-id="" data-selected="0" name="state" id="state-dropdown">
                 
              </select>
            </div>                        

            <div class="mb-3">
              <label for="city">City</label>
              <select class="form-control" name="city" id="city-dropdown">
                 
              </select>
            </div>
            <ui class="contacts" style="height: 300px;display: block;overflow-y: scroll;">
            <?php $allUsers = $this->common_model->GetAllData('users' , array('status' => 1 , 'id !=' => $this->user_id) , 'name' , 'asc'); ?>
            <li name="members"></li>
            <?php if ($allUsers): ?>
              <?php foreach ($allUsers as $key => $value): ?>
              <li class="active" >
                <label class="d-flex align-items-center justify-content-between">
                  <div class="d-flex bd-highlight">
                    <div class="img_cont">
                      <img src="<?= base_url($value['image']) ?>" class="rounded-circle user_img">
                      <?= ($value['active_status'] == 1) ? '<span class="online_icon"></span>' : '<span class="online_icon offline"></span> ' ?>
                    </div>
                    <div class="user_info">
                      <span><?= $value['name'] ?></span>
                      <p><?= $value['name'] ?> is <?= ($value['active_status'] == 1) ? 'Online' : 'Offline' ?></p>
                    </div>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" name="members[]" value="<?= $value['id'] ?>" id="form-check-<?= $value['id'] ?>" type="checkbox">
                  </div>
                </label>
              </li>
              <?php endforeach ?>
            <?php endif ?>
            
            </ui>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm"  data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-shadow btn-sm do_create_group_btn">Create Group</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modalGroupinfo" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable" role="document" id="group_info">
    
  </div>
</div>

<div class="modal fade" id="modalEditGroupinfo" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable" role="document" id="edit_group_info">
    
  </div>
</div>

     <div class="chat_list">

       <div class="chat">

            <div class="card mb-sm-3 mb-md-0 contacts_card">

          <div class="card-header pb-0">

            <div class="d-flex align-items-center justify-content-between mb-3">
              <label class="fs-base">Chats</label>
              <div>
                
                <?php if ($this->user): ?>
                  <?php if (check_subscription($this->user_id , true)['active']): ?>
                    
                    <button class="btn btn-xs btn-primary" data-bs-toggle="modal" data-bs-target="#modalScroll" ><i data-bs-toggle="tooltip" data-bs-placement="top" title="Create groups" class="fi-edit"></i> </button>
                  <?php endif ?>
                <?php endif ?>
              
                <a class="btn btn-xs btn-primary" href="<?= base_url('groups') ?> "  data-bs-toggle="tooltip" data-bs-placement="top" title="Search groups" ><i class="fi-search"></i> </a>
              </div>
              

            </div>

            <!-- <div class="input-group">

              <input type="text" placeholder="Search..." name="" class="form-control search">

              <div class="input-group-prepend">

                <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>

              </div>

            </div> -->

          </div>

          <div class="card-body contacts_body">



            <ul class="nav nav-tabs mb-0 chat_tabs" role="tablist">

              <li class="nav-item">

                <a href="#chats" class="nav-link active" data-bs-toggle="tab" role="tab" >

                  Chats

                </a>

              </li>

              <li class="nav-item">

                <a href="#groups" class="nav-link" data-bs-toggle="tab" role="tab" onclick="refresh_chat_users(1)">

                  Groups

                </a>

              </li>
              

            </ul>

            <hr class="hr mb-2">



            <div class="tab-content">

              <div class="tab-pane fade show active" id="chats" role="tabpanel">

                <ul class="contacts contacts_open" id="chat_users"></ul>

              </div>

              <div class="tab-pane fade" id="groups" role="tabpanel">

                <ui class="contacts contacts_open" id="group_users">

                </ui>

              </div>

            </div>







          </div>

        </div>

        </div>

     </div>
<!-- add coupon -->
<div class="modal" id="myModal">                 
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
  
    <!-- Modal Header -->
     <div class="modal-header bg-light p-3">
      <h4 class="modal-title">Add Coupon</h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>
    
    <!-- Modal body -->
    <form id="add_coupon" method="post" action="#" onsubmit="return add_coupon()" >
         <div class="modal-body">
        <div class="col-md-12 py-3">
            <?php
                    $id = $this->session->has('user_id');
                    $partOne =  substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);    
                    $partTwo =  substr(str_shuffle("0123456789"), 0, 3);  
                    $coupon_code = $partOne.$partTwo;
                    $userData = false;
                    if($this->session->has('user_id')){
                       $groupData = $this->common_model->GetAllData('groups',array('create_by'=>$id),'id','asc');
                       $userData = array();
                       
                       if($groupData)
                       {
                         foreach($groupData as $key => $groupUser)
                         {
                          
                            $group_id = explode(',',$groupUser['members']);
                            $arr_id = array_merge($userData,$group_id);
                            //array_push($userData,$group_id);*/
                          }

                         $groups_ids = implode(',',$arr_id);
                         $userData =  $this->common_model->GetAllData('users',"id IN(".$groups_ids.")",'id','desc');
                       }
                    }
              
              // print_r($userData);
              
            ?>
            <div>
                <label>Coupon Code</label>
                <input type="text" class="form-control"  name="coupon_code"  placeholder="Coupon Code" value="<?= $coupon_code; ?>" readonly>
            </div>

            <div>
                <label>Title</label>
                <input type="text" class="form-control"  name="title"  placeholder="Title" required>
            </div>
            <div>
                <label>Description</label>
                <textarea class="form-control"  name="description"  placeholder="Description" required></textarea> 
            </div>
            <div>
                <label>Price</label>
                <input type="number" min="1" class="form-control"  name="price"  placeholder="Price" required>
            </div>
            <div>
                <label>Offer(%)</label>
                <input type="number" min="1" class="form-control"  name="coupon_off"  placeholder="Offer" required>
            </div>
            <div>
                <label>Number Of Units</label>
                <input type="number" min="1" class="form-control"  name="no_unit"  placeholder="Number Of unit" required>
            </div>
            <div>
                <label>Image</label>
                <input type="file" class="form-control"  name="image" accept="image/*" required>
            </div>
           
            <div>
                <label>Expiry Date</label>
                <input type="date" class="form-control"  name="end_date" id="end_date" required>
            </div>
            <div>
                <input type="checkbox" data-bs-toggle="modal" data-bs-target="#my_group_users"> 
                <label>Invite By Group</label><br>
                <input type="checkbox" data-bs-toggle="modal" data-bs-target="#my_group_users_near">
                <label>Invite By Near By User</label><br>
            </div>
          <div class="mt-3 text-center">
              <button type="submit" id="add_btn"  class="btn btn-success">Add</button>
            </div>
           </div>
           
        </div>
    </form>
    
    
  </div>
</div>
</div>


<!-- add coupon -->


<!-- <div class="modal" id="my_group_users">                 
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
  
    
     <div class="modal-header bg-light p-3">
      <h4 class="modal-title">Group Users</h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>
    
    
    <form id="add_user" method="post" action="#" onsubmit="return add_user()" >
         <div class="modal-body">
        <div class="col-md-12 py-3">
          <div>
                <label>Group Users</label>
                <select class="form-control user_page" required="" name="group_user[]" multiple="">
                 
                </select>
            </div>
            <div class="mt-3 text-center">
              <button type="submit" id="add_btn"  class="btn btn-success">Save</button>
            </div>
           </div>
           
        </div>
    </form>
    
    
  </div>
</div>
</div>



<div class="modal" id="my_group_users_near">                 
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
  
    
     <div class="modal-header bg-light p-3">
      <h4 class="modal-title">Group Users Near By</h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>
    
    
    <form id="add_coupon" method="post" action="#" onsubmit="return add_coupon()" >
         <div class="modal-body">
        <div class="col-md-12 py-3">
          <div>
                <label>Users Near By</label>
                <select class="form-control user_page" required="" name="group_user[]" multiple="">
                  <option>1</option>
                  <option>1</option>
                  <option>1</option>
                  <option>1</option>
                </select>
            </div>
            <div class="mt-3 text-center">
              <button type="submit" id="add_btn"  class="btn btn-success">Save</button>
            </div>
           </div>
           
        </div>
    </form>
    
    
  </div>
</div>
</div> -->





    <div class="chat_tab" id="chat_tab"></div>



    <!-- Back to top button-->
<?php if ($this->user): ?>
   <a class="btn btn-primary btn_chat btn_chatt" href="javascript:void(0);" onclick="refresh_chat_users()" >
<?php else: ?>
  <a class="btn btn-primary btn_chat" href="#signin-modal" data-bs-toggle="modal" >
<?php endif ?>
    

     

      <i class="fi-chat-circle"></i> <span class="fs-sm">Chat</span>

    </a>



    <a class="btn-scroll-top" href="#top" data-scroll>

      <!-- <span class="btn-scroll-top-tooltip text-muted fs-sm me-2">Top</span> -->

      <i class="btn-scroll-top-icon fi-chevron-up"></i>

    </a>

    <!-- Vendor scrits: js libraries and plugins-->

    <script src="<?= base_url() ?>/assets/site/js/bootstrap.bundle.min.js"></script>

    <script src="<?= base_url() ?>/assets/site/js/simplebar.min.js"></script>

    <script src="<?= base_url() ?>/assets/site/js/smooth-scroll.polyfills.min.js"></script>

    <script src="<?= base_url() ?>/assets/site/js/nouislider.min.js"></script>

    <script src="<?= base_url() ?>/assets/site/js/tiny-slider.js"></script>

    <!-- Main theme script-->

    <script src="<?= base_url() ?>/assets/site/js/theme.min.js"></script>

    <script src="<?= base_url() ?>/assets/site/js/filepond.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.toaster.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.10.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.10.0/firebase-messaging-compat.js"></script>
    <script type="module" src="<?= base_url() ?>/firebase_test/notification.js"></script>
    
    <link href="<?= base_url() ?>/assets/site/vendor/emoji-picker/lib/css/emoji.css" rel="stylesheet"> 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.user_page').select2();
});
</script>
    
    <script type="text/javascript">
      $(document).on('click' , '.close_chat' , function(){


          $('.chat_tab').removeClass('active');

          $('.chat_tab').removeClass('right');

        });
      


      $(document).ready(function(){

        $('#chat_open').click(function(){

          $('.chat_tab').addClass('active');

        });

      });



      $(document).ready(function(){

        $('.contacts_open li').click(function(){

          $('.chat_tab').addClass('active right');

        });

        $('.btn_chatt').click(function(){

          $('.chat_list').toggleClass('active');

        });

      });



      $(document).ready(function(){

        $('.chat_open_nw').click(function(){

          $('.chat_tab').addClass('active');

        });

      });

    </script>



    <script type="text/javascript">

      $(document).ready(function(){

        $('#auction').change(function(){

        if(this.checked) 

        $('#auction_show').fadeIn('slow');

        else

        $('#auction_show').fadeOut('slow');



        });

        });

    </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" ></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"  />
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="module">

  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-app.js";
  import { getMessaging, getToken , onMessage  } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-messaging.js";
    import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.10.0/firebase-analytics.js";
 const firebaseConfig = {
    apiKey: "AIzaSyCVm8L87Qf07vxqRHBQF-1dgkGgFWIM5yM",
    authDomain: "tekhalini-e22e7.firebaseapp.com",
    projectId: "tekhalini-e22e7",
    storageBucket: "tekhalini-e22e7.appspot.com",
    messagingSenderId: "160721044724",
    appId: "1:160721044724:web:df656f1a35ed0f5b048aa1",
    measurementId: "G-NG7GX8TRGS"
  };
  const app = initializeApp(firebaseConfig);

      const messaging = getMessaging(app);
      
function requestPermission() {
  console.log("Requesting permission...");
  Notification.requestPermission().then((permission) => {
    if (permission === "granted") {
      console.log("Notification permission granted.");
      
     
      getToken(messaging, {
        vapidKey:
          "BC74TcehJDo1n9fc_ANgnaygD3HbtjObZAojnSR9GCSvDKSSpdc5hPZikfCcpru7A11QU7qM2FhGudKoTP2Wq10",
      }).then((currentToken) => {
        if (currentToken) {
          console.log("currentToken: ", currentToken);
          device_id = currentToken;
          updateDeviceId(currentToken);
          localStorage.setItem("device_id",currentToken);
          //$('body').html(currentToken)
        } else {
          console.log("Can not get token");
        }
      });
    } else {
      console.log("Do not have permission!");
    }

  });
  
 

}

function updateDeviceId(device_id){
  //alert(device_id);
  $.ajax({
       url: '<?= base_url('home/update_device_id') ?>',
       type: 'post',
       data: {'device_id' : device_id},
       dataType: 'json',
       success: function (data) {
        console.log('device_id updated',data)
       }
     });
}

requestPermission();

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('firebase-messaging-sw.js');
}


      onMessage(messaging, (payload) => {
    console.log("Message received. ", JSON.stringify(payload));
  
  
  });
</script>

<script type="text/javascript">
  var playing = false;
function googleTranslateElementInit() {
  lang = $('html').attr('lang');
  new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: "ar,en"}, 'google_translate_element');
}

function changeLanguage(lang) {
  var selectField = document.querySelector("#google_translate_element select");
  for(var i=0; i < selectField.children.length; i++){
    var option = selectField.children[i];
    // find desired langauge and change the former language of the hidden selection-field 
    if(option.value==lang){
       selectField.selectedIndex = i;
       // trigger change event afterwards to make google-lib translate this side
       selectField.dispatchEvent(new Event('change'));
       break;
    }
  }
}

$(function () {
  //$('body').hide();
  setTimeout(function() {
    lang = $('html').attr('lang');
    changeLanguage(lang);    
    change_lang(lang);
  }, 2000);
  

});
$(document).on('change', '.goog-te-combo' , function () {
  lang = $(this).val();
  change_lang(lang);
});

function change_lang(lang) {
  if (lang == 'ar') 
  {
    $('html').attr('dir' , 'rtl');
    $('#rtl_css').attr('href' , 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css');
  }
  else
  {
    $('html').attr('dir' , 'ltr');
    $('#rtl_css').attr('href' , '');
  }
  
}
</script>

<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script>
  function do_login(e) 
  {
    e.preventDefault();
      $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/Login/do_login',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#do_login')[0]),
      dataType: 'json',
      beforeSend: function() {        
        $('#sub_btn').prop('disabled' , true);
        $('#sub_btn').text('Processing..');
      },
      success : function(res){
        $('#sub_btn').prop('disabled' , false);
        $('#sub_btn').text('Sign In');
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
        else if(res.status == 2)
        {
          for (var err in res.message) {
            
            $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
          }
        }
        else
        {
          $('#login_error').html(res.message);
        }
      }
    });
return false;
}
</script>
<script>
  function do_signup (e) 
  {
    e.preventDefault();
      $('.alert-danger').remove();
      form = $('#do_signup')[0];
      if (form.checkValidity() === false){
        // This is the magic function that displays the validation errors to the user
        form.reportValidity();   
        return; 
    }
      $.ajax({
      url: '<?= base_url() ?>/Signup/do_signup',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#do_signup')[0]),
      dataType: 'json',
      beforeSend: function() {        
        $('#signup_btn').prop('disabled' , true);
        $('#signup_btn').text('Processing..');
      },
      success : function(res){
        $('#signup_btn').prop('disabled' , false);
        $('#signup_btn').text('Sign Up');
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

 function do_forgot(e) 
  {
    e.preventDefault();
      $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/Login/do_forgot',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#do_forgot')[0]),
      dataType: 'json',
      beforeSend: function() {        
        $('#do_forgot_btn').prop('disabled' , true);
        $('#do_forgot_btn').text('Processing..');
      },
      success : function(res){
        $('#do_forgot_btn').prop('disabled' , false);
        $('#do_forgot_btn').text('Reset');
        if (res.status == 1) 
        {
            Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
                window.location.href = res.redirect
            })
           
        }
        else if(res.status == 2)
        {
          for (var err in res.message) {
            
            $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
          }
        }
        else
        {
          Swal.fire({
               title: "Error", 
               text: res.message, 
               icon: "error"
             }).then(function (result) {
              window.location.href = res.redirect
            })
        }
      }
    });
return false;
}  

<?php if ($this->session->getFlashdata('success')): ?>
   Swal.fire({
               title: "Success", 
               text: '<?= $this->session->getFlashdata('success') ?>', 
               icon: "success"
             }).then(function (result) {
            
            })
<?php endif ?>

<?php if ($this->session->getFlashdata('error')): ?>
   Swal.fire({
               title: "Oops", 
               text: '<?= $this->session->getFlashdata('error') ?>', 
               icon: "error"
             }).then(function (result) {
            
            })
<?php endif ?>
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABk-0Al27H9Ap_Rtti2t0ePxOLvl5QFzk&libraries=places&callback=initMaps" async defer></script>
<script type="text/javascript">
var selected = false;
function initMaps() 
{
    //var input = document.getElementById('address');
    var input = document.getElementById('signup_address');

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
        $('#signup_city').val(city)
        $('#signup_state').val(state)
        $('#signup_country').val(country)
        $('#signup_zipcode').val(zipcode)
        $('#signup_lat').val(lat)
        $('#signup_lng').val(lng)
     } 
     else 
     {
         window.alert('No results found');
     }
  });
   

 
}
// $('#signup_address').on('focus', function() {
//   selected = false;
//   }).on('blur', function() {
//     if (!selected) {
//       $(this).val('');
//     }
//   });
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/1.0.12/push.min.js"></script>
  <script type="text/javascript"> 

function onGranted(){console.log('onGranted'); showPushNotifi();};
function onDenied(){console.log('onDenied');};
//setInterval(function(){ showPushNotifi() }, 7000);
 if(Push.Permission.has())
 {
    
    showPushNotifi()
 }
 else
 {
    Push.Permission.request(onGranted, onDenied);
 }
    function showPushNotifi()
    {
        <?php if($this->user_id ){ 
 
         $user_id = $this->user_id;

         ?>
       
         $.ajax({
            url: '<?php echo base_url();?>/Home/GetPushmsg',
            type: 'post',
            dataType: 'JSON',
            success: function(response){ 
              //console.log(response);
             $.each(response.notifi, function(i, item) {
                //alert(item.msg);
                //console.log(item)
                Push.create("New Notification !", {
              body: item.message,
              icon: '<?= base_url() ?>/assets/images/message.png',
              
              onClick: function () {
               //location.reload();
                  this.close();
              }
          });
            }); 
             

            //  $('#result').delay(6000).fadeOut('slow');
           // location.reload(true);
            }
           });


         <?php }else { ?>
           console.log('user not logged in')
        <?php } ?>

    }

$('.comming_soon').on('click' , function(){
  alert('comming soon')
})
 
</script> 
<script type="text/javascript" id="add_to_fav_script_js">
     function addToFav(id , type='post') {
      //alert(id);
      var formData = new FormData();
      formData.append('post_id', id);
      formData.append('post_type', type);
      $.ajax({
        url: "<?php echo base_url('Home/add_to_fav');?>",
        method: "POST",
        data: formData,
        datatype:'json',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $.blockUI();
        },
        success: function (data) {
          $.unblockUI();
           obj = JSON.parse(data);
           //console.log(data);
          if (obj.status == 1)
          {
            $('.post_heart_'+id).addClass('fa-heart')
            $('.post_heart_'+id).removeClass('fa-heart-o')
            toastr['success'](obj.msg, 'Success!!', {
                    closeButton: true,
                    positionClass: 'toast-top-right',
                    progressBar: true,
                    newestOnTop: true,
                });
          }
          else if(obj.status == 0)
          {
            $('.post_heart_'+id).addClass('fa-heart-o')
            $('.post_heart_'+id).removeClass('fa-heart')
              toastr['success'](obj.msg, 'Success!!', {
                    closeButton: true,
                    positionClass: 'toast-top-right',
                    progressBar: true,
                    newestOnTop: true,
                });
          }
          else{
               $.unblockUI();
              toastr['error'](obj.msg, 'Oops..!!', {
                      closeButton: true,
                      positionClass: 'toast-top-right',
                      progressBar: true,
                      newestOnTop: true,
                  });
              //window.location.href = '<?php echo base_url('login'); ?>';
          }
          
        }
      });
    }
 </script>
 <script src="<?= base_url() ?>/assets/site/vendor/emoji-picker/lib/js/config.js"></script>
    <script src="<?= base_url() ?>/assets/site/vendor/emoji-picker/lib/js/util.js"></script>
    <script src="<?= base_url() ?>/assets/site/vendor/emoji-picker/lib/js/jquery.emojiarea.js"></script>
    <script src="<?= base_url() ?>/assets/site/vendor/emoji-picker/lib/js/emoji-picker.js"></script>
    <script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
<script type="text/javascript">
  var active_client_id = 0;
  var active_is_group = 0;
  let scroll_to_bottom = '';
  function open_chat(client_id , open=0 , is_group=0) 
  {
    if (is_group != 0 ) {is_group = client_id}
    $.ajax({
        url: '<?= base_url('Chat/ajax_chat_between_users') ?>',
        type: 'post',
        data: {'client_id':client_id , 'open':open , 'is_group':is_group},
        success: function (data) 
        {
          active_client_id = client_id;
          active_is_group = is_group;
          if (open == true) 
          {
            $('#chat_tab').html(data)
            audio_element_load()

          }
          else
          {
            $('.chat_messages').html(data)
          }
          
          
          scroll_to_bottom = document.getElementById('card-body');
          scrollBottom(scroll_to_bottom);
          window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: '<?= base_url() ?>/assets/site/vendor/emoji-picker/lib/img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
       
        window.emojiPicker.discover();
          if(open)
          {
            $('.chat_tab').addClass('right');
            $('.chat_tab').addClass('active');
          }
          $('.emoji-wysiwyg-editor').keypress(function(e){
            if(e.which === 13)
            {
              $('.emoji-wysiwyg-editor').blur();
              if ($('.emoji-wysiwyg-editor').text() != '') {
                $('#send_btn_chat').click();
              }
              
            }
               

         });
          
        }
      });
  }
  <?php if ($this->user_id): ?>
    setInterval(function()
   {
    if (playing) 
        {
          return false;
        }
    if ("geolocation" in navigator)
    {
        navigator.geolocation.getCurrentPosition(function(position)
        { 
          console.log("Found your location \nLat : "+position.coords.latitude+" \nLang :"+ position.coords.longitude);
          //UpdateLocation(position.coords.latitude , position.coords.longitude)
        });
    }

    //showPushNotifi()
     //alert(active_client_id)
     if($('.chat_list').hasClass('active'))
     {
         refresh_chat_users()
         refresh_chat_users(is_group =1)
        if (document.activeElement != document.getElementById("chat_message_input")) 
        {
          if(active_client_id != 0)
          {
            
            open_chat(active_client_id , 0 , active_is_group);
          }
          
        }
     }
     
  } , 10000);
    
  <?php endif ?>
  
  function send_message(client_id , is_file=false) 
  {

    message = $('#chat_message_input').val();
    chat_file = $('#chat_file').val();
    is_group = $('#is_group').val();
    fd = new FormData($('#send_chat_form')[0]);
   if (is_file) 
   {
      var filename = new Date().toISOString();
      fd.append("audio_data", is_file, filename);
   }
    if(message.trim() == '' && chat_file.trim() == '' && is_file == false)
    {
      toastr['error']('Please type a msg', 'Oops..!!', {
                      closeButton: true,
                      positionClass: 'toast-top-right',
                      progressBar: true,
                      newestOnTop: true,
                  });
      return false;
    }
    $.ajax({
        url: '<?= base_url('Chat/ajax_send_message') ?>',
        type: 'post',
        processData: false,
        contentType: false,
        data: fd,
         beforeSend: function() {        
        $('#chat_message_input').val('')
           $('#chat_file').val('')
          $('.emoji-wysiwyg-editor').text('')
      },
        success: function (data) 
        {
          
          open_chat(client_id , 0 , is_group);
          return true;
        
        }
      });
  }
  
 
    function scrollBottom(element) {
      element.scroll({ top: element.scrollHeight})
    }
function refresh_chat_users(is_group=0)
{
  $.ajax({
        url: '<?= base_url('Chat/ajax_chat_users') ?>',
        type: 'post',
        data: {'is_group':is_group},
        success: function (data) 
        {
          if (is_group) 
          {
            $('#group_users').html(data)
            
          }
          else
          {
            $('#chat_users').html(data)
           
          }
          
        }
      });
}
</script>
<script type="text/javascript" id="group_js">
  
  function do_create_group (e , elem) 
  {
    btn_text = $(elem).find('.do_create_group_btn').text();
    e.preventDefault();
      $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/Chat/ajax_create_group',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($(elem)[0]),
      dataType: 'json',
      beforeSend: function() {        
        $(elem).find('.do_create_group_btn').prop('disabled' , true);
        $(elem).find('.do_create_group_btn').text('Processing..');
      },
      success : function(res){
        $(elem).find('.do_create_group_btn').prop('disabled' , false);
        $(elem).find('.do_create_group_btn').text(btn_text);
        if (res.status == 1) 
        {
            Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) 
             {
                open_chat(res.group_id , 1 , 1);
                $('#modalScroll').modal('hide')
                $('#modalEditGroupinfo').modal('hide')
                $('#modalGroupinfo').modal('hide')
                
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

function open_group_chat(group_id )
{
    open_chat(group_id , 1 , 1);
    $('#modalScroll').modal('hide')
    $('#modalEditGroupinfo').modal('hide')
    $('#modalGroupinfo').modal('hide')
}
function get_group_info(group_id , join=0)
{
  $.ajax({
        url: '<?= base_url('Chat/ajax_group_info') ?>',
        type: 'post',
        data: {'group_id':group_id , 'join':join},
        success: function (data) 
        {
            $('#group_info').html(data) 
            $('#modalGroupinfo').modal('show')
        }
      });
}
function open_edit_group(group_id )
{
  $.ajax({
        url: '<?= base_url('Chat/ajax_edit_group_info') ?>',
        type: 'post',
        data: {'group_id':group_id },
        success: function (data) 
        {
            $('#edit_group_info').html(data) 
            $('.country-dropdown').trigger('change');
            
            $('#modalEditGroupinfo').modal('show')
        }
      });
}
function remove_user_from_group(user_id , group_id,is_delete=0 )
{
  $.ajax({
        url: '<?= base_url('Chat/ajax_remove_user_from_group') ?>',
        type: 'post',
        data: {'group_id':group_id , 'user_id':user_id},
        dataType: 'json',
        success: function (data) 
        {
          Swal.fire({
               title: "Success", 
               text: data.message, 
               icon: "success"
             }).then(function (result) 
             {
                refresh_chat_users(1)
                $('#modalGroupinfo').modal('hide')
                $('#chat_tab').removeClass('active')
            })
            
        }
      });
}
function join_user_in_group(user_id , group_id )
{
  $.ajax({
        url: '<?= base_url('Chat/ajax_join_user_in_group') ?>',
        type: 'post',
        data: {'group_id':group_id , 'user_id':user_id},
        dataType: 'json',
        success: function (data) 
        {
          Swal.fire({
               title: "Success", 
               text: data.message, 
               icon: "success"
             }).then(function (result) 
             {
                refresh_chat_users(1)
                $('#modalGroupinfo').modal('hide')
                $('#chat_tab').removeClass('active')
                open_chat(group_id , 1 , 1)
            })
            
        }
      });
}

</script>
<script>
$(document).ready(function() {
    $(document).on('change' , '.country-dropdown' , function() {
            var id = $(this).data('id');
            var selected = $(this).data('selected');
            var country_id = this.value;
            $.ajax({
                url: "<?= base_url('Home/states_by_country') ?>",
                type: "POST",
                data: {
                    country_id: country_id,
                    selected : selected
                },
                cache: false,
                success: function(result){
                    $("#state-dropdown"+id).html(result);
                    $('#state-dropdown'+id).trigger('change');
                    $('#city-dropdown'+id).html('<option value="">Select State First</option>'); 
                }
            });
         
         
    });    
 
   $(document).on('change' , '.state-dropdown' , function() {
            var state_id = this.value;
            var id = $(this).data('id');
            var selected = $(this).data('selected');
            $.ajax({
                url: "<?= base_url('Home/cities_by_states') ?>",
                type: "POST",
                data: {
                    state_id: state_id,
                    selected : selected
                },
                cache: false,
                success: function(result){
                    $("#city-dropdown"+id).html(result);
                }
            });
         
         
    });
    
     $('#f-search').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });
    if($('#pr-position')[0]){
    document.getElementById('pr-position').addEventListener("keypress", function(event){
      if (event.key === "Enter") {
        
        event.preventDefault();
        
        search_filter('keyword');
      }
    });
    }
});
</script>
<script type="text/javascript" id="search_js">
  function search_filter(filter)
  {
    if (filter == 'category') {
      window.location.href = $('#search_category').val();
    }
    if (filter == 'keyword') {
      keyword = $('#pr-position').val()
      window.location.href = '<?= base_url('shop') ?>?keyword='+keyword
    }
  }
</script>
<?php if ($this->session->getFlashdata('toast_success')): ?>
  <script type="text/javascript">
        $.toaster({ priority : 'success', title : 'Success', message : '<?= $this->session->getFlashdata('toast_success') ?>' });
  </script>
<?php endif ?>
<?php if ($this->session->getFlashdata('toast_error')): ?>
  <script type="text/javascript">
        $.toaster({ priority : 'danger', title : 'Notice', message : '<?= $this->session->getFlashdata('toast_error') ?>' });
  </script>
<?php endif ?>
  </body>
<script type="text/javascript" id="send_audio_js">
  //webkitURL is deprecated but nevertheless
   URL = window.URL || window.webkitURL;
var gumStream;
//stream from getUserMedia() 
var rec;
//Recorder.js object 
var input;
//MediaStreamAudioSourceNode we'll be recording 
// shim for AudioContext when it's not avb. 
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext = new AudioContext;
//new audio context to help us record  
  function audio_element_load() 
  {
   
var recordButton = document.getElementById("recordButton");
var stopButton = document.getElementById("stopButton");
var stopButtonContainer = document.getElementById("stopButtonContainer");
//var pauseButton = document.getElementById("pauseButton");
//add events to those 3 buttons 
recordButton.addEventListener("click", startRecording);
stopButton.addEventListener("click", stopRecording);
//pauseButton.addEventListener("click", pauseRecording);
/* Simple constraints object, for more advanced audio features see

https://addpipe.com/blog/audio-constraints-getusermedia/ */

var constraints = {
    audio: true,
    video: false
} 
/* Disable the record button until we get a success or fail from getUserMedia() */

recordButton.disabled = true;
stopButton.disabled = false;
stopButtonContainer.style.display = "none";

/* We're using the standard promise based getUserMedia()

https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia */
 navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
    console.log("getUserMedia() success, stream created, initializing Recorder.js ..."); 
    /* assign to gumStream for later use */
    gumStream = stream;
    recordButton.disabled = false;
    stopButton.disabled = true;

    /* use the stream */
    input = audioContext.createMediaStreamSource(stream);
    /* Create the Recorder object and configure to record mono sound (1 channel) Recording 2 channels will double the file size */
    rec = new Recorder(input, {
        numChannels: 1
    }) 
    //start the recording process 
    
}).catch(function(err) {
    //enable the record button if getUserMedia() fails 
    recordButton.disabled = true;
    stopButton.disabled = false;
   
});
function startRecording() 
{ 
  recordButton.disabled = true;
  playing = true;
  stopButton.disabled = false;
  recordButton.style.display = "none";
  stopButtonContainer.style.display = "unset";
  rec.record()
  console.log("Recording started");
}

function stopRecording() {
    console.log("stopButton clicked");

    //disable the stop button, enable the record too allow for new recordings 
    stopButton.disabled = true;
    recordButton.disabled = false;
   recordButton.style.display = "unset";
   stopButtonContainer.style.display = "none";
    //reset button just in case the recording is stopped while paused 
   
    //tell the recorder to stop the recording 
    rec.stop(); //stop microphone access 
    gumStream.getAudioTracks()[0].stop();
    //create the wav blob and pass it on to createDownloadLink 
    rec.exportWAV(createDownloadLink);
}
async function  createDownloadLink(blob) {
  
    await send_message(active_client_id , blob);
    playing = false;
}
  }
$("audio").on({
    play:function(){ // the audio is playing!
        playing = true;
    },
    pause:function(){ // the audio is paused!
       playing = false
    },
})




</script>
<script type="text/javascript" id="notification">
  function markAsRead1(id , other) {

    $.ajax({
          url: '<?= base_url() ?>/Home/markAsRead',
          type: 'POST',
          cache:false,
          data:{'user_id':id},
          dataType: 'html',
          beforeSend: function() {
          },
          success : function(res){
            if (other) {
              url = other.click_action
              screen = other.screen
              id = other.id
              if(screen == 'chat')
              {
                open_chat(id , 1)
              }
            }
            else
            {
              url = "#";
            }

            if (url != '#') {
               window.location.href = url
            }
            
            
          }
        });

}
$('.timeline-panel').on('click' , function(){
    other = $(this).find('a').data('other')
    id = $(this).find('a').data('id')
    console.log(other);

    markAsRead1(id , other)
})
</script>
</script>

<script type="text/javascript">
    $("#start_date").change(function(){
        //alert('alert');
          var val = $(this).val();
          $('#end_date').val('');
          $('#end_date').attr('min',val);
        });
</script>
<script>
   $(document).ready(function() {
    $('#example23').DataTable( {
        
        paging:true,
        select: false,
        info: true,         
        lengthChange:true ,
        language: {
            paginate: {
              previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
              next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>' 
            }
          },
  
    } );
} );

function blockui(action='show') {
          if (action == 'show') 
          {
            $.blockUI({message:'<div class="spinner-border text-primary" role="status"></div>',css:{backgroundColor:"transparent",border:"0"},overlayCSS:{backgroundColor:"#fff",opacity:.8}})
          }
          else
          {
             $.unblockUI()
          }
        }
    
</script>
<script>
        $(document).ready(function () {
          
            $('#country-dd').on('change', function () {
                var idCountry = $(this).find('option:selected').data('id');
                if (!idCountry) {
                  idCountry = 0;
                }
                $("#state-dd").html('');
                $("#state-dd-div").show();
                 blockui()
                $.ajax({
                    url: "<?= base_url('DropdownController/fetchState') ?>",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                       
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#state-dd').html('<option value="">Select State</option>');
                        $.each(res.states, function (key, value) {
                            $("#state-dd").append('<option data-id="' + value
                                .id + '" value="' + value
                                .name + '">' + value.name + '</option>');
                        });
                         blockui('hide')
                    }
                });
            });

            $('#state-dd').on('change', function () {
                var idstate = $(this).find('option:selected').data('id');
                if (!idstate) {
                  idstate = 0;
                }
                $("#city-dd").html('');
                 $("#city-dd-div").show();
                 blockui()
                $.ajax({
                    url: "<?= base_url('DropdownController/fetchCity') ?>",
                    type: "POST",
                    data: {
                        state_id: idstate,
                        
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#city-dd').html('<option value="">Select City</option>');
                        $.each(res.cities, function (key, value) {
                            $("#city-dd").append('<option data-id="' + value
                                .id + '" value="' + value
                                .name + '">' + value.name + '</option>');
                        });
                         blockui('hide')
                    }
                });
            });
        });
    </script>
</html>