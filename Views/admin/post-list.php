<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"><?= ucfirst($page_title); ?></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?= ucfirst($page_title); ?></a></li>
                            <li class="breadcrumb-item active"><?= ucfirst($page_title); ?></li>
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
                        <h4 class="card-title mb-0"><?php if($post_type==1){ echo ucfirst($page_title); } else{ ?>Approved <?= ucfirst($page_title); ?> <?php }  ?> list</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div id="customerList">
                                <?= $this->session->getFlashdata('msg'); ?>
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <!-- <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#myModal" id="add_btns">Add</button> -->
                                    </div>
                                 
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="example23">
                                        <thead class="table-light">
                                            <tr>
                                               <th>S.No</th>
                                               <?php if($post_type!==1){ ?> <th>Image</th> <?php } ?>
                                                <th>User</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <?php if($post_type==1){ ?> <th>Quantity</th> <?php } ?>
                                                <?php if($post_type==1){ ?> <th>Category</th> <?php } ?>
                                                <?php if($post_type==1){ ?> <th>Expire date</th> <?php } ?>
                                                <th>Post Type</th>
                                                <th>Price</th>
                                                <?php if($post_type!==1){ ?>
                                                    <th>Address</th>
                                                    <th>Created At</th>
                                                <?php } ?>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        <?php if ($post_list): $i = 1; ?>
                                            <?php foreach ($post_list as $key => $value):
                                            // foreach ($view as $key => $imgvalue):
                                                
                                                ?>
                                                <tr> 
                                                 <td><?= $i; ?></td>
                                                 <?php 
                                                    $imageDetail=$this->common_model->GetSingleData('post_images',array('post_id' =>$value['id']));
                                                    $image = ($imageDetail) ? ($imageDetail['file']) : 'assets/images/no_image.jpg';
                                                 ?>
                                                <?php if($post_type!==1){ ?>
                                                    <td><img src="<?=base_url().'/'.$image?>" alt="" width="50" height="60"></td>
                                                <?php } ?>
                                                    <td>
                                                        <?php $user =$this->common_model->GetSingleData('users',array('id' =>$value['user_id'])); 
                                                            if(!empty($user)){ ?>
                                                                <a href="<?php echo base_url('admin/userview/'.$value['user_id']); ?>"><?php echo $user['name']; ?> </a>
                                                            <?php  } ?>
                                                    </td>
                                                    <td><?= $value['title'] ?></td>
                                                    <td><?php if (strlen($value['description']) > 30) { echo substr($value['description'], 0, 30). '......'; } else { echo $value['description']; } ?></td>

                                                    <?php if($post_type==1){ ?><td><?php echo $value['auction_qty']; ?></td><?php } ?>

                                                    <?php if($post_type==1){ $category =$this->common_model->GetSingleData('category',array('id' =>$value['category'])); ?>
                                                      <td><?php if(!empty($category)){ echo $category['title_eng']; } ?></td>
                                                    <?php } ?>
                                                    <?php if($post_type==1){ ?><td><?php echo humanDate($value['auction_expire_date']); ?></td><?php } ?>

                                                    <td><?= ($value['post_type']==0) ? ("Normal") : "Auction" ?></td>

                                                    <td>
                                                        <?php if($post_type==1){ echo $value['auction_currency'].' '.$value['auction_price']; }else{ echo $value['currency'].' '.$value['price']; } ?>
                                                            
                                                    </td>
                                                <?php if($post_type!==1){ ?>
                                                    <td><p>Address: <?= $value['address']?></p> 
                                                        <p>City: <?= $value['city']?></p>
                                                        <p>State: <?=$value['state']?></p>
                                                        <p>Zipcode: <?= $value['zipcode'] ?></p>
                                                        <p>Country: <?= $value['country'] ?></p>
                                                    </td>
                                                    <td><?= humanDate($value['created_at']) ?></td>
                                                 <?php } ?>

                                                <td>
                                                        <a href="<?php echo base_url()?>/admin/post-view/<?=$value['id']?>" class="btn btn-sm btn-info" >View Details</a>
                                                        <a href="<?php echo base_url()?>/admin/post-comments/<?=$value['id']?>" class="btn btn-sm btn-dark" >View Comments</a>
                                                    
                                                        <button class="btn  btn-sm btn-danger" id="delete_btns" onclick="delete_post(<?= $value['id'] ?>)">Delete</button>
                                                    
                                                </td>
                        </tr>
                        <?php $i++; endforeach ?>
                  
                  <?php  endif ?>    
                    </tbody>
                </table> 
                                
                      <div class="noresult" style="display: <?= ($post_list) ? 'none' : 'block' ?>">
                          <div class="text-center">
                              <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                              <h5 class="mt-2">Sorry! No Result Found</h5>
                              
                          </div>
                      </div>

                                </div>
                                <div class="d-flex justify-content-end">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">
                                            Previous
                                        </a>
                                    <ul class="pagination listjs-pagination mb-0"></ul>
                                    <a class="page-item pagination-next" href="#">
                                        Next
                                    </a>
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
    <script>
        function delete_post(id) {
        // event.preventDefault();
    if(confirm('Are you sure ?'))
    {
        $.ajax({
      url: '<?= base_url() ?>/Admin/Post/deletePost',
      type: 'POST',
      cache:false,
      data:{'id':id},
      dataType: 'json',
      beforeSend: function() {
        $('#delete_btns'+id).prop('disabled' , true);
        $('#delete_btns'+id).text('Processing..');
      },
      success : function(res){
        console.log(res);
        $('#delete_btns'+id).prop('disabled' , false);
        if (res.status == 1) {
           Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
            location.reload();
            })
        }
        
      }
    });
    }
    
}
    </script>
    