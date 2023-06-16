<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Users</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                        <h4 class="card-title mb-0">Users Update</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div id="customerList">
                                <div class="row g-4 mb-3">
                                    <div>
                                        <?= $this->session->getFlashdata('msg'); ?>
                                    </div>
                                   
                                </div>
                                <div class="">
                                  <form method="post" onsubmit="return EditUser(this, event, <?= $edit['id']; ?>)" id="EditUser" enctype="multipart/form-data">  
                                     <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control" required placeholder="Title" value="<?php echo $edit['title']; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="fname" class="form-control" required placeholder="First Name" value="<?php echo $edit['first_name']; ?>" />
                                        <input type="hidden" name="id" value="<?php echo $edit['id']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="lname" class="form-control" required placeholder="Last Name" value="<?php echo $edit['last_name']; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required placeholder="Email" value="<?php echo $edit['email']; ?>" />
                                    </div>
                                     <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="image" class="form-control"  placeholder="Image" accept="image/*" value="<?php echo $edit['image']; ?>" />
                                        <?php if(!empty($edit["image"])) { ?>
                                            <img style="height: 100px;width: 100px;" src="<?php echo base_url($edit["image"]);?>">
                                            <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label>User Name</label>
                                        <input type="text" name="username" class="form-control" required placeholder="Username" value="<?php echo $edit['username']; ?>" />
                                    </div>
                                   
                                    <div class="form-group">
                                        <label>Prononous</label>
                                        <input type="text" name="prononous" class="form-control" required placeholder="Prononous" value="<?php echo $edit['prononus']; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label>State</label>
                                        <input type="text" name="state" class="form-control" required placeholder="State" value="<?php echo $edit['state']; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" name="city" class="form-control" required placeholder="City" value="<?php echo $edit['city']; ?>" />
                                    </div>
                                     <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="street_address" class="form-control" required placeholder="Address"><?php echo $edit['street_address']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Aboout Me</label>
                                        <input type="text" name="about_me" class="form-control" required placeholder="Aboout Me" value="<?php echo $edit['about_me']; ?>" />
                                    </div>
                                     <div class="form-group">
                                        <label>My Skils</label>
                                        <input type="text" name="my_skill" class="form-control" required placeholder="My Skils" value="<?php echo $edit['my_skills']; ?>" />
                                    </div>
                                <br>
                           <button class="btn btn-primary" id="upbtn<?= $edit['id']; ?>" type="submit">Update</button>
                        </form>
                             
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
        function enable_user(id) {
        // event.preventDefault();
    if(confirm('Are you sure ?'))
    {
        $.ajax({
          url: '<?= base_url() ?>/Admin/Users/enableUser',
          type: 'POST',
          cache:false,
          data:{'id':id},
          dataType: 'json',
          beforeSend: function() {
            $('#del_btn').prop('disabled' , true);
            // $('#del_btn').text('Processing..');
          },
          success : function(res){
            if (res.status == 1) {
              window.location.reload();
            }
            else
            {
              $('#result').html(res.msgs)
            }
          }
        });
    }
}


function EditUser(el, event, id) {
    event.preventDefault();
    $('.alert-danger').remove();
    var data = new FormData($(el)[0]);

    $.ajax({
        url: '<?= base_url()?>/Admin/Users/update_user',
        data: data,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType:'json',
        beforeSend: function() {        
            $('#upbtn'+id).prop('disabled' , true);
            $('#upbtn'+id).text('Processing..');
          },
        success: function(result){
            $('#upbtn'+id).prop('disabled' , false);
            $('#upbtn'+id).text('Add');
            if(result.status == 1)
            {
              window.location.reload();
            }
            else
            {
              console.log(result.message);
              for (var err in result.message) {
            
              $("[name='" + err + "']").after("<div  class='label alert-danger'>" + result.message[err] + "</div>");
              }
            }
        }
    });
    return false;
  }
    </script>