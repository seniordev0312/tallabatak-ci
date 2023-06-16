<?php 
include_once 'includes/header.php';
?>
<style type="text/css">
  .my_group_menu {
    background: #f1f1f1;
    margin: 10px 0;
    border-radius: 10px;
}
</style>
<section class="container pt-5 mt-5">
    <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= ucwords($table) ?> Wishlist</li>
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
                    <h1 class="h2 mb-0"><?= ucwords($table) ?> Wishlist</h1>
                </div>
                <p class="pt-1 mb-4">Here you can see your Wishlist.</p>
                <!-- Item-->
                <div class="my_group_menu">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 " style="flex-direction: unset;">
                        <li class="nav-item">
                            <a  <?= (url_is('wishlist/post')) ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>  href="<?= base_url('wishlist/post') ?>">Posts Wishlist</a>
                        </li>
                        <li class="nav-item">
                            <a <?= (url_is('wishlist/coupon')) ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?> href="<?= base_url('wishlist/coupon') ?>">Coupons Wishlist</a>
                        </li>
                        <li class="nav-item">
                            <a <?= (url_is('wishlist/swap')) ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?> href="<?= base_url('wishlist/swap') ?>">Swaps Wishlist</a>
                        </li>
                       
                        
                    </ul>
                </div>
                <?php
                $data = false;
                 if ($view): ?>
                    <?php 
                        $all_post_id = [];
                        foreach ($view as $key => $value){ 
                            $post_id = $value['post_id'];
                            array_push($all_post_id, $post_id);
                        }
                            $p_ids =  implode(",",$all_post_id);
                    ?>
                    <?php $table = ($table == 'coupon' ) ? 'coupons' : $table ; ?>
                    <?php $data = $this->common_model->GetAllData($table,"id in($p_ids)");?>
                  
                    <?php $table = ($table == 'coupons' ) ? 'coupon' : $table ; ?>
                           
                <?php endif ?>    
                 <div class="row">
                            <?= view('loop/'.$table , ['posts'=> $data , 'col'=> 'col-sm-6 mt-3' ]); ?>
                    </div>       
            </div>
        </div><!-- end card -->
    </div>
    <!-- end row -->
</div>
<!-- container-fluid -->

<?php include_once 'includes/footer.php'; ?>
<script type="text/javascript">
//   function delete_post(id) 
//   {
//     Swal.fire({
//       title: 'Are you sure?',
//       text: "You won't be able to revert this!",
//       icon: 'warning',
//       showCancelButton: true,
//       confirmButtonColor: '#3085d6',
//       cancelButtonColor: '#d33',
//       confirmButtonText: 'Yes, delete it!'
//     }).then((result) => {
//       if (result.isConfirmed) {
//         $.ajax({
//             url: '<?= base_url('Post/delete_post') ?>',
//             type: 'post',
//             data: {'id' : id},
//             success: function (data) {
//               Swal.fire(
//                 'Deleted!',
//                 'Your post has been deleted.',
//                 'success'
//               ).then((result) => {
//                 location.reload();
//               })
              
//             }
//           });
        
//       }
//     })
//   }
</script>