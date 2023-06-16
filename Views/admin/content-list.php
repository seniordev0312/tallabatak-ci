<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Content</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Content</a></li>
                            <li class="breadcrumb-item active">Content</li>
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
                        <h4 class="card-title mb-0">Content list</h4>
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
                                                <th>Page Name</th>
                                                <th>Content</th>
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
                                                <td><?= $value['page'] ?></td>
                                                <td ><?= substr(strip_tags($value['content']), 0, 100);?>...</td>
                                              <td>
                                                    <div class="d-flex gap-2">
                                                        <div class="edit">
                                                         <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $value['id']; ?>">Edit</button>
                                                        </div>
                                                    </div>
                                                </td>

            <div class="modal" id="editModal<?= $value['id']; ?>">                 
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                          
                            <!-- Modal Header -->
                             <div class="modal-header bg-light p-3">
                              <h4 class="modal-title p-0">Edit Content</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                            </div>
                            
                            <!-- Modal body -->
                            <form id="edit_content" method="post" action="#" onsubmit="return edit_content(this , <?= $value['id']; ?>)" >
                                <div class="modal-body">
                                <div class="col-md-12 py-3">
                                  <div>
                                    <label>Page Name</label>
                                    <input type="text" class="form-control" value="<?= $value['page']; ?>"  name="page_name" readonly>
                                    <input type="hidden" class="form-control" value="<?= $value['id']; ?>" name="id" >
                                  </div>
                                   <div>
                                    <label>Content</label>
                                    <textarea class="form-control textarea" name="content" placeholder="Enter Content"><?= $value['content']; ?></textarea>
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

function edit_content(el , id) {
    $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/Admin/Content/editContent',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($(el)[0]),
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

    </script>