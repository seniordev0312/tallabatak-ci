<?php include ('includes/header.php') ?>
<style type="text/css">
  header , footer , .btn_chat
  {
    display: none!important;
  }
</style>
<div class="login-page">
	<div class="container main">
   
	<section class="wrapper bg-transparent middle login-middle">
      <div class="container pb-14 pb-md-16">
        <div class="row">
          <div class="col-lg-7 col-xl-6 col-xxl-5 mx-auto mt-n20">
            <div class="card card_login" data-aos="zoom-in-down" data-aos-offset="400">
              <div class="card-body p-11 text-center">
                <img src="<?= base_url('assets/site/imgs/logo.png') ?>" class="mt-3 mb-3" width="200">
                <h2 class="mb-2 text-start">Change Password</h2>
                <p class=" mb-4 text-start">Enter a new password for <?= $user['email'] ?></p>			
                 <form class="text-end mb-3 form_login" action="#" id="do_reset" method="post" onsubmit="return do_reset(event)">
                  <div class="mb-4 text-left">
					          <label>New Password</label>
                    <input type="password" class="form-control" name="password">
                    <input type="hidden" name="token" value="<?= $token ?>">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                  </div>
                  <div class="mb-4 text-left">
                    <label>Confirm New Password</label>
                    <input type="password" class="form-control" name="cpassword">
                  </div> 
                  <button type="submit" id="do_reset_btn" class="btn btn-primary btn-lg w-100 mb-2">Change Password</button>
                </form> 
                <!-- /form --> 
                
              </div>
              <!--/.card-body -->
            </div>
            <!--/.card -->
          </div>
          <!-- /column -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container -->
    </section>
	</div>
</div>
<?php include ('includes/footer.php') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"></script>
<script>

  function do_reset(e) 
  {
    e.preventDefault();
      $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/Home/do_reset',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#do_reset')[0]),
      dataType: 'json',
      beforeSend: function() {        
        $('#do_reset_btn').prop('disabled' , true);
        $('#do_reset_btn').text('Processing..');
      },
      success : function(res){
        $('#do_reset_btn').prop('disabled' , false);
        $('#do_reset_btn').text('Change password');
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

</script>