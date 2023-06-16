<?php 
include_once 'includes/header.php';
?>

<section class="container pt-5 mt-5">
        <!-- Breadcrumb-->
        
        <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Post</li>
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
          <div class="" id="" role="">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h1 class="h2 mb-0">My Posts</h1>
            </div>
            <p class="pt-1 mb-4">Here you can see your posts and edit them easily.</p>

             
            
            <!-- Item-->
            <?php 
            $is_featured = $this->common_model->GetSingleData('admin',array('id'=>1));
            if ($view): $i = 1; ?>
            <?php foreach ($view as $key => $value):
            // foreach ($view as $key => $imgvalue):
                
                ?>
<div class="card card-horizontal shadow-sm card-hover border-0 h-100 tns_height mb-3">
  <div class="dropdown position-absolute zindex-5 top-0 end-0 mt-3 me-3">
    <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
    <ul class="dropdown-menu my-1" aria-labelledby="contextMenu1">
      <li>
        <a href="edit_post/<?= $value['id'] ?>" class="dropdown-item" type="button"><i class="fi-edit opacity-60 me-2"></i>Edit</a>
      </li>
      <li>
        <button class="dropdown-item" type="button" onclick="delete_post('<?= $value['id'] ?>')"><i class="fi-trash opacity-60 me-2" ></i>Delete</button>
      </li>
       <li>
        <?php 
          if($value['is_featured'] == 1){
         ?>
             <button style="color: green;" class="dropdown-item" type="button"><i class="fi-check opacity-60 me-2" ></i>Featured</button>
        <?php
          }else{
        ?>
        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#editModal<?= $value['id']; ?>"><i class="fi-star opacity-60 me-2" ></i>Mark As Featured</button>
        <?php  }
        ?>
       
      </li>
    </ul>
  </div>
  <div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="<?= get_post_url($value) ?>"></a>
    
    <div class="content-overlay end-0 top-0 pt-3 pe-3">
      <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
    </div>
    <?php $img = $this->common_model->GetAllData('post_images',array('post_id' =>$value['id']) )?>
     <div>
       <span class="badge rounded-pill bg-success py-1 px-2 fs-xs btn-features"><?= ($value['is_featured']==0) ? '' : 'Featured'?></span>
     </div>
    <div class="tns-carousel-inner">
      <?php 
        if($img){
        foreach($img as $images) {?>
      <img src="<?php echo base_url().'/'.$images["file"]?>" alt="Image">
      <?php }
    } else{?>
      <img src="<?php echo base_url() ?>/assets/upload/post_default.jpg" alt="Image">
      <?php
    }
      ?>
    </div>
  </div>
  <div class="card-body position-relative pb-3">
    <div class="d-flex align-items-start justify-content-between">
      <div>
        <h4 class="mb-0 h4 fs-xs text-primary"><i class="fi-map-pin me-2"></i> <?= $value['city'] ?><!-- <span class="fs-sm m-0 fw-normal text-primary">(2 miles)</span>--></h4>
        <!-- <span class="fs-sm h6 m-0"><?= $value['distance'] ?> miles  </span> -->
      </div>
        <span class="badge rounded-pill bg-success py-1 px-2 fs-xs auction"><?= ($value['post_type']==0)? '' : 'Auction'?></span>
      </div>
      <h3 class="h6 mb-2 mt-1 fs-base"><a class="nav-link stretched-link" href="<?= get_post_url($value) ?>"><?= $value['title'] ?></a></h3>
      <p class="mb-2 fs-sm text-muted"><?= substr($value['description'],0,50) ?></p>
      <div class="d-flex align-items-center text-decoration-none" href="#"><img class="rounded-circle loaded tns-complete" src="<?= base_url($this->user['image']) ?>" alt="<?= $this->user['name'] ?>" width="44">
        <div class="ps-2">
          <h6 class="fs-sm text-nav lh-base mb-1"><?= $this->user['name'] ?></h6>
          <div class="d-flex text-body fs-xs"><span class="me-2 pe-1"><i class="fi-calendar-alt opacity-70 mt-n1 me-1 align-middle"></i><?= humanDate($value['created_at']) ?></span><span><i class="fi-chat-circle opacity-70 mt-n1 me-1 align-middle"></i>No comments</span></div>
        </div>
      </div>
    </div>
  </div>

<div class="modal" id="editModal<?= $value['id']; ?>">                 
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
  
    <!-- Modal Header -->
     <div class="modal-header bg-light p-3">
      <h4 class="modal-title">Post Is Featured</h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>
    
    <!-- Modal body -->
    
     <div class="modal-body">
        <div class="col-md-12 py-3">
          
           <div>
            <div class="row">
              <div class="col-sm-4"><label>Amount: </label></div>
              <div class="col-sm-6"><label>$<?php echo $is_featured['featured_cost']; ?></label></div>
            </div>
              
            </div>
            <div>
              <div class="row">
                <div class="col-sm-4"><label>Number Of Days: </label></div>
                <div class="col-sm-6"><label><?php echo $is_featured['no_days']; ?> Days</label></div>
              </div>
            </div><br><br>
             <div class="mt-3 text-center">
                 <button style="display: none;"  type="hidden"  class="btn btn-danger paypal_btn_btn" data-amt="<?= $is_featured['featured_cost']; ?>" data-post_id="<?= $value['id']; ?>" data-duration="<?= $is_featured['no_days']; ?>">Pay With PayPal</button>
                <div class="pay_btn paypal_btn" id="paypal_btn<?= $value['id']; ?>">Pay With PayPal</div>
              </div>
           </div>
           
        </div>
    
  </div>
</div>
</div>

  <?php $i++; endforeach ?>
                  
                  <?php  endif ?>  

          </div>

   </div>


        </div>
      </div>
<

<?php
include_once 'includes/footer.php'; ?>
<script src="https://www.paypal.com/sdk/js?client-id=<?= PayPal_CLIENT_ID ?>"></script>
<script>
$(".paypal_btn_btn").each(function(){
        var amt = $(this).attr('data-amt');
        var postId = $(this).attr('data-post_id');
        var no_days = $(this).attr('data-duration');
        

         PaymentGetway(amt, postId , no_days);
});

function PaymentGetway(amt, postId='',no_days) {

  $('#paypal_btn'+postId).html('');
 
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
    url: "<?php echo base_url(); ?>/Post/upgradePost",
    type:"POST",
   /* cache:false,
    contentType: false,
    processData: false,*/
    data:{amt:amt,postId:postId,trans_id:trans_id,no_days:no_days},
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
  }).render('#paypal_btn'+postId); 
  

  }
 
</script> 
<script type="text/javascript">
  function delete_post(id) 
  {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
            url: '<?= base_url('Post/delete_post') ?>',
            type: 'post',
            data: {'id' : id},
            success: function (data) {
              Swal.fire(
                'Deleted!',
                'Your post has been deleted.',
                'success'
              ).then((result) => {
                location.reload();
              })
              
            }
          });
        
      }
    })
  }
</script>

