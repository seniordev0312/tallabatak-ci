<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Plan Subscription</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Plan Subscription</a></li>
                            <li class="breadcrumb-item active">Plan Subscription</li>
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
                        <h4 class="card-title mb-0">Plan Subscription list</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div id="customerList">
                                <?= $this->session->getFlashdata('msg'); ?>
                                <div class="row g-4 mb-3">
                                    
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="example23">
                                        <thead class="table-light">
                                            <tr>
                                               <th>S.No</th>
                                               <th>User Name</th>
                                               <th>Plan</th>
                                               <th>Status</th>
                                               <th>Start Date</th>
                                               <th>End Date</th>
                                               <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        <?php if ($data): $i = 1; ?>
                                            <?php foreach ($data as $key => $value): ?>
                                                <tr>
                                                 <td><?= $i; ?></td>
                                                 <td><?php //$value['title']; 
                                                 $userdata = $this->common_model->GetColumnName('users',array('id'=>$value['user_id']),array('name'));
                                                 echo $userdata->name;
                                                 ?></td>
                                                 <td><?php 
                                                 $plan = $this->common_model->GetColumnName('plan_management',array('id'=>$value['plan_id']),array('title'));
                                                 echo $plan->title;
                                                ?></td>
                                               <td><?php  
                                                  if($value['end_date'] <  $value['start_date']){
                                                    echo "<span class='badge badge-soft-danger'>Expired</span>";
                                                  }else{
                                                    echo "<span class='badge badge-soft-success'>Active</span>";
                                                  }

                                                ?></td>
                                             
                                                <td><?= $value['start_date']; ?></td>
                                                <td><?= $value['end_date'] ?></td>
                                                <td><?= humanDate($value['created_at']) ?></td>
                                                
                                                
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
                <h4 class="modal-title">Add Plan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
              </div>
              
              <!-- Modal body -->
              <form id="add_plan" method="post" action="#" onsubmit="return add_plan()" enctype="multipart/form-data" >
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
                        <label>Price</label>
                        <input type="text" required class="form-control" value=""  name="price">
                      </div>
                      <div>
                        <label>Post</label>
                        <input type="number" min="0" required class="form-control" value=""  name="post">
                      </div>
                  
                    <div>
                        <!-- <label>Chat</label> --><br>
                        <input type="checkbox" value="1" name="chat">
                        <label>Enable Chat</label>
                    </div>
                   
                    <div>
                        <!-- <label>Notification</label><br> -->
                        <input type="checkbox" value="1" name="notification">
                        <label>Enable Notification</label>
                    </div>
                     <div>
                        <label>Duration</label>
                        <select required class="form-control" name="duration">
                          <option value="">--Select--</option>
                          <option value="1">1 Month</option>
                          <option value="2">2 Month</option>
                          <option value="3">3 Month</option>
                          <option value="4">4 Month</option>
                          <option value="5">5 Month</option>
                          <option value="6">6 Month</option>
                          <option value="7">7 Month</option>
                          <option value="8">8 Month</option>
                          <option value="9">9 Month</option>
                          <option value="10">10 Month</option>
                          <option value="11">11 Month</option>
                          <option value="12">12 Month</option>
                       </select>
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
        function add_plan() {
  $('.alert-danger').remove();
    
      $.ajax({
      url: '<?= base_url() ?>/Admin/Plan_Management/add_plan',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#add_plan')[0]),
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
function edit_plan(el , id) {
    $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/Admin/Plan_Management/editPlan',
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

function delete_plan(id) {
        // event.preventDefault();
    if(confirm('Are you sure ?'))
    {
        $.ajax({
      url: '<?= base_url() ?>/Admin/Plan_Management/deletePlan',
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