<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
class Users extends BaseController {

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

  	public function index()
    {
        $data['data'] = $this->common_model->GetAllData('users',array('user_type'=>1),'id','desc');
        return view('admin/users', $data);
    }
    // public function sellersList()
    // {
    //     $data['data'] = $this->common_model->GetAllData('users',array('user_type != '=>1),'id','desc');
    //     return view('admin/sellers-list', $data);
    // }
    public function isVerified()
    { 
        $data['data'] = $this->common_model->GetAllData('users',array('is_verified'=>1,'user_type'=>2),'id','desc');
        $data['sellers_incoming'] = $this->common_model->GetAllData('users',array('is_verified'=>2,'user_type'=>1),'id','desc');
        return view('admin/sellers-verified', $data);
    }
    public function incomingSellers()
    { 
        $data['data'] = $this->common_model->GetAllData('users',array('is_verified'=>2,'user_type'=>1),'id','desc');
        return view('admin/sellers-incoming', $data);
    }

    public function userView($id)
    {
         //echo $id;die;
         $data['view'] = $this->common_model->GetSingleData('users',array('id' =>$id));
     // echo $this->db->lastQuery; die();
       return view('admin/userview', $data);
    }
  	
    
  	public function user_edit($id)
    {
        $data['edit'] = $this->common_model->GetSingleData('users',array('id'=>$id));
        return view('admin/useredit', $data);
    }

  	
    public function update_user()
    {
         $this->validation->setRule('title','Title','trim|required');
    	 $this->validation->setRule('fname','First Name','trim|required');
         $this->validation->setRule('lname','Last Name','trim|required');
         $this->validation->setRule('email','Email','trim|required');
         $this->validation->setRule('username','User Name','trim|required');
         
         $this->validation->setRule('prononous','Prononous','trim|required');
         $this->validation->setRule('state','State','trim|required');
         $this->validation->setRule('city','City','trim|required');
         $this->validation->setRule('street_address','Address','trim|required');
         $this->validation->setRule('about_me','Aboout Me','trim|required');
         $this->validation->setRule('my_skill','My Skils','trim|required');
         
         if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['validation']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
        else
        {
        	$id = $_POST['id'];
            $update['title'] = $_POST['title'];
			$update['first_name'] = $_POST['fname'];
			$update['last_name'] = $_POST['lname'];
            $update['email'] = $_POST['email'];
            $update['username'] = $_POST['username'];
            
            $update['prononus'] = $_POST['prononous'];
            $update['state'] = $_POST['state'];
            $update['city'] = $_POST['city'];
            $update['street_address'] = $_POST['street_address'];
            $update['about_me'] = $_POST['about_me'];
            $update['my_skills'] = $_POST['my_skill'];
            if(!empty($_FILES['image']['name']))
               {
                    $newName = explode('.',$_FILES['image']['name']);
                    $ext = end($newName);
                    $fileName = 'assets/upload/'.rand().time().'.'.$ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
                    $update['image']= base_url().'/'.$fileName ; 
               }
			
			$run = $this->common_model->UpdateData('users',array('id' =>$id), $update);
			if($run)
			{
				
					$this->session->setFlashdata('msg', '<div class="alert alert-success">User has been Updated successfully.</div>');
					$output['status']=1;
					$output['message']="User has been Updated successfully.";
			}else
            {
                      $this->session->setFlashdata('msg', '<div class="alert alert-success">Something Went Wrong.</div>');
                    $output['status']=1;
                    $output['message']="Something Went Wrong.";
            }
	    }
		echo json_encode($output);
    }



    //verification reject
    public function verifyReject()
    {
    	$id = $_POST['id'];
        $reason = $_POST['reason'];
    	
        $update['is_verified'] = 3;        
        $update['reject_reason'] = $reason;        
        $update['user_type'] = 1;        
	        
	    $run = $this->common_model->UpdateData('users',array('id' =>$id), $update);
	    $run1 = $this->common_model->GetSingleData('users',array('id' =>$id));
	    $email = $run1['email'];
	    if($run)
        {
            $subject="Seller verification";    
        	$body = '<p>Hello '. $run1['name'].'</p>';
        	$body .= '<p>Unfortunately, we were unable to verify your document due to a '. $reason.' . At this time, you are still able to log into your panel as a customer. You can also resubmit your seller document at any time in order to become a seller.</p>';

            $notifi['user_id'] = $id;
            $notifi['message'] = 'Unfortunately, we were unable to verify your document due to a '. $reason.' . At this time, you are still able to log into your panel as a customer. You can also resubmit your seller document at any time in order to become a seller.';
            $notifi['is_read'] = 0;
            $notifi['created_at'] = date('Y-m-d H:i:s');
            $notifi['type'] = 'become-seller';
            $this->common_model->InsertData('notification' ,$notifi); 
            $send = $this->common_model->SendMail($email,$subject,$body);
            if($send)
            {
            	$output['status']=1;
            }   
                            

        }
		echo json_encode($output);	
				
    }

    //verification accept
    public function verifyAccept()
    {
    	$id = $_POST['id'];
    	
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
            	$output['status']=1;
            }   
                            

        }
		echo json_encode($output);	
				
    }

   

    public function enableUser()
    {
      		$id = $_POST['id'];
          $checkuser = $this->common_model->GetSingleData('users',array('id'=>$id));
          if(!empty($checkuser)){
            if($checkuser['status']==1){
                $update['status']=0;
                $this->session->setFlashdata('msgs','<div class="alert alert-success">User has been Blocked!!</div>');
            }else{
                $update['status']=1;
                $this->session->setFlashdata('msgs','<div class="alert "User has been Unblocked!!</div>');
            }   
            $run = $this->common_model->UpdateData('users',['id'=>$id], $update);
            if($run){
                $output['status']=1;
            }
          } else {
            $output['msgs']='<div class="alert alert-danger">Somthing wrong</div>';
            $output['status']=0;
        }

        echo json_encode($output);
    }

    //CUSTOMERS
    public function enableCustomer()
    {
      		$id = $_POST['id'];
          $checkuser = $this->common_model->GetSingleData('users',array('id'=>$id));
          if(!empty($checkuser)){
            if($checkuser['status']==1){
                $update['status']=0;
                $this->session->setFlashdata('msgs','<div class="alert alert-success">Customer has been Blocked!!</div>');
            }else{
                $update['status']=1;
                $this->session->setFlashdata('msgs','<div class="alert "Customer has been Unblocked!!</div>');
            }   
            $run = $this->common_model->UpdateData('users',['id'=>$id], $update);
            if($run){
                $output['status']=1;
            }
          } else {
            $output['msgs']='<div class="alert alert-danger">Somthing wrong</div>';
            $output['status']=0;
        }

        echo json_encode($output);
    }


    public function deleteUser() {        
        
        $id = $_POST['id'];

        
        $this->common_model->DeleteData('groups', array('create_by'=> $id));
        $this->common_model->DeleteData('chat', 'sender = '.$id.' OR receiver ='.$id);
        $this->common_model->DeleteData('notification', array('user_id'=> $id));
        $this->common_model->DeleteData('post', array('user_id'=> $id));
        $this->common_model->DeleteData('post_comments', array('user_id'=> $id));
        $this->common_model->DeleteData('near_by_post_sent', array('user_id'=> $id));
        $this->common_model->DeleteData('plan_subscriptions', array('user_id'=> $id));
        $this->common_model->DeleteData('device_ids', array('user_id'=> $id));
        $this->common_model->DeleteData('is_featured_subscription', array('user_id'=> $id));
        $this->common_model->DeleteData('swap', array('user_id'=> $id));
        $this->common_model->DeleteData('wishlist', array('user_id'=> $id));
        $this->common_model->DeleteData('coupons', array('user_id'=> $id));
        $run = $this->common_model->DeleteData('users', array('id'=> $id));
        if ($run) {
            $json['message'] = 'Success! User has been Deleted successfully';
            $json['status'] = 1;
        } else {
            $json['message'] = 'Error! Something went wrong';
            $json['status'] = 0;
        }
        echo json_encode($json);
    }
    
   
}