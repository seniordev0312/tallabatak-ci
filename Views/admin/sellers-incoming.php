<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<div class="page-content incoming-seller">
    <div class="container-fluid">
    
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Incoming Sellers</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Incoming Sellers</a></li>
                            <li class="breadcrumb-item active">Incoming Sellers</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12">
                        <ul class="nav nav-tabs">
                        
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url() ?>/admin/verified">Verified Seller</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= base_url() ?>/admin/incoming-seller">Incoming Seller&nbsp;<span class="badge bg-secondary"><?= ($data) ? count($data) : 0;?></span></a>
                        </li>
                        </ul>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Sellers Incoming list</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        
                                    </div>
                                    
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="example23">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Joining Date</th>
                                                <th>User Type</th>
                                                <th>Is Verified</th>
                                                <th>Document</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        <?php if ($data): $i = 1; ?>
                                            <?php foreach ($data as $key => $value): ?>
                                                <tr>
                                               
                                                <td>#<?= $i; ?></td>
                                                <td><?= $value['name'] ?></td>
                                                <td><?= $value['email'] ?></td>
                                                <td><?= $value['address'].' '.$value['city'].' , '.$value['state'] ?></td>
                                                <td><?= humanDate($value['created_at']) ?></td>
                                                <td><?php if($value['user_type'] != 2 ){ 
                                                    echo "<span class='badge badge-soft-info text-uppercase'>Customer</span>" ;} ?></td>
                                                <td><?php if($value['is_verified'] == 0){ 
                                                    echo "<span class='badge badge-soft-danger text-uppercase'>Not Verified</span>";
                                                    }elseif($value['is_verified'] == 1){
                                                        echo "<span class='badge badge-soft-success text-uppercase'>Verified</span>";
                                                    }else{
                                                        echo "<span class='badge badge-soft-warning text-uppercase'>Pending</span>";
                                                    }  ?></td>

                                                <td>
                                                    <?php if ($value['document_id']): ?>
                                                        <a target="_blank" href="<?= base_url($value['document_id'])?>" class="badge badge-soft-success text-uppercase">View Document</a>
                                                    <?php else: ?>
                                                        <span class="badge badge-soft-danger text-uppercase">No Document Found</span>
                                                    <?php endif ?>
                                                    
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="javascript:;" onclick="deleteData('Admin/Users/deleteUser' , <?= $value['id'] ?>)" class="btn btn-sm btn-danger" >Delete</a>
                                                        <!-- <?php if ($value['status'] == 1): ?>
                                                        <div class="remove">
                                                            <button onclick="enable_user(<?= $value['id'] ?>)" class="btn btn-sm btn-danger remove-item-btn" >Block</button>
                                                        </div>
                                                        <?php else: ?>
                                                        <div class="remove">
                                                            <button onclick="enable_user(<?= $value['id'] ?>)" class="btn btn-sm btn-success remove-item-btn" >Unblock</button>
                                                        </div>
                                                        <?php endif ?> -->
                                                        <div class="remove">
                                                            <button class="btn btn-sm btn-success" id="verify_accept_btn" onclick="verify_accept(<?= $value['id'] ?>)">Accept</button>
                                                        </div>
                                                        <div class="remove">
                                                            <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#myModal<?= $value['id'] ?>" id="">Reject</button>
                                                            <div class="modal fade" id="myModal<?= $value["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Reject Reason</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    <form method="post" onsubmit="return verify_reject('<?php echo $value['id']; ?>',event);" id="verify_reject<?php echo $value["id"]; ?>" enctype="multipart/form-data">
                                                                    <div class="form-group">
                                                                        <label>Reason</label>
                                                                        <textarea class="form-control" rows="5"
                                                                            placeholder="Enter Reason" name="reason" id="reason<?= $value["id"]; ?>"></textarea>
                                                                        <input type="hidden" name="id" value="<?= $value["id"]; ?>" />
                                                                        
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                                                        <button type="submit" id="verify_reject_btn<?= $value["id"]; ?>" class="btn btn-primary">Submit</button>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                         
                                                        </div>
                                                        <div class="remove">
                                                            <a href="<?php echo base_url()?>/admin/userview/<?=$value['id']?>" class="btn btn-sm btn-primary remove-item-btn" >View</a>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; endforeach ?>
                                      
                                      <?php endif ?>    
                                        </tbody>
                                    </table> 
                                
                                    <div class="noresult" style="display: <?= ($data) ? 'none' : 'block' ?>">
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
    <script type="text/javascript">
        function enable_user(id) {
        // event.preventDefault();
    if(confirm('Are you sure ?'))
    {
        $.ajax({
          url: '<?= base_url() ?>/Admin/Users/enableUser',
          type: 'POST',
          cache:false,
          data:{'id':id},
          dataType: 'json',
          beforeSend: function() {
            $('#del_btn').prop('disabled' , true);
            // $('#del_btn').text('Processing..');
          },
          success : function(res){
            if (res.status == 1) {
              window.location.reload();
            }
            else
            {
              $('#result').html(res.msgs)
            }
          }
        });
    }
}

function verify_accept(id) {
    if(confirm('Are you sure ?'))
    {
        $.ajax({
      url: '<?= base_url() ?>/Admin/Users/verifyAccept',
      type: 'POST',
      cache:false,
      data:{'id':id},
      dataType: 'json',
      beforeSend: function() {
        $('#verify_accept_btn'+id).prop('disabled' , true);
        $('#verify_accept_btn'+id).text('Processing..');
      },
      success : function(res){
        console.log(res);
        $('#verify_accept_btn'+id).prop('disabled' , false);
        if (res.status == 1) {
           Swal.fire({
               title: "User has been verified successfully", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
                location.href = "<?= base_url() ?>/admin/verified";
            })
        }
        
      }
    });
    }
    
}

function verify_reject(id, e) {
     e.preventDefault();
      var reason=  $("#reason"+id).val()
      if(reason.trim()==''){
        alert ("Reason field is required");
        return false;
      }
   
        $.ajax({
      url: '<?= base_url() ?>/Admin/Users/verifyReject',
      type: 'POST',
      cache:false,
      data:{'id':id,'reason':reason},
      dataType: 'json',
      beforeSend: function() {
        $('#verify_reject_btn'+id).prop('disabled' , true);
        $('#verify_reject_btn'+id).text('Processing..');
      },
      success : function(res){
        console.log(res);
        $('#verify_reject_btn'+id).prop('disabled' , false);
        if (res.status == 1) {
           Swal.fire({
               title: "User has been rejected successfully", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
                location.href = "<?= base_url() ?>/admin/verified";
            })
        }
        
       }
      });
   
    
}






    </script>