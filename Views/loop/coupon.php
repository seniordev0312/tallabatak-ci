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
     $check = false; 
      if($this->user_id){
            $check = $this->common_model->GetSingleData('wishlist' , array('post_id' => $value['id'],'post_type' => 'coupon' ,'user_id'=>$this->user_id)); 
      }
      $user_info =  $this->common_model->GetSingleData('users' , array('id' => $value['user_id'] ));
      if (!$user_info) {
       continue;
      }
       if ($this->user_id)
       {
   
           $link_attr = 'href="'.base_url().'/coupon-detail/'.$value['id'].'"';
        }
        else
        {
            $link_attr = 'href="#signin-modal" data-bs-toggle="modal"';
        }
        ?>


       <div class="<?= $col ?>">
            <div class="card shadow-sm card-hover border-0 h-100">
                <div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" <?= $link_attr ?>></a>
                    <div class="content-overlay end-0 top-0 pt-3 pe-3">
                    </div>
                    <div class="content-overlay end-0 top-0 pt-3 pe-3">
                      <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle " type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist" onclick="return addToFav(<?php echo $value['id'] ?> , 'coupon')"><i class="fa <?= ($check) ? 'fa-heart' : 'fa-heart-o' ?> post_heart_<?= $value['id'] ?>"></i></button>
                    </div>

                    <div>
                       <span class="badge rounded-pill bg-success py-1 px-2 fs-xs me-5"></span>
                    </div>
                    
                    <div>
                        <img style="height: 200px; object-fit: cover;" src="<?php echo base_url($value['image']);?>" alt="Image">
                    </div>
                </div>
                
                <div class="card-body position-relative pb-3">                                
                    <h3 class="h6 mb-2 mt-1 fs-base">
                        <a class="nav-link stretched-link" <?= $link_attr ?>><?= $value['title']?> <?= $value['coupon_off'] ?>% OFF </a>
                    </h3>
                   
                    <p >Valid till : <?= date('d M Y' , strtotime($value['end_date'] ))?><br>Price : $<?= $value['price'] ?></p>
                   
                    <a <?= $link_attr ?> class="btn btn-primary">See Details</a>
                  
                    
                </div>
            </div>
        </div>
   
    <?php endforeach ?>
  <?php else: ?>
    <div class="col-sm-12">
      <div class="alert alert-danger">No item found!</div>
    </div>
  <?php endif ?>
