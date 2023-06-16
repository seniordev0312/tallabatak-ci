 <?php if ($chats['status'] == 1): ?>
              
            
              <?php foreach ($chats['users'] as $key => $value): ?>
                <?php if ($value['sender']['id'] != $my_user['id']): ?>
                  <div class="d-flex flex-row justify-content-start client_id">

                  <img src="<?= base_url($value['sender']['image']) ?>" class="rounded-circle user_img" alt="avatar 1" style="width: 45px; height: 100%;">

                  <div>

                     <?php if ($value['msg_type'] == 'text'): ?>
                       <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;"><?= $value['message'] ?></p>
                    <?php elseif($value['msg_type'] == 'file'): ?>
                       <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;"><img src="<?= base_url($value['message']) ?>" width="100px"></p>
                    
                  <?php elseif($value['msg_type'] == 'audio'): ?>
                      
                        <audio style="width:150px" controls>
                          <source src="<?= base_url($value['message']) ?>" type="audio/wav">
                         
                        Your browser does not support the audio element.
                        </audio>
                      
                    <?php endif ?>

                    <p class="small ms-3 mb-3 rounded-3 text-muted"><?= $value['create_date'] ?></p>

                  </div>

                </div>
                <?php else: ?>
                  <div class="d-flex flex-row justify-content-end mb-4 pt-1 my_id">

                  <div>

                     <?php if ($value['msg_type'] == 'text'): ?>
                       <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;"><?= $value['message'] ?></p>
                    <?php elseif($value['msg_type'] == 'file'): ?>
                       <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;"><img src="<?= base_url($value['message']) ?>" width="100px"></p>
                    
                  <?php elseif($value['msg_type'] == 'audio'): ?>
                      
                        <audio style="width:150px" controls>
                          <source src="<?= base_url($value['message']) ?>" type="audio/wav">
                         
                        Your browser does not support the audio element.
                        </audio>
                      
                    <?php endif ?>

                    <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end"><?= $value['create_date'] ?></p>

                  </div>

                  <img src="<?= base_url($value['sender']['image']) ?>" alt="avatar 1" class="rounded-circle user_img" style="width: 45px; height: 100%;">

                </div>
                <?php endif ?>
                

              <?php endforeach ?>
          <?php else: ?>
            <div class="d-flex flex-row justify-content-start client_id">
              <div class="alert alert-warning">Start new chat</div>
            </div>

          <?php endif ?>