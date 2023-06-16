
<?php 

use App\Models\Common_model;
$this->common_model = new Common_model();
$this->session = \Config\Services::session();
$this->user_id =  $this->session->get('user_id');
$this->user =  $this->common_model->GetSingleData('users' , array('id' => $this->user_id ));
 ?>

  <!-- Loop -->
  <?php if ($posts): ?>
    <?php foreach ($posts as $key => $value): ?>
      <?php  
      $img = $this->common_model->GetAllData('post_images' , array('post_id' => $value['id'] ));
      $check = false; 
      if($this->user_id){
            $check = $this->common_model->GetSingleData('wishlist' , array('post_id' => $value['id'],'user_id'=>$this->user_id)); 
      }
      $user_info =  $this->common_model->GetSingleData('users' , array('id' => $value['user_id'] ));
      if (!$user_info) {
       continue;
      }
      ?>

       <div class="<?= $col ?>">
              <div class="card shadow-sm card-hover border-0 h-100">
                 <div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="<?= get_post_url($value) ?>"></a>
                   
                    <div class="content-overlay end-0 top-0 pt-3 pe-3">
                      <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist" onclick="return addToFav(<?php echo $value['id'] ?>)"><i class="fa <?= ($check) ? 'fa-heart' : 'fa-heart-o' ?> post_heart_<?= $value['id'] ?>"></i></button>
                    </div>
                     <div>
                       <span class="badge rounded-pill bg-success py-1 px-2 fs-xs btn-feature "><?= ($value['is_featured']==0) ? '' : 'Featured'?></span>
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
                      <span class="badge rounded-pill bg-success py-1 px-2 fs-xs"><?= ($value['post_type']==0) ? '' : 'Auction'?></span>
                    </div>
                    <h3 class="h6 mb-2 mt-1 fs-base"><a class="nav-link stretched-link" href="<?= get_post_url($value) ?>"><?= $value['title'] ?></a></h3>
                    <?php if ($value['post_type'] == 1): ?>
                      <div class="auction_timer">
                        <p>Auction ends in :</p>
                        <div id="timer">
                          <span id="days<?= $value['id'] ?>" class="days"></span><b>days</b> 
                          <span id="hours<?= $value['id'] ?>" class="hours"></span><b>hours</b>
                          <span id="minutes<?= $value['id'] ?>" class="minutes"></span><b>minutes</b>
                          <span id="seconds<?= $value['id'] ?>" class="seconds"></span><b>seconds</b>
                        </div>
                      </div>
                      <script type="text/javascript">
                        var timer<?= $value['id'] ?>;

                        var compareDate<?= $value['id'] ?> = new Date('<?= date('d F, Y h:i a' , strtotime($value['auction_expire_date'].'24:00:00')) ?>');


                        timer<?= $value['id'] ?> = setInterval(function() {
                          timeBetweenDates<?= $value['id'] ?>(compareDate<?= $value['id'] ?>);
                        }, 1000);

                        function timeBetweenDates<?= $value['id'] ?>(toDate) {
                          var dateEntered = toDate;
                          var now = new Date();
                          var difference = dateEntered.getTime() - now.getTime();
                          console.log(compareDate<?= $value['id'] ?>)
                          if (difference <= -1) {

                            // Timer done
                            clearInterval(timer<?= $value['id'] ?>);
                          
                          } else {
                            
                            var seconds = Math.floor(difference / 1000);
                            var minutes = Math.floor(seconds / 60);
                            var hours = Math.floor(minutes / 60);
                            var days = Math.floor(hours / 24);

                            hours %= 24;
                            minutes %= 60;
                            seconds %= 60;

                            $("#days<?= $value['id'] ?>").text(days);
                            $("#hours<?= $value['id'] ?>").text(hours);
                            $("#minutes<?= $value['id'] ?>").text(minutes);
                            $("#seconds<?= $value['id'] ?>").text(seconds);
                          }
                        }
                      </script>
                    <?php endif ?>
                    
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
                    <p class="mb-2 fs-sm text-muted"><?= substr($value['description'],0,50) ?></p>
                    <div class="d-flex align-items-center text-decoration-none" href="#"><img class="rounded-circle loaded tns-complete" src="<?= base_url($user_info['image']) ?>" alt="<?= $user_info['name'] ?>" width="44">
                      <div class="ps-2">
                        <h6 class="fs-sm text-nav lh-base mb-1"><?= $user_info['name'] ?></h6>
                        <div class="d-flex text-body fs-xs"><span class="me-2 pe-1"><i class="fi-calendar-alt opacity-70 mt-n1 me-1 align-middle"></i><?= humanDate($value['created_at']) ?></span><span><i class="fi-chat-circle opacity-70 mt-n1 me-1 align-middle"></i>No comments</span></div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
   
    <?php endforeach ?>
  <?php else: ?>
    <div class="col-sm-12">
      <div class="alert alert-danger">No item found!</div>
    </div>
  <?php endif ?>
