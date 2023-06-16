
<div class="modal-content" style="max-height: auto; overflow: auto;">
      <div class="modal-header">
        <h4 class="h5 modal-title"><?= $group['group_name'] ?></h4>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="#" onsubmit="return do_left_group(event)" id="do_create_group">
        <div class="modal-body fs-sm">
          <div class="mb-3">
            
            <ui class="contacts" style="height: 300px;display: block;overflow-y: scroll;">
           
            
            <li class="active" >
              <label class="d-flex align-items-center justify-content-between">
                <div class="d-flex bd-highlight">
                  <div class="img_cont">
                    <img src="<?= base_url($group['create_by']['image']) ?>" class="rounded-circle user_img">
                    <?= ($group['create_by']['active_status'] == 1) ? '<span class="online_icon"></span>' : '<span class="online_icon offline"></span> ' ?>
                  </div>
                  <div class="user_info">
                    <span><?= $group['create_by']['name'] ?> <?= ($group['create_by']['id'] == $user_id) ? '(You)' : '' ?></span>
                    <p><?= $group['create_by']['name'] ?> is <?= ($group['create_by']['active_status'] == 1) ? 'Online' : 'Offline' ?></p>
                  </div>
                </div>
                
                  <div class="form-check">
                  <div class="badge bg-primary">Admin</div>
                </div>
                
                
              </label>
            </li>

            <?php foreach ($group['members'] as $key => $value): ?>
            <li class="active" >
              <label class="d-flex align-items-center justify-content-between">
                <div class="d-flex bd-highlight">
                  <div class="img_cont">
                    <img src="<?= base_url($value['image']) ?>" class="rounded-circle user_img">
                    <?= ($value['active_status'] == 1) ? '<span class="online_icon"></span>' : '<span class="online_icon offline"></span> ' ?>
                  </div>
                  <div class="user_info">
                    <span><?= $value['name'] ?> <?= ($value['id'] == $user_id) ? '(You)' : '' ?></span>
                    <p><?= $value['name'] ?> is <?= ($value['active_status'] == 1) ? 'Online' : 'Offline' ?></p>
                  </div>
                </div>
                <?php if ($user_id == $group['create_by']['id'] || $user_id == 0): ?>
                  <div class="form-check">
                  <button class="btn btn-danger btn-xs" type="button" onclick="return remove_user_from_group(<?= $value['id'] ?> , <?= $group['id'] ?>)">Remove</button>
                </div>
                <?php endif ?>
                
              </label>
            </li>
            <?php endforeach ?>
            
            </ui>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm"  data-bs-dismiss="modal">Cancel</button>
          <?php if ($join): ?>
             <button type="button"  class="btn btn-primary btn-shadow btn-sm" id="do_create_group_btn" onclick="return join_user_in_group(<?= $user_id ?> , <?= $group['id'] ?>)">Join  Group</button>
          <?php else: ?>
             <button type="button"  class="btn btn-primary btn-shadow btn-sm" id="do_create_group_btn" onclick="return remove_user_from_group(<?= $user_id ?> , <?= $group['id'] ?>,1)"><?= ($user_id == $group['create_by']['id'] || $user_id == 0) ? 'Remove' : 'Left' ?>  Group</button>
             <button type="button"  class="btn btn-primary btn-shadow btn-sm" id="do_create_group_btn" onclick="return  open_group_chat(<?= $group['id'] ?>);">Open Chat</button>
             <?php if ($user_id == $group['create_by']['id'] || $user_id == 0): ?>
               <button type="button"  class="btn btn-primary btn-shadow btn-sm" id="do_edit_group_btn" onclick="return open_edit_group(<?= $group['id'] ?>)">Edit  Group</button>
             <?php endif ?>
          <?php endif ?>
         
        </div>
      </form>
    </div>