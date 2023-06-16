<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<style type="text/css">
  
.slick-slider .item{
  height:100px;
  width:100px;
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


</style>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Post</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Post</a></li>
                            <li class="breadcrumb-item active">Post</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Post Details</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        
                                    </div>
                                </div>
                                <div class="">
                                        <div class="row">
                                        <?php $cat = $this->common_model->GetSingleData('category',array('id' =>$view['category']))?>
                                           <div class="col-md-4">Category</div>
                                           <div class="col-md-8"><b><?= $cat['title_eng']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Title</div>
                                           <div class="col-md-8"><b><?= $view['title']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Description</div>
                                           <div class="col-md-8"><b><?= $view['description']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Distance</div>
                                           <div class="col-md-8"><b><?= $view['distance']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Post Type</div>
                                           <div class="col-md-8"><b><?php 
                                             if($view['post_type']==0){
                                              echo "Normal";
                                             }else{
                                                echo "Auction";
                                           }; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Address</div>
                                           <div class="col-md-8"><b><?= $view['address']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Country</div>
                                           <div class="col-md-8"><b><?= $view['country']; ?></b></div>
                                        </div>
                                        <hr>
                                         <div class="row">
                                           <div class="col-md-4">State</div>
                                           <div class="col-md-8"><b><?= $view['state']; ?></b></div>
                                        </div>
                                        <hr>
                                         <div class="row">
                                           <div class="col-md-4">City</div>
                                           <div class="col-md-8"><b><?= $view['city']; ?></b></div>
                                        </div>
                                        <hr>
                                         <div class="row">
                                           <div class="col-md-4">Zip code</div>
                                           <div class="col-md-8"><b><?= $view['zipcode']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Price</div>
                                           <div class="col-md-8"><b><?= $view['currency'].''.$view['price']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Duration</div>
                                           <div class="col-md-8"><b><?= $view['duration']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Auction Quantity</div>
                                           <div class="col-md-8"><b><?= $view['auction_qty']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Auction Expire Date</div>
                                           <div class="col-md-8"><b><?= $view['auction_expire_date']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Auction Price</div>
                                           <div class="col-md-8"><b><?= $view['auction_price'].''.$view['auction_currency']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Create At</div>
                                           <div class="col-md-8"><b><?= humanDate($view['created_at']); ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Updated At</div>
                                           <div class="col-md-8"><b><?= humanDate($view['updated_at']); ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                        <?php $img = $this->common_model->GetAllData('post_images',array('post_id' =>$view['id']))?>
                                          <div class="col-md-4">Image</div>
                                          <div class="col-md-8">
                                            <div class="slick-slider">
                                                <?php 
                                                if($img){
                                                foreach($img as $images) {?>
                                                    <div class="item">
                                                        <img style="height: 100px;width: 100px;" src="<?php echo base_url().'/'.$images["file"]?>">
                                                    </div>
                                                <?php }} ?>
                                            </div>
                                          </div>
                                          </div>
                                        </div>
                                        <hr>
                                </div>
                        </div>
                        </div><!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
            
            <!-- Modal -->
            
            <!--end modal -->
        </div>
        <!-- container-fluid -->
    </div>
    <?php include 'include/footer.php'; ?>
    


<script src="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script> 

<script type="text/javascript">
    
    $(document).ready(function(){
        $(".slick-slider").slick({
            slidesToShow: 1,
            infinite:true,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: true,
        });
});

</script>