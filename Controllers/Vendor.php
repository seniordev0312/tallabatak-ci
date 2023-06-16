<?php

namespace App\Controllers;
use App\Models\Common_model;

class Vendor extends BaseController
{
    public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->common_model = new Common_model();
        $this->user_id =  $this->session->get('user_id');
        $this->user = $this->common_model->GetSingleData('users', array('id' => $this->user_id));
        return $this->check_login();
    } 
    
    public function check_login()
    {
        if ($this->session->has('user_id')) {
            
            if($this->user['email_verified']==0)
            {
                header('Location: '.base_url('verification-pending-screen'));
                exit();
            }
          
        }
        if(!$this->session->has('user_id'))
        {
            $this->session->setFlashdata('error', 'Please login first to access that page');
            header('Location: '.base_url('/'));
            exit();
        }
       
    }

    function vendor_profile($slug)
    {
        $url = explode('-', $slug);
        $id  = end($url);
        $data['vendor'] = $this->common_model->GetSingleData("users", array("id"=>$id));
       
        
        if($data['vendor'])
        { 

            return view('site/vendor-profile', $data);
        }
        return view('site/404');
    }
   
    
}
