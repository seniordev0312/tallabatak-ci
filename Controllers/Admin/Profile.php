<?php 
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
class Profile extends BaseController {

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

   public function adminProfile()
    {
      
      $login_id = $this->session->has('admin_id');
      $data['data'] = $this->common_model->GetSingleData('admin', array('id'=>$login_id));
        return view('admin/profile', $data);
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
                  "label" => "Phone Number", 
                  "rules" => "required|trim"
              ],
              "footer_phone" => [
                  "label" => "Footer Phone Number", 
                  "rules" => "required|trim"
              ],
               "footer_email" => [
                  "label" => "Footer Email", 
                  "rules" => "required|trim"
              ],
              "featured_cost" => [
                  "label" => "Featured Cost", 
                  "rules" => "required|trim"
              ],
              "no_days" => [
                  "label" => "Number of days", 
                  "rules" => "required|trim"
              ]
          ];

          if ($this->validate($rules)) {
        $update['name'] = $_POST['name'];
        $update['contact_number'] = $_POST['contact_number'];
        $update['footer_phone'] = $_POST['footer_phone'];
        $update['footer_email'] = $_POST['footer_email'];
        $update['featured_cost'] = $_POST['featured_cost'];
        $update['no_days'] = $_POST['no_days'];
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
  
 public function update_password()
    {
      helper(['form']);
      if ($this->request->getMethod() == "post") {
          $validation =  \Config\Services::validation();

          $rules = [
              "old_pass" => [
                  "label" => "Old Password", 
                  "rules" => "required|min_length[6]"
              ],
              "new_pass" => [
                  "label" => "New Password", 
                  "rules" => "required|min_length[6]"
              ],
              "cnew_pass" => [
                  "label" => "Confirm New Password", 
                  "rules" => "required|matches[new_pass]|min_length[6]"
              ]
          ];

          if ($this->validate($rules)) {
        $update['password'] = $_POST['new_pass'];       
        $login_id = $this->session->has('admin_id');
        $get = $this->common_model->GetSingleData('admin', array('id'=>$login_id));
        if($get['password'] == $_POST['old_pass'])
        {
          $run = $this->common_model->UpdateData('admin',array('id' =>$login_id), $update);
           if($run)
            {
          
              $this->session->setFlashdata('msg', '<div class="alert alert-success">Password has been Changed successfully.</div>');
              $output['status']=1;
           }
        }
        else
        {
          $output['status']= 0 ; 
          $output["message"] = '<div class="alert alert-danger">Current Password does not match </div>';  
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

   
}