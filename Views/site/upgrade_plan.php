<?php 
include_once 'includes/header.php';
?>
<style type="text/css">
  .plan-active{
    border: 5px solid #fd5631;
  }
</style>
     <section class="container pt-5 mt-5">
        <!-- Breadcrumb-->
       
        <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Upgrade Plan</li>
          </ol>
        </nav>
      </section>

       <div class="container">
       	 <div class="row">
          <!-- Sidebar-->
          <?php include_once 'includes/user_sidebar.php' ?>
          <!-- Content-->
          <div class="col-lg-8 col-md-7 mb-5">

    <!-- tab 6 -->
    <div class="" id="" role="">
       <?= $this->session->getFlashdata('msg'); ?>
         <h1 class="h2 mb-4">Upgrade Plan</h1>
         <p class="pb-2 mb-4 ">Select your perfect plan to add more Advertisements</p>
        <div class="row">
         <?php
          $plan_data = $this->common_model->GetSingleData('plan_subscriptions','user_id = "'.$this->user_id.'" AND status = 1','id','desc');
          if(isset($plan_data) && !empty($plan_data)){
           $plan = $this->common_model->GetSingleData('plan_management','id = "'.$plan_data['plan_id'].'"');
          ?>
           <!-- <div class="col-sm-4">
              <p class="">
               
              <b>Plan Name: </b><?= $plan['title']; ?><br>
              <b>Post: </b><?= $plan['post']; ?><br>
              <b>Start Date: </b><?= $plan_data['start_date']; ?><br>
              <b>End Date: </b><?= $plan_data['end_date']; ?><br><p>
               
            </div> -->
        <?php }?>
        </div>
        <div class="row">
       <?php 
        $proPlan = $this->common_model->GetAllData('plan_management','','id','asc');

        foreach($proPlan as $planV)
        {
          $check_plan = $this->common_model->GetSingleData('plan_subscriptions',array('plan_id'=>$planV['id'],'user_id'=>$this->user_id));

          if ($plan_data) 
          {
            if ($plan_data['plan_id'] != 1 && $planV['id'] == 1) 
            {
              continue;
            }
          }
          else
          {
            if ($planV['id'] == 1) 
            {
              continue;
            }
          }
          
          if(!$plan_data  || $plan_data['plan_id'] != $planV['id'])
          { 
              $pay_btn =  '<button style="display: none;"  type="hidden"  class="btn btn-danger paypal_btn_btn" data-amt="'.$planV['price'].'" data-plan_id="'.$planV['id'].'" data-duration="'.$planV['duration'].'">Pay With PayPal</button>
                    <div class="pay_btn paypal_btn" id="paypal_btn'.$planV['id'].'">Pay With PayPal</div>';
              $active_class = '';
                
          }
          else
          {
            $abs_diff = numberOfDays($plan_data['start_date'] , $plan_data['end_date']);
           
              $pay_btn = '<p class="btn alert-success"><i class="fa fa-check"></i> Plan Active</p><p class="text-left bg-light"><b>Plan Name: </b>'.$plan['title'].'<br><b>Post: </b>'.$plan['post'].'<br><b>Expired in </b>'.$abs_diff.' Days<br><p>';
              $active_class = 'plan-active';
          }
                
        ?>
        
         <div class="col-sm-6 col-md-4 mb-4">
          <form method="post" enctype="multipart/form-data" action="#">
            <div class="card shadow-sm <?= $active_class ?>">
              <div class="card-body"><img class="d-block mx-auto mt-2 mb-4" src="<?= base_url() ?>/assets/site/imgs/premium.png" width="72" alt="Icon">
                <h2 class="h5 fw-normal text-center py-1 mb-0"><?= $planV['title']; ?></h2>
                <div class="d-flex align-items-end justify-content-center mb-4">
                  <div class="h1 mb-0">$<?= $planV['price']; ?></div>
                  <div class="pb-2 ps-2">/<?= $planV['duration']; ?> month</div>
                  <input type="hidden" name="user_id" id="user_id" value="<?= $this->user_id ?>">
                  <input type="hidden" name="plan_id" id="plan_id" value="<?= $planV['id']; ?>">
                </div>
                <ul class="list-unstyled d-block mb-0 mx-auto" style="max-width: 16rem;">
                  <?php
                    if($planV['groups'] == 1){
                  ?>
                    <li class="d-flex"><i class="fi-check text-primary fs-sm mt-1 me-2"></i><span>Groups</span></li>
                 
                  <?php
                    }else{ ?>
                      <li class="d-flex text-muted"><i class="fi-x fs-xs mt-2 me-2"></i><span>Groups</span></li>
                   <?php 
                    }
                  ?>
                 <?php
                    if($planV['auction'] == 1){
                  ?>
                  <li class="d-flex"><i class="fi-check text-primary fs-sm mt-1 me-2"></i><span>Auctions</span></li>
                    <?php
                    }else{ ?>
                      <li class="d-flex text-muted"><i class="fi-x fs-xs mt-2 me-2"></i><span>Auctions</span></li>
                  <?php 
                    }
                  ?>
                  <?php
                    if($planV['swap'] == 1){
                  ?>
                  <li class="d-flex"><i class="fi-check text-primary fs-sm mt-1 me-2"></i><span>Swaps</span></li>
                    <?php
                    }else{ ?>
                      <li class="d-flex text-muted"><i class="fi-x fs-xs mt-2 me-2"></i><span>Swaps</span></li>
                  <?php 
                    }
                  ?>
                  <?php
                    if($planV['coupon'] == 1){
                  ?>
                  <li class="d-flex"><i class="fi-check text-primary fs-sm mt-1 me-2"></i><span>Coupons</span></li>
                    <?php
                    }else{ ?>
                      <li class="d-flex text-muted"><i class="fi-x fs-xs mt-2 me-2"></i><span>Coupons</span></li>
                  <?php 
                    }
                  ?>
                   <li class="d-flex"><i class="fi-check text-primary fs-sm mt-1 me-2"></i><span>No of post : <b><?= $planV['post']; ?></b></span></li>
                  <li class="d-flex"><i class="fi-check text-primary fs-sm mt-1 me-2"></i><span><?= $planV['description']; ?></span></li>
                </ul>
              </div>
                 
              <div class="card-footer py-2 border-0">
                <div class="border-top text-center pt-4 pb-3">

                  
                <?php
               
                    echo $pay_btn;
                 
                ?>
                  
                </div>
              </div>
            </div>
          </form>
          </div>
         
           <?php
            }
          ?>
          </div>
           
            
          </div>


    <!-- tab 6 -->

 
      
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




