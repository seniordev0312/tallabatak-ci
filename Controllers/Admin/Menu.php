<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
class Menu extends BaseController {

	public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        
        $this->check_login();
    } 
    public function check_login()
    {
      if (!$this->session->has('admin_id')) {
          header('Location: '.base_url('admin'));
          return ; 
      }
       
    }

    public function editMenu()
    {
        	$id = $_POST['id'];
            $update['menu_items'] = $_POST['menu_items'];
			$run = $this->common_model->UpdateData('header_menu',array('id' =>$id),$update);
            if($run)
            {
                    $this->session->setFlashdata('msg', '<div class="alert alert-success">Header Menu has been Updated successfully.</div>');
                    $output['status']=1;
                    $output['message']="Header Menu has been Updated successfully.";
            }else{
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Something Went Wrong.</div>');
                    $output['status']=1;
                    $output['message']="Something Went Wrong.";
            }
            
			
	   
		echo json_encode($output);
    }

    public function menu_list()
    {
        $data['data'] = $this->common_model->GetAllData('header_menu','','id','desc');
        return view('admin/menu-list', $data);
    }

  


    
}