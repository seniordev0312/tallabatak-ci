<?php

namespace App\Controllers;
use App\Models\Common_model;
use App\Models\CouponModel;
class User extends BaseController
{
    public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->common_model = new Common_model();
        $this->CouponModel = new CouponModel();
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

    public function index()
    {
        return view('site/dashboard');
    }
   public function become_seller()
    {
        return view('site/become-seller');
    }
   
   /* public function profile()
    {
        
        return view('site/edit-profile');
    }
    public function change_password()
    {
        
        return view('site/change-password');update_password
    }*/

  public function update_profile()
    {
        
        return view('site/profile');
    }
   
    public function do_update()
    {

         $this->validation->setRule('name','Full Name','trim|required');
         $this->validation->setRule('phone','phone','trim|required');
         $this->validation->setRule('category','Interested In','required');
         $this->validation->setRule('country','country','trim|required');
         $this->validation->setRule('city','city','trim|required');
         $this->validation->setRule('state','state','trim|required');
         if ($_POST['category'] == 0) {
             $this->validation->setRule('other_interest','Others','required');
         }
         
        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $insert['name'] = $this->request->getVar('name');            
            $insert['address'] = $this->request->getVar('address');            
            $insert['phone'] = $this->request->getVar('phone');            
            $insert['phonecode'] = $this->request->getVar('phonecode');            
            
           $latLng = geoLocate($_POST['address'].', '.$_POST['city'].', '.$_POST['state'].', '.$_POST['country']);

            $insert['lat'] = $latLng['lat'];
            $insert['lng'] = $latLng['lat'];
            
            if ($_POST['lat'] && $_POST['lng']) 
            {
                $insert['lat'] = $this->request->getVar('lat');
                $insert['lng'] = $this->request->getVar('lng');
            }
            $insert['city'] = $this->request->getVar('city');
            $insert['state'] = $this->request->getVar('state');
            $insert['country'] = $this->request->getVar('country');
            $insert['zipcode'] = $this->request->getVar('zipcode');
            $insert['facebook'] = $this->request->getVar('facebook');
            $insert['linkedin'] = $this->request->getVar('linkedin');
            $insert['twitter'] = $this->request->getVar('twitter');
            $insert['instagram'] = $this->request->getVar('instagram');
            $insert['pinterest'] = $this->request->getVar('pinterest');
            $insert['interested_in'] = $this->request->getVar('category');  
            $insert['other_interest'] = isset($_POST['other_interest']) ? $_POST['other_interest'] : '';  
            if(!empty($_FILES['image']['name']))
            {
                $newName = explode('.',$_FILES['image']['name']);
                $ext = end($newName);
                $fileName = 'assets/upload/'.rand().time().'.'.$ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
                $insert['image']= $fileName ; 
            }
            
            $insert['updated_at'] = date('Y-m-d H:i:s');
            

            $run = $this->common_model->UpdateData('users', array('id'=> $this->user_id) ,$insert );
            // echo $this->db->lastQuery; die(); 
            if($run)
            {  
             
                $output['message']='Your profile has been updated successfully.' ;
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
    public function do_forgot()
    {
       
        $this->validation->setRule('email','Email','trim|required|valid_email');

        if($this->validation->withRequest($this->request)->run()==false)
        {
            $output['message']=$this->validation->getErrors();
            $output['status']= 2 ;       
        }
    
        else
        {
            $email = $this->request->getVar('email');
           
            $run = $this->common_model->GetSingleData('users',array('email' =>$email ));
            
            if($run)
            {
                $insert['reset_token'] = md5(mt_rand(100000,999999)) ;
                $where['id'] = $run['id'] ;

                $this->common_model->UpdateData('users', $where , $insert);

                $subject="Reset password";
                $body = '<p style="text-align: left;color: black; padding:5px 0;">Hello! '.$run['first_name'].',</p>';               
                $body .= '<p style="text-align: left;color: black; padding:5px 0;">This is an automatic message . If you did not start the Reset Password process recently, please ignore this email.</p>';                
                $body .= '<p style="text-align: left;color: black; padding:5px 0;">You indicated that you forgot your login password. Please click below to reset your '.Project.' account password.</p>'; 

                $body .= '<a href="'.base_url().'/reset-password/'.$run['id'].'/'.$insert['reset_token'].'" style="margin-top: 30px;font-size: 18px;font-weight: 450;font-family: ProximaNova, Helvetica, Arial, sans-serif;color: rgb(255, 255, 255);background: #000;text-decoration: none;border-radius: 2px;border: 0px;display: inline-block;line-height: 35px;padding: 5px 15px;text-size-adjust: 100%;">Reset Password</a>';
                
                

                $this->common_model->SendMail($email,$subject,$body);
                
                $output['message']='You will receive an email with a link to reset your password.' ;
                $output['type']='success' ;
                $output['status']= 1 ;                  
                $output['redirect']= base_url('dashboard') ;  
                
               } 
               else 
               {
                
                $output['message']='Error! This email id does not exists in our system.' ;
                $output['type']='error' ;
                $output['status']= 0 ;                  
                $output['redirect']= base_url('dashboard') ;                  

                }
            
         }
         echo json_encode($output);
    }

    public function update_password()
    {
        
        return view('site/change-password');
    }
    public function do_change_password()
    {

         $this->validation->setRule('curr_password','Current Password','trim|required');
         $this->validation->setRule('password','Password','trim|required|min_length[6]|max_length[12]');
    
         $this->validation->setRule('c_password','Confirm Password','trim|required|matches[password]');

        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $curr_password = base64_encode($this->request->getVar('curr_password'));
            $new_password = base64_encode($this->request->getVar('password'));
            if($this->user['password'] == $curr_password)
            {
                $insert['password'] = $new_password; 
                $insert['updated_at'] = date('Y-m-d H:i:s');
                $run = $this->common_model->UpdateData('users', array('id'=> $this->user_id) ,$insert );
                if($run)
                {  
                    $output['message']='Your Password has been updated successfully.' ;
                    $output['status']= 1 ;                               
                    $output['redirect']= base_url().'/profile' ;                               
                }
                else 
                {
                    $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                    $output['status']= 0 ;  
                } 
            }
            else 
            {
                $output['message']= ['curr_password' => 'Current password is incorrect'] ;
                $output['status']= 0 ;
            }            
            
            
         }
         echo json_encode($output);
    }

    public function do_delete_account()
    {

        $where['id'] = $this->request->getVar('id');
        $where['password'] = base64_encode($this->request->getVar('password'));
           
        $run = $this->common_model->DeleteData('users', $where );
        if($run)
        {  
            $output['message']='Your Account has been Deleted successfully.' ;
            $output['status']= 1 ;                               
            $output['redirect']= base_url('Home/logout') ;                                
        }
        else 
        {
            $output['message']='Invalid Password' ;
            $output['status']= 0 ;  
        }   
                                      
        
        echo json_encode($output);
    } 
    public function change_notifications()
    {

        $where['id'] = $this->request->getVar('user_id');
        $update[$_POST['col']] = $this->request->getVar('status');
        
        $run = $this->common_model->UpdateData('users', $where , $update);
        if($run)
        {  
            $output['message']='Your Notification setting has been Updated successfully.' ;
            $output['status']= 1 ;                               
                                        
        }
        else 
        {
            $output['message']='Something wrong' ;
            $output['status']= 0 ;  
        }   
                                      
        
        echo json_encode($output);
    }
    public function do_become_seller()
    {

         $this->validation->setRule('company_name','company Name','trim|required');
         $this->validation->setRule('address','address','trim|required');
         $this->validation->setRule('city','city','trim|required');
         $this->validation->setRule('state','state','trim|required');
         $this->validation->setRule('zipcode','zipcode','trim|required');
         $this->validation->setRule('country','country','trim|required');
         $this->validation->setRule('description','description','trim|required');
         //$this->validation->setRule('lang','Language','trim|required');
         
         

        $code = rand();
        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $where['id'] = $this->user_id;
            $insert['company_name'] = $this->request->getVar('company_name');            
            //$insert['language'] = $this->request->getVar('lang');   
                     
            $insert['address'] = $this->request->getVar('address');
            $insert['city'] = $this->request->getVar('city');
            $insert['state'] = $this->request->getVar('state');
            $insert['zipcode'] = $this->request->getVar('zipcode');
            $insert['country'] = $this->request->getVar('country');
            $insert['description'] = $this->request->getVar('description');
            
            $insert['is_verified'] = 2;
            $insert['created_at'] = date('Y-m-d H:i:s');
            $insert['token'] = md5(mt_rand(100000,999999)) ;
            if(!empty($_FILES['document_id']['name']))
            {
                $newName = explode('.',$_FILES['document_id']['name']);
                $ext = end($newName);
                $fileName = 'assets/upload/'.rand().time().'.'.$ext;
                move_uploaded_file($_FILES['document_id']['tmp_name'], $fileName);
                $insert['document_id']= $fileName ; 
            }
            else
            {
                $output['message']=['document_id' => 'Document field is required'] ;
                $output['status']= 0 ;  
                echo json_encode($output);
                exit;
            }
            $run = $this->common_model->UpdateData('users', $where , $insert);
           
            if($run)
            {
                $output = $this->direct_verify($this->user_id);
                echo json_encode($output);
                exit;
                $login_id = $this->session->get('user_id'); 

                $user = $this->common_model->GetSingleData('users',array('id'=>$login_id));
                $email = $user['email'];
                $subject="Thank you for Applying to become a seller";
                $body = '<p style="font-size: 16px;color: #000;padding: 5px;">Hello '.$user['name'].' , </p>
                <p style="font-size: 16px;color: #000;padding: 5px;">Your request to become a seller is under review, and it will take more than 24 hours for us to verify your documents. Please wait until we finish reviewing them</p>';

                $notifi['user_id'] = $login_id;
                $notifi['message'] = 'Your request to become a seller is under review, and it will take more than 24 hours for us to verify your documents. Please wait until we finish reviewing them';
                $notifi['is_read'] = 0;
                $notifi['created_at'] = date('Y-m-d H:i:s');
                $notifi['type'] = 'become-seller';
                $notifi['other'] = ['screen' => 'post-detail' , 'click_action' =>'#' , 'id' => 0];
                $notifi['noti_type'] = 'all';
                $this->common_model->send_and_insert_notifi('notification' ,$notifi);          
                $send = $this->common_model->SendMail($email,$subject,$body);       
             
                $output['message'] = 'Your Request to become a seller has been sent successfully' ;
                $output['status'] = 1 ;                  
                $output['redirect'] = base_url().'/become-seller' ;                  

            }
            else 
            {
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ;  
            
            }
         }
         echo json_encode($output);
    }
    private function direct_verify($user_id)
    {
        $id = $user_id;
        
        $update['is_verified'] = 1;     
        $update['user_type'] = 2;    
            
        $run = $this->common_model->UpdateData('users',array('id' =>$id), $update);
        $run1 = $this->common_model->GetSingleData('users',array('id' =>$id));
        $email = $run1['email'];
        if($run)
        {
            $subject="Seller verification";    
            $body = '<p>Hello '. $run1['name'].'</p>';
            $body .= '<p>Greetings '. $run1['name'].' Your application to become a seller has been verified successfully. You can now post ads on our website.</p>';
            
            $plan = $this->common_model->GetSingleData('plan_management' , array('id' => 1));
            $duration  = $plan['duration'];
            $startDate = date('Y-m-d H:i:s');
            $endDate = date('Y-m-d H:i:s', strtotime('+'.$duration.' month'));

            $plan_insert['user_id'] = $id;
            $plan_insert['plan_id'] = 1;
            $plan_insert['start_date'] = $startDate;
            $plan_insert['end_date'] = $endDate;
            $plan_insert['status'] = 1;
            $plan_insert['created_at'] = date('Y-m-d H:i:s');
            $plan_insert['updated_at'] = date('Y-m-d H:i:s');
            $this->common_model->InsertData('plan_subscriptions' ,$plan_insert);

            $notifi['user_id'] = $id;
            $notifi['message'] = 'Your application to become a seller has been verified successfully. You can now post ads on our website.';
            $notifi['is_read'] = 0;
            $notifi['created_at'] = date('Y-m-d H:i:s');
            $notifi['type'] = 'become-seller';

            $this->common_model->InsertData('notification' ,$notifi); 
            $send = $this->common_model->SendMail($email,$subject,$body);
            if($send)
            {
                
                 $output['message'] = 'Your application to become a seller has been verified successfully. You can now post ads on our website.' ;
                $output['status'] = 1 ;                  
                $output['redirect'] = base_url().'/become-seller' ;
            }   
                            

        }
       return $output;  
                
    }
   public function Upgrade_plan() {  
    
    if (isset($_REQUEST['plan']) && !empty($_REQUEST['plan']) && $_REQUEST['plan'] == 1) {
            $this->session->setFlashdata('msg', '<div class="alert alert-danger">Please upgrade your plan</div>');
     }
     if ($this->user['user_type'] == 1) {
        $this->session->setFlashdata('error', 'You dont have permission to access this page ! only seller can access');
         return redirect('dashboard');
     }
        //echo "hello";die;
       return view('site/upgrade_plan');
    }

   public function upgradePlan()
    {
       
       $insert['user_id'] = $this->user_id;            
       $plan_id = $insert['plan_id'] = $this->request->getVar('planId');
       $insert['amount'] = $this->request->getVar('amt');
       $insert['transaction_id'] = $this->request->getVar('trans_id');
       $insert['start_date'] = date('Y-m-d');

        $plan_data =  $this->common_model->GetSingleData('plan_management', array('id'=>$plan_id));
        $insert['post'] = $plan_data['post'];
        $insert['chat'] = $plan_data['chat'];
        $insert['notification'] = $plan_data['notification'];
        $insert['status'] = 1;

          $dt = date('Y-m-d');
          $month = $this->request->getVar('duration');
          
          $insert['end_date'] =  date('Y-m-d', strtotime('+'.$month.' month'));

          $insert['created_at'] = date('Y-m-d H:i:s');
        

         $this->common_model->UpdateData('plan_subscriptions' , ['user_id' => $this->user_id ] , ['status' => 0]);
        $run = $this->common_model->InsertData('plan_subscriptions' , $insert);

            if($run)
            {  
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Your plan has been upgrade successfully.</div>');
                $output['status'] = 1;  
                $output['message'] = 'Your plan has been upgrade successfully.';
                //$output['redirect']= base_url().'/profile' ;
            }
            else 
            {
            
                $output['status']= 0 ;  
                $output['message']='<div class="alert alert-danger">Something went wrong</div>';
            }
         
         echo json_encode($output);
   }
   public function my_post()
    {
        //  echo $id;die;
         $data['view'] = $this->common_model->GetAllData('post',array('user_id' =>$this->user_id,'is_delete' =>0),'is_featured','desc');
    //  echo $this->db->lastQuery; die();
    
      return view('site/my_post',$data);
    }

    public function wishlist($table)
    {
        //  echo $id;die;
         $data['view'] = $this->common_model->GetAllData('wishlist',array('user_id' =>$this->user_id , 'post_type' =>$table),'id','desc');
         $data['table'] = $table;
    //  echo $this->db->lastQuery; die();
    
      return view('site/wishlist',$data);
    }

    public function my_post_view($id)
    {
         //echo $id;die;
         $data['view'] = $this->common_model->GetSingleData('post',array('id' =>$id,'user_id' =>$this->user_id));
    //  echo $this->db->lastQuery; die();
       return view('admin/detail', $data);
    }

   public function my_review()
    {
      return view('site/my_review');
    }
  public function Notification()
    {
        $plan = $this->common_model->GetSingleData('plan_subscriptions', array('user_id' => $this->user_id));
        $nearby_radius = $this->common_model->GetSingleData('plan_management', array('id' => $plan['plan_id']))['nearby_radius'];
        $this->session->set('nearby_radius',$nearby_radius);
        return view('site/my_notification');
    }

  public function coupon_list()
    {
        //  echo $id;die;
      $data['view'] = $this->common_model->GetAllData('coupons',array('user_id' =>$this->user_id),'id','desc');
       return view('site/my_coupons',$data);
    }
    public function swap_list()
    {
        //  echo $id;die;
      $data['view'] = $this->common_model->GetAllData('swap',array('user_id' =>$this->user_id),'id','desc');
       return view('site/my_swaps',$data);
    }

    //search user by ID and email
    public function search_user_by_key()
    {
        $key = $this->request->getVar('search_key');
        $key = $this->request->getVar('user_id');
        $users = $this->common_model->GetUsersByKey($key);
        $output['users'] = $users;
        echo json_encode($output); 
    }
    
}
