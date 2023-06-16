<?php 
include_once 'includes/header.php';
?>

<section class="container pt-5 mt-5">
    <nav class="mb-3 pt-md-3" aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Coupon Code</li>
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
                    <h1 class="h2 mb-0">My Coupon Code</h1>
                </div>
                <p class="pt-1 mb-4">Here you can add your Coupon Code.</p>
    <!-- my code -->
              <div class="table-responsive table-card mt-3 mb-1">
                 <h1 class="h2 mb-0">Edit Coupon</h1>
        <form id="add_coupon" method="post" action="#" onsubmit="return add_coupon()" >
         <div class="modal-body">
        <div class="col-md-12 py-3">
            <?php
                    $id = $this->session->has('user_id');
                    $partOne =  substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3);    
                    $partTwo =  substr(str_shuffle("0123456789"), 0, 3);  
                    $coupon_code = $partOne.$partTwo;
                    $userData = false;
                    $login_user = $this->common_model->GetSingleData('users',array('id'=>$id),'id','desc');
                   $groupData = $this->common_model->GetAllData('groups','create_by='.$id.' OR FIND_IN_SET('.$id.' , members)','id','asc');
                     
                    
              
              //print_r($userData);
              
            ?>
            <div>
                <label>Coupon Code</label>
                <input type="text" class="form-control"  name="coupon_code"  placeholder="Coupon Code" value="<?= $edit['coupon_code']; ?>" readonly>
            </div>

            <div>
                <label>Title</label>
                <input type="text" class="form-control"  name="title"  placeholder="Title" required value="<?= $edit['title']; ?>">
            </div>
            <div>
                <label>Description</label>
                <textarea class="form-control"  name="description"  placeholder="Description" required ><?= $edit['description']; ?></textarea> 
            </div>
            <div>
                <label>Price</label>
                <input type="number" min="1" class="form-control"  name="price"  placeholder="Price" required value="<?= $edit['price']; ?>">
            </div>
            <div>
                <label>Offer(%)</label>
                <input type="number" min="1" class="form-control"  name="coupon_off"  placeholder="Offer" required value="<?= $edit['coupon_off']; ?>">
            </div>
            <div>
                <label>Number Of Units</label>
                <input type="number" min="1" class="form-control"  name="no_unit"  placeholder="Number Of unit" required value="<?= $edit['no_unit']; ?>">
            </div>
            <div>
              <div class="image">
                <img class="img-thumbnail" src="<?= base_url($edit['image']) ?>" width="100px">
              </div>
                <label>Image</label>
                <input type="file" class="form-control"  name="image" accept="image/*"  >
            </div>
          
            <div>
                <label>Expiry Date</label>
                <input type="date" min="<?= date('Y-m-d'); ?>" class="form-control"  name="end_date" id="end_date" required value="<?= $edit['end_date']; ?>">
            </div>
            <div>

                <label><input type="radio" name="invite" class="invite_radio" value="invite_group"> Invite By Group</label>
                <br>
                <div class="group_select other_select" style="display: none; ">
                  <label>Groups</label>
                  <select class="form-control user_page" id="my_user"  name="group_user[]" multiple=""> <?php
                      foreach ($groupData as $key => $groupV) { ?> 
                        <option value="<?= $groupV['id']; ?>"> <?= $groupV['group_name']; ?> </option> 
                      <?php } ?> 
                  </select>
                </div>
                <label><input type="radio" name="invite" class="invite_radio" value="invite_city"> Invite By City</label><br>
                  <div class="city_select other_select" style="display: none; ">
                    <label>Users of "<?= $login_user['city'] ?>"</label>
                    <select class="form-control user_page" id="city_near_user"  name="near_user[]" multiple="">
                      <?php
                      
                      $userData_near = $this->common_model->GetAllData('users',array('city'=>$login_user['city'],'id!='=> $id),'id','desc');
                        if($userData_near){
                        foreach($userData_near as $UserNear){
                      ?>
                      <option value="<?= $UserNear['id']; ?>"><?= $UserNear['name']; ?></option>
                      <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                <label><input type="radio" name="invite" class="invite_radio" value="invite_country"> Invite By Country</label><br>
                <div class="country_select other_select" style="display: none; ">
                  <label>Users of "<?= $login_user['country'] ?>"</label>
                  <select class="form-control user_page" id="country_near_user"  name="near_user[]" multiple="">
                     <?php
                     $userData_near = $this->common_model->GetAllData('users',array('country'=> $login_user['country'],'id!='=> $id),'id','desc');
                      if($userData_near){
                      foreach($userData_near as $UserNear){
                    ?>
                    <option value="<?= $UserNear['id']; ?>"><?= $UserNear['name']; ?></option>
                    <?php
                      }
                    }
                    ?>
                  </select>
                </div>
            </div>
              <div class="mt-3 text-center">
                <button type="submit" id="add_btn"  class="btn btn-success">Update</button>
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
function add_coupon() {
  $('.alert-danger').remove();
    
      $.ajax({
      url: '<?= base_url('Coupon/add_coupon/'.$edit['id']) ?>',
      type: 'POST',
      cache:false,
      contentType: false,
      processData: false,
      data:new FormData($('#add_coupon')[0]),
      dataType: 'json',
      beforeSend: function() {        
        $('#add_btn').prop('disabled' , true);
        $('#add_btn').text('Processing..');
      },
      success : function(res){
        $('#add_btn').prop('disabled' , false);
        $('#add_btn').text('Update');
        if (res.status == 1) {
            Swal.fire({
               title: "Success", 
               text: res.message, 
               icon: "success"
             }).then(function (result) {
              //location.reload();
              window.location.href = "<?= base_url('coupons'); ?>";
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

$(document).on('change , click', '.invite_radio', function () {
  
  $(".other_select").hide();
  if ($(this).val() == 'invite_group') 
  {
    $(".group_select").show();
  } 
  else if ($(this).val() == 'invite_city')  
  {
    $(".city_select").show();
  }
  else if ($(this).val() == 'invite_country')  
  {
    $(".country_select").show();
  }

});
</script>