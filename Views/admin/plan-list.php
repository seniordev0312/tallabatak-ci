<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Plan</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Plan</a></li>
                            <li class="breadcrumb-item active">Plan</li>
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
                        <h4 class="card-title mb-0">Plan list</h4>
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
                                               <th>Price</th>
                                               <th>Post</th>
                                               <th>Radius</th>
                                               <!-- <th>Chat Feature</th> -->
                                               <th>Features</th>
                                               <!-- <th>Notification Feature</th> -->
                                               <th>Plan Duration</th>
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
                                                 <td>$<?= $value['price']; ?></td>
                                                <td><?= $value['post']; ?></td>
                                                <td>
                                                  <?php if($value['nearby_radius'] < 1){echo (string)($value['nearby_radius']*1000).' m';}else{echo (string)($value['nearby_radius']). ' km';} ?></td>
                                                <td>
                                                    
                                                    <label>Enable Groups: <?php if($value['groups'] == 1){ echo "<span class='badge badge-soft-success'>Yes</span>"; }else{ echo "<span class='badge badge-soft-danger'>No</span>"; } ?></label><br>
                                                    <label>Enable Auction: <?php if($value['auction'] == 1){ echo "<span class='badge badge-soft-success'>Yes</span>"; }else{ echo "<span class='badge badge-soft-danger'>No</span>"; } ?></label><br>
                                                    <label>Enable Swap: <?php if($value['swap'] == 1){ echo "<span class='badge badge-soft-success'>Yes</span>"; }else{ echo "<span class='badge badge-soft-danger'>No</span>"; } ?></label><br>
                                                    <label>Enable Coupon: <?php if($value['coupon'] == 1){ echo "<span class='badge badge-soft-success'>Yes</span>"; }else{ echo "<span class='badge badge-soft-danger'>No</span>"; } ?></label>
                                                </td>
                                                <!-- <td> 
                                                    <?php  
                                                  // if($value['notification'] == 1){
                                                  //   echo "<span class='badge badge-soft-success'>Enabled</span>";
                                                  // }else{
                                                  //    echo "<span class='badge badge-soft-danger'>Disabled</span>";
                                                  // }

                                                ?></td>-->
                                                <td><?= $value['duration'] ?> Month</td>
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
                    <h4 class="modal-title p-0">Edit Plan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                  </div>
                  
                  <!-- Modal body -->
                  <form id="edit_plan" method="post" action="#" onsubmit="return edit_plan(this , <?= $value['id']; ?>)" >
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
                          <label>Price</label>
                          <input type="text"  required class="form-control" value="<?= $value['price']; ?>"  name="price"  >
                        </div>

                        <div>
                          <label>post</label>
                          <input type="number" min="0" required class="form-control" value="<?= $value['post']; ?>"  name="post"  >
                        </div>
                        <div>
                          <label>Nearby Radius(km)</label>
                          <input min="0" required class="form-control" value="<?= $value['nearby_radius'] ?>"  name="nearby_radius" placeholder="Please insert kms">
                        </div>
                      <!-- <div>
                        <input type="checkbox" <?= ($value['chat'] == 1)? 'Checked' : ''; ?> value="1" name="chat">
                        <label>Enable Chat</label>
                      </div>
                   
                      <div>
                          <input type="checkbox" <?= ($value['notification'] == 1)? 'Checked' : ''; ?>  value="1" name="notification">
                          <label>Enable Notifications</label>
                      </div> -->

                        <div>
                            <input type="checkbox" value="1" name="groups" <?= ($value['groups'] == 1)? 'Checked' : ''; ?> >
                            <label>Enable Groups</label>
                        </div>
                        <div>
                            <input type="checkbox" value="1" name="auction" <?= ($value['auction'] == 1)? 'Checked' : ''; ?> >
                            <label>Enable Auction</label>
                        </div>

                        
                        <div>
                            <input type="checkbox" value="1" name="swap" <?= ($value['swap'] == 1)? 'Checked' : ''; ?> >
                            <label>Enable Swap</label>
                        </div>
                        <div>
                            <input type="checkbox" value="1" name="coupon" <?= ($value['coupon'] == 1)? 'Checked' : ''; ?> >
                            <label>Enable Coupon</label>
                        </div>

                      <div>
                        <label>Duration</label>
                        <select required class="form-control" name="duration">
                          <option value="">--Select--</option>
                          <option <?= ($value['duration'] == 1)? 'Selected':''; ?> value="1">1 Month</option>
                          <option <?= ($value['duration'] == 2)? 'Selected':''; ?> value="2">2 Month</option>
                          <option <?= ($value['duration'] == 3)? 'Selected':''; ?> value="3">3 Month</option>
                          <option <?= ($value['duration'] == 4)? 'Selected':''; ?> value="4">4 Month</option>
                          <option <?= ($value['duration'] == 5)? 'Selected':''; ?> value="5">5 Month</option>
                          <option <?= ($value['duration'] == 6)? 'Selected':''; ?> value="6">6 Month</option>
                          <option <?= ($value['duration'] == 7)? 'Selected':''; ?> value="7">7 Month</option>
                          <option <?= ($value['duration'] == 8)? 'Selected':''; ?> value="8">8 Month</option>
                          <option <?= ($value['duration'] == 9)? 'Selected':''; ?> value="9">9 Month</option>
                          <option <?= ($value['duration'] == 10)? 'Selected':''; ?> value="10">10 Month</option>
                          <option <?= ($value['duration'] == 11)? 'Selected':''; ?> value="11">11 Month</option>
                          <option <?= ($value['duration'] == 12)? 'Selected':''; ?> value="12">12 Month</option>
                       </select>
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
                          <?php 
                            if($value['id'] != 1)
                            {
                           ?>
                            <div class="remove">
                              <button class="btn btn-danger" id="delete_btns" onclick="delete_plan(<?= $value['id'] ?>)">Delete</button>
                          </div>
                          <?php
                            }
                          ?>
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
                        <label>Nearby Radius(km)</label>
                        <input  min="0" required class="form-control" value=""  name="nearby_radius" placeholder="Please insert kms">
                      </div>
                  
                    <!-- <div>
                        <input type="checkbox" value="1" name="chat">
                        <label>Enable Chat</label>
                    </div>
                   
                    <div>
                        <input type="checkbox" value="1" name="notification">
                        <label>Enable Notification</label>
                    </div> -->

                    <div>
                        <input type="checkbox" value="1" name="groups">
                        <label>Enable Groups</label>
                    </div>
                    <div>
                        <input type="checkbox" value="1" name="auction">
                        <label>Enable Auction</label>
                    </div>
                    <div>
                        <input type="checkbox" value="1" name="swap">
                        <label>Enable Swap</label>
                    </div>
                    <div>
                        <input type="checkbox" value="1" name="coupon">
                        <label>Enable Coupon</label>
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