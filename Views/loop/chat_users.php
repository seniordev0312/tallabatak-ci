
<ul class="contacts contacts_open">
                  <?php if(chat_users($user_id , $is_group)): ?>
                    <?php foreach (chat_users($user_id , $is_group) as $key => $value): ?>
                      <?php if ($value['is_group']): ?>
                        <li class="active" onclick="open_chat(<?= $value['data']['id'] ?> , 1 , 1)">

                        <div class="d-flex bd-highlight">

                          <div class="img_cont">

                            <img src="<?= base_url($value['data']['icon']) ?>" class="rounded-circle user_img">
                           
                          </div>

                          <div class="user_info">

                            <span><?= $value['data']['group_name'] ?></span>

                            <p><?= ($value['last_message']['msg_type'] == 'text') ? mb_strimwidth(strip_tags($value['last_message']['message']), 0, 20, '...') : 'attachment' ?> </p>

                          </div>

                        </div>

                      </li>
                      <?php else: ?>
                         <li class="active" onclick="open_chat(<?= $value['data']['id'] ?> , 1)">

                        <div class="d-flex bd-highlight">

                          <div class="img_cont">

                            <img src="<?= base_url($value['data']['image']) ?>" class="rounded-circle user_img">
                            <?= ($value['data']['active_status'] == 1) ? '<span class="online_icon"></span>' : '<span class="online_icon offline"></span> ' ?>
                            

                          </div>

                          <div class="user_info">

                            <span><?= $value['data']['name'] ?></span>

                            <p><?= ($value['last_message']['msg_type'] =='text') ? $value['last_message']['message'] : 'attachment' ?> </p>

                          </div>

                        </div>

                      </li>
                      <?php endif ?>
                     

                 
                    <?php endforeach ?>
                  <?php else:  ?>
                    <li >
                      <div class="alert alert-danger">No record found</div>
                    </li>
                  <?php endif ?>
                  

                </ul>