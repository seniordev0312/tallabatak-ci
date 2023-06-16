<?php

namespace App\Controllers;
use App\Models\Common_model;
use App\Models\CouponModel;
class Coupon extends BaseController
{
    public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->common_model = new Common_model();
        $this->CouponModel = new CouponModel();
        $this->user_id =  $this->session->get('user_id');
        $this->user = $this->common_model->GetSingleData('users', array('id' => $this->user_id));
        
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

    public function addcouponForm() {
        //  echo $id;die;
      //$data['view'] = $this->common_model->GetAllData('coupons',array('user_id' =>$this->user_id),'id','desc');
       $this->check_login();
        $plan_data = check_subscription($this->user_id);
        if ($plan_data["active"] && $plan_data['plan']['coupon'] == 1) {
            return view('site/add-coupon');
        } else {
            header('Location: '.base_url('upgrade-plan?plan=1'));
                exit();
        }
    }
    public function editcouponForm($edit_id) {
        //  echo $id;die;
      //$data['view'] = $this->common_model->GetAllData('coupons',array('user_id' =>$this->user_id),'id','desc');
        $this->check_login();
        $plan_data = check_subscription($this->user_id);
        if ($plan_data["active"] && $$plan_data['plan']['coupon'] == 1) {
            $data['edit'] = $this->common_model->GetSingleData('coupons' , array('user_id' =>$this->user_id , 'id' =>$edit_id));
            if (!$data['edit']) 
            {
                $this->session->setFlashdata('error', 'You are not allowed to edit that coupon');
                return redirect('coupons');
            }
            return view('site/edit-coupon' , $data);

        } else {
            header('Location: '.base_url('upgrade-plan?plan=1'));
                exit();
        }
    }

 public function add_coupon($edit_id = 0) {
        $this->check_login();
         $this->validation->setRule('title','Title','trim|required');
         $this->validation->setRule('description','Description','trim|required');
         $this->validation->setRule('price','Price','trim|required');
         $this->validation->setRule('no_unit','Number Of Units','trim|required');
         $this->validation->setRule('end_date','End Date','trim|required');
         $this->validation->setRule('coupon_off','Offer','trim|required|min_length[1]|max_length[2]');
         
        $code = rand();
        if($this->validation->withRequest($this->request)->run()==false) {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0;       
        } else {
            
            $insert['coupon_code'] = $this->request->getVar('coupon_code');
            $insert['user_id'] = $this->user_id;
            $insert['title'] = $this->request->getVar('title');            
            $insert['description'] = $this->request->getVar('description');            
            $insert['price'] = $this->request->getVar('price');            
            $insert['no_unit'] = $this->request->getVar('no_unit');            
            $insert['end_date'] = $this->request->getVar('end_date');
            $insert['coupon_off'] = $this->request->getVar('coupon_off');
              if(!empty($_FILES['image']['name']))
               {
                    $newName = explode('.',$_FILES['image']['name']);
                    $ext = end($newName);
                    $fileName = 'assets/coupon_image/'.rand().time().'.'.$ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
                    $insert['image']= $fileName ; 
               }
            if ($edit_id) 
            {
                $text = 'Updated';
                $where['id'] = $edit_id;
                $this->common_model->UpdateData('coupons', $where ,$insert);
                $run = $edit_id;
            }
            else
            {
                $text = 'Added';
                $insert['created_at'] = date('Y-m-d H:i:s');
                $run = $this->common_model->InsertData('coupons', $insert);
            }
            
           
            if($run) 
            {

                if(isset($_POST['invite']))
                {
                    if ($_POST['invite'] == 'invite_group') 
                    {
                        $invite_group = $_POST['group_user'];
                        if ($invite_group) {
                            $this->sendInvitationToGroups($invite_group , $insert , $run);
                        }
                        
                    }
                    else
                    {
                        $invite_users = $_POST['near_user'];
                        if ($invite_users) {
                            $this->sendInvitationToNearBy($invite_users , $insert , $run);
                        }
                        
                    }

                }
                 //$this->session->setFlashdata('success', 'Your coupon '.$text.' successfully');
                $output['message'] = 'Your coupon '.$text.' successfully' ;
                $output['status'] = 1 ;  
            }

            else 
            {
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ;  
            
            }
                               
            
         }
         echo json_encode($output);
    }

    public function delete_coupon()
    {
        $this->common_model->DeleteData('coupons' , ['id' => $_POST['id']]);
        $output['message'] = 'Your coupon has been deleted successfully' ;
        $output['status'] = 1 ;  
        echo json_encode($output);
    }
    public function sendInvitationToGroups($invite_groups , $insert , $run)
    {
        $message = $this->user['name'].' sent a coupon offers please grabe it. '.$insert['coupon_off'].'% off in '.$insert['title'].' at just '.$insert['price'].'$, Offers till : '.$insert['end_date'];
        $url = base_url('coupon-detail/'.$run);
        $message .= '<br><a href="'.$url.'" style="margin-top: 30px;font-size: 18px;font-weight: 450;font-family: ProximaNova, Helvetica, Arial, sans-serif;color: rgb(255, 255, 255);background: #000;text-decoration: none;border-radius: 2px;border: 0px;display: inline-block;line-height: 35px;padding: 5px 15px;text-size-adjust: 100%;">click here</a>';
        foreach ($invite_groups as $key => $value) 
        {
            $data = ['sender' => $this->user_id , 'receiver' => 0 , 'is_group' => 1 , 'thread_id' => $value , 'msg_type' => 'text' , 'message' => $message];
            $send = $this->send_message($data , false);
           // print_r($send);
        }
        

    }
    public function send_message($data , $file) {
   
    
    if ($data['sender'] == NULL || $data['is_group'] == NULL || $data['msg_type'] == NULL) 
    {
        $output['status']=0;
        $output['msg']='Check User Param.';
    } else {
        
        $i = 0;
        
        $insert['thread_id'] = $data['thread_id'];
        $insert['sender'] = $data['sender'];
        $insert['receiver'] = isset($data['receiver']) ? $data['receiver'] : 0;
        $insert['message'] = isset($data['message']) ? $data['message'] : '';
        $insert['msg_type'] = $data['msg_type'];
        if(isset($file['chat_file']['name']) && !empty($file['chat_file']['name']))
        {
            $tmp_name = $file['chat_file']['name'];
            $tmp_name = explode(".",$tmp_name);
            $exts = end($tmp_name);
            $f_name = rand().time().".".$exts;
            $newfile = 'assets/images/chat/'.$f_name;
            move_uploaded_file($file['chat_file']['tmp_name'], $newfile);
            $insert['message'] = $newfile;
            $insert['msg_type'] = 'file';
                    
        }
        if(isset($file['audio_data']['name']) && !empty($file['audio_data']['name']))
        {
            $tmp_name = $file['audio_data']['name'];
            $tmp_name = explode(".",$tmp_name);
            $exts = end($tmp_name);
            $f_name = rand().time().".wav";
            $newfile = 'assets/images/chat/'.$f_name;
            move_uploaded_file($file['audio_data']['tmp_name'], $newfile);
            $insert['message'] = $newfile;
            $insert['msg_type'] = 'audio';
                    
        }
       
        $insert['is_group'] = ($data['is_group']) ? 1 : 0;
        $insert['is_read'] = 0;
        $insert['read_by'] = $data['sender'];
        $insert['create_date'] = date('Y-m-d H:i:s');
        
        $run = $this->common_model->InsertData('chat',$insert);
        
        if($data['receiver'])
        {
        
            $user = $this->common_model->GetSingleData('users' , array('id' => $data['sender']));
            $show_name = $user['name'];
            $current = date('Y-m-d H:i:s');//11:50:50
            $tolerance = date('Y-m-d H:i:s',strtotime($current.' - 10 seconds'));//11:50:40
            
            $sql = "select last_chat_time from users where id = ".$data['receiver']." and last_chat_with = '".$insert['thread_id']."'";
            
            $run = $this->db->query($sql);
            
            $check_send = false;
            
            $numrow = count($run->getResultArray());
            
            if($numrow==0){
                $check_send = true;
            } else {
                $numrow = $run->getRowArray();
                if(strtotime($numrow['last_chat_time']) <= strtotime($tolerance)){
                    $check_send = true;
                }
            }
            $message = $show_name.' has sent you a message.';
            
            $notifi['user_id'] = $data['receiver'];
            $notifi['message'] = $message;
            $notifi['is_read'] = 0;
            $notifi['created_at'] = date('Y-m-d H:i:s');
            $notifi['type'] = 'chat';
            $notifi['other'] = ['screen' => 'chat' , 'click_action' => '#' , 'id' => $this->user_id];
            $notifi['noti_type'] = 'buyer_chat';
            if($check_send){

                $this->common_model->send_and_insert_notifi('notification' ,$notifi);  

            }
            else
            {
                $notifi['onlyPushNot'] = true;
                $this->common_model->send_and_insert_notifi('notification' ,$notifi);  

            }


        }
            
            $output['status'] = 1;
            $output['msg'] = 'message sent';
        
        } 
    
    return $output;
} 
    public function sendInvitationToNearBy($invite_users , $insert , $run)
    {

        foreach ($invite_users as $key => $userV) 
        {
            if (!$userV) {
                continue;
            }
            $userData = $this->common_model->GetSingleData('users',array('id'=>$userV));
            $notifi1['user_id'] = $userV;
            $notifi1['message'] = $this->user['name'].' sent a coupon offers please grabe it.
                                  '.$insert['coupon_off'].'% off in '.$insert['title'].' at just '.$insert['price'].'$, Offers till : '.$insert['end_date'];
            $notifi1['is_read'] = 0;
            $notifi1['created_at'] = date('Y-m-d H:i:s');
            $notifi1['type'] = 'become-seller';
            $notifi1['other'] = ['screen' => 'coupon-detail' , 'click_action' => base_url().'/coupon-detail/'.$run , 'id' => $run];
            $notifi1['noti_type'] = 'all';
            $this->common_model->send_and_insert_notifi('notification' ,$notifi1);

            $url = base_url('coupon-detail/'.$run);

            $subject="Coupon Invitation";
            $body = '<p style="text-align: left;color: black; padding:5px 0;">Hello! '.$userData['name'].',</p>';              
            $body .= '<p style="text-align: left;color: black; padding:5px 0;">'.$notifi1['message'].'</p>';
            $body .= '<p style="text-align: left;color: black; padding:5px 0;">For more details please click below link</p>';

            $body .= '<a href="'.$url.'" style="margin-top: 30px;font-size: 18px;font-weight: 450;font-family: ProximaNova, Helvetica, Arial, sans-serif;color: rgb(255, 255, 255);background: #000;text-decoration: none;border-radius: 2px;border: 0px;display: inline-block;line-height: 35px;padding: 5px 15px;text-size-adjust: 100%;">click here</a>';
            $this->common_model->SendMail($userData["email"],$subject,$body);
        }
    }
    public function all_coupon_list()
    {
        //  echo $id;die;
      $data['all_coupon'] = $this->common_model->GetAllData('coupons','','id','desc');
       return view('site/all_coupon_list',$data);
    }

     function fetch_data()
     {
       // print_r($_POST);
        sleep(1);

      $pager = \Config\Services::pager();
      $config = array();
      
      $config['total_rows'] = $this->CouponModel->count_all($_POST);
      $config['per_page'] = 9;
      
      // $this->pagination->initialize($config);
      $page = $this->request->uri->getSegment(3);
      $total = $config['total_rows'];
      $start = ($page - 1) * $config['per_page'];
      $output = array(
       'pagination_link'  => $pager->makeLinks($page, $config['per_page'], $total, 'ajax_full'),
       'coupon_list'   => $this->CouponModel->fetch_data($config["per_page"], $start, $_POST),
       'total' => 'There are '.$config['total_rows'].' Coupons.'
      );
      echo json_encode($output);
     }
    public function coupon_detail($id)
    {
        //echo $id;die;
        $this->check_login();
      $data['coupon_detail'] = $this->common_model->GetSingleData('coupons',array('id'=>$id));
       return view('site/coupon_detail',$data);
    }
   
   
}
