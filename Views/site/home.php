<?php include 'includes/header.php'; ?>
    <!-- Page content-->
      <!-- Hero-->
      <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
      <section class="container-fluid mt-5 top_banner">
        <div class="row pt-0 pt-md-2 pt-lg-0 justify-content-center mx-0">
          <!-- <div class="col-xl-5 col-lg-6 col-md-5 order-md-2 mb-4 mb-lg-3">
            <img src="<?= base_url() ?>/assets/site/imgs/banner_img.png" alt="Hero image">
          </div> -->
          <div class="col-xl-7 col-lg-6 col-md-7 order-md-1 pe-lg-0 ps-lg-0 mb-3 text-md-start text-center">
            <h1 class="display-4 mb-md-4 mb-3 pt-md-4 pb-lg-2 text-center">Easy way to find <br> everything for you</h1>
            <p class="position-relative lead text-center fs-base">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
          </div>
          <!-- Search property form group-->
          <div class="col-xl-8 col-lg-10 order-3">
            <form class="form-group d-block" id="f-search">
              <div class="row g-0 ms-sm-n2">
                <div class="col-md-12 d-flex align-items-center">
                 <input class="form-control form-control-lg" type="text" id="pr-position" placeholder="What are you looking for..." required="" >
                 <a href="#"  class="btn btn-icon btn-primary px-3 w-sm-auto flex-shrink-0 " type="button" onclick="search_filter('keyword')"><i class="fi-search"></i></a>
                </div>
              </div>
            </form>
          </div>

          <div class="col-xl-8 col-lg-10 order-3">
            <form class="form-group d-block form_btns">
              <div class="row g-0 ms-sm-n2">
                <div class="col-md-12 d-flex align-items-center justify-content-center">
              
                  <div class="dropdown" data-bs-toggle="select">
                    <i class="fi-map-pin me-2 text-light"></i>
                    <select class="btn btn-link dropdown-toggle ps-2 ps-sm-3 drop_region" id="search_category">
                      <option value="<?= base_url('shop') ?>">All Categories</option>
                     <?php   $category = $this->common_model->GetAllData('category','' ,'id','desc'); ?>
              <?php if($category) {  ?>
              <?php foreach($category as $cat) {  ?>
              <option value="<?= base_url('shop/'.slugify($cat['title_eng']).'-'.$cat['id']) ?>"><?= $cat['title_eng'] ?></option>
              <?php } } ?>
          
                      
                     
                    </select>
                  </div>
                  <button class="btn btn-icon btn-primary px-3 w-auto flex-shrink-0 ms-2 mr_top" type="button" onclick="search_filter('category')"><i class="fi-search"></i></button>
                  <!-- <button class="btn btn-icon btn-primary px-3 w-auto flex-shrink-0 ms-1" onclick="search_filter('nearby')" type="button"><i class="fi-map-pin me-2"></i> Near</button> -->
                </div>
                
              </div>
            </form>
          </div>
        </div>
      </section>


    <div class="banner_middle_section">
      
         <?php  $latest_post = $this->common_model->GetLatestPost('3'); 
            
        ?>
        
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" style="background:url(<?=base_url().'/'.$latest_post[1]['file'] ?>) no-repeat center/cover;">
                <?php foreach ($latest_post as $key => $value) { ?>
                    <div class="carousel-item  overflow-auto <?= ($key == 0) ?  'active' : ''  ?>" data-bs-interval="3000" style="backdrop-filter:blur(25px);width:100%">
                      <!-- <div style="display:flex;justify-content:center;"> -->
                          <a href="<?php echo get_post_url($value)?>">
                            <img src="<?= $value['file'] ?>" class="d-block w-100" alt="..." style="object-fit:contain!important;">
                          </a>
                      <!-- </div> -->
                    </div>
                <?php } ?>
                
            </div>
           <!--  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button> -->
        </div>
     </div>

      <!-- Property categories-->
      <section class="container mt-5 mb-5 cat_sec">

        <div class="d-flex align-items-center justify-content-between mb-4">
          <h2 class="h3 mb-0">Categories</h2><a class="btn btn-link fw-normal p-0 " href="<?= base_url('shop')  ?>">View all<i class="fi-arrow-long-right ms-2"></i></a>
        </div>

        <div class="row row-cols-lg-6 row-cols-sm-3 row-cols-2 g-3 g-xl-4">
          <?php $categories = $this->common_model->GetAllData('category' ,array('parent_id' => 0 ) , 'id' , 'desc' , 6); ?>
          <?php foreach ($categories as $key => $value): ?>
            <div class="col">
              <a class="icon-box card card-body h-100 border-0 shadow-sm card-hover h-100 text-center" href="<?= base_url('shop/'.slugify($value['title_eng']).'-'.$value['id']) ?>">
              <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3 mx-auto">
                <img src="<?= base_url($value['image']) ?>">
              </div>
              <h3 class="icon-box-title fs-base mb-0"><?= $value['title_eng'] ?></h3></a>
          </div>
          <?php endforeach ?>
          
        <!--   <div class="col">
            <div class="dropdown h-100"><a class="icon-box card card-body h-100 border-0 shadow-sm card-hover text-center" href="search.php" data-bs-toggle="dropdown">
                <div class="icon-box-media bg-faded-primary text-primary rounded-circle mb-3 mx-auto"><i class="fi-dots-horisontal"></i></div>
                <h3 class="icon-box-title fs-base mb-0">More</h3></a>
              <div class="dropdown-menu dropdown-menu-end my-1"><a class="dropdown-item fw-bold" href="#"><i class="fi-single-bed fs-base opacity-60 me-2"></i>personal items</a><a class="dropdown-item fw-bold" href="#"><i class="fi-computer fs-base opacity-60 me-2"></i>furniture</a><a class="dropdown-item fw-bold" href="#"><i class="fi-real-estate-buy fs-base opacity-60 me-2"></i>Livestock</a><a class="dropdown-item fw-bold" href="#"><i class="fi-parking fs-base opacity-60 me-2"></i>Animals and birds</a></div>
            </div>
          </div> -->
        </div>
      </section>
      <!-- Services-->
        
      <hr class="mt-n1 mb-5 d-md-none">
      <!-- Top offers (carousel)-->
      <section class="container mb-5 pb-md-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h2 class="h3 mb-0">Top List</h2><a class="btn btn-link fw-normal p-0" href="<?= base_url('shop')  ?>">View all<i class="fi-arrow-long-right ms-2"></i></a>
        </div>
        <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-nav-outside-flush mx-n2">
          <div class="tns-carousel-inner row gx-4 mx-0 pt-3 pb-4" data-carousel-options="{&quot;items&quot;: 4, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3},&quot;992&quot;:{&quot;items&quot;:4}}}">
            <!-- Item-->

           <?= view('loop/post', ['posts'=> $top_list , 'col'=> 'col-sm-6 top_posts' ]); ?>

          </div>
        </div>
      </section>
      <section class="mb-5 mt-n3 mt-lg-0 how_to_work">

          <div class="container">
          <div class="row gx-4 mx-0 py-3">
            <div class="col-md-4 mb-3">
              <div class="card card-hover border-0 h-100 pb-2 pb-sm-3 px-sm-3 text-center"><img class="d-block mx-auto my-3" src="<?= base_url() ?>/assets/site/imgs/buy.png" width="256" alt="Illustration">
                <div class="card-body">
                  <h2 class="h4 card-title">Buy everything</h2>
                  <p class="card-text fs-sm">Blandit lorem dictum in velit. Et nisi at faucibus mauris pretium enim. Risus sapien nisi aliquam egestas leo dignissim.</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card card-hover border-0 h-100 pb-2 pb-sm-3 px-sm-3 text-center"><img class="d-block mx-auto my-3" src="<?= base_url() ?>/assets/site/imgs/selling.png" width="256" alt="Illustration">
                <div class="card-body">
                  <h2 class="h4 card-title">Sell everything</h2>
                  <p class="card-text fs-sm">Amet, cras orci justo, tortor nisl aliquet. Enim tincidunt tellus nunc, nulla arcu posuere quis. Velit turpis orci venenatis.</p>
                </div>
              </div>
            </div>
            <div class="col-md-4 mb-3">
              <div class="card card-hover border-0 h-100 pb-2 pb-sm-3 px-sm-3 text-center"><img class="d-block mx-auto my-3" src="<?= base_url() ?>/assets/site/imgs/add-product.png" width="256" alt="Illustration">
                <div class="card-body">
                  <h2 class="h4 card-title">Place an Ad</h2>
                  <p class="card-text fs-sm">Sed sed aliquet sed id purus malesuada congue viverra. Habitant quis lacus, volutpat natoque ipsum iaculis cursus.</p>
                </div>
              </div>
            </div>
          </div>
          </div>
      </section>


      <!-- Recently added-->
      <!-- <section class="container pb-4 pt-1 mb-5">
        <div class="d-flex align-items-end align-items-lg-center justify-content-between mb-4 pb-md-2">
          <div class="d-flex w-100 align-items-center justify-content-between justify-content-lg-start">
            <h2 class="h3 mb-0 me-md-4">Added today</h2>
            <div class="dropdown d-md-none" data-bs-toggle="select">
              <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"><span class="dropdown-toggle-label">Houses</span></button>
              <input type="hidden">
              <div class="dropdown-menu"><a class="dropdown-item" href="#"><span class="dropdown-item-label">Apartments</span></a><a class="dropdown-item" href="#"><span class="dropdown-item-label">Houses</span></a><a class="dropdown-item" href="#"><span class="dropdown-item-label">Rooms</span></a><a class="dropdown-item" href="#"><span class="dropdown-item-label">Commercial</span></a></div>
            </div>
            <ul class="nav nav-tabs d-none d-md-flex ps-lg-2 mb-0">
              <li class="nav-item"><a class="nav-link fs-sm mb-2 mb-md-0" href="#">Apartments</a></li>
              <li class="nav-item"><a class="nav-link fs-sm active mb-2 mb-md-0" href="#">Houses</a></li>
              <li class="nav-item"><a class="nav-link fs-sm mb-2 mb-md-0" href="#">Rooms</a></li>
              <li class="nav-item"><a class="nav-link fs-sm mb-2 mb-md-0" href="#">Commercial</a></li>
            </ul>
          </div><a class="btn btn-link fw-normal d-none d-lg-block p-0" href="#">View all<i class="fi-arrow-long-right ms-2"></i></a>
        </div>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="card bg-size-cover bg-position-center border-0 overflow-hidden h-100" style="background-image: url(img/real-estate/recent/01.jpg);"><span class="img-gradient-overlay"></span>
              <div class="card-body content-overlay pb-0">
                <div class="d-flex"><span class="badge bg-success fs-sm me-2">Verified</span><span class="badge bg-info fs-sm">New</span></div>
              </div>
              <div class="card-footer content-overlay border-0 pt-0 pb-4">
                <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5"><a class="text-decoration-none text-light pe-2" href="#">
                    <div class="fs-sm text-uppercase pt-2 mb-1">For rental</div>
                    <h3 class="h5 text-light mb-1">Luxury Rental Villa</h3>
                    <div class="fs-sm opacity-70"><i class="fi-map-pin me-1"></i>118-11 Sutphin Blvd Jamaica, NY 11434</div></a>
                  <div class="btn-group ms-n2 ms-sm-0 mt-3"><a class="btn btn-primary px-3" href="#" style="height: 2.75rem;">From $3,850</a>
                    <button class="btn btn-primary btn-icon border-end-0 border-top-0 border-bottom-0 border-light fs-sm" type="button"><i class="fi-heart"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card bg-size-cover bg-position-center border-0 overflow-hidden mb-4" style="background-image: url(img/real-estate/recent/02.jpg);"><span class="img-gradient-overlay"></span>
              <div class="card-body content-overlay pb-0"><span class="badge bg-info fs-sm">New</span></div>
              <div class="card-footer content-overlay border-0 pt-0 pb-4">
                <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5"><a class="text-decoration-none text-light pe-2" href="#">
                    <div class="fs-sm text-uppercase pt-2 mb-1">For sale</div>
                    <h3 class="h5 text-light mb-1">Duplex with Garage</h3>
                    <div class="fs-sm opacity-70"><i class="fi-map-pin me-1"></i>21 Pulaski Road Kings Park, NY 11754</div></a>
                  <div class="btn-group ms-n2 ms-sm-0 mt-3"><a class="btn btn-primary px-3" href="#" style="height: 2.75rem;">$200,410</a>
                    <button class="btn btn-primary btn-icon border-end-0 border-top-0 border-bottom-0 border-light fs-sm" type="button"><i class="fi-heart"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card bg-size-cover bg-position-center border-0 overflow-hidden" style="background-image: url(img/real-estate/recent/03.jpg);"><span class="img-gradient-overlay"></span>
              <div class="card-body content-overlay pb-0"><span class="badge bg-info fs-sm">New</span></div>
              <div class="card-footer content-overlay border-0 pt-0 pb-4">
                <div class="d-sm-flex justify-content-between align-items-end pt-5 mt-2 mt-sm-5"><a class="text-decoration-none text-light pe-2" href="#">
                    <div class="fs-sm text-uppercase pt-2 mb-1">For sale</div>
                    <h3 class="h5 text-light mb-1">Country House</h3>
                    <div class="fs-sm opacity-70"><i class="fi-map-pin me-1"></i>6954 Grand AveMaspeth, NY 11378</div></a>
                  <div class="btn-group ms-n2 ms-sm-0 mt-3"><a class="btn btn-primary px-3" href="#" style="height: 2.75rem;">$162,000</a>
                    <button class="btn btn-primary btn-icon border-end-0 border-top-0 border-bottom-0 border-light fs-sm" type="button"><i class="fi-heart"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> -->
  
      <!-- Top agents (lnked carousel)-->
      <?php 
         if($testimonial){

      ?>
      <section class="container mb-5 pb-2 pb-lg-4">
        <h2 class="h3 mb-4 pb-3 text-center text-md-start">Our Testimonials</h2>
        <div class="tns-carousel-wrapper">
          <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 1, &quot;mode&quot;: &quot;gallery&quot;, &quot;controlsContainer&quot;: &quot;#agents-carousel-controls&quot;, &quot;nav&quot;: false}">
            
              <!--start foreach -->
               <?php 
                foreach ($testimonial as $key => $value) {
              ?>
              
              <div>
              <div class="row align-items-center">
                <div class="col-xl-4 d-none d-xl-block"><img class="rounded-3" src="<?= base_url($value['image']) ?>" alt="Agent picture"></div>
               <div class="col-xl-4 d-none d-xl-block"><img class="rounded-3" src="<?= (@$testimonial[$key+1]) ? base_url($testimonial[$key+1]['image']) : base_url('assets/upload/default.png') ?>" alt="Agent picture"></div>
            <div class="col-xl-4 col-md-7 col-sm-8 px-4 px-sm-3 px-md-0 ms-md-n4 mt-n5 mt-sm-0 py-3">
                  <div class="card border-0 shadow-sm ms-sm-n5">
                    <blockquote class="blockquote card-body">
                      <h4 style="max-width: 22rem;">&quot;<?= $value['title']; ?> &quot;</h4>
                      <p class="d-sm-none d-lg-block"><?= $value['description']; ?> </p>
                      <footer class="d-flex justify-content-between">
                        <div class="pe-3"><a class="text-decoration-none" href="#">
                            <h6 class="mb-0"><?= $value['name']; ?></h6>
                            <div class="text-muted fw-normal fs-sm mb-3"><?= $value['position']; ?></div></a></div>
                        <div><span class="star-rating"><?php  if(!empty($value['rate'])){ 
                                                $float = explode('.', $value['rate']);
                                                for($i=1; $i<=5; $i++){ if($i<=$value['rate']){ ?>
                                                <i style="color:orange;" class="fa fa-star rating-color"></i>
                                                <?php }else{ 
                                                    if(!empty($float[1])){  $float = []; ?> 
                                                    <i class="fa fa-star fa-star-half-o"></i>
                                                <?php }else{ ?>
                                                    <i class="fa fa-star"></i>
                                                <?php }
                                                }
                                                
                                                }?> 
                                                <span class="badge light badge-success"><?php echo $value['rate']; ?></span>
                                        <?php } else{
                                            for($i=1; $i<=5; $i++){  ?> 
                                                <i class="fa fa-star"></i>
                                            <?php  } ?>
                                            <span class="badge light badge-success">0</span>
                                        <?php }
                                        ?></span>
                          
                        </div>
                      </footer>
                    </blockquote>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
        <!--end foreach -->
            
            
            
          </div>
        </div>
        <div class="tns-carousel-controls justify-content-center justify-content-md-start my-2 mt-md-4" id="agents-carousel-controls">
          <button class="mx-2" type="button"><i class="fi-chevron-left"></i></button>
          <button class="mx-2" type="button"><i class="fi-chevron-right"></i></button>
        </div>
      </section>
    <?php } ?>
    </main>

<?php include 'includes/footer.php'; ?>
