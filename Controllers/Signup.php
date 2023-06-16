<?php

namespace App\Controllers;

class Signup extends BaseController
{
    // public function __construct() 
    // {
    //     $this->check_login();
    //     error_reporting(1);
    // }
    public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        return $this->check_login();
    } 
    public function index()
    {
        return view('signup');
    }
    public function check_login()
    {
      if ($this->session->has('user_id')) {
          header('Location: '.base_url('dashboard'));
      }
       
    }
    public function do_signup()
    {

         $this->validation->setRule('full_name','Full Name','trim|required');
         $this->validation->setRule('category','Interested In','required');
         $this->validation->setRule('terms','Terms','required' , array('required' =>'Please accept and agree our terms and conditions to proceed'));
         if ($_POST['category'] && $_POST['category'] == 0) {
             $this->validation->setRule('other_interest','Others','required');
         }
         $this->validation->setRule('password','Password','trim|required|min_length[6]|max_length[25]');
         $this->validation->setRule('cnfm_password','Confirm Password','trim|required|min_length[6]|max_length[25]|matches[password]');
        
         $this->validation->setRule('email','Email','trim|required|valid_email|is_unique[users.email]',array('is_unique' =>'This email is already registered with us please try diffrent one'));
         $this->validation->setRule('phone','phone','trim|required|is_unique[users.phone]',array('is_unique' =>'This phone is already registered with us please try diffrent one'));
         $this->validation->setRule('phonecode','phonecode','required|');
         $this->validation->setRule('country','country','trim|required');
         $this->validation->setRule('city','city','trim|required');
         $this->validation->setRule('state','state','trim|required');

        $code = rand();
        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $insert['name'] = $this->request->getVar('full_name');            
            //$insert['language'] = $this->request->getVar('lang');            
            $insert['email'] = $this->request->getVar('email');
            $insert['phonecode'] = $this->request->getVar('phonecode');
            $insert['phone'] = $this->request->getVar('phone');
            $insert['interested_in'] = $this->request->getVar('category');  
            $insert['other_interest'] = isset($_POST['other_interest']) ? $_POST['other_interest'] : '';  
            $insert['address'] = $this->request->getVar('address');
            $insert['city'] = $this->request->getVar('city');
            $insert['state'] = $this->request->getVar('state');
            $insert['country'] = $this->request->getVar('country');
            $insert['zipcode'] = $this->request->getVar('zipcode');
            $latLng = geoLocate($_POST['address'].', '.$_POST['city'].', '.$_POST['state'].', '.$_POST['country']);

            $insert['lat'] = $latLng['lat'];
            $insert['lng'] = $latLng['lng'];
            
            if ($_POST['lat'] && $_POST['lng']) 
            {
                $insert['lat'] = $this->request->getVar('lat');
                $insert['lng'] = $this->request->getVar('lng');
            }
            
        
            if (isset($_POST['recieve_notifications'])) 
            {
                $insert['near_by_ads'] = 1;
                $insert['uread_msg'] = 1;
                $insert['group_added'] = 1;
                $insert['group_joined'] = 1;
                $insert['buyer_chat'] = 1;
            }
            $insert['password'] = base64_encode($this->request->getVar('password'));
            $insert['status'] = 1;
            $insert['user_type'] =1;
            $insert['created_at'] = date('Y-m-d H:i:s');
            $insert['token'] = md5(mt_rand(100000,999999)) ;
            if(!empty($_FILES['image']['name']))
            {
                $newName = explode('.',$_FILES['image']['name']);
                $ext = end($newName);
                $fileName = 'assets/upload/'.rand().time().'.'.$ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
                $insert['image']= $fileName ; 
            }
            else
            {
                $output['message']=['image' => 'Image field is required'] ;
                $output['status']= 0 ;  
                echo json_encode($output);
                exit;
            }
            $run = $this->common_model->InsertData('users',$insert);
           
            if($run)
            {
                $user_id =   $this->session->set('user_id',$run);  
                $login_id = $this->session->get('user_id'); 

                $user = $this->common_model->GetSingleData('users',array('id'=>$login_id));
                $email = $this->request->getVar('email');
                $subject="Thank you for registering with us";
                $body = '<p style="font-size: 16px;color: #000;padding: 5px;">Hello '.$this->request->getVar('full_name').' , </p>
                <p style="font-size: 16px;color: #000;padding: 5px;"> Congratulation! This is an email to inform you that your account has been created successfully.</p>';
                $body .= '<p style="font-size: 16px;color: #000;padding: 5px;">Please <a href="'.base_url().'/verify-email/'.$run.'/'.$insert['token'].'">click here </a> to verify your account</p>';
                $send = $this->common_model->SendMail($email,$subject,$body);       
             
                $output['message'] = 'Your account has been created successfully. Please check your email to verify your account' ;
                $output['status'] = 1 ;                  
                $output['redirect'] = base_url().'/dashboard' ;                  

            }
            else 
            {
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ;  
            
            }
         }
         echo json_encode($output);
    }
    function random_username($string) 
    {
        return vsprintf('%s%s%d', [...sscanf(strtolower($string), '%s %2s'), random_int(0, 100)]);
    }
}
