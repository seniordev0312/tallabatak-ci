<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
class Dashboard extends BaseController {

	public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        return $this->check_login();
    } 
    public function check_login()
    {
      if (!$this->session->has('admin_id')) {
          header('Location: '.base_url('admin'));
      }
       
    }
    public function index()
    {
        return view('admin/dashboard');
    }
    public function adminProfile()
    {
      $login_id = $this->session->has('admin_id');
      $data['data'] = $this->common_model->GetSingleData('admin', array('id'=>$login_id));
        return view('admin/admin-profile', $data);
    }

    public function update_password()
    {
      helper(['form']);
      if ($this->request->getMethod() == "post") {
          $validation =  \Config\Services::validation();

          $rules = [
              "old_pass" => [
                  "label" => "Old Password", 
                  "rules" => "required"
              ],
              "new_pass" => [
                  "label" => "New Password", 
                  "rules" => "required"
              ],
              "cnew_pass" => [
                  "label" => "Confirm New Password", 
                  "rules" => "required|matches[new_pass]"
              ]
          ];

          if ($this->validate($rules)) {
        $update['password'] = $_POST['new_pass'];       
        $login_id = $this->session->has('admin_id');
        $get = $this->common_model->GetSingleData('admin', array('id'=>$login_id));
        if($get['password'] == $_POST['old_pass'])
        {
          $run = $this->common_model->UpdateData('admin',array('id' =>$login_id), $update);
        }
        else
        {
          $output['status']= 0 ; 
                $output["message"] = '<div class="alert alert-danger">Current Password does not match </div>';  
        }
        
        //$id = $run[0]->id;
    
        if($run)
        {
          
            $this->session->setFlashdata('msg', '<div class="alert alert-success">Password has been Updated successfully.</div>');
            $output['status']=1;
        }
      } else {
            $output['status']= 0 ; 
              $output["validation"] = $validation->getErrors();
          }
      }
    echo json_encode($output);
    }

    public function changePassword()
    {
        return view('admin/change-password');
    }

    public function update_profile()
    {
      helper(['form']);
      if ($this->request->getMethod() == "post") {
          $validation =  \Config\Services::validation();

          $rules = [
              "name" => [
                  "label" => "Name", 
                  "rules" => "required|trim"
              ],
              "contact_number" => [
                  "label" => "Phone", 
                  "rules" => "required|numeric"
              ]
          ];

          if ($this->validate($rules)) {
        $update['name'] = $_POST['name'];
        $update['contact_number'] = $_POST['contact_number'];
        $login_id = $this->session->has('admin_id');
        $run = $this->common_model->UpdateData('admin',array('id' =>$login_id), $update);
        //$id = $run[0]->id;
    
        if($run)
        {
          
            $this->session->setFlashdata('msg', '<div class="alert alert-success">Profile has been Updated successfully.</div>');
            $output['status']=1;
        }
      } else {
            $output['status']= 0 ; 
              $output["validation"] = $validation->getErrors();
          }
      }
    echo json_encode($output);
    }

public function Logout()
    {
      $this->session->remove('admin_id');
        $this->session->setFlashdata('msg','<div class="alert alert-success">You have been Logged out successfully.</div>');
        return redirect('admin');
    }

  public function subscription_list()
    {
        $data['subscription_list'] = $this->common_model->GetAllData('newsletter','','id','desc');
        return view('admin/subscription-list', $data);
    }
  	
}