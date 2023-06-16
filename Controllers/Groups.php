<?php

namespace App\Controllers;
use App\Models\Common_model;
class Groups extends BaseController
{
    public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->common_model = new Common_model();
        $this->user_id =  $this->session->get('user_id');
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

    public function index()
    {
        $model = new \App\Models\GroupModel();
        //$where = "id NOT IN (SELECT id FROM groups WHERE FIND_IN_SET($this->user_id , members)) AND create_by != $this->user_id";
        $where = "id != 0";
        $getdata = get_client_location();
        
        if(isset($_REQUEST['country']) )
        {
            $getdata['country'] = $_REQUEST['country'];
        }
        if(isset($_REQUEST['state']) )
        {
            $getdata['state'] = $_REQUEST['state'];
        }
        if(isset($_REQUEST['city']) )
        {
            $getdata['city'] = $_REQUEST['city'];
        }
        if (isset($getdata['country']) && !empty($getdata['country'])) 
        {
            $where .= " AND country=".$getdata['country'];
        }
        if (isset($getdata['state']) && !empty($getdata['state'])) 
        {
            $where .= " AND state=".$getdata['state'];
        }
        if (isset($getdata['city']) && !empty($getdata['city'])) 
        {
            $where .= " AND city=".$getdata['city'];
        }
        
        $data = [
            'groups' => $model->where($where)->paginate(2),
            'pager' => $model->pager,
        ];
        
        return view('site/search_groups' , $data);
    }
   public function my_joined_groups()
    {
        $this->check_login();
        $model = new \App\Models\GroupModel();
        $where = "id IN (SELECT id FROM groups WHERE FIND_IN_SET($this->user_id , members))";
        $data = [
            'groups' => $model->where($where)->paginate(4),
            'pager' => $model->pager,
        ];
        return view('site/my_groups' , $data);
    }
   public function my_created_groups()
    {
        $this->check_login();
        $model = new \App\Models\GroupModel();
        $where = "create_by = $this->user_id";
        $data = [
            'groups' => $model->where($where)->paginate(4),
            'pager' => $model->pager,
        ];
        return view('site/my_groups' , $data);
    }
   
   /* public function profile()
    {
        
        return view('site/edit-profile');
    }
    public function change_password()
    {
        
        return view('site/change-password');update_password
    }*/


  

   
}
