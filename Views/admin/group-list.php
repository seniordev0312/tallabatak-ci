<?php include 'include/header.php'; ?>
<?php include 'include/sidebar.php'; ?>
<style>
    .user_info {
    margin-top: auto;
    margin-bottom: auto;
    margin-left: 15px;
    }
    .img_cont {
        position: relative;
        height: 40px;
        width: 40px;
    }
    .contacts {
        list-style: none;
        padding: 0;
    }
    .contacts li {
        width: 100% !important;
        padding: 5px 10px;
        margin-bottom: 5px !important;
        cursor: pointer;
    }
    .user_img {
        height: 40px;
        width: 40px;
        border: 1.5px solid #f5f6fa;
    }
</style>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Group</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Group</a></li>
                            <li class="breadcrumb-item active">Group</li>
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
                        <h4 class="card-title mb-0">Group list</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div id="customerList">
                                <?= $this->session->getFlashdata('msg'); ?>
                                <div class="row g-4 mb-3">
                                    <div class="col-sm-auto">
                                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalScroll" id="add_btns">Add</button>
                                    </div>
                                 
                                </div>
                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap" id="example23">
                                        <thead class="table-light">
                                            <tr>
                                               <th>S.No</th>
                                                <th>Group Name</th>
                                                <th>Image</th>
                                                <th>Members</th>
                                                <th>Create Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        <?php if ($data): $i = 1; ?>
                                            <?php foreach ($data as $key => $value): 
                                                ?>
                                                <tr>
                                                <td><?= $i ?></td>

                                                <td><?= $value['group_name'] ?></td>
                                                <td><img class="rounded-circle loaded tns-complete" src="<?= base_url($value['icon']) ?>" alt="Test" width="44"> </td>
                                                <td>
                                                <?php $users = $this->common_model->GetAllData('users' ,'id IN('. $value['members'].')');
                                                        foreach ($users as $key => $value1): 
                                                ?>
                                                <?= $value1['name'].',' ?>
                                                            <?php endforeach ?></td>
                                                <td><?= humanDate($value['create_date']) ?></td>
                                               <td><button id ="view" class="btn btn-info" onclick="get_group_info(<?= $value['id'] ?>)">View</button>
                                                </td>
                                                </tr>
                                            <?php $i++; endforeach ?>  
                                        <?php endif ?>    
                                        </tbody>
                                    </table> 
                     

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
    <div class="modal fade" id="modalScroll" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content" style="max-height: inherit; overflow: unset;">
            <div class="modal-header">
                <h4 class="h5 modal-title">Create New Group</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="#" onsubmit="return do_create_group(event , this)" id="do_create_group">
                <div class="modal-body fs-sm">
                <div class="mb-3">
                    <div class="mb-3">
                    <label class="form-label fw-bold fs-sm" for="ap-title">Group Name<span class="text-danger">*</span></label>
                    <input class="form-control form-control-sm" type="text" id="ap-title" name="group_name" placeholder="Enter group name" value="" required="">
                    </div>
                    <ui class="contacts" style="height: 300px;display: block;overflow-y: scroll;">
                    <?php $allUsers = $this->common_model->GetAllData('users' , array('status' => 1 , 'id !=' => 0) , 'name' , 'asc'); ?>
                    <li name="members"></li>   
                    <?php foreach ($allUsers as $key => $value): ?>
                    <li class="active" >
                    <label class="d-flex align-items-center justify-content-between">
                        <div class="d-flex bd-highlight">
                        <div class="img_cont">
                            <img src="<?= base_url($value['image']) ?>" class="rounded-circle user_img">
                            <?= ($value['active_status'] == 1) ? '<span class="online_icon"></span>' : '<span class="online_icon offline"></span> ' ?>
                        </div>
                        <div class="user_info">
                            <span><?= $value['name'] ?></span>
                            <p><?= $value['name'] ?> is <?= ($value['active_status'] == 1) ? 'Online' : 'Offline' ?></p>
                        </div>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" name="members[]" value="<?= $value['id'] ?>" id="form-check-<?= $value['id'] ?>" type="checkbox">
                        </div>
                    </label>
                    </li>
                    <?php endforeach ?>
                    
                    </ui>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm"  data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-shadow btn-sm do_create_group_btn">Create Group</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    <div class="modal fade" id="modalGroupinfo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-scrollable" role="document" id="group_info">
            
        </div>
    </div>

    <div class="modal fade" id="modalEditGroupinfo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable" role="document" id="edit_group_info">
        
    </div>
    </div>
    <?php include 'include/footer.php'; ?>
    <script type="text/javascript">

    function get_group_info(group_id)
    {
        $.ajax({
            url: '<?= base_url('Admin/Group_management/ajax_group_info') ?>',
            type: 'post',
            data: {'group_id':group_id },
            success: function (data) 
            {
                $('#group_info').html(data) 
                $('#modalGroupinfo').modal('show')
            }
        });
    }
    function remove_user_from_group(user_id , group_id ,is_delete=0)
    {
        $.ajax({
            url: '<?= base_url('Admin/Group_management/ajax_remove_user_from_group') ?>/'+is_delete,
            type: 'post',
            data: {'group_id':group_id , 'user_id':user_id},
            dataType: 'json',
            success: function (data) 
            {
            Swal.fire({
                title: "Success", 
                text: data.message, 
                icon: "success"
                }).then(function (result) 
                {
                    $('#modalGroupinfo').modal('hide')
                    location.reload();
                })
                
            }
        });
    }

    function open_edit_group(group_id )
    {
        $.ajax({
            url: '<?= base_url('Admin/Group_management/ajax_edit_group_info') ?>',
            type: 'post',
            data: {'group_id':group_id },
            success: function (data) 
            {
                $('#edit_group_info').html(data) 
                $('.country-dropdown').trigger('change');
                $('#modalEditGroupinfo').modal('show')
            }
        });
    }
    function do_create_group (e , elem) 
    {
        btn_text = $(elem).find('.do_create_group_btn').text();
        e.preventDefault();
        $('.alert-danger').remove();
        $.ajax({
        url: '<?= base_url('Admin/Group_management/ajax_create_group') ?>',
        type: 'POST',
        cache:false,
        contentType: false,
        processData: false,
        data:new FormData($(elem)[0]),
        dataType: 'json',
        beforeSend: function() {        
            $(elem).find('.do_create_group_btn').prop('disabled' , true);
            $(elem).find('.do_create_group_btn').text('Processing..');
        },
        success : function(res){
            $(elem).find('.do_create_group_btn').prop('disabled' , false);
            $(elem).find('.do_create_group_btn').text(btn_text);
            if (res.status == 1) 
            {
                Swal.fire({
                title: "Success", 
                text: res.message, 
                icon: "success"
                }).then(function (result) 
                {
                    
                    $('#modalScroll').modal('hide')
                    $('#modalEditGroupinfo').modal('hide')
                    $('#modalGroupinfo').modal('hide')
                    location.reload()
                    
                })
            
            }
            else
            {
            for (var err in res.message) {
                
                $("[name='" + err + "']").after("<div  class='label alert-danger'>" + res.message[err] + "</div>");
            }
            }
        }
        });
        return false;
    }
    </script>
    <script>
$(document).ready(function() {
    $(document).on('change' , '.country-dropdown' , function() {
            var id = $(this).data('id');
            var selected = $(this).data('selected');
            var country_id = this.value;
            $.ajax({
                url: "<?= base_url('Home/states_by_country') ?>",
                type: "POST",
                data: {
                    country_id: country_id,
                    selected : selected
                },
                cache: false,
                success: function(result){
                    $("#state-dropdown"+id).html(result);
                    $('#state-dropdown'+id).trigger('change');
                    $('#city-dropdown'+id).html('<option value="">Select State First</option>'); 
                }
            });
         
         
    });    
 
   $(document).on('change' , '.state-dropdown' , function() {
            var state_id = this.value;
            var id = $(this).data('id');
            var selected = $(this).data('selected');
            $.ajax({
                url: "<?= base_url('Home/cities_by_states') ?>",
                type: "POST",
                data: {
                    state_id: state_id,
                    selected : selected
                },
                cache: false,
                success: function(result){
                    $("#city-dropdown"+id).html(result);
                }
            });
         
         
    });
});
</script>