<?php 
include_once 'includes/header.php';
?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.green.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css"> -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/rating.css') ?>">



<!-- Page content-->
      <!-- Review modal-->
      <style type="text/css">
       .slick-slider .element{
  height:400px;
  width:100%;
  object-fit: cover;
  border-radius:5px;
  display:inline-block;
  margin:0px 10px;
  display:-webkit-box;
  display:-ms-flexbox;
  display:flex;
  -webkit-box-pack:center;
      -ms-flex-pack:center;
          justify-content:center;
  -webkit-box-align:center;
      -ms-flex-align:center;
          align-items:center;
  font-size:20px;
}
.slick-slider .slick-disabled {
  opacity : 0; 
  pointer-events:none;
}
.slick-slide img {
    height: 400px;
    object-fit: contain;
}
button.slick-prev, button.slick-next {
    background: #fd5631;
    width: fit-content;
    color: #fff;
    border-radius: 20px;
    font-size: 15px;
    padding: 3px 10px;
    margin-right: 5px;
    border: none;
}
 #timer {
  font-family: Arial, sans-serif;
  font-size: 14px;
  color: #999;
  letter-spacing: -1px;
}
#timer span {
  font-size: 20px;
  color: #333;
  margin: 0 3px 0 2px;
}
#timer span:first-child {
  margin-left: 0;
}
/*a.lb-close {
    position: absolute;
    top: 0px;
    right: 30px;
}*/

      </style>
      <?php $check = false; 
      if($this->user_id){
            $check = $this->common_model->GetSingleData('wishlist' , array('post_id' => $post['id'],'user_id'=>$this->user_id)); 
      } ?>
      <div class="modal fade" id="modal-review" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header d-block position-relative border-0 pb-0 px-sm-5 px-4">
              <!-- <h3 class="modal-title mt-4 text-center">Leave a Comment</h3> -->
              <button class="btn-close position-absolute top-0 end-0 mt-3 me-3" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 px-4 mt-3">
              <form class="needs-validation" novalidate>
               
                <div class="mb-4">
                  <input type="text" class="form-control mb-3" name="" placeholder="Enter your bid amount">
                  <textarea class="form-control" id="review-text" rows="5" placeholder="Your message" required></textarea>
                  <!-- <div class="invalid-feedback">Please write your review.</div> -->
                </div>
                <button class="btn btn-primary btn-sm d-block mb-4" type="submit">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Page header-->
      <section class="container pt-5 mt-5">
        <!-- Breadcrumb-->
        <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="#"><?= isset($post['category']) ? $post['category']['title_eng'] : '' ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $post['title'] ?> </li>
          </ol>
        </nav>
      </section>

   <div class="container">
     
       
          
            
            <h1 class="h2 mb-2"><?= $post['title'] ?></h1><span class="star-rating">
                                <?php for ($i=1; $i < 6 ; $i++) 
                                { 
                                  if ($i <= $post['rating']) 
                                  {
                                    echo '<i class="star-rating-icon fi-star-filled active"></i>';
                                  }
                                  else
                                  {
                                    echo '<i class="star-rating-icon fi-star"></i>';
                                  }
                                  
                                } ?>
                              </span>
            <!-- <p class="mb-2 pb-1 fs-lg">Lorem Ipsum is simply dummy text of the printing</p> -->
            <!-- Features + Sharing-->
            <div class="d-flex justify-content-end align-items-center">
            
              <div class="text-nowrap">
                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist" onclick="return addToFav(<?php echo $post['id'] ?>)"><i class="fa <?= ($check) ? 'fa-heart' : 'fa-heart-o' ?> post_heart_<?= $post['id'] ?>"></i></button>
                <!-- <div class="dropdown d-inline-block" data-bs-toggle="tooltip" title="Share">
                  <button class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle ms-2 mb-2" type="button" data-bs-toggle="dropdown"><i class="fi-share"></i></button>
                  <div class="dropdown-menu dropdown-menu-end my-1">
                    <button class="dropdown-item" type="button"><i class="fi-facebook fs-base opacity-75 me-2"></i>Facebook</button>
                    <button class="dropdown-item" type="button"><i class="fi-twitter fs-base opacity-75 me-2"></i>Twitter</button>
                    <button class="dropdown-item" type="button"><i class="fi-instagram fs-base opacity-75 me-2"></i>Instagram</button>
                  </div>
                </div> -->
              </div>
            </div>


              
                <section class="container overflow-auto mb-4 pb-3 " dir="ltr" style="direction: ltr;" data-simplebar>
                   <div class="row g-2 g-md-3 slick-slider gallery" data-thumbnails="true" style="min-width: 30rem;">
                  <?php if ($post_images): ?>
                    <?php foreach ($post_images as $key => $value): ?>
                      <div class="col element" style="background: url(<?= base_url($value['file']) ?>) no-repeat center/cover;">
                          <a class="gallery-item rounded rounded-md-3" data-lightbox="gallery" style="backdrop-filter: blur(25px); width:100%" href="<?= base_url($value['file']) ?>" data-sub-html="<h6 class=&quot;fs-sm text-light&quot;>Bathroom</h6>">
                            <img src="<?= base_url($value['file']) ?>" alt="Gallery thumbnail">
                          </a>

                          <!-- <a class="gallery-item rounded rounded-md-3" href="<?= base_url($value['file']) ?>" data-sub-html="&lt;h6 class=&quot;fs-sm text-light&quot;&gt;Bathroom&lt;/h6&gt;">
                            <img src="<?= base_url($value['file']) ?>" alt="Gallery thumbnail">
                          </a> -->
                      </div> 
                    <?php endforeach;  ?>
                  <?php else:  ?>
                    <div class="col-12 element">
                      <a class="gallery-item rounded rounded-md-3" data-lightbox="gallery" href="<?php echo base_url() ?>/assets/upload/post_default.jpg" data-sub-html="<h6 class=&quot;fs-sm text-light&quot;>Bathroom</h6>">
                            <img src="<?php echo base_url() ?>/assets/upload/post_default.jpg" alt="Gallery thumbnail">
                          </a>

                          <!-- <a class="gallery-item rounded rounded-md-3" href="<?php echo base_url() ?>/assets/upload/post_default.jpg" data-sub-html="&lt;h6 class=&quot;fs-sm text-light&quot;&gt;Bathroom&lt;/h6&gt;">
                            <img src="<?php echo base_url() ?>/assets/upload/post_default.jpg" alt="Gallery thumbnail">
                          </a> -->
                        </div>
                 
                  <?php endif;  ?>
                    
                    
                  </div>
                </section>


                 <ul class="nav nav-pills mb-3" id="pills-tab">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Product Details</button>
                    </li>
                    <?php if ($post['post_type'] == 1): ?>
                      <li class="nav-item" role="presentation">
                      <button class="nav-link comming_soon" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile1" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Auction History</button>
                    </li>
                    <?php endif ?>
                    
                  </ul>


             <div class="tab-content" id="pills-tabContent">


             <!-- detail Tab -->
           <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <section class="container mb-5 pb-1">
                <div class="row">
                  <div class="col-md-7 mb-md-0 mb-4">
                    <?php if ($post['post_type'] == 1): ?>
                    <span class="badge bg-success me-2 mb-3">Auction</span>
                    <!-- <span class="badge bg-info me-2 mb-3">New</span> -->
                    <div class="">
                      <div class="d-flex align-items-center justify-content-between  border-bottom">
                        <h2 class="h3"><?= $post['auction_currency'] ?><?= number_format($post['auction_price']) ?></h2>
                       
                         <?php if ($post['post_type'] == 1): ?>
                      <div class="auction_timer ms-3 h5 text-primary fw-normal">
                        <p class="m-0">This Auction Ends on :</p>
                        <div id="timer">
                          <span id="days<?= $post['id'] ?>" class="days"></span><b>days</b>
                          <span id="hours<?= $post['id'] ?>" class="hours"></span><b>hours</b>
                          <span id="minutes<?= $post['id'] ?>" class="minutes"></span><b>minutes</b>
                          <span id="seconds<?= $post['id'] ?>" class="seconds"></span><b>seconds</b>
                        </div>
                      </div>
                      <script type="text/javascript">
                        var timer<?= $post['id'] ?>;

                        var compareDate<?= $post['id'] ?> = new Date('<?= date('d F, Y' , strtotime($post['auction_expire_date'])) ?>');


                        timer<?= $post['id'] ?> = setInterval(function() {
                          timeBetweenDates<?= $post['id'] ?>(compareDate<?= $post['id'] ?>);
                        }, 1000);

                        function timeBetweenDates<?= $post['id'] ?>(toDate) {
                          var dateEntered = toDate;
                          var now = new Date();
                          var difference = dateEntered.getTime() - now.getTime();

                          if (difference <= 0) {

                            // Timer done
                            $("#timer").text('Expired');
                            clearInterval(timer<?= $post['id'] ?>);
                          
                          } else {
                            
                            var seconds = Math.floor(difference / 1000);
                            var minutes = Math.floor(seconds / 60);
                            var hours = Math.floor(minutes / 60);
                            var days = Math.floor(hours / 24);

                            hours %= 24;
                            minutes %= 60;
                            seconds %= 60;

                            $("#days<?= $post['id'] ?>").text(days);
                            $("#hours<?= $post['id'] ?>").text(hours);
                            $("#minutes<?= $post['id'] ?>").text(minutes);
                            $("#seconds<?= $post['id'] ?>").text(seconds);
                          }
                        }
                      </script>
                    <?php endif ?>
                      </div>
                    </div>
                    <?php endif ?>
                    <!-- Overview-->
                    <div class="mb-2 pb-md-3">
                      <p class="mb-1 mt-2"><?= substr($post['description'],0,150) ?></p>
                      <div class="collapse" id="seeMoreOverview">
                        <p class="mb-1"><?= substr($post['description'],150) ?></p>
                      </div>
                      <a class="collapse-label collapsed" href="#seeMoreOverview" data-bs-toggle="collapse" data-bs-label-collapsed="Show more" data-bs-label-expanded="Show less" role="button" aria-expanded="false" aria-controls="seeMoreOverview"></a>
                    </div>
                    <!-- Property Details-->

                    <!-- Post meta-->
                    <div class="mb-lg-2 mb-md-4 pb-lg-2 py-1 border-top">
                      <ul class="d-flex mb-2 list-unstyled fs-sm">
                        <li class="me-3 pe-3 border-end">Published: <b><?= humanDate($post['created_at']) ?></b></li>
                        <li class="me-3 pe-3 border-end">Ad number: <b><?= $post['id'] ?></b></li>
                        <li class="me-3 pe-3">Location: <b><?= $post['city'] ?></b></li>
                      </ul>
                      <?php if ($post['post_type'] == 1): ?>
                      <a class="btn btn-primary btn-xs mb-sm-0 mt-3 comming_soon" href="#modal-review1" data-bs-toggle="modal">Submit A Bid</a>
                      <?php endif ?>
                    </div>
                    <!-- Reviews-->
                    <div class="mb-3 mt-5  border-bottom">
                      <h3 class="h4"><i class="fi-chat-circle mt-n1 me-2 lead align-middle text-primary"></i>Comments</h3>
                    </div>
                    
                    <!-- Review-->
                    <div class="mb-4 pb-4 border-bottom">
                      <?php if ($post_comments ): ?>
                      <?php foreach ($post_comments as $key => $value): ?>
                        <?php 
                        $comment_user = $this->common_model->GetSingleData('users' , array('id' => $value['user_id'] ));
                        if (!$comment_user) {
                          continue;
                        }
                         ?>
                        <div class="d-flex justify-content-between mb-3">
                          <div class="d-flex align-items-center pe-2"><img class="rounded-circle me-1" src="<?= base_url($comment_user['image']) ?>" width="48" alt="Avatar">
                            <div class="ps-2">
                              <h6 class="fs-base mb-0"><?= $comment_user['name'] ?></h6>
                              <span class="text-muted fs-sm"><?= humanDate($value['created_at']) ?></span>
                              <span class="star-rating">
                                <?php for ($i=1; $i < 6 ; $i++) 
                                { 
                                  if ($i <= $value['rating']) 
                                  {
                                    echo '<i class="star-rating-icon fi-star-filled active"></i>';
                                  }
                                  else
                                  {
                                    echo '<i class="star-rating-icon fi-star"></i>';
                                  }
                                  
                                } ?>
                              </span>
                            </div>
                          </div>
                        </div>
                        <p><?= $value['comment'] ?></p>
                      <?php endforeach ?>
                      <?php endif ?>
                     
                 
                      <form class="needs-validation pb-4" novalidate="" id="do_comment" method="post" onsubmit="return do_comment(event)">
                        
                          <input
                            class="rating rating--nojs"
                            max="5"
                            step="1"
                            type="range"
                            value="1" name="rating">
                        <div class="mt-3 d-flex align-items-center justify-content-between">
                          
                          <div class="input-group me-2">
                            <textarea class="form-control" name="comment" placeholder="Type your comment here..." rows="6"></textarea>
                            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                            <input type="hidden" name="post_user_id" value="<?= $post['user_id'] ?>">
                            <span class="input-group-text">
                              <i class="fi-chat-left"></i>
                            </span>
                            
                          </div>
                        </div>
                        <?php if ($this->user): ?>
                          <button type="submit" class="btn btn-primary btn-sm mb-sm-0 mt-3 " id="do_comment_btn" >Send</button>
                        <?php else: ?>
                          <a  class="btn btn-primary btn-sm mb-sm-0 mt-3 " href="#signin-modal" data-bs-toggle="modal" >Send</a>
                        <?php endif ?>
                        
                      </form>
                      
                    </div>
                  </div>
                  <!-- Sidebar-->
                  <aside class="col-lg-4 col-md-5 ms-lg-auto pb-1">
                    <!-- Contact card sticky-top top100-->
                    <div class="card shadow-sm mb-4">
                      <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between"><a class="text-decoration-none" href="#"><img class="rounded-circle mb-2" src="<?= base_url($post_user['image']) ?>" width="60" alt="Avatar">
                          <h5 class="mb-1"><?= $post_user['name'] ?></h5><span class="star-rating">
                                <?php for ($i=1; $i < 6 ; $i++) 
                                { 
                                  if ($i <= $post_user['rating']) 
                                  {
                                    echo '<i class="star-rating-icon fi-star-filled active"></i>';
                                  }
                                  else
                                  {
                                    echo '<i class="star-rating-icon fi-star"></i>';
                                  }
                                  
                                } ?>
                              </span>
                          
                          <p class="text-body">Group Agent</p></a>
                          <div class="ms-4 flex-shrink-0">
                            <?php if ($post_user['facebook']): ?>
                            <a target="_blank" class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle ms-2 mb-2" href="<?= $post_user['facebook'] ?>">
                              <i class="fi-facebook"></i>
                              <?php endif ?>
                              <?php if ($post_user['linkedin']): ?>
                              <a target="_blank" class="btn btn-icon btn-light-primary btn-xs shadow-sm rounded-circle ms-2 mb-2" href="<?= $post_user['linkedin'] ?>">
                                <i class="fi-linkedin"></i>
                                <?php endif ?>
                                
                              </a>
                              
                            </div>
                          </div>
                          <!-- <ul class="list-unstyled border-bottom mb-4 pb-4">
                            <li><a class="nav-link fw-normal p-0" href="tel:3025550107"><i class="fi-phone mt-n1 me-2 align-middle opacity-60"></i>(302) 555-0107</a></li>
                            <li><a class="nav-link fw-normal p-0" href="mailto:floyd_miles@email.com"><i class="fi-mail mt-n1 me-2 align-middle opacity-60"></i>johnsmith@email.com</a></li>
                          </ul> -->
                        <?php if ($this->user): ?>
                          <?php if ($this->user_id != $post['user_id']): ?>
                              <a class="btn btn-primary btn-sm mb-sm-0 mt-0" onclick="open_chat(<?= $post['user_id'] ?> , 1 , 0)" ><i class="fi-chat-circle mt-n1 me-2 lead align-middle text-white "></i> Chat</a>
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
                          
                          <?php $seller = $this->common_model->getSingleData('users','id='.$post['user_id'],null,'desc',['lat','lng']); ?>
                          <iframe src="//maps.google.com/maps?q=<?= $post['lat'] ?>,<?= $post['lng'] ?>&z=15&output=embed" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                          
                          
                        </div>
                        <p class="mb-0 fs-base text-primary"><?= $post['address'] ?></p>
                      </div>
                    </aside>
                </div>
              </section>
            </div>

             <!-- Auction Tab -->
        <?php if ($post['post_type'] == 1): ?>
          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <section class="auction_sec">
              <div class="container">
                <div class="col-md-6">
                  <div class="card bg-secondary card-hover mb-3">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center">
                          <img class="me-2" src="img/avatars/22.jpg" alt="IT Pro Logo" width="24">
                          <span class="fs-sm text-dark opacity-80 px-1">
                            <h3 class="fs-sm m-0">John Smith</h3>
                            <span class="fs-xs text-dark opacity-80">8 june 2022, 10:52 PM</span>
                          </span>
                          
                        </div>
                        <!-- <div class="dropdown content-overlay">
                          <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
                          <ul class="dropdown-menu my-1" aria-labelledby="contextMenu1" style="">
                            <li>
                              <button class="dropdown-item" type="button"><i class="fi-x-circle opacity-60 me-2"></i>Not interested</button>
                            </li>
                          </ul>
                        </div> -->
                      </div>
                      <h3 class="h6 card-title pt-1 mb-2 mt-1">$70</h3>
                      <p class="fs-sm">Euismod nec sagittis sit arcu libero, metus. Aliquam nisl rhoncus porttitor volutpat, ante cras tincidunt. Nec sit nunc, ornare tincidunt enim, neque. Ornare pulvinar enim fames orci enim in libero.</p>
                      <div class="d-flex align-items-center justify-content-between">
                        <!--  <a class="btn btn-primary btn-sm mb-sm-0 mt-0 chat_open_nw"><i class="fi-chat-circle mt-n1 me-2 lead align-middle text-white"></i> Chat</a> -->
                        <div class="fs-sm"><span class="text-nowrap me-3"><i class="fi-map-pin text-muted me-1"> </i>Chicago</span></div>
                      </div>
                    </div>
                  </div>
                  <div class="card bg-secondary card-hover mb-3">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center">
                          <img class="me-2" src="img/avatars/22.jpg" alt="IT Pro Logo" width="24">
                          <span class="fs-sm text-dark opacity-80 px-1">
                            <h3 class="fs-sm m-0">John Smith</h3>
                            <span class="fs-xs text-dark opacity-80">8 june 2022, 10:52 PM</span>
                          </span>
                          
                        </div>
                        <!-- <div class="dropdown content-overlay">
                          <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
                          <ul class="dropdown-menu my-1" aria-labelledby="contextMenu1" style="">
                            <li>
                              <button class="dropdown-item" type="button"><i class="fi-x-circle opacity-60 me-2"></i>Not interested</button>
                            </li>
                          </ul>
                        </div> -->
                      </div>
                      <h3 class="h6 card-title pt-1 mb-2 mt-1">$90</h3>
                      <p class="fs-sm">Euismod nec sagittis sit arcu libero, metus. Aliquam nisl rhoncus porttitor volutpat, ante cras tincidunt. Nec sit nunc, ornare tincidunt enim, neque. Ornare pulvinar enim fames orci enim in libero.</p>
                      <div class="d-flex align-items-center justify-content-between">
                        <!--  <a class="btn btn-primary btn-sm mb-sm-0 mt-0 chat_open_nw"><i class="fi-chat-circle mt-n1 me-2 lead align-middle text-white"></i> Chat</a> -->
                        <div class="fs-sm"><span class="text-nowrap me-3"><i class="fi-map-pin text-muted me-1"> </i>Chicago</span></div>
                      </div>
                    </div>
                  </div>
                  <div class="card bg-secondary card-hover mb-3">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center">
                          <img class="me-2" src="img/avatars/22.jpg" alt="IT Pro Logo" width="24">
                          <span class="fs-sm text-dark opacity-80 px-1">
                            <h3 class="fs-sm m-0">John Smith</h3>
                            <span class="fs-xs text-dark opacity-80">8 june 2022, 10:52 PM</span>
                          </span>
                          
                        </div>
                        <!-- <div class="dropdown content-overlay">
                          <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
                          <ul class="dropdown-menu my-1" aria-labelledby="contextMenu1" style="">
                            <li>
                              <button class="dropdown-item" type="button"><i class="fi-x-circle opacity-60 me-2"></i>Not interested</button>
                            </li>
                          </ul>
                        </div> -->
                      </div>
                      <h3 class="h6 card-title pt-1 mb-2 mt-1">$110</h3>
                      <p class="fs-sm">Euismod nec sagittis sit arcu libero, metus. Aliquam nisl rhoncus porttitor volutpat, ante cras tincidunt. Nec sit nunc, ornare tincidunt enim, neque. Ornare pulvinar enim fames orci enim in libero.</p>
                      <div class="d-flex align-items-center justify-content-between">
                        <!--  <a class="btn btn-primary btn-sm mb-sm-0 mt-0 chat_open_nw"><i class="fi-chat-circle mt-n1 me-2 lead align-middle text-white"></i> Chat</a> -->
                        <div class="fs-sm"><span class="text-nowrap me-3"><i class="fi-map-pin text-muted me-1"> </i>Chicago</span></div>
                      </div>
                    </div>
                  </div>
                  <div class="card bg-secondary card-hover mb-3">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="d-flex align-items-center">
                          <img class="me-2" src="img/avatars/22.jpg" alt="IT Pro Logo" width="24">
                          <span class="fs-sm text-dark opacity-80 px-1">
                            <h3 class="fs-sm m-0">John Smith</h3>
                            <span class="fs-xs text-dark opacity-80">8 june 2022, 10:52 PM</span>
                          </span>
                          
                        </div>
                        <!-- <div class="dropdown content-overlay">
                          <button class="btn btn-icon btn-light btn-xs rounded-circle shadow-sm" type="button" id="contextMenu1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
                          <ul class="dropdown-menu my-1" aria-labelledby="contextMenu1" style="">
                            <li>
                              <button class="dropdown-item" type="button"><i class="fi-x-circle opacity-60 me-2"></i>Not interested</button>
                            </li>
                          </ul>
                        </div> -->
                      </div>
                      <h3 class="h6 card-title pt-1 mb-2 mt-1">$150</h3>
                      <p class="fs-sm">Euismod nec sagittis sit arcu libero, metus. Aliquam nisl rhoncus porttitor volutpat, ante cras tincidunt. Nec sit nunc, ornare tincidunt enim, neque. Ornare pulvinar enim fames orci enim in libero.</p>
                      <div class="d-flex align-items-center justify-content-between">
                        <!--  <a class="btn btn-primary btn-sm mb-sm-0 mt-0 chat_open_nw"><i class="fi-chat-circle mt-n1 me-2 lead align-middle text-white"></i> Chat</a> -->
                        <div class="fs-sm"><span class="text-nowrap me-3"><i class="fi-map-pin text-muted me-1"> </i>Chicago</span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        <?php endif ?>

          </div>
         
        </div>
      </div>

      

    </main>
<div class="modal fade" id="userinfo-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content" style="max-height: inherit; overflow: unset;">
      <div class="modal-header">
        <h4 class="h5 modal-title">Communicate with the advertiser</h4>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?php $msg = "Peace be upon you, ".$post_user['name'].". I have an inquiry regarding your ad. ".$post['title'].". The ad link: ".get_post_url($post)." " ?>
        <div class="modal-body fs-sm">
          <div class="mb-3">
            <ul>
              <li><a href="mailto:<?= $post_user['email'] ?>">private messages <i class="fa fa-envelope"></i></a></li>
              <li><a href="tel:<?= $post_user['phone'] ?>"><?= $post_user['phone'] ?> <i class="fa fa-phone"></i></a></li>
              <li><a href="https://api.whatsapp.com/send/?phone=<?= $post_user['phone'] ?>&text=<?= urlencode($msg) ?>&type=phone_number&app_absent=0">Message via WhatsApp <i class="fa fa-whatsapp"></i></a></li>
            </ul>
              
              
              

           
            
          </div>
        </div>
        
    
    </div>
  </div>
</div>
<?php
include_once 'includes/footer.php'; ?>

<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcpNpTtV_czTWzF9IJzqDpAnmcMI3yUlY&libraries=places&callback=initMap" async defer></script>-->
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
        //  lat = location.lat();
        //  lng = location.lng();
        lat = parseFloat("<?php echo $post['lat'];?>");
        lng = parseFloat("<?php echo $post['lng'];?>");
        console.log(lat);
        console.log(lng);
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
</script>
<script type="text/javascript" id="do_comment_js">
  function do_comment (e) 
  {
    e.preventDefault();
      $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/Shop/do_comment',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#do_comment')[0]),
      dataType: 'json',
      beforeSend: function() {        
        $('#do_comment_btn').prop('disabled' , true);
        $('#do_comment_btn').text('Processing..');
      },
      success : function(res){
        $('#do_comment_btn').prop('disabled' , false);
        $('#do_comment_btn').text('Send');
        if (res.status == 1) 
        {
            Swal.fire({
               title: res.title, 
               text: res.message, 
               icon: res.icon
             }).then(function (result) {
               
               location.reload()
            })
           
        }
        else
        {
          for (var err in res.message) {
            
            $("[name='" + err + "']").parent().parent().after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
            
          }
        }
      }
    });
return false;
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>
<script type="text/javascript">  
  $(".slick-slider").slick({
   slidesToShow: 1,
   infinite:false,
   slidesToScroll: 1,
   autoplay: true,
   autoplaySpeed: 2000
     // dots: false, Boolean
    // arrows: false, Boolean
  });


</script>
<script>
    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })
</script>
<script type="text/javascript">
  $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    startPosition: 2,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
</script>