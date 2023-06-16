<?php 
use App\Models\Common_model;
  $this->session = \Config\Services::session();
  $this->common_model = new Common_model();
  $this->user_id =  $this->session->get('user_id');
  //$this->user_id =  10;
  $this->user = $this->common_model->GetSingleData('users', array('id' => $this->user_id));
  $ids = explode(',', $group['members']);
  $allUsers = $this->common_model->GetAllData('users' , "id != $user_id AND status = 1 AND id NOT IN (".$group['members'].")"  , 'name' , 'asc'); 
       
?>
<div class="modal-content" style="max-height: inherit; overflow: unset;">
      <div class="modal-header">
        <h4 class="h5 modal-title">Edit "<?= $group['group_name'] ?>"</h4>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="#" onsubmit="return do_create_group(event , this)" id="do_create_group">
        <div class="modal-body fs-sm">
          <div class="mb-3">
            <div class="mb-3">
              <label class="form-label fw-bold fs-sm" for="ap-title">Group Name<span class="text-danger">*</span></label>
              <input class="form-control form-control-sm" type="text" id="ap-title" name="group_name" placeholder="Enter group name" value="<?= $group['group_name'] ?>" required="">
              <input class="" type="hidden"  name="edit_id" value="<?= $group['id'] ?>" >
              <?php foreach ($ids as $key => $value): ?>
                <input class="" type="hidden"  name="members[]" value="<?= $value ?>" >
              <?php endforeach ?>
            </div>
            <div class="mb-3">
              <label for="country">Country</label>
              <select class="form-control country-dropdown" name="country" data-id="<?= $group['id'] ?>" data-selected="<?= $group['state'] ?>">
              <option value="">Select Country</option>
                <?php
               $countries = $this->common_model->GetAllData('countries' , '' , 'name' , 'asc');
                foreach($countries as $row) {
                ?>
                    <option <?= ($group['country'] == $row['id']) ? 'selected' : '' ?> value="<?php echo $row['id'];?>"><?php echo $row["name"];?></option>
                <?php
                }
                ?>
                 
              </select>
            </div>
            <div class="mb-3">
              <label for="state">State</label>
              <select class="form-control state-dropdown" name="state" data-id="<?= $group['id'] ?>" id="state-dropdown<?= $group['id'] ?>" data-selected="<?= $group['city'] ?>" >
                 
              </select>
            </div>                        

            <div class="mb-3">
              <label for="city">City</label>
              <select class="form-control " name="city" id="city-dropdown<?= $group['id'] ?>" >
                 
              </select>
            </div>
            <ui class="contacts" style="height: 300px;display: block;overflow-y: scroll;">
           
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
                    <span><?= $value['name'] ?> </span>
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
          <button type="submit" class="btn btn-primary btn-shadow btn-sm do_create_group_btn">Update Group</button>
        </div>
      </form>
    </div>