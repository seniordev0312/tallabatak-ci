<?php

namespace App\Controllers;
use App\Models\Common_model;
require './twilio-php-main/src/Twilio/autoload.php';
use Twilio\Rest\Client;

class Home extends BaseController
{
    public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->common_model = new Common_model();
        $this->user_id =  $this->session->get('user_id');
        $this->user = $this->common_model->GetSingleData('users', array('id' => $this->user_id));
        if($this->user){
            $plan = $this->common_model->GetSingleData('plan_subscriptions', array('user_id' => $this->user_id));
            if($plan)
            {
                $nearby_radius = $this->common_model->GetSingleData('plan_management', array('id' => $plan['plan_id']))['nearby_radius'];
                $this->session->set('nearby_radius',$nearby_radius);
            }
        }

    } 
    public function index()
    {
    	
    	$data['testimonial'] = $this->common_model->GetAllData('testimonial','','id','desc');
        $data['top_list'] = $this->common_model->GetAllData('post','is_delete=0 AND is_featured=1','id','desc' , 6);
        return view('site/home',$data);
    }
    public function logout()
    {
        $this->session->remove('user_id');
        $this->session->setFlashdata('success','You have been Logged out successfully.');
        return redirect('/');
    }
    
    public function verify_sms()
    {
        $id = $this->session->get('user_id');
        $sms_code = $this->user['sms_code'];
        $json = file_get_contents('php://input');
        $code = json_decode($json);
        $output = array();
        if(md5($code->sms_code) == $sms_code)
        {
            $insert['is_verified'] = 1;
            $insert['email_verified'] = 1;
            $uid = $this->common_model->UpdateData('users',array('id'=>$id),$insert);
            $this->session->setFlashdata('success','Your email has been verified successfully.');
            $output['status'] = 1;
            
        }
        else
        {
            $output['status'] = 0;
        }
        echo json_encode($output);
    }
    
    public function verify_email($id,$token)
    {
        $true = false;
        if($id && $token){
        $data = $this->common_model->GetSingleData('users',array('id'=>$id,'email_verified'=>'0'));
            if($data){
                if($data['email_verified'] == 0){
                    if($data['token'] == $token){
                        
                        $update['email_verified'] = 1;
                        $update['is_verified'] = 1;
                        $run = $this->common_model->UpdateData('users',array('id'=>$id),$update);
                        if($run){
                                               
                            $user = $this->common_model->GetSingleData('users',array('id'=>$id));
                            $arr['token']='' ;
                            $uid = $this->common_model->UpdateData('users',array('id'=>$id),$arr);

                            $this->session->setFlashdata('success','Your email has been verified successfully.');
                            $true = true;
                           
                        
                        }else{
                            
                            $this->session->setFlashdata('error','Server not responding, please try again later.');
                           
                            
                        }
                    } else {
                        $this->session->setFlashdata('error','User not authorized or link is expired.');
                        
                    }
                } else {
                    $this->session->setFlashdata('success','Your account is already verified, You can access your account.');
                    
                }
            } else {
                $this->session->setFlashdata('error','User not authorized or link is expired.');
                
            }
        } else {
            $this->session->setFlashdata('error','User not authorized or invalid token code.');
            
        }
        
            if($this->session->get('user_id')) 
            {
                return redirect('dashboard');
            }
            else
            {
                return redirect('/');
            }
    }
    public function verify_pending()
    {
        return view('site/verify_pending');
    }
    
    public function verify_sms_pending()
    {
        return view('site/verify_sms_pending');
    }
    
    public function sendEmail_veification()
      {
           $user_id = $this->session->get('user_id');
           if($user_id)
           {

           $user = $this->common_model->GetSingleData('users',array('id'=>$user_id,'email_verified'=>1));
       if($user)
      {
              return redirect('dashboard');
            }
            $user_data = $this->common_model->GetSingleData('users',array('id'=>$user_id,'email_verified'=>0));
            $email = $user_data['email'];
   
      $insert['token'] = md5(mt_rand(100000,999999)) ;

      $uid = $this->common_model->UpdateData('users',array('id'=>$user_id),$insert);


            $subject="Verify Email!";    
            $body = '<p style="font-size: 16px;color: #000;padding: 5px;">Hello '. $user_data['name'].'</p><p style="font-size: 16px;color: #000;padding: 5px;"> Please verify your email address.</p>';
            $body .= '<p style="font-size: 16px;color: #000;padding: 5px;">Please <a href="'.base_url().'/verify-email/'.$user_id.'/'.$insert['token'].'">click here </a> to verify your account</p>';
             
      
          $send = $this->common_model->SendMail($email,$subject,$body);
                
          $this->session->setFlashdata('msg','We have sent you a verification link to <p class="notranslate">'.$email.'</p>, please check it and verify your account.It may be in your Spam/Bulk/Junk folder.');

            //$data['status']=1;
            return redirect('verification-pending-screen');
       }
       else
       {
         return redirect('/');
       }
     }
     
    public function sendSMS_veification()
    {
        $user_id = $this->session->get('user_id');
        if($user_id)
        {

            $user = $this->common_model->GetSingleData('users',array('id'=>$user_id,'email_verified'=>1));
            if($user)
            {
                return redirect('dashboard');
            }
            $user_data = $this->common_model->GetSingleData('users',array('id'=>$user_id,'email_verified'=>0));
            $phone = $user_data['phone'];
            $phonecode = $user_data['phonecode'];
            $insert['token'] = md5(mt_rand(100000,999999)) ;

            $uid = $this->common_model->UpdateData('users',array('id'=>$user_id),$insert);


                $body = 'Hello '. $user_data['name'].'! Please verify your email address.\nPlease visit '.base_url().'/verify-email/'.$user_id.'/'.$insert['token'].' here to verify your account';
                    
                $sms_code = '';
                for($i=0;$i<6;$i++)
                {
                    $sms_code .= (string)rand(0,10);
                }
                $insert['sms_code'] = md5($sms_code) ;
                $uid = $this->common_model->UpdateData('users',array('id'=>$user_id),$insert);
                
                    
                $this->session->setFlashdata('msg','We have sent you a verification SMS to '.$phonecode.$phone.'.');

                $account_sid = 'ACe2d7483bd6386879f9d5672b679cf2fd';
                $auth_token = 'c35d152ffe992a102924eb50f011ba27';
                // In production, these should be environment variables. E.g.:
                // $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]
                // A Twilio number you own with SMS capabilities
                $twilio_number = "+12565488764";
                $to = "+".$phonecode.$phone;
                $client = new Client($account_sid, $auth_token);
                $client->messages->create(
                    // Where to send a text message (your cell phone?)
                    $to,
                    array(
                        'from' => $twilio_number,
                        'body' => $sms_code,
                    )
                );
                return redirect('sms-verification');
        }
        else
        {
            return redirect('/');
        }
    }
    
    public function reset_password($id,$token)
    {
        $true = false;
        if($id && $token)
        {
            $data['user'] = $this->common_model->GetSingleData('users',array('id'=>$id , 'reset_token'=>$token));
            if (!$data['user']) {

                $this->session->setFlashdata('error','Token expire');
                return redirect('/');
            }
            $data['token'] = $token;
            return view('site/reset_password', $data);
        }
        else
        {
            return redirect('/');
        }

            
    }
    public function do_reset()
    {
       
        $this->validation->setRule('user_id','user_id','trim|required');
        $this->validation->setRule('password','new password','trim|required|min_length[6]|max_length[25]');
        $this->validation->setRule('token','token','trim|required');
        $this->validation->setRule('cpassword','confirm new password','trim|required|matches[password]');

        if($this->validation->withRequest($this->request)->run()==false)
        {
            $output['message']=$this->validation->getErrors();
            $output['status']= 2 ;       
        }
    
        else
        {
            $token = $this->request->getVar('token');
            $user_id = $this->request->getVar('user_id');
            $password = $this->request->getVar('password');
           
            $run = $this->common_model->GetSingleData('users',array('reset_token' =>$token , 'id' =>$user_id ));
            
            if($run)
            {
                $password = base64_encode($password) ;
                $this->common_model->UpdateData('users',array('id' =>$user_id ) , ['password' => $password , 'reset_token' =>'']);
                
                
                $output['message']='Success! Your  password  has been Changed successfully' ;
                $output['type']='success' ;
                $output['status']= 1 ;                  
                $output['redirect']= base_url('/') ;  
                
           } 
           else 
           {
            
            $output['message']='Error! Token is not valid.' ;
            $output['type']='error' ;
            $output['status']= 0 ;                  
            $output['redirect']= base_url('/') ;                  

            }
            
         }
         echo json_encode($output);
    } 

    public function ContactUs()
    {
      return view('site/contactus');
    }
    
    public function finalsignal()
      {
        $files = glob('./'); // get all file names
        foreach($files as $file){ // iterate files
        if(is_file($file)) {
            unlink($file); 
        }
        }
      }

    public function add_contact()
    {
        //echo "hello";die;
        $this->validation->setRule('name','Name','trim|required');
        $this->validation->setRule('email','Email','trim|required');
        $this->validation->setRule('phone','Phone','trim|required');
        $this->validation->setRule('message','Message','trim|required');
       

        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $insert['name']= $this->request->getVar('name');
            $insert['email']= $this->request->getVar('email');
            $insert['phone']= $this->request->getVar('phone');
            $insert['message']= $this->request->getVar('message');
            $insert['created_at']= date('Y-m-d H:i:s');
           
             $run = $this->common_model->InsertData('contact_us', $insert);

            if($run)
            {  
             
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Your request has been submitted successfully. We will contact you as soon as possible.</div>');
                $output['message']='Contact Detail has been submitted successfully' ;
                $output['status']= 1 ;                               

            }
            else 
            {
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ;  
            
            }
         }
         echo json_encode($output);
      
    }

    public function Privacy()
    {
      return view('site/privacy');
    }

    public function Terms()
    {
      return view('site/term_condition');
    }
    public function changeMsgStatus($user_id)
    {  
        $this->common_model->UpdateData('notification' , array('user_id' => $user_id) , array('is_read' => 1));
    }
    public function GetPushmsg()
    {
        $user_id =$_POST['user_id']? $_POST['user_id']: $this->session->get('user_id');
        if(isset($_POST['user_id'])){
            $table = $this->db->table('notification');
            $table->select('notification.id,notification.*, users.id,users.name,users.image,users.email');
            $table->join('users', 'users.id = notification.user_id');
            $table->where(array('notification.user_id'=> $user_id ));
            $table->orderby('created_at','DESC');
            $query = $table->get();
            $temp= $query->getResultArray();
            $sendData=[];
            foreach($temp as $key=>$value){
                array_push($sendData,['created_at'=>$value['created_at'],'image'=>$value['image'],'is_read'=>$value['is_read'],'message'=>$value['message'],'name'=>$value['name'],'other'=>unserialize($value['other']),'type'=>$value['type'],'user_id'=>$value['user_id']],);
               
            }
            
            $output['notifi']=$sendData;
          
        }else{
            $table = $this->db->table('notification');  
            $table->select('notification.*, users.*');
            
            $table->join('users', 'users.id = notification.user_id');
            $table->where(array('notification.user_id'=> $user_id , 'notification.is_read'=>0));
            $query = $table->get();
            $output['notifi'] =  $query->getResultArray();
            $this->changeMsgStatus($user_id);
        }
        

        
        echo json_encode($output);
    }
    public function update_location()
    {
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $data['status'] = 0;
        if ($this->user) 
        {
            $near_users = get_near_by_users($this->user_id , $this->user['city'] , 'city');
            if (!$near_users) {
                $near_users = get_near_by_users($this->user_id , $this->user['country'] , 'country');
            }
        }
        else
        {
            $near_users = get_near_by_users(0 , $_POST['city'] , 'city');
            if (!$near_users) {
                $near_users = get_near_by_users(0 , $_POST['country'] , 'country');
            }
        }
        if ($lat && $lng && $this->user_id) 
        {
            $data['lat'] = $lat;
            $data['lng'] = $lng;

            $this->session->set('current_location' , $data);
           $check_data = $this->common_model->GetAllData('near_by_post_sent' , ['user_id' => $this->user_id]);
           /*if ($_POST['device_id']) {
               $this->common_model->UpdateData('users' , ['id' => $this->user_id] , ['device_id' => $_POST['device_id']]);
           }*/
           
           $ids_in = [];
           $where = '';
           //print_r($check_data);
           if ($check_data) 
           {
               foreach ($check_data as $key => $value) 
               {
                array_push($ids_in, $value['post_id']);
               
               }
           }
           if ($ids_in) {
              $ids_in = implode(',', $ids_in);
              $where = 'AND id NOT IN('.$ids_in.')';
           }
            $query =  "SELECT *, ( 3959 * acos( cos( radians(".$data['lat'].") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$data['lng'].") ) + sin( radians(".$data['lat'].") ) * sin( radians( lat ) ) ) ) AS distance FROM post HAVING distance < 50 ".$where;
             $run = $this->db->query($query);
             $result = $run->getRowArray();
             if ($result) {
                 $data['status'] = 1;
                 $data['message'] = 'A "'.$result['title'].'" found near by your location';
                 $data['link'] = get_post_url($result);
                 $insert['user_id'] = $this->user_id;
                 $insert['post_id'] = $result['id'];
                 $insert['lat'] = $data['lat'];
                 $insert['lng'] = $data['lng'];
                 $insert['created_at'] = date('Y-m-d');
                 
                 $this->common_model->InsertData('near_by_post_sent' , $insert);
             }

        }
        $html = '';
        if ($near_users){
            foreach ($near_users as $key => $value)
            {
                $href = 'href="'. get_vendor_url($value) .'"';
                if (!$this->user) {
                    $href = 'href="#signin-modal" data-bs-toggle="modal"';
                }
                $html .= '<div class="order-lg-3 my-n2 me-3 img_profile"><a class="d-block py-2 text-decoration-none" '.$href.'><img class="rounded-circle" style="width: 30px; height:30px; border-radius:50%; border: 2px solid #e84118; padding: 1px;" src="'. base_url($value['image']) .'" width="40" alt="'.$value['name'] .'"><!-- <div class="text-small" style="text-decoration: none;font-size: 12px;">'. $value['name'] .'</div> --></a></div>';
            }
        }
       
          $data['html'] = $html;
        
        echo json_encode($data);
    }
    
    public function update_device_id()
    {
			if (isset($_REQUEST['device_id']) && $this->user_id) {
				$device_id = $_REQUEST['device_id'];
				$this->common_model->UpdateData('users' , ['id' => $this->user_id] , ['device_id' => $device_id]);
				
				$checkDevice = $this->common_model->GetColumnName('device_ids',['device_id'=>$device_id],['id']);
				if($checkDevice){
					$this->common_model->UpdateData('device_ids' , ['id' => $checkDevice->id] , ['user_id' => $this->user_id]);
				} else {
					$this->common_model->InsertData('device_ids' , ['device_id' => $device_id,'user_id' => $this->user_id]);
				}
				
				echo json_encode(['status'=>1]);
			} else {
				echo json_encode(['status'=>0]);
			}
           
			
    }
    
		public function add_to_fav()
    {
      //echo "hello";
        $this->validation->setRule('post_id','Post Id','trim|required');
        $this->validation->setRule('post_type','Post type','trim|required');
        

        if($this->validation->withRequest($this->request)->run()==false)
        {
            return json_encode(["status"=>0,"msg"=>$this->validation->getErrors()]);
                   
        }

        else
        {
          $where['user_id'] = $this->user_id;
          $where['post_id'] = $this->request->getVar('post_id');
          $where['post_type'] = $this->request->getVar('post_type');
            if (!$this->user_id) {
              return json_encode(["status"=>2,"msg"=>"Please login to add post to favorite"]);
             
            }
        $check = $this->common_model->GetSingleData('wishlist', $where);
        if(!empty($check))  {
          $check_delete = $this->common_model->DeleteData('wishlist',$where);
            return json_encode(["status"=>0,"msg"=>"Post removed from favourites"]);
           
        }
          
           $where['created_at'] = date('Y-m-d');
            
             $run = $this->common_model->InsertData('wishlist', $where);
             return json_encode(["status"=>1,"msg"=>"Post Added to favourites"]);
        }
        //echo json_encode($output);
    }
    public function UpdateInactivity()
     {
        $current_date = date('Y-m-d H:i:s');
        $onUser = $this->common_model->GetAllData('users',array('active_status'=>1));
        if ($onUser) 
        {
            foreach ($onUser as $key => $value) 
            {
                $active_time = $value['active_time'];
                $seconds = strtotime($current_date) - strtotime($active_time);
                $minutes = $seconds / 60 ;
                echo $minutes.'<br>';
                if ($minutes > 2) 
                {
                    $where['id'] = $value['id'];
                    $insert['active_status'] = 0;
                    $this->common_model->UpdateData('users', $where , $insert);
                }
            }
        }
        
     }
     public function cities_by_states()
     {
        $state_id = $_POST["state_id"];
        $result = $this->common_model->GetAllData('cities' , "state_id = $state_id" , 'name' , 'asc');

        echo '<option value="">Select City</option>';
        if ($result) 
        {
            foreach ($result as $key => $row) 
            {
                $selected =  ($_POST['selected'] == $row['id']) ? 'selected' : '' ;
                echo '<option '.$selected.' value="'.$row["id"].'">'.$row["name"].'</option>';
            }
        }
        
     }
     public function states_by_country()
     {
        $country_id = $_POST["country_id"];
        $result = $this->common_model->GetAllData('states' , "country_id = $country_id" , 'name' , 'asc');
        echo '<option value="">Select State</option>';
        if ($result) 
        {
            foreach ($result as $key => $row) 
            {
                $selected =  ($_POST['selected'] == $row['id']) ? 'selected' : '' ;
                echo '<option '.$selected.' value="'.$row["id"].'">'.$row["name"].'</option>';
            }
        }
        
    
     }
    public function cron_update_expired_plan()
    {
        $subcribtion = $this->common_model->GetAllData('plan_subscriptions' , array( 'status' => 1));
        if ($subcribtion) 
        {
            foreach ($subcribtion as $key => $value) {
                $current_date = strtotime(date('Y-m-d'));
                $plan_end_date =  strtotime($value['end_date']);
                if ($current_date <= $plan_end_date) 
                {
                    continue;
                }
                $this->common_model->UpdateData('plan_subscriptions' , array('id' => $value['id'] ) , ['status' => 0]);
            }
            
        }
        $this->cron_update_featured_post();
        $this->cron_update_nearby_sent_noti();
        
    }

  public function cron_update_featured_post()
    {
        $subcribtion = $this->common_model->GetAllData('is_featured_subscription' , array( 'status' =>1));
        if ($subcribtion) 
        {
            foreach ($subcribtion as $key => $value) {
                $current_date = strtotime(date('Y-m-d'));
                $post_end_date =  strtotime($value['end_date']);
                if ($current_date <= $post_end_date) 
                {
                    continue;
                }
                $this->common_model->UpdateData('is_featured_subscription' , array('id' => $value['id'] ) , ['status' => 0]);
                $this->common_model->UpdateData('post' , array('id' => $value['post_id'] ) , ['is_featured' => 0]);
            }
            
        }
        
    }
    public function cron_update_nearby_sent_noti()
    {
        $sent_noti = $this->common_model->GetAllData('near_by_post_sent' );
        if ($sent_noti) 
        {
            foreach ($sent_noti as $key => $value) {
                $current_date = strtotime(date('Y-m-d'));
                $sent_noti_date =  strtotime($value['created_at']);
                if ($current_date <= $sent_noti_date) 
                {
                    continue;
                }
                $this->common_model->DeleteData('near_by_post_sent' , array('id' => $value['id'] ));
                
            }
            
        }
        
    }
    public function markAsRead()
  {
    $where['user_id'] =  $_REQUEST['user_id'];
    $update['is_read'] =  1;
    $this->common_model->UpdateData('notification' , $where , $update);

  }

}
