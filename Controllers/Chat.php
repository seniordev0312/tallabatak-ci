<?php

namespace App\Controllers;
use App\Models\Common_model;
class Chat extends BaseController
{
    public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->common_model = new Common_model();
         $this->user_id =  $this->session->get('user_id');
         //$this->user_id =  10;
        $this->user = $this->common_model->GetSingleData('users', array('id' => $this->user_id));
       
    } 
    
    public function check_login()
    {
        if ($this->session->has('user_id')) {
            if($this->user['email_verified']==0)
            {
                header('Location: '.base_url('verification-pending-screen'));
                exit;
            }
          
        }
        if(!$this->session->has('user_id'))
        {
            header('Location: '.base_url('/'));
            exit;
        }
       
    }
    public function ajax_chat_between_users()
    {
        $client_user = $_POST['client_id'];
        $my_id = $this->user_id;
        $is_group = $_POST['is_group'];
        
        $thread_id = $this->getThreadID($client_user , $my_id);
        $chat['client_user'] = $this->common_model->GetSingleData('users' , array('id' => $client_user));
        if ($is_group) 
        {
            $thread_id = $client_user;
            $chat['client_user'] = $this->common_model->GetSingleData('groups' , array('id' => $is_group));
            $chat['client_user']['name'] = @$chat['client_user']['group_name'];
            $chat['client_user']['image'] = @$chat['client_user']['icon'];
        }
        $data = ['user_id' => $my_id , 'thread_id' => $thread_id];
        $chat['my_user'] = $this->user;
        $chat['chats'] = $this->chat_between_users($data);
        $chat['is_group'] = $is_group;
        //print_r($chat); die;
        if ($_POST['open'] == 0) {
            echo view('loop/chats' , $chat);
        }
        else
        {
            echo view('loop/chat_tab' , $chat);

        }
        
    }
    private function notifyRemoveUser($user_id , $group)
    {
        $user = $this->common_model->GetSingleData('users' , array('id' =>$user_id));
        $email = $user['email'];
        $subject="New Post has been posted near you";
        
        $body = $user['name'].', you have been removed from the group "'.$group['group_name'].'"';

        $notifi['user_id'] = $user['id'];
        $notifi['message'] = $user['name'].', you have been removed from the group "'.$group['group_name'].'"';
        $notifi['is_read'] = 0;
        $notifi['created_at'] = date('Y-m-d H:i:s');
        $notifi['type'] = 'group_joined';
        $notifi['other'] = ['screen' => 'home' , 'click_action' => '#' , 'id' => $group['id']];
        $notifi['noti_type'] = 'group_joined';

        $this->common_model->send_and_insert_notifi('notification' ,$notifi);          
        $send = $this->common_model->SendMail($email,$subject,$body); 
        
           
    }
    public function ajax_chat_users()
    {
        
        $my_id = $this->user_id;
        $chat['user_id'] = $my_id;
        $chat['is_group'] = $_POST['is_group'];
        echo view('loop/chat_users' , $chat);
    }
    public function ajax_group_info()
    { 
        $chat['user_id'] = $this->user_id;
        $group_id = $_POST['group_id'];
        $where = "id = $group_id AND (FIND_IN_SET($this->user_id , members) OR create_by = $this->user_id )";
        $check = $this->common_model->GetSingleData('groups' ,$where);
        $chat['join'] = false;
        if (!$check) {
            $chat['join'] = $_POST['join'];
        }
        
        $chat['group'] = group_data($group_id,1);
        echo view('loop/group_info' , $chat);
    }
    public function ajax_edit_group_info()
    { 
        $chat['user_id'] = $this->user_id;
        $group_id = $_POST['group_id'];
        $chat['group'] = group_data($group_id,0);
        echo view('loop/edit_group_info' , $chat);
    }
    public function ajax_remove_user_from_group()
    { 
        $my_id = $this->user_id;
        $group_id = $_POST['group_id'];
        $user_id = $_POST['user_id'];
        $group = group_data($group_id , 0);
        $member_array = explode(',', $group['members']);
        $new_member_array = array_diff($member_array, array($user_id));
        $update['members'] = implode(',', $new_member_array);
        $where['id'] = $group_id;
        $this->notifyRemoveUser($user_id , $group);
        if ($group['create_by'] == $user_id) 
        {
            $where1['thread_id'] = $group_id;
            $this->common_model->DeleteData('groups' , $where); 
            $this->common_model->DeleteData('chat' , $where1); 
            $output['message'] = 'Group Deleted successfully';
        }
        else
        {
            $this->common_model->UpdateData('groups' , $where , $update); 
            $output['message'] = 'User removed successfully';
        }
        $output['status'] = 1;
        echo json_encode($output);
       
    }
    public function ajax_join_user_in_group()
    { 
        $my_id = $this->user_id;
        $group_id = $_POST['group_id'];
        $user_id = $_POST['user_id'];
        $group = group_data($group_id , 0);
        $member_array = explode(',', $group['members']);
        array_push($member_array, $user_id);
        $update['members'] = implode(',', $member_array);
        $where['id'] = $group_id;
        $this->common_model->UpdateData('groups' , $where , $update); 
        $someone = $this->common_model->GetSingleData('users' , ['id' => $user_id]);
        
        $message = $someone['name'].' Joined your '.$group['group_name'].' group';
                
        $notifi['user_id'] = $group['create_by'];
        $notifi['message'] = $message;
        $notifi['is_read'] = 0;
        $notifi['created_at'] = date('Y-m-d H:i:s');
        $notifi['type'] = 'group';
        $notifi['noti_type'] = 'group_joined';

        $this->common_model->send_and_insert_notifi('notification' ,$notifi);  
        $output['group_id'] = $group_id;
        $output['message'] = 'Group Joined successfully';
        
        $output['status'] = 1;
        echo json_encode($output);
       
    }

    public function chat_between_users($data) { 
    
    if ($data['user_id']==NULL or $data['thread_id']==NULL) {
        $output['status']=0;
        $output['msg']='Check User Param.';
    } else {
        
        $i = 0;
        
        $user_id = $data['user_id'];
        $thread_id = $data['thread_id'];
        
        $new_user = array();
        
        // $sql = "SELECT * FROM `chat` WHERE thread_id = '".$thread_id."' order by id desc limit 200";
        $sql = "SELECT * FROM `chat` WHERE thread_id = '".$thread_id."' and (is_admin = 0 || (is_admin = 1 && sender != $user_id)) order by id desc limit 200";
        $run = $this->db->query($sql);
        
        if(count($run->getResultArray()) > 0){
            
            foreach($run->getResultArray() as $row){
                
                $new_user[$i] = $row;
                
                //if($row['sender']!=$user_id){
                    if($row['read_by']){
                        $read_by = explode(',',$row['read_by']);
                        array_push($read_by,$user_id);
                        $read_by = array_unique($read_by);
                        $read_by = implode(',',$read_by);
                    } else {
                        $read_by = $user_id;
                    }
                    //echo $read_by;
                    //echo '/';
                    
                    $this->common_model->UpdateData('chat' , "id = '".$row['id']."'" , array('is_read'=>1,'read_by'=>$read_by));
                //}
                
                if($row['receiver']){
                    $new_user[$i]['receiver'] = $this->common_model->GetSingleData('users' , array('id' => $row['receiver']));
                }
                if ($row['sender']) 
                {
                   $new_user[$i]['sender'] = $this->common_model->GetSingleData('users' , array('id' => $row['sender']));
                }
                else
                {
                    $new_user[$i]['sender'] = $GLOBALS["common_model"]->GetSingleData('admin', "id = 1");
                    $new_user[$i]['sender']['active_status'] = 1;
                    $new_user[$i]['sender']['active_time'] = date('Y-m-d h:i:s');
                }
                
                $new_user[$i]['create_date'] = time_ago($row['create_date']);
                
                $i++;
            }
            
            $output['users'] = array_reverse($new_user);
            $output['status'] = 1;
            $output['msg'] = 'Success';
            
            if(isset($data['thread_id']) && !empty($data['thread_id'])){
                $receiver = $data['thread_id'];
             
                $this->common_model->UpdateData('users' , "id = $user_id" , array('last_chat_with'=>$receiver,'last_chat_time'=>date('Y-m-d H:i:s')));
            }
            
        
            
        } else {
            $output['status'] = 0;
            $output['msg'] = 'no record found';
        }
    }
    return $output;
}
  public function ajax_send_message()
    {
        header('Content-type text/html; charset=UTF-8');

        $client_user = $_POST['client_id'];
        $message = $_POST['message'];
        $is_group = $_POST['is_group'];
        $app_req = false;
        if($_POST['user_id']){
            $my_id = $_POST['user_id'];
            $app_req = true;
        }
        else
            $my_id = $this->user_id;
        if ($is_group == 0) 
        {
            $thread_id = $this->getThreadID($my_id , $client_user);
        }
        else
        {
            $thread_id = $is_group;
            $client_user = 0;
        }
        
        
        $data = ['sender' => $my_id , 'receiver' => $client_user , 'is_group' => $is_group , 'thread_id' => $thread_id , 'msg_type' => 'text' , 'message' => $message];
        $chat['client_user'] = $this->common_model->GetSingleData('users' , array('id' => $client_user));
        $chat['my_user'] = $this->user;
        try{
            $chat['chats'] = $this->send_message($data , $_FILES);
            if($app_req){
                echo json_encode(array('success'=>true));
            }
            else
                echo view('loop/chat_tab' , $chat);
        }
        catch (Exception $e){
            if($app_req){
                echo json_encode(array('success'=>false));
            }
        }

        //echo view('loop/chat_tab' , $chat);

    } 

public function send_message($data , $file) {
   
    
    if ($data['sender'] == NULL ||  $data['is_group'] == NULL || $data['msg_type'] == NULL) 
    {
        $output['status']=0;
        $output['msg']='Check User Param.';
    } else {
        
        $i = 0;
        
        $insert['thread_id'] = $data['thread_id'];
        $insert['sender'] = $data['sender'];
        $insert['receiver'] = isset($data['receiver']) ? $data['receiver'] : 0;
        $insert['message'] = isset($data['message']) ? $data['message'] : '';
        $insert['msg_type'] = $data['msg_type'];
        if(isset($file['chat_file']['name']) && !empty($file['chat_file']['name']))
        {
            $tmp_name = $file['chat_file']['name'];
            $tmp_name = explode(".",$tmp_name);
            $exts = end($tmp_name);
            $f_name = rand().time().".".$exts;
            $newfile = 'assets/images/chat/'.$f_name;
            move_uploaded_file($file['chat_file']['tmp_name'], $newfile);
            $insert['message'] = $newfile;
            $insert['msg_type'] = 'file';
                    
        }
        if(isset($file['audio_data']['name']) && !empty($file['audio_data']['name']))
        {
            $tmp_name = $file['audio_data']['name'];
            $tmp_name = explode(".",$tmp_name);
            $exts = end($tmp_name);
            $f_name = rand().time().".wav";
            $newfile = 'assets/images/chat/'.$f_name;
            move_uploaded_file($file['audio_data']['tmp_name'], $newfile);
            $insert['message'] = $newfile;
            $insert['msg_type'] = 'audio';
                    
        }
       
        $insert['is_group'] = ($data['is_group']) ? 1 : 0;
        $insert['is_read'] = 0;
        $insert['read_by'] = $data['sender'];
        $insert['create_date'] = date('Y-m-d H:i:s');
        
        $run = $this->common_model->InsertData('chat',$insert);
        
        if($data['is_group'])
        {
            $group_info = $this->common_model->GetSingleData('groups', ['id' => $data['thread_id']] );
            $user = $this->common_model->GetSingleData('users' , array('id' => $data['sender']));
            $show_name = $user['name'];
            $this->sendNotiToGroup($group_info , $show_name , $insert);
           
        }
        if($data['receiver'])
        {
        
            $user = $this->common_model->GetSingleData('users' , array('id' => $data['sender']));
            $show_name = $user['name'];
            $current = date('Y-m-d H:i:s');//11:50:50
            $tolerance = date('Y-m-d H:i:s',strtotime($current.' - 10 seconds'));//11:50:40
            
            $sql = "select last_chat_time from users where id = ".$data['receiver']." and last_chat_with = '".$insert['thread_id']."'";
            
            $run = $this->db->query($sql);
            
            $check_send = false;
            
            $numrow = count($run->getResultArray());
            
            if($numrow==0){
                $check_send = true;
            } else {
                $numrow = $run->getRowArray();
                if(strtotime($numrow['last_chat_time']) <= strtotime($tolerance)){
                    $check_send = true;
                }
            }
            $message = $show_name.' has sent you a message.';
            
            $notifi['user_id'] = $data['receiver'];
            $notifi['message'] = $message;
            $notifi['is_read'] = 0;
            $notifi['created_at'] = date('Y-m-d H:i:s');
            $notifi['type'] = 'chat';
            $notifi['other'] = ['screen' => 'chat' , 'click_action' => '#' , 'id' => $this->user_id];
            $notifi['noti_type'] = 'buyer_chat';
            if($check_send){

                $this->common_model->send_and_insert_notifi('notification' ,$notifi);  

            }
            else
            {
                $notifi['onlyPushNot'] = true;
                $this->common_model->send_and_insert_notifi('notification' ,$notifi);  

            }


        }
            
            $output['status'] = 1;
            $output['msg'] = 'message sent';
        
        } 
    
    return $output;
} 

 public function sendNotiToGroup($group_info , $show_name , $data)
 {
    $message = 'Attachment';
    if ($data['msg_type'] ==  'text') {
        $message = $data['message'];
    }
    $message = $show_name." Says : \n \"".$message."\" \n On: \"".$group_info['group_name']."\"";
    $memebers = explode(',' , $group_info['members']);   
    foreach ($memebers as $key => $value) 
    {
       $notifi['user_id'] = $value;
        $notifi['message'] = $message;
        $notifi['is_read'] = 0;
        $notifi['created_at'] = date('Y-m-d H:i:s');
        $notifi['type'] = 'chat';
        $notifi['other'] = ['screen' => 'chat' , 'click_action' => '#' , 'id' => $this->user_id];
        $notifi['noti_type'] = 'buyer_chat';
        //$notifi['onlyPushNot'] = true;
        $this->common_model->send_and_insert_notifi('notification' ,$notifi);
    }     
    
 }
 public function getThreadID($user_id1 , $user_id2)
 {
     if ($user_id1 > $user_id2) 
     {
         
         return $user_id2.'_'.$user_id1;
     }
     else
     {
        return $user_id1.'_'.$user_id2;
     }
 }

    public function ajax_create_group()
    {
        $this->validation->setRule('group_name','Group Name','trim|required');
        $this->validation->setRule('country','country','trim|required');
        $this->validation->setRule('state','state','trim|required');
        $this->validation->setRule('city','city','trim|required');
        $this->validation->setRule('members','Members','required');
        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {

            $my_id = isset($_POST['user_id'])?$_POST['user_id']:$this->user_id;
            $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : 0;
            $data = ['group_name' => $_POST['group_name'] ,'country' => $_POST['country'] ,'state' => $_POST['state'] ,'city' => $_POST['city'] , 'user_id' => $my_id , 'edit_id' => $edit_id , 'members' => $_POST['members'] , 'filedata' => $_FILES ];
            
           $output = $this->create_group($data);
           $user_name=isset($_POST['user_name'])?$_POST['user_id']:$this->user['name'];
           foreach ($_POST['members'] as $key => $value) 
           {
              
        
                $message = $user_name.' added you in a '.$_POST['group_name'].' group';
                        
                $notifi['user_id'] = $value;
                $notifi['message'] = $message;
                $notifi['is_read'] = 0;
                $notifi['created_at'] = date('Y-m-d H:i:s');
                $notifi['type'] = 'group';
                $notifi['noti_type'] = 'group_added';

                $this->common_model->send_and_insert_notifi('notification' ,$notifi); 
           }
           
       }
      echo json_encode($output);

    } 
    private function create_group($data)
    {
    
        if(!$data){
            $output['status']=0;
            $output['msg']='Check User Param.';
        } else {
            
            $insert['group_name'] = $data['group_name'];
            $insert['country'] = $data['country'];
            $insert['state'] = $data['state'];
            $insert['city'] = $data['city'];
            $insert['create_by'] = $data['user_id'];
            $insert['members'] = implode(',' , $data['members']);
            $fildata = $data['filedata'];
            
            if(isset($filedata['icon']['name']) && !empty($filedata['icon']['name'])){
                
                $exts=end(explode(".",$filedata['icon']['name']));
                $f_name = rand().time().".".$exts;
                $newfile = 'assets/images/groups/'.$f_name;
                
                move_uploaded_file($filedata['files']['tmp_name'], $newfile);
                
            }
            else
            {
                $newfile = 'assets/images/groups/icon-group.png';
                
            }
            $insert['icon'] = $newfile;
            if ($data['edit_id']) 
            {
               $last_id = $data['edit_id'];

               $edit_group = $this->common_model->GetSingleData('groups', ['id' => $last_id] );
               $insert['members'] = implode(',' , $data['members']);
               $this->common_model->UpdateData('groups', ['id' => $last_id] , $insert);
               $output['message'] = "Group Updated successfully.";
            }
            else
            {
                $last_id = $this->common_model->InsertData('groups',$insert);
                $output['message'] = "Group created successfully.";

                
                $insert2['sender'] = $data['user_id'];
                $insert2['receiver'] = 0;
                $insert2['message'] = 'New group '.$insert['group_name'].' created.';
                $insert2['thread_id'] = $last_id;
                $insert2['is_group'] = 1;
                $insert2['read_by'] = $data['user_id'];
                $insert2['is_group_first_message'] = 1;
                $this->common_model->InsertData('chat',$insert2);
            }
            $output['status'] = 1;
            
            $output['group_id'] = $last_id;
            
            
            
        }
        return $output;
    } 

    public function get_clients_name()
    {
        $output['id']=4;
        $sql = "SELECT * FROM `chat` WHERE thread_id = '".$thread_id."' and (is_admin = 0 || (is_admin = 1 && sender != $user_id)) order by id desc limit 200";
        $run = $this->db->query($sql);
        echo json_encode($output);
    }

    public function get_group_info()
    {
        $user_id = $_POST['user_id'];
        $group_info = $this->common_model->getGroupInfo($user_id);
        $output['groups'] = $group_info;
        echo json_encode($output);
    }

    public function get_current_dm()
    {
        
        $client_id = $_POST['client_id'];
        $user_id = $_POST['user_id'];
        $not_count = $this->common_model->GetSingleData('notification',array('user_id' =>$user_id,'is_read'=>0));
        $unread_messages = $this->common_model->getSingleData('chat',array('receiver'=>$user_id,'is_group'=>0,'is_read'=>0));
        $output['msg_count'] = count($unread_messages);
        $output['noti_count'] = count($not_count);
        if($client_id == 0)
        {
            $dm = $this->common_model->GetDMData($user_id);
        }
        else{
            $last_message_id = $_POST['last_message_id'];
            $thread_id = $user_id > $client_id ? ($client_id.'_'.$user_id) : ($user_id.'_'.$client_id);
            $where = "thread_id='".$thread_id."' and id <= '".$last_message_id."'";
            $this->common_model->UpdateData('chat',$where,array('is_read'=>1));
            $where = "thread_id='".$thread_id."' and id > '".$last_message_id."'";
            $dm = $this->common_model->GetAllData('chat',$where);      
        }
        
        $output['dm'] = $dm;
        //
        echo json_encode($output);

    }

    
    public function get_current_group()
    {
        $user_id = $_POST['user_id'];
        $group_id = $_POST['group_id'];
        $last_message_id = $_POST['last_message_id'];
        if($group_id == 0)
        {
            $group_chat = $this->common_model->GetDMData($user_id);
            $where = "thread_id LIKE '%".$user_id."%' and is_read = 0 and is_group = 0";
            // $unread_messages = $this->common_model->getSingleData('chat',$where);
        }
        else{

            // $where = "thread_id='".$group_id."' and id <= '".$last_message_id."'";
            // $this->common_model->UpdateData('chat',$where,array('is_read'=>1));
            // $where = "thread_id='".$group_id."' and id <= '".$last_message_id."'";
            $this->common_model->UpdateReadBy($user_id, $group_id,$last_message_id);
            $where = "thread_id='".$group_id."' and id > '".$last_message_id."'";
            $group_chat = $this->common_model->GetAllData('chat',$where);
            // $unread_messages = $this->common_model->getSingleData('chat',array('thread_id'=>$thread_id,'is_group'=>0,'is_read'=>0));
        }
        
        $output['group_chat'] = $group_chat;
        // $output['unread_count'] = count($unread_messages);
        echo json_encode($output);

    }
    
    public function chat_group_app()
    {
        $user_id=$_POST['user_id'];
        $insert['sender'] = $user_id;
        $insert['receiver'] =0;
        $insert['message'] = $_POST['message'];
        $insert['is_read'] = 0;
        $insert['create_date'] = date('Y-m-d H:i:s');
        $insert['thread_id'] = $_POST['thread_id'];
        $insert['is_group'] =  1;
        $insert['read_by'] = $user_id;
        $insert['is_group_first_message']=0;
        $insert['msg_type'] = 'text';
        $insert['is_admin']=0;
        $run = $this->common_model->InsertData('chat',$insert);
        $show_name=$_POST['user_name'];
        $group_info = $this->common_model->GetSingleData('groups', ['id' => $_POST['thread_id']] );
        $message = $show_name." has sent you message";
        // $message = $show_name." Says : \n \"".$_POST['message']."\" \n On: \"".$group_info['group_name']."\"";
        $memebers = explode(',' , $group_info['members']);   
        foreach ($memebers as $key => $value) 
        {
        $notifi['user_id'] = $value;
            $notifi['message'] = $message;
            $notifi['is_read'] = 0;
            $notifi['created_at'] = date('Y-m-d H:i:s');
            $notifi['type'] = 'chat';
            $notifi['other'] = ['screen' => 'chat' , 'click_action' => '#' , 'id' => $user_id];
            $notifi['noti_type'] = 'buyer_chat';
            //$notifi['onlyPushNot'] = true;
            $this->common_model->send_and_insert_notifi('notification' ,$notifi);
        }     
    
 }
}
    
