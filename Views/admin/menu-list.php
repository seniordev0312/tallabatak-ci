<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Header Menu</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Header Menu</a></li>
                            <li class="breadcrumb-item active">Header Menu</li>
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
                        <h4 class="card-title mb-0">Header Menu list</h4>
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
                                                <th>Menu Item</th>
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
                                                <td>
                                                <?php $category = $this->common_model->GetAllData('category','id in('.$value['menu_items'].')' ,'','')?>
                                                <?php if($category) {  ?>
                                                <?php foreach($category as $cat) {  ?>
                                                <span class="badge bg-danger"><?= $cat['title_eng'] ?></span>
                                                <?php } } ?>
                                                </td>
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
                              <h4 class="modal-title p-0">Edit Header Menu</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                            </div>
                            
                            <!-- Modal body -->
                            <form id="edit_menu<?= $value['id']; ?>" method="post" action="#" onsubmit="return edit_menu(this , <?= $value['id']; ?>)" >
                                <div class="modal-body">
                                <div class="col-md-12 py-3">
                                  <div>
                                    <label>Category</label>
                                    <select  class="form-select mb-2 dropdownValue" id="dropdownValue" name="menu_items[]" required  multiple>
									
									<?php $category = $this->common_model->GetAllData('category','','id','desc')?>
									<?php if($category) {  
                                        ?>
									<?php foreach($category as $cat)
                                     {
                                        $menu = explode(',' , $value['menu_items'])
                                          ?>
									<option value="<?=$cat['id']?>" <?=(in_array($cat['id'],$menu)) ? 'selected' : ''?>> <?=$cat['title_eng']?></option>
								    <?php } } ?>
								    </select>
                                    <input type="hidden" class="form-control" value="<?= $value['id']; ?>" name="id" >
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
     
     new Choices('#dropdownValue', {
        allowHTML: true,
            delimiter: ',',
            editItems: true,
            maxItemCount: 5,
            removeItemButton: true,

        });

    function edit_menu(el , id) {
    var formdata = new FormData($('#edit_menu'+id)[0]);
    var select_val = $('.choices__input').val();
    formdata.append('menu_items' , select_val)
   
    $('.alert-danger').remove();
      $.ajax({
      url: '<?= base_url() ?>/Admin/Menu/editMenu',
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

    </script>