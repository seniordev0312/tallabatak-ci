<?php 
include_once 'includes/header.php';
?>

<section class="container pt-5 mt-5">
    <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Swap</li>
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
                    <h1 class="h2 mb-0">Edit Swap </h1>
                </div>
                <p class="pt-1 mb-4">Here you can edit your Swap </p>
    <!-- my code -->
              <div class="table-responsive table-card mt-3 mb-1">
                 
        <form id="add_swap" method="post" action="#" onsubmit="return add_swap()" >
         <div class="modal-body">
        <div class="col-md-12 py-3">
          
            <div>
                <label>Title</label>
                <input type="text" class="form-control"  name="title"  placeholder="Title" required value="<?= $edit['title']; ?>">
            </div>
            <div>
                <label>Description</label>
                <textarea class="form-control"  name="description"  placeholder="Description" required><?= $edit['description']; ?></textarea> 
            </div>
           
            <div>
                 <div class="image">
                <img class="img-thumbnail" src="<?= base_url($edit['image']) ?>" width="100px">
              </div>
                <label>Image</label>
                <input type="file" class="form-control"  name="image" accept="image/*" >
            </div>
          
              <div class="mt-3 text-center">
                <button type="submit" id="add_btn"  class="btn btn-success">Edit</button>
              </div>  
           </div>
          </div>
    </form>
    
               
  </div>


                


            </div>
        </div><!-- end card -->
    </div>
    <!-- end row -->
</div>
<!-- container-fluid -->

<?php include_once 'includes/footer.php'; ?>
<script>
function add_swap() {
  $('.alert-danger').remove();
    
      $.ajax({
      url: '<?= base_url('Swap/add_swap/'.$edit['id']) ?>',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#add_swap')[0]),
      dataType: 'json',
      beforeSend: function() {        
        $('#add_btn').prop('disabled' , true);
        $('#add_btn').text('Processing..');
      },
      success : function(res){
        $('#add_btn').prop('disabled' , false);
        $('#add_btn').text('Edit');
        if (res.status == 1) {
            Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
              //location.reload();
              window.location.href = "<?= base_url('my-swaps'); ?>";
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


</script>