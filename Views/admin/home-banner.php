<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Home Banner</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home Banner</a></li>
                            <li class="breadcrumb-item active">Home Banner</li>
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
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">Home Banner list</h4>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Add</button>
                        </div>
                    </div><!-- end card header -->

                        <div class="card-body">
                            <div id="customerList">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        
                                    </div>
                                  <?= $this->session->getFlashdata('msg'); ?>
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="example23">
                                        <thead class="table-light">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Banner</th>
                                                <th>Banner url</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        <?php if ($data):
                                            $i = 1;
                                         ?>
                                            <?php foreach ($data as $key => $value): ?>
                                                <tr> 
                                                <td><?= $i; ?></td>
                                                <td><img src="<?= base_url($value['home_banner']); ?>" alt="<?= $value['home_banner']; ?>" width="200px">
                                                </td>
                                                <td><?= $value['home_banner_url']; ?></td>
                                              <td>
                                                    <div class="d-flex gap-2">
                                                        <div class="edit">
                                                         <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $value['id']; ?>">Edit</button>
                                                         <?php if(count($data) != 1) : ?>
                                                            <a href="javascript:;" class="btn btn-danger" id="delete" onclick="return DeleteBanner(<?=$value['id']?>)">Delete</a>
                                                         <?php endif ?>
                                                        </div>
                                                    </div>
                                                </td>

            <div class="modal" id="editModal<?= $value['id']; ?>">                 
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                          
                            <!-- Modal Header -->
                             <div class="modal-header bg-light p-3">
                              <h4 class="modal-title p-0">Edit Home Banner</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                            </div>
                            
                            <!-- Modal body -->
                            <form id="edit_banner<?= $value['id']; ?>" method="post" action="#" onsubmit="return edit_banner(this , <?= $value['id']; ?>)" >
                                <div class="modal-body">
                                <div class="col-md-12 py-3">
                                  <div class="form-group my-3">
                                    <label for="">Home Banner</label>
                                    <img src="<?= base_url($value['home_banner']); ?>" alt="<?= $value['home_banner']; ?>" srcset="" width="100%">
                                    <p class="alert alert-warning">Banner should be in 1200*200</p>
                                    <input type="file" name="home_banner" accept="image/*" id="">
                                    <input type="hidden" class="form-control" value="<?= $value['id']; ?>" name="id" >
                                  </div>
                                  <div class="form-group my-3">
                                        <label for=""> Banner URL</label>
                                      <input type="url" name="home_banner_url" class="form-control" value="<?= $value['home_banner_url']; ?>">
                                  </div>
                                   
                                  <div class="mt-3 text-center">
                                      <button type="submit"  id="update<?= $value['id']; ?>" class="btn btn-success">Update</button>
                                  </div>
                                    
                                      
                                    </div>
                               </div>
                            </form>
                            
                          </div>
                        </div>
                      </div>
                                        </tr>

                                        
                                            <?php $i++; endforeach ?>
                                      
                                      <?php endif ?>    
                                        </tbody>
                                    </table> 
                                
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
    <div class="modal" id="addModal">                 
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
          
                <!-- Modal Header -->
                <div class="modal-header bg-light p-3">
                    <h4 class="modal-title p-0">Add Home Banner</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
            
                <!-- Modal body -->
                <form id="add_banner" method="post" action="#" onsubmit="return add_banner(event)" >
                    <div class="modal-body">
                        <div class="col-md-12 py-3">
                            <div class="form-group my-3">
                                <label for="">Home Banner</label>
                                <input type="file" name="home_banner" required="" accept="image/*" id="">
                            </div>
                            <div class="form-group my-3">
                                <label for=""> Banner URL</label>
                                <input type="url" name="home_banner_url" class="form-control">
                            </div>
                   
                            <div class="mt-3 text-center">
                                <button type="submit"  id="add" class="btn btn-success">Add</button>
                            </div> 
                        </div>
                    </div>
                </form>
            
            </div>
        </div>
    </div>
    <?php include 'include/footer.php'; ?>
    <script type="text/javascript">
    function edit_banner(el , id) {
    var formdata = new FormData($('#edit_banner'+id)[0]);
    var select_val = $('.choices__input').val();
    formdata.append('menu_items' , select_val)
   
    $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/Admin/Admin/editBanner',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:formdata,
      dataType: 'json',
      beforeSend: function() {        
        $('#update'+id).prop('disabled' , true);
        $('#update'+id).text('Processing..');
      },
      success : function(res){
        $('#update'+id).prop('disabled' , false);
        $('#update'+id).text('Update');
        if (res.status == 1) {
            Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
            window.location.reload();
            })         
        }
        else
        {
         
          $('#result').html(res.message);
          for (var err in res.validation) {
            
            $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.validation[err] + "</div>");
          }
        }
      }
    });
return false;    
}
function add_banner(event) {
    event.preventDefault();
    var formdata = new FormData($('#add_banner')[0]);
    var select_val = $('.choices__input').val();
    formdata.append('menu_items' , select_val)   
    $('.alert-danger').remove();
        $.ajax({
        url: '<?= base_url() ?>/Admin/Admin/addBanner',
        type: 'POST',
        cache:false,
        contentType: false,
        processData: false,
        data:formdata,
        dataType: 'json',
        beforeSend: function() {        
            $('#add').prop('disabled' , true);
            $('#add').text('Processing..');
        },
        success : function(res){
            $('#add').prop('disabled' , false);
            $('#add').text('Add');
            if (res.status == 1) {
                Swal.fire({
                    title: "Success", 
                    text: res.message, 
                    icon: "success"
                }).then(function (result) {
                    window.location.reload();
                })         
            }
            else
            {
         
                $('#result').html(res.message);
                for (var err in res.validation) {
            
                    $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.validation[err] + "</div>");
                }
            }
        }
    });
    return false;    
}

function DeleteBanner(id)
{
    Swal.fire(
    {
        Title : 'Are You Sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        customClass: {
            confirmButton: "btn btn-primary"
        }
    }).then(function (data) 
    {
        if (data.isConfirmed) 
        {
            $.ajax({
                url : '<?=base_url()?>/Admin/Admin/DeleteBanner',
                type : 'post',
                data : {id : id},
                dataType : 'json',
                beforeSend: function() {        
                    $('#delete').prop('disabled' , true);
                    $('#delete').text('Processing..');
                },
                success : function(result)
                {
                    $('#delete').prop('disabled' , true);
                    $('#delete').text('Delete');
                    Swal.fire(
                    {
                        text: result.message,
                        icon: result.type,
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function (data) 
                    {
                        location.reload();
                    })
                }
            })
        }
    })
    return false;
}

    </script>