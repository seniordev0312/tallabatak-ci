<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
class Coupon extends BaseController {

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
        $data['all_coupon'] = $this->common_model->GetAllData('coupons','','id','desc');
        return view('admin/all_coupon_list',$data);
    }

    public function deleteCoupon()
    {
        $this->common_model->DeleteData('coupons' , ['id' => $_POST['id']]);
        $output['message'] = 'Your coupon has been deleted successfully' ;
        $output['status'] = 1 ;  
        echo json_encode($output);
    }

    public function changeStatus()
    {
        $this->common_model->UpdateData('coupons', ['id' => $_POST['id']], ['status' => $_POST['status']]);
        $output['message'] = 'Your coupon status has been change successfully' ;
        $output['status'] = 1 ;  
        echo json_encode($output);
    }
      
}
    