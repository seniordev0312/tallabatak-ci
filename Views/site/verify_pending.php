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
 
  if($this->user['email_verified']==1)
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
         <h4 class="email-heading">Email verification </h4>
         <div class="msg"></div>
         <?php $user_id = $this->session->get('user_id'); ?>
         <p>You need to verify your email address. We've sent an email to Please verify your address.</p>
         <p>Please click the link in that email to continue.</p>

         <p class="text-center"> <a class="btn btn-primary" href="<?php echo base_url().'/sendVerificationMail/'.$user_id ?>"> Resend verification link</a> </p>
         <p>Not available via Email?.</p>
         <p class="text-center"> <a class="btn btn-primary" href="<?php echo base_url().'/sendVerificationSMS/'.$user_id ?>"> Send verification SMS</a> </p>
      </div>
   </div>
</div>

<?php include_once('includes/footer.php'); ?>