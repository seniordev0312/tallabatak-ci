<?php 
include_once 'includes/header.php';
?>

<section class="container pt-5 mt-5">
    <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Swaps</li>
        </ol>
    </nav>
</section>
<div class="container">
    <div class="row">
        <!-- Sidebar-->
        <?php include_once 'includes/user_sidebar.php' ?>
        <!-- Content-->
        <div class="col-lg-8 col-md-7 mb-5">
            <?= $this->session->getFlashdata('msg'); ?>
            <div class="" id="" role="">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="h2 mb-0">My Swaps</h1>
                </div>
                <p class="pt-1 mb-4">Here you can see your Swap </p>
    
                <div class="table-responsive table-card mt-3 mb-1">
                <!-- <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModal" id="add_btns">Add</button> -->
                    <a href="<?= base_url()?>/add-swap" class="btn btn-primary btn-sm">Add</a>
                    <br><br>
                <table class="table align-middle table-nowrap" id="example23">
                <thead class="table-light">
                    <tr>
                        <th>S.No</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>description</th>
                        
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="list form-check-all">
                <?php if ($view): $i = 1; ?>
                    <?php foreach ($view as $key => $value): ?>
                        <tr>
                         <td><?= $i; ?></td>
                         <td>
                            <?php if(!empty($value["image"])) { ?>
                              <img class="img-thumbnail"  src="<?php echo base_url($value["image"]);?>">
                              <?php } ?>
                         </td>
                         <td><?= $value['title'] ?></td>
                         <td><?= substr($value['description'],0,50); ?></td>
                         
                        
                         <td><?= humanDate($value['created_at']) ?></td>
                         <td><a class="btn btn-primary" href="<?= base_url('edit-swap/'.$value['id']) ?>">Edit</a>
                        <a class="btn btn-danger" onclick="delete_swap(<?= $value['id'] ?>)">Delete</a></td>
                        </tr>
                        <?php $i++; endforeach ?>
                  
                  <?php endif ?>    
                    </tbody>
                </table> 
                                
                      <div class="noresult" style="display: <?= ($view) ? 'none' : 'block' ?>">
                          <div class="text-center">
                              <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                              <h5 class="mt-2">Sorry! No Result Found</h5>
                              
                          </div>
                      </div>

                                </div>


    <!-- mycode  -->
                


            </div>
        </div><!-- end card -->
    </div>
    <!-- end row -->
</div>
<!-- container-fluid -->

<?php include_once 'includes/footer.php'; ?>
<script>
function delete_swap(id , elem) {

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        fd = new FormData()
    fd.append('id' , id)
      $.ajax({
      url: '<?= base_url('Swap/delete_swap') ?>',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:fd,
      dataType: 'json',
      beforeSend: function() {        
        $(elem).prop('disabled' , true);
        $(elem).text('Processing..');
      },
      success : function(res){
        $(elem).prop('disabled' , false);
        $(elem).text('Delete');
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
    })
    
return false;    
}


</script>