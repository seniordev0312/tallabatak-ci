<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<style type="text/css">
  
.slick-slider .element{
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
                    <h4 class="mb-sm-0">Users</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                        <h4 class="card-title mb-0">Users Details</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        
                                    </div>
                                </div>
                                <div class="">
                                        <div class="row">
                                           <div class="col-md-4">Name</div>
                                           <div class="col-md-8"><b><?= $view['name']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">User Type</div>
                                           <div class="col-md-8"><b><?php 
                                             if($view['user_type']==1){
                                              echo "Customer";
                                             }else{
                                                echo "Vendor";
                                           }; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                           <div class="col-md-4">Email</div>
                                           <div class="col-md-8"><b><?= $view['email']; ?></b></div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                          <div class="col-md-4">Image</div>
                                          <div class="col-md-8">
                                            
                                              <img style="height: 100px;width: 100px;" src="<?php echo base_url().'/'.$view["image"]?>">
                                            </div>
                                             
                                          </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                          <div class="col-md-4">Document</div>
                                          <div class="col-md-8">
                                            <!-- <div class="slick-slider"><b> -->
                                              <?php if(!empty($view)) { ?>
                                                <div class="col-md-8"><a href="<?= base_url().'/'.$view['document_id']; ?>" class="btn btn-sm btn-info" target="_blank">View</a></div>
                                                <?php }else{ ?>
                                                <div class="col-md-8"><b>No document found</b></div>
                                                  <?php
                                                  }
                                                ?>
                                            <!-- </div></b> -->
                                          </div>
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
    <script type="text/javascript">
    
     $(document).ready(function(){
         $(".slick-slider").slick({
           slidesToShow: 3,
           infinite:false,
           slidesToScroll: 1,
           autoplay: true,
           autoplaySpeed: 2000
             // dots: false, Boolean
            // arrows: false, Boolean
          });
});

</script>

<script src="js/jquery-3.4.1.min.js"></script>
     <script src="js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script> 

 