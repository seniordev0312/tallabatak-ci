<?php include_once 'includes/header.php';?>

<style type="text/css">
    .simplebar-content {
        padding: 0 !important;
    }

    .hightlight {
        padding: 1.25rem;
        background-color: var(--bs-gray-100);
    }
    p.code {
        display: flex;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;   
        background: 0% 0% no-repeat padding-box padding-box rgb(255, 255, 255);
        border: 1px dashed rgb(112, 112, 112);
        border-radius: 6px;
        text-align: center;
        margin: 0px;
        font: 600 22px / 38px Poppins !important;
        color: rgb(253 86 49) !important;
    }

    .coupon-code-color .code {
        width: 50%;
        margin-right: 15px;
        border: 2px dashed;
        font: 600 26px/30px 'Noto Sans' !important;
    }

    .coupon_text ul {
        list-style: circle;
    }

    hr {
        width: 7%;
        margin: 0 auto;
        height: 4px !important;
        border-radius: 10px;
        background-color: #ddd !important;
    }
</style>

<section class="container pt-5 mt-5">
    <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Coupons</li>
        </ol>
    </nav>

    <div class="row">
        <?php 
        if($coupon_detail){
        ?>
        <div class="col-md-7">
            <div class="coupondetiail text-center">
                <div class="">
                    <div>
                        
                        <img class="img-thumbnail " style="width:50%"  src="<?php echo base_url($coupon_detail['image']);?>">
                            
                    </div>
                    <div class="off_text">
                        <div class="mt-4">
                            <p class="mb-2"><?= $coupon_detail['coupon_off']?>% OFF</p>
                            <h3 class="mb-2"> <?= $coupon_detail['title']?></h3>
                        </div>
                    </div>
                </div>
                <div class="coupon">
                    <p class="sc-fgfRvd hXvfKz">Paste this code in checkout.</p>
                    <div class="d-flex justify-content-center coupon-code-color">
                        <p class="code">
                        <?= $coupon_detail['coupon_code']?></p>
                        <button class="copy_text btn btn-danger">
                        Copy</button>
                    </div>
                    <p class="mt-3 mb-2 fs-lg fw-bold text-dark"><?= $coupon_detail['coupon_off']?>% OFF</p>
                    <hr>
                    <div class="coupon_text mb-5 mt-4">
                        <ul class="text-start fs-sm">
                            <li>
                            <?= $coupon_detail['description']; ?></li>
                            <li>
                            Valid till  <b><?= $coupon_detail['end_date']; ?></b></li>
                            <li>Number Of Units: <b><?= $coupon_detail['no_unit']; ?></b></li>
                            <li>Price: <b>$<?= $coupon_detail['price']; ?></b></li>
                        </ul>
                    </div>
                </div>
            </div>


        </div>
<?php
    }

?>
<?php
       $userData = $this->common_model->GetSingleData('users',array('id'=>$coupon_detail['user_id']));
        if($userData){
?>
        <div class="col-md-5">
            <aside class="ms-5 pb-1">
            <!-- Contact card-->
            
            <div class="card shadow-sm mb-4">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between"><a class="text-decoration-none" href="real-estate-vendor-properties.html"><img class="rounded-circle mb-2" src="<?php echo base_url($userData['image']);?>" width="60" alt="Avatar">
                    <h5 class="mb-1"><?= $userData['name']; ?></h5>
                    <div class="mb-1">
                        <span class="star-rating">
                             <?php for ($i=1; $i < 6 ; $i++) 
                                { 
                                  if ($i <= $userData['rating']) 
                                  { ?>
                                   <i class="star-rating-icon fi-star-filled active"></i>
                                  <?php }
                                  else
                                  {
                                 ?>
                                    <i class="star-rating-icon fi-star"></i>
                                 <?php
                                  }
                                  
                                } ?>

                            </span>
                    </div>
                    </a>
                   <div class="ms-4 flex-shrink-0">
                            <?php if ($userData['facebook']): ?>
                            <a target="_blank" class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle ms-2 mb-2" href="<?= $userData['facebook'] ?>">
                              <i class="fi-facebook"></i>
                              <?php endif ?>
                              <?php if ($userData['linkedin']): ?>
                              <a target="_blank" class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle ms-2 mb-2" href="<?= $userData['linkedin'] ?>">
                                <i class="fi-linkedin"></i>
                                <?php endif ?>
                                
                              </a>
                              
                            </div>
                </div>
                <ul class="list-unstyled border-bottom mb-4 pb-4">
                  <li><a class="nav-link fw-normal p-0" href="tel:<?= $userData['phone']; ?>"><i class="fi-phone mt-n1 me-2 align-middle opacity-60"></i><?= $userData['phone']; ?></a></li>
                  <li><a class="nav-link fw-normal p-0" href="mailto:<?= $userData['email']; ?>"><i class="fi-mail mt-n1 me-2 align-middle opacity-60"></i><?= $userData['email']; ?></a></li>
                </ul>
                 <?php if ($this->user): ?>
                          <?php if ($this->user_id != $userData['id']): ?>
                              <a class="btn btn-primary btn-sm mb-sm-0 mt-0" onclick="open_chat(<?= $userData['id'] ?> , 1 , 0)" ><i class="fi-chat-circle mt-n1 me-2 lead align-middle text-white "></i> Chat</a>
                              <button class="btn btn-primary btn-sm mb-sm-0 mt-0"href="#userinfo-modal" data-bs-toggle="modal"  ><i class="fa fa-phone -circle mt-n1 me-2 lead align-middle text-white "></i> Communication </button>
                          <?php endif ?>
                        <?php else: ?>
                         
                          <a class="btn btn-primary btn-sm mb-sm-0 mt-0"href="#signin-modal" data-bs-toggle="modal"  ><i class="fi-chat-circle mt-n1 me-2 lead align-middle text-white "></i> Chat</a>
                        <?php endif ?>
              </div>
            </div>
            <div class="pt-2">
                <div class="position-relative mb-2 map_div shadow-sm">
                  <!-- <img class="rounded-3" src="img/real-estate/single/map.jpg" alt="Map"> -->
                  
                  <?php $lat = $this->user['lat'];
                        $lng = $this->user['lng'];
                  ?>
                  <iframe src="//maps.google.com/maps?q=<?= $lat?>,<?= $lng ?>&z=15&output=embed" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  
                  
                </div>
                <p class="mb-0 fs-base text-primary"><?= $this->user['address']; ?></p>
              </div>
          </aside>
        </div>
    <?php } ?>
    </div>
<div class="modal fade" id="userinfo-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content" style="max-height: inherit; overflow: unset;">
      <div class="modal-header">
        <h4 class="h5 modal-title">Communicate with the Group User</h4>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php $msg = "Peace be upon you, ".$userData['name'].". I have an inquiry regarding your ad. ".$coupon_detail['title'].". " ?>
        <div class="modal-body fs-sm">
          <div class="mb-3">
            <ul>
              <li><a href="mailto:<?= $userData['email'] ?>">private messages <i class="fa fa-envelope"></i></a></li>
              <li><a href="tel:<?= $userData['phone'] ?>"><?= $userData['phone'] ?> <i class="fa fa-phone"></i></a></li>
              <li><a href="https://api.whatsapp.com/send/?phone=<?= $userData['phone'] ?>&text=<?= urlencode($msg) ?>&type=phone_number&app_absent=0">Message via WhatsApp <i class="fa fa-whatsapp"></i></a></li>
            </ul>
              
              
              

           
            
          </div>
        </div>
        
    
    </div>
  </div>
</div>

    
</section>


<!-- <div class="container">
    <div class="row">
        
        <div class="col-lg-8 col-md-7 mb-5">
            <?= $this->session->getFlashdata('msg'); ?>
            <div class="" id="" role="">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="h2 mb-0">My Coupon Code</h1>
                </div>
                <p class="pt-1 mb-4">Here you can see your Coupon Code.</p>

                
                    
                  coupon Detail
                                
                      

                                



                


            </div>
        </div>
    </div>
</div> -->
<!-- container-fluid -->

<?php include_once 'includes/footer.php'; ?>
