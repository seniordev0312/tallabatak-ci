<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
class Swap extends BaseController {

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
        $data['all_swap'] = $this->common_model->GetAllData('swap','','id','desc');
        return view('admin/all_swap_list',$data);
    }

    public function deleteSwap()
    {
        $this->common_model->DeleteData('swap' , ['id' => $_POST['id']]);
        $output['message'] = 'Your swap has been deleted successfully' ;
        $output['status'] = 1 ;  
        echo json_encode($output);
    }

    public function changeStatus()
    {
        $this->common_model->UpdateData('swap', ['id' => $_POST['id']], ['status' => $_POST['status']]);
        $output['message'] = 'Your swap status has been change successfully' ;
        $output['status'] = 1 ;  
        echo json_encode($output);
    }
      
}
    