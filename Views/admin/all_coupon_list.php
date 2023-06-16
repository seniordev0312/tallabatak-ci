<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Coupon</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Coupon</a></li>
                            <li class="breadcrumb-item active">Coupon</li>
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
                        <h4 class="card-title mb-0">Coupon list</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div id="customerList">
                               
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="example23">
                                        <thead class="table-light">
                                            <tr>
                                               <th>S.No</th>
                                                <th>Title</th>
                                                <th>Code</th>
                                                <th>Price</th>
                                                <th>Image</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                 <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                            <?php if ($all_coupon): $i = 1; ?>
                                                <?php foreach ($all_coupon as $key => $value): ?>
                                                    <tr>
                                                        <td><?= $i; ?></td>
                                                        <td><?= $value['title']; ?></td>
                                                        <td><?= $value['coupon_code']; ?></td>
                                                        <td><?= $value['price']; ?></td>
                                                        <td><img src="<?= base_url($value['image']); ?>" class="img-thumbnail" width="100px;"></td>
                                                        <td><?php if (strlen($value['description']) > 30) { echo substr($value['description'], 0, 30). '......'; } else { echo $value['description']; } ?></td>
                                                        <td><?php if($value['status'] == 1){ echo "<span class='badge badge-soft-success'>Enable</span>"; }else{ echo "<span class='badge badge-soft-danger'>Disable</span>"; } ?></td>
                                                        <td>
                                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $value['id']; ?>">View</button>
                                                            <button class="btn btn-danger btn-sm" id="delete_btns<?= $value['id']; ?>" onclick="delete_coupon(<?= $value['id'] ?>)">Delete</button>
                                                            <?php if($value['status']==1){ ?> <button class="btn btn-danger btn-sm" id="status_btns<?= $value['id']; ?>" onclick="change_status(0, <?= $value['id'] ?>)">Disable</button> <?php }else{ ?> <button class="btn btn-success btn-sm" id="status_btns<?= $value['id']; ?>" onclick="change_status(1, <?= $value['id'] ?>)">Enable</button> <?php } ?>


                                                        </td>
                                                    </tr>

                                                    <div class="modal" id="editModal<?= $value['id']; ?>">                 
                                                      <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                          <div class="modal-header bg-light p-3">
                                                            <h4 class="modal-title p-0">View Coupon</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                                          </div>
                                                          <div class="modal-body">
                                                            <div class="col-md-12"><label>Title:</label> <?= $value['title']; ?></div>
                                                            <div class="col-md-12"><label>Coupon code:</label> <?= $value['coupon_code']; ?></div>
                                                            <div class="col-md-12"><label>Units:</label> <?= $value['no_unit']; ?></div>
                                                            <div class="col-md-12"><label>Price:</label> <?= $value['price']; ?></div>
                                                            <div class="col-md-12"><label>Off:</label> <?= $value['coupon_off']; ?></div>
                                                            <div class="col-md-12"><label>Image:</label> <img src="<?= base_url($value['image']); ?>" class="img-thumbnail" width="100px;"></div>
                                                            <div class="col-md-12"><label>Description:</label> <br><?= $value['description']; ?></div>
                                                            <div class="col-md-12"><label>Status:</label> <?php if($value['status'] == 1){ echo "<span class='badge badge-soft-success'>Enable</span>"; }else{ echo "<span class='badge badge-soft-danger'>Disable</span>"; } ?></div>
                                                            <div class="col-md-12"><label>Start date:</label> <?= $value['start_date']; ?></div>
                                                            <div class="col-md-12"><label>End date:</label> <?= $value['end_date']; ?></div>
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
      url: '<?= base_url() ?>/Admin/Coupon/changeStatus',
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


function delete_coupon(id) {
    if(confirm('Are you sure want to delete coupon?'))
    {
        $.ajax({
      url: '<?= base_url() ?>/Admin/Coupon/deleteCoupon',
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