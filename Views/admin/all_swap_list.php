<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Swap</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Swap</a></li>
                            <li class="breadcrumb-item active">Swap</li>
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
                        <h4 class="card-title mb-0">Swap list</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div id="customerList">
                               
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="example23">
                                        <thead class="table-light">
                                            <tr>
                                               <th>S.No</th>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Description</th>
                                                <th>User</th>
                                                <th>Status</th>
                                                 <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            <?php if ($all_swap): $i = 1; ?>
                                                <?php foreach ($all_swap as $key => $value): 
                                                     $user = $this->common_model->GetSingleData('users',array('id'=>$value['user_id']));
                                                    ?>
                                                    <tr>
                                                        <td><?= $i; ?></td>
                                                        <td><?= $value['title']; ?></td>
                                                        <td><img src="<?= base_url($value['image']); ?>" class="img-thumbnail" width="100px;"></td>
                                                        <td> <?php if (strlen($value['description']) > 30) { echo substr($value['description'], 0, 30). '......'; } else { echo $value['description']; } ?></td>
                                                        <td> 
                                                            <?php if($user){  ?>
                                                                <a href="<?php echo base_url('admin/userview/'.$value['user_id']); ?>"><?= $user['name']; ?></a>
                                                            <?php  } ?> 
                                                        </td>
                                                        <td><?php if($value['status'] == 1){ echo "<span class='badge badge-soft-success'>Enable</span>"; }else{ echo "<span class='badge badge-soft-danger'>Disable</span>"; } ?></td>
                                                        <td>
                                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $value['id']; ?>">View</button>
                                                            <button class="btn btn-danger btn-sm" id="delete_btns<?= $value['id']; ?>" onclick="delete_swap(<?= $value['id'] ?>)">Delete</button>
                                                            <?php if($value['status']==1){ ?> <button class="btn btn-danger btn-sm" id="status_btns<?= $value['id']; ?>" onclick="change_status(0, <?= $value['id'] ?>)">Disable</button> <?php }else{ ?> <button class="btn btn-success btn-sm" id="status_btns<?= $value['id']; ?>" onclick="change_status(1, <?= $value['id'] ?>)">Enable</button> <?php } ?>


                                                        </td>
                                                    </tr>

                                                    <div class="modal" id="editModal<?= $value['id']; ?>">                 
                                                      <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                          <div class="modal-header bg-light p-3">
                                                            <h4 class="modal-title p-0">View Swap</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                          </div>
                                                          <div class="modal-body">
                                                            <div class="col-md-12"><label>Title:</label> <?= $value['title']; ?></div>
                                                            <div class="col-md-12"><label>Image:</label> <img src="<?= base_url($value['image']); ?>" class="img-thumbnail" width="100px;"></div>
                                                            <div class="col-md-12"><label>User name:</label> <?php if($user){ echo $user['name']; } ?></div>
                                                            <div class="col-md-12"><label>Description:</label> <br><?= $value['description']; ?></div>
                                                            <div class="col-md-12"><label>Status:</label> <?php if($value['status'] == 1){ echo "<span class='badge badge-soft-success'>Enable</span>"; }else{ echo "<span class='badge badge-soft-danger'>Disable</span>"; } ?></div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                <?php $i++; endforeach ?>
                      
                                            <?php endif ?>    
                                        </tbody>
                                    </table> 
                                
                      

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

function change_status(status, id) {
    if(confirm('Are you sure want to change status?'))
    {
        $.ajax({
      url: '<?= base_url() ?>/Admin/Swap/changeStatus',
      type: 'POST',
      cache:false,
      data:{'id':id,'status':status},
      dataType: 'json',
      beforeSend: function() {
        $('#status_btns'+id).prop('disabled' , true);
        $('#status_btns'+id).text('Processing..');
      },
      success : function(res){
        console.log(res);
        $('#status_btns'+id).prop('disabled' , false);
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


function delete_swap(id) {
    if(confirm('Are you sure want to delete coupon?'))
    {
        $.ajax({
      url: '<?= base_url() ?>/Admin/Swap/deleteSwap',
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