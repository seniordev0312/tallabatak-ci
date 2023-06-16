<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Contact</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Contact</a></li>
                            <li class="breadcrumb-item active">Contact</li>
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
                        <h4 class="card-title mb-0">Contact list</h4>
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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Message</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        <?php if ($contact_list): $i = 1; ?>
                                            <?php foreach ($contact_list as $key => $value): ?>
                                                <tr>
                                                 <td><?= $i; ?></td>
                                                 <td><?= $value['name'] ?></td>
                                                 <td><?= $value['email'] ?></td>
                                                 <td><?= $value['phone'] ?></td>
                                                 <td><?= $value['message'] ?></td>
                                                 <td><?= humanDate($value['created_at']) ?></td>
                                                
                        </tr>
                        <?php $i++; endforeach ?>
                  
                  <?php endif ?>    
                    </tbody>
                </table> 
                                
                      <div class="noresult" style="display: <?= ($contact_list) ? 'none' : 'block' ?>">
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
    