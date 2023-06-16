<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>

<style type="text/css">
  .rating-color{
    color:orange;
  }

</style>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Testimonial</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Testimonial</a></li>
                            <li class="breadcrumb-item active">Testimonial</li>
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
                        <h4 class="card-title mb-0">Testimonial list</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div id="customerList">
                                <?= $this->session->getFlashdata('msg'); ?>
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#myModal" id="add_btns">Add</button>
                                    </div>
                                 
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="example23">
                                        <thead class="table-light">
                                            <tr>
                                               <th>S.No</th>
                                               <th>Title</th>
                                               <th>Description</th>
                                               <th>Image</th>
                                               <th>Name</th>
                                               <th>Rate</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        <?php if ($data): $i = 1; ?>
                                            <?php foreach ($data as $key => $value): ?>
                                                <tr>
                                                 <td><?= $i; ?></td>
                                                 <td style="white-space: break-spaces;"><?= $value['title']; ?></td>
                                                 <td style="white-space: break-spaces;">
                                                  <?= $value['description']; ?>
                                                 </td>
                                                 <td><img width="80px" src="<?= base_url($value['image']) ?>"></td>
                                                <td><?= $value['name'] ?></td>
                                                <!-- <td></td> -->
                                    <td>
                                          <?= $value['rate'] ?>                                            
                                    <span>
                                        <?php  if(!empty($value['rate'])){ 
                                                $float = explode('.', $value['rate']);
                                                for($i=1; $i<=5; $i++){ if($i<=$value['rate']){ ?>
                                                <i  class="fa fa-star rating-color"></i>
                                                <?php }else{ 
                                                    if(!empty($float[1])){  $float = []; ?> 
                                                    <i  class="fa fa-star fa-star-half-o rating-color"></i>
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
                                        ?>
                                    </span>
                                
                                    </td>
                                                <td><?= humanDate($value['created_at']) ?></td>
                                                
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <div class="edit">
                                                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal<?= $value['id']; ?>">Edit</button>
              <div class="modal" id="editModal<?= $value['id']; ?>">                 
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                
                  <!-- Modal Header -->
                   <div class="modal-header bg-light p-3">
                    <h4 class="modal-title p-0">Edit Social Link</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                  </div>
                  
                  <!-- Modal body -->
                  <form id="edit_testimonial" method="post" action="#" onsubmit="return edit_testimonial(this , <?= $value['id']; ?>)" >
                      <div class="modal-body">
                      <div class="col-md-12 py-3">
                        <div>
                          <label>Title</label>
                          <input type="text" class="form-control" value="<?= $value['title']; ?>"  name="title"  required>
                          <input type="hidden" class="form-control" value="<?= $value['id']; ?>" name="id">
                          <p id="result1"></p>
                        </div>

                        <div>
                            <label>Description</label>
                            <textarea required class="form-control" name="description"><?= $value['description']; ?></textarea>
                        </div>

                         <div>
                          <label>Name</label>
                          <input type="text"  required class="form-control" value="<?= $value['name']; ?>"  name="name"  >
                        </div>

                        <div>
                          <label>Position</label>
                          <input type="text"  required class="form-control" value="<?= $value['position']; ?>"  name="position"  >
                        </div>
                        <div>
                          <label>Rate</label>
                          <input type="number" min="0" step="0.5" required class="form-control" value="<?= $value['rate']; ?>"  name="rate" >
                        </div>


                      <div>
                          <label>Image</label>
                          <input type="file" accept="image/*"  class="form-control" value=""  name="image"  ><br>
                          <div><img width="80px" src="<?= base_url($value['image']) ?>"></div>
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
                          </div>
                          
                          <div class="remove">
                              <button class="btn btn-danger" id="delete_btns" onclick="delete_testimonial(<?= $value['id'] ?>)">Delete</button>
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
    <div class="modal" id="myModal">                 
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
              <!-- Modal Header -->
               <div class="modal-header bg-light p-3">
                <h4 class="modal-title">Add Testimonials</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
              </div>
              
              <!-- Modal body -->
              <form id="add_testimonial" method="post" action="#" onsubmit="return add_testimonial()" enctype="multipart/form-data" >
                   <div class="modal-body">
                  <div class="col-md-12 py-3">

                    <div>
                        <label>Title</label>
                        <input type="text"  required class="form-control" value=""  name="title"  >
                    </div>

                    <div>
                        <label>Description</label>
                        <textarea required class="form-control" value=""  name="description"></textarea>
                    </div>
                      
                      
                     <div>
                        <label>Image</label>
                        <input type="file" accept="image/*" required class="form-control" value=""  name="image">
                      </div>
                    <div>
                        <label>Name</label>
                        <input type="text"  required class="form-control" value=""  name="name"  >
                    </div>
                    <div>
                        <label>Position</label>
                        <input type="text"  required class="form-control" value=""  name="position"  >
                    </div>
                    <div>
                        <label>Rate</label>
                        <input type="number" min="0" step="0.5"  required class="form-control" value=""  name="rate"  >
                    </div>
                     
                      <div class="mt-3 text-center">
                          <button type="submit" id="add_btn"  class="btn btn-success">Add</button>
                      </div>
                      
                  </div>
              </div>
              </form>
              
              
            </div>
          </div>
        </div>
    <?php include 'include/footer.php'; ?>

    <script type="text/javascript">
        function add_testimonial() {
  $('.alert-danger').remove();
    
      $.ajax({
      url: '<?= base_url() ?>/Admin/Testimonial/add_testimonial',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#add_testimonial')[0]),
      dataType: 'json',
      beforeSend: function() {        
        $('#add_btn').prop('disabled' , true);
        $('#add_btn').text('Processing..');
      },
      success : function(res){
        $('#add_btn').prop('disabled' , false);
        $('#add_btn').text('Add');
        if (res.status == 1) {
            Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
            location.reload();
            })         
        }
        else
        {
         
          $('#result').html(res.message);
          for (var err in res.message) {
            
            $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
          }
        }
      }
    });
return false;    
}
function edit_testimonial(el , id) {
    $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/Admin/Testimonial/edittestimonial',
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
         
          $('#result1').html(res.message);
          for (var err in res.message) {
            
            $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
          }
        }
      }
    });
return false;    
}

function delete_testimonial(id) {
        // event.preventDefault();
    if(confirm('Are you sure ?'))
    {
        $.ajax({
      url: '<?= base_url() ?>/Admin/Testimonial/deleteTestimonial',
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