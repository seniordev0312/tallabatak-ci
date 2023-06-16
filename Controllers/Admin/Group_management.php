<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Group_management extends BaseController {

	public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
         $this->common_model = new Common_model();
        $this->check_login();
    } 
    public function check_login()
    {
      if (!$this->session->has('admin_id')) {
          header('Location: '.base_url('admin'));
          return ; 
      }
       
    }

  	public function group_list()
    {
        $data['data'] = $this->common_model->GetAllData('groups','','id','desc');
        return view('admin/group-list', $data);
    }

    public function ajax_group_info()
    { 
        $chat['user_id'] = 0;
        $group_id = $_POST['group_id'];
        $chat['join'] = 0;
        $chat['group'] = group_data($group_id,1);
        echo view('loop/group_info' , $chat);
    }

    public function ajax_edit_group_info()
    { 
        $chat['user_id'] = 0;
        $group_id = $_POST['group_id'];
        $chat['group'] = group_data($group_id,0);
        echo view('loop/edit_group_info' , $chat);
    }

    public function ajax_remove_user_from_group($is_delete=0)
    { 
        $my_id = 0;
        $group_id = $_POST['group_id'];
        $user_id = $_POST['user_id'];
        $group = group_data($group_id , 0);
        $member_array = explode(',', $group['members']);
        $new_member_array = array_diff($member_array, array($user_id));
        $update['members'] = implode(',', $new_member_array);
        $where['id'] = $group_id;
        if ($is_delete) 
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

    public function ajax_create_group()
    {
        //echo "Ayay"; die;
        $this->validation->setRule('group_name','Group Name','trim|required');
        $this->validation->setRule('members','Members','required');
        $this->validation->setRule('country','country','trim|required');
        $this->validation->setRule('state','state','trim|required');
        $this->validation->setRule('city','city','trim|required');
        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            
            $my_id = 0;
            $edit_id = isset($_POST['edit_id']) ? $_POST['edit_id'] : 0;
            $data = ['group_name' => $_POST['group_name'] ,'country' => $_POST['country'] ,'state' => $_POST['state'] ,'city' => $_POST['city'] , 'user_id' => $my_id , 'edit_id' => $edit_id , 'members' => $_POST['members'] , 'filedata' => $_FILES ];
            
           $output = $this->create_group($data);
           
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
            if (!isset($data['edit_id'])) {
                $insert['create_by'] = $data['user_id'];
            }
           
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
   
   
}