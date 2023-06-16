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
        <!-- Breadcrumb-->
        
        <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Post</li>
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
              <h1 class="h2 mb-0">My Groups</h1>
            </div>
            <p class="pt-1 mb-4">Here you can see your Groups </p>
            <div class="my_group_menu">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0 " style="flex-direction: unset;">
                <li class="nav-item">
                  <a  <?= (url_is('my-joined-groups')) ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?>  href="<?= base_url('my-joined-groups') ?>">My Joined Groups</a>
                </li>
                <li class="nav-item">
                  <a <?= (url_is('my-created-groups')) ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?> href="<?= base_url('my-created-groups') ?>">My Created Groups</a>
                </li> 
                <li class="nav-item">
                  <a <?= (url_is('groups')) ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?> href="<?= base_url('groups') ?>">Search Groups</a>
                </li>
                <?php if (check_subscription($this->user_id , true)['active']): ?>
                  <li class="nav-item">
                    <a <?= (url_is('groups')) ? 'class="nav-link active" aria-current="page"' : 'class="nav-link"' ?> href="<?= base_url('groups') ?>">Create new Group</a>
                </li>
                <?php endif ?>
                
              </ul>
            </div>
             
            <div class="row">
                  <!-- Loop -->
      <?php if ($groups): ?>
        <?php foreach ($groups as $key => $value): ?>
          
        <div class="col-sm-6 col-xl-4" onclick="get_group_info(<?= $value['id'] ?>)">
          <div class="card shadow-sm card-hover border-0 h-100">
            <div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="javascript:;"></a>
            <div class="tns-carousel-inner">
                        <img src="<?= base_url($value['icon']) ?>" alt="Image">
                      </div>
          </div>
          <div class="card-body position-relative pb-3">
            
            <h3 class="h6 mb-2 mt-1 fs-base">
              <a class="nav-link stretched-link" href="javascript:;"><?= $value['group_name'] ?></a>
            </h3>
            <?php 
                $admin = $this->common_model->GetSingleData('users' , ['id'=> $value['create_by']]);
                $member_array = explode(',', $value['members']);
                 ?>
            <div class="d-flex align-items-center text-decoration-none" href="#">
              <img class="rounded-circle loaded tns-complete" src="<?= base_url($admin['image']) ?>" alt="Test" width="44">
              <div class="ps-2">
                <?php $city = $this->common_model->GetSingleData('cities' , array('id' => $value['city'])); ?>
                <h4 class="mb-0 h4 fs-xs text-primary"><i class="fi-map-pin me-2"></i> <?= $city['name'] ?></h4>
                <h6 class="fs-sm text-nav lh-base mb-1"><?= $admin['name'] ?></h6>
                <div class="d-flex text-body fs-xs"><span class="me-2 pe-1"><i class="fi-calendar-alt opacity-70 mt-n1 me-1 align-middle"></i><?= $value['create_date'] ?></span><span><i class="fa fa-user opacity-70 mt-n1 me-1 align-middle"></i><?= count($member_array) ?> members</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach ?>
      <div class="col-lg-12">
        <?php if ($pager) :?>
              <?= $pager->links() ?>
              <?php endif ?>   
      </div>
    <?php else: ?>
      <div class="col-lg-12 alert alert-danger">No Groups Founds </div>
    <?php endif ?>
            </div>

          </div>

   </div>


        </div>
      </div>

<?php
include_once 'includes/footer.php'; ?>
<script type="text/javascript">
  function delete_post(id) 
  {
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
        $.ajax({
            url: '<?= base_url('Post/delete_post') ?>',
            type: 'post',
            data: {'id' : id},
            success: function (data) {
              Swal.fire(
                'Deleted!',
                'Your post has been deleted.',
                'success'
              ).then((result) => {
                location.reload();
              })
              
            }
          });
        
      }
    })
  }
</script>