
        <div class="card" id="chat2">

          <div class="card-header d-flex justify-content-between align-items-center p-3">

            <h5 class="mb-0 fs-base"><?= $client_user['name'] ?></h5>
            <?php if ($is_group): ?>
              <button class="btn btn-xs btn-primary" onclick="get_group_info(<?= $client_user['id'] ?>)">Group Info</button>
            <?php endif ?>
            <button class="btn-close close_chat" type="button" id="close_chat"></button>

          </div>

          <div class="card-body chat_messages" id="card-body" data-mdb-perfect-scrollbar="true" style="position: relative; height: 290px; overflow: auto;">

            <?php if ($chats['status'] == 1): ?>
              
            
              <?php foreach ($chats['users'] as $key => $value): ?>
                <?php if ($value['sender']['id'] != $my_user['id']): ?>
                  <div class="d-flex flex-row justify-content-start client_id">

                  <img src="<?= base_url($value['sender']['image']) ?>" alt="avatar 1" class="rounded-circle user_img" style="width: 45px; height: 100%;">

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
            
          </div>

          <div class="card-footer text-muted d-flex justify-content-start align-items-center py-0 px-3">

            <img src="<?= base_url($my_user['image']) ?>" class="rounded-circle user_img" alt="avatar 3" style="width: 40px; height: 100%;">
            <form id="send_chat_form">
            <input type="hidden" name="is_group" id="is_group" value="<?= $is_group ?>">
            <input type="hidden" name="client_id" id="client_id" value="<?= $client_user['id'] ?>">
            <p class="lead emoji-picker-container">
              <input type="text" class="form-control form-control-lg" id="chat_message_input" name="message" placeholder="Type message" data-emojiable="true">
           </p>
           <div class="d-flex justify-content-between">
            <label class="ms-1 text-muted" href="#!"><i class="fa fa-paperclip"></i><input type="file" onchange="send_message(<?= $client_user['id'] ?>)" name="chat_file" id="chat_file" style="display: contents;"></label>

            <button type="button" class="ms-3 text-muted" id="recordButton"><i class="fa fa-microphone"></i></button>
            <div id="stopButtonContainer">
              <div class="boxContainer">
              <div class="box box1"></div>
              <div class="box box2"></div>
              <div class="box box3"></div>
              <div class="box box4"></div>
              <div class="box box5"></div>
              <button type="button" class="ms-3 text-muted" id="stopButton"><i class="fa fa-stop"></i></button>
            </div>
            
            </div>
            

            <a class="ms-3" href="javascript:;" id="send_btn_chat" onclick="send_message(<?= $client_user['id'] ?>)"><i class="fa fa-send"></i>Send</a>
            </div>
            </form>
          </div>

        </div>

        