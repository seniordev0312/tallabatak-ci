<?php include_once('includes/header.php'); ?>
<style type="text/css">
      .verify {
    padding: 20px;
    border-radius: 10px;
    margin: 20px auto;
    max-width: 650px;
    width: 100%;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    background: #fff;
}

.g_img img {
    width: 125px;
    max-width: 100%;
}

h4.email-heading {
    font-size: 22px;
    font-weight: 600;
    margin-top: 15px;
}

.verify p {
    font-size: 16px;
    width: 100%;
    margin: 15px 0;
}
 </style>
 
<?php 
 
  if($this->user['is_verified']==1)
   {
    header('Location: '.base_url('dashboard'));
}
  ?>
<div class="container mt-5 main">
   <div class="verify">
      <div class="text-center">


		<?php  if($this->session->getFlashdata('msg')){?>
                             
             <div class="alert alert-success"><?php echo $this->session->getFlashdata('msg');?></div>
                             
        <?php } ?>

         <div class="g_img">
            <img src="<?= base_url() ?>/assets/images/message_1.png">
         </div>
         <h4 class="email-heading">SMS verification </h4>
         <div class="msg"></div>
         <?php $user_id = $this->session->get('user_id'); ?>
         <p>Please insert authentication_code we've sent to your phone.</p>
         <div class="row justify-content-center" >
            <div class="col-6">
                <input class="form-control" type="text" id="sms_code" name="sms_code" required>
                <button class="text-center btn btn-primary" id="verify">Verify</button>
            </div>
        </div> 
         <p class="text-center"> <a class="btn btn-primary" href="<?php echo base_url().'/sendVerificationMail/'.$user_id ?>"> Send verification link</a> </p>
         <p>Not available via Email?.</p>
         <p class="text-center"> <a class="btn btn-primary" href="<?php echo base_url().'/sendVerificationSMS/'.$user_id ?>"> Resend verification SMS</a> </p>
      </div>
   </div>
</div>

<?php include_once('includes/footer.php'); ?>
<script>
    $('#verify').click(function(){
        $.ajax({
      url: '<?= base_url() ?>/Home/verify_sms',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data: JSON.stringify({
        'sms_code' : $('#sms_code').val(),
      }),
      dataType: 'json',
      success:function(res){
        console.log(res);
        if (res.status == 1) 
        {
            Swal.fire({
               title: "Success", 
               text: "Your account has been verified successfully.", 
               icon: "success"
             }).then(function (result) {
              location.href= "/home";
            })
           
        }
        else
        {
            Swal.fire({
               title: "Error", 
               text: "Code Incorrect", 
               icon: "error"
             }).then(function (result) {
              location.reload();
            })
        }
      }
    });
    })

</script>