<?php

namespace App\Controllers;

class Login extends BaseController
{
	public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
       // return $this->check_login();
    } 
    public function check_login()
    {
      if ($this->session->has('user_id')) {
          header('Location: '.base_url('profile'));
      }
       
    }
    
    public function do_login()
    {
        $this->validation->setRule('password1','Password','trim|required');
        $this->validation->setRule('email1','Email','trim|required|valid_email');

        if($this->validation->withRequest($this->request)->run()==false)
        {
            $output['message']=$this->validation->getErrors();
            $output['status']= 2 ;       
        }
    
        else
        {
        	$email = $this->request->getVar('email1');
			$password =  base64_encode($this->request->getVar('password1'));
			$run = $this->common_model->GetSingleData('users',array('email' =>$email ,'password'=>$password));
            
            if($run)
            {
                if ($run['status'] == 1) 
                {
                    $this->session->set('user_id',$run['id']);  
                    $data['lat'] = $run['lat'];
                    $data['lng'] = $run['lng'];
                    $this->session->set('current_location' , $data);
                    $output['message']='You are logged in successfully.' ;
                    $output['status']= 1 ;                  
                    $output['redirect']= base_url('/') ; 
                }
                else
                {
                    $output['message']='<div class="alert alert-danger">Your account has been disabled. please contact admin</div>' ;
                    $output['status']= 0 ; 
                }
                                 

            }
            else 
            {
            
                $output['message']='<div class="alert alert-danger">Invalid Login details</div>' ;
                $output['status']= 0 ;  
            
            }
         }
         echo json_encode($output);
    }

    public function do_login_app()
    {
        $email = $this->request->getVar('email1');
        $password =  base64_encode($this->request->getVar('password1'));
        $run = $this->common_model->GetSingleData('users',array('email' =>$email ,'password'=>$password));
        $userList=$this->common_model->GetALLData('users');
        if($run)
        {
            if ($run['status'] == 1) 
            {
                // $this->session->set('user_id',$run['id']);  
                $data['lat'] = $run['lat'];
                $data['lng'] = $run['lng'];
                // $this->session->set('current_location' , $data);
                $output['message']='You are logged in successfully.' ;
                $output['status']= 1 ;                  
                $output['userData']=$run;
            }
            else
            {
                $output['message']='<div class="alert alert-danger">Your account has been disabled. please contact admin</div>' ;
                $output['status']= 0 ; 
            }
            $dm = $this->common_model->GetDMData($run['id']);
            $output['dm'] = $dm;
            
            $total_count = 0;
            for($i=0;$i<count($dm);$i++){
                $total_count += $dm[$i]['unread_count'];
            }
            $output['total_count'] = $total_count;
            $not_count = $this->common_model->GetSingleData('notification',array('user_id' =>$run['id'],'is_read'=>0));
            $output['notification_count'] = count($not_count);
            $output['user_list']=$userList;
        }
        else 
        {
        
            // $output['message']='<div class="alert alert-danger">Invalid Login details</div>' ;
            $output['status']= 0 ;  
        
        }
        //chat info (all contacts(chat list), last message , unread count per contact , total unread count, notification unread count)

        echo json_encode($output);
    }



    public function do_forgot()
    {
       
        $this->validation->setRule('email2','Email','trim|required|valid_email');

        if($this->validation->withRequest($this->request)->run()==false)
        {
            $output['message']=$this->validation->getErrors();
            $output['status']= 2 ;       
        }
    
        else
        {
            $email = $this->request->getVar('email2');
           
            $run = $this->common_model->GetSingleData('users',array('email' =>$email ));
            
            if($run)
            {
                $insert['reset_token'] = md5(mt_rand(100000,999999)) ;
                $where['id'] = $run['id'] ;

                $this->common_model->UpdateData('users', $where , $insert);

                $subject="Forgot password";
                $body = '<p style="text-align: left;color: black; padding:5px 0;">Hello! '.$run['name'].',</p>';               
                $body .= '<p style="text-align: left;color: black; padding:5px 0;">This is an automatic message . If you did not start the Forgot Password process recently, please ignore this email.</p>';                
                $body .= '<p style="text-align: left;color: black; padding:5px 0;">You indicated that you forgot your login password. Please click below to reset your '.Project.' account password.</p>'; 

                $body .= '<a href="'.base_url().'/reset-password/'.$run['id'].'/'.$insert['reset_token'].'" style="margin-top: 30px;font-size: 18px;font-weight: 450;font-family: ProximaNova, Helvetica, Arial, sans-serif;color: rgb(255, 255, 255);background: #000;text-decoration: none;border-radius: 2px;border: 0px;display: inline-block;line-height: 35px;padding: 5px 15px;text-size-adjust: 100%;">Reset Password</a>';
                
                

                $this->common_model->SendMail($email,$subject,$body);
                
                $output['message']='If there is an account associated with the provided email address, then you will receive an email with a link to reset your password.' ;
                $output['type']='success' ;
                $output['status']= 1 ;                  
                $output['redirect']= base_url('profile') ;  
                
               } 
               else 
               {
                
                $output['message']='Error! This email id does not exists in our system.' ;
                $output['type']='error' ;
                $output['status']= 0 ;                  
                $output['redirect']= base_url('profile') ;                  

                }
            
         }
         echo json_encode($output);
    }
    public function do_google_signup()
    {
        $this->google_client = initGoogleLogin()['client'];
       

        $this->google_service = initGoogleLogin()['service'];
      if(isset($_GET["code"]))
      {
       $this->google_client->authenticate($_GET["code"]);
       $token = $this->google_client->getAccessToken();
       
       if($this->google_client->getAccessToken())
       {
        $this->google_client->setAccessToken($token);

        $data = $this->google_service->userinfo->get();
        //print_r($data); die;
        
            $insert['name'] = $data['name'];           
            //$insert['language'] = $this->request->getVar('lang');            
            $insert['email'] = $data['email'];
           
            $insert['login_oauth_uid'] = $data['id'];
            $insert['created_at'] = date('Y-m-d H:i:s');
            $insert['token'] = md5(mt_rand(100000,999999)) ;
            $insert['email_verified'] = 1;
            $check = $this->common_model->GetSingleData('users' , array('email' => $insert['email']));
            if ($check) 
            {
                $this->common_model->UpdateData('users', array('email' => $insert['email']),$insert);
                $user_id =   $this->session->set('user_id',$check['id']); 
                echo $output['message']='Your account has been logged in successfully. ' ;
                return redirect('dashboard');      
            }
            else
            {
                 if ($data['picture']) {
                    $insert['image'] = 'assets/upload/'.rand().time().'.jpg';
                    copy($data['picture'], $insert['image']);

                }
                $insert['status'] = 1;
                $insert['user_type'] =1;
                $insert['password'] = base64_encode(mt_rand(100000,999999));
                $run = $this->common_model->InsertData('users',$insert);
                if($run)
                {
                    $user_id =   $this->session->set('user_id',$run);  
                    $login_id = $this->session->get('user_id'); 

                    $user = $this->common_model->GetSingleData('users',array('id'=>$login_id));
                    $email = $user['email'];
                    $subject="Account created !";
                    $body = '<p>Hello '.$user['name'].' </p><p> Congratulation! This is an email to inform you that your account has been created successfully.</p>';
                  
                    $send = $this->common_model->SendMail($email,$subject,$body);       
                 
                    echo $output['message']='Your account has been created successfully. Please check your email to verify your account' ;
                    $output['status']= 1 ;                  
                    return redirect('dashboard');                  

                }
                else 
                {
                
                    $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                    $output['status']= 0 ;
                    return redirect('/'); 
                
                }
            }
            
         
        }
        
       }
      }

    public function do_fb_signup()
    {
        $helper = initFbLogin()['fb_helper'];
        $facebook = initFbLogin()['facebook'];
       
      if(isset($_GET["code"]))
      {
    
        $access_token = $helper->getAccessToken(); 
      
        $facebook->setDefaultAccessToken($access_token);
        $graph_response = $facebook->get('/me?fields=first_name,last_name,email' , $access_token);
        $data = $graph_response->getGraphUser();
       //print_r($data); die;
         //insert data
           $insert['name'] = $data['first_name'].' '.$data['last_name'];           
            //$insert['language'] = $this->request->getVar('lang');            
            $insert['email'] = $data['email'];
           
            $insert['login_oauth_uid'] = $data['id'];
            $insert['created_at'] = date('Y-m-d H:i:s');
            $insert['token'] = md5(mt_rand(100000,999999)) ;
            $insert['email_verified'] = 1;
            if ($data['email']) {
                $check = $this->common_model->GetSingleData('users' , array('email' => $insert['email']));
            }
            else
            {
                $check = $this->common_model->GetSingleData('users' , array('login_oauth_uid' => $data['id']));
            }
            
            if ($check) 
            {
                $insert['password'] = $check['password'];
                $this->common_model->UpdateData('users', array('email' => $insert['email']),$insert);
                $user_id =   $this->session->set('user_id',$check['id']); 
                echo $output['message']='Your account has been logged in successfully. ' ;
                return redirect('dashboard');      
            }
            else
            {
                
                $insert['status'] = 1;
                $insert['user_type'] =1;
                $insert['password'] = base64_encode(mt_rand(100000,999999));
                $run = $this->common_model->InsertData('users',$insert);
                if($run)
                {
                    $user_id =   $this->session->set('user_id',$run);  
                    $login_id = $this->session->get('user_id'); 

                    $user = $this->common_model->GetSingleData('users',array('id'=>$login_id));
                    $email = $user['email'];
                    $subject="Account created !";
                    $body = '<p>Hello '.$user['name'].' </p><p> Congratulation! This is an email to inform you that your account has been created successfully.</p>';
                  
                    $send = $this->common_model->SendMail($email,$subject,$body);        
                 
                    echo $output['message']='Your account has been created successfully. Please check your email to verify your account' ;
                    $output['status']= 1 ;                  
                    return redirect('dashboard');                  

                }
                else 
                {
                
                    $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                    $output['status']= 0 ;
                    return redirect('/'); 
                
                }
            }
            
         
        }
        else 
        {
        
            $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
            $output['status']= 0 ;
            return redirect('/'); 
        
        }
        
      
      }
    
}
