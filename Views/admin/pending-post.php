<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
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
                        <h4 class="card-title mb-0">Pending Post list</h4>
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
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Post Type</th>
                                                <th>Price</th>
                                                <th>Address</th>
                                                <th>Created At</th>
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
                                                 <?php $imageDetail=$this->common_model->GetSingleData('post_images',array('post_id' =>$value['id']));
                                                    $image = ($imageDetail) ? ($imageDetail['file']) : 'assets/images/no_image.jpg';
                                                 ?>
                                                 <td><img src="<?=base_url().'/'.$image?>" alt="" width="50" height="60"></td>
                                                 <td><?= $value['title'] ?></td>
                                                 <td><?= substr($value['description'],0,50) ?></td>
                                                 <td><?= ($value['post_type']==0) ? ("Normal") : "Auction" ?></td>
                                                 <td><?= $value['currency'].' '.$value['price'] ?></td>
                                                 <td><p>Address: <?= $value['address']?></p>
                                                     <p>City: <?= $value['city']?></p>
                                                     <p>State: <?=$value['state']?></p>
                                                     <p>Zipcode: <?= $value['zipcode'] ?></p>
                                                     <p>Country: <?= $value['country'] ?></p>
                                                 </td>
                                                 <td><?= humanDate($value['created_at']) ?></td>
                                                <td>
                                                  <?php
                                                    if($value['status'] == 0){
                                                   ?>
                                                   <button class="btn  btn-sm btn-success" id="submit<?= $value['id']; ?>" onclick="change_status(<?php echo $value['id']; ?>,1,<?php echo $value['user_id']; ?>)">Approve</button>
                                                  <?php
                                                    }
                                                  ?>
                                                        <a href="<?php echo base_url()?>/admin/post-view/<?=$value['id']?>" class="btn btn-sm btn-info" >View Details</a>
                                                       <!--  <a href="<?php echo base_url()?>/admin/post-comments/<?=$value['id']?>" class="btn btn-sm btn-dark" >View Comments</a> -->
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

<script>
   function change_status(id,status,user_id)
   {
    if(confirm('Are you sure?'))
    {
    $.ajax({
          type: "POST",
          url: "<?php echo base_url('Admin/Post/approved_post'); ?>",
          data: {id:id,status:status,user_id:user_id},
          dataType: "json",
          beforeSend:function(){
          $('#submit'+id).prop('disabled',true);
          $('#submit'+id).text('processing',true);
          
        },
          success: function(data){
            if(data.status == 1)  //json status return by controller
            {
                location.reload();
            }
            else
            {
              $('.error-msg').html(data.message);
              $('#submit'+id).prop('disabled',false);
            }
              
          },
          
     });
    }

   }
</script>
    