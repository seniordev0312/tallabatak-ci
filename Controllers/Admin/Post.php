<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
class Post extends BaseController {

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


    // public function aucation_list()
    // {
    //     $data['post_list'] = $this->common_model->GetAllData('post',array('is_delete'=> 0, 'post_type'=>1, 'status'=>1),'id','desc');
    //     return view('admin/post-list', $data);
    // }
    // public function pending_aucation_list()
    // {
    //     $data['post_list'] = $this->common_model->GetAllData('post',array('is_delete'=> 0, 'post_type'=>1, 'status'=>0),'id','desc');
    //     return view('admin/pending-post', $data);
    // }


	public function post_list()
    {
      
        if($this->request->uri->getSegment(2)=='auction'){
            $post_type = 1;
            $data['post_type']=$post_type;
            $data['page_title'] = 'Auction';
            $data['post_list'] = $this->common_model->GetAllData('post',array('is_delete'=> 0, 'post_type'=>$post_type),'id','desc');
        }else{
            $post_type = 0;
            $data['post_type']=$post_type;
            $data['page_title'] = 'Post';
            $data['post_list'] = $this->common_model->GetAllData('post',array('is_delete'=> 0, 'post_type'=>$post_type,  'status'=>1),'id','desc');
        }

    //  echo $this->db->lastQuery; die();

        return view('admin/post-list', $data);
    }
    public function pending_post_list()
    {

        $data['post_list'] = $this->common_model->GetAllData('post',array('is_delete'=> 0, 'status'=>0),'id','desc');
    //  echo $this->db->lastQuery; die();

        return view('admin/pending-post', $data);
    }

    public function approved_post()
    {
        // echo "hello";
            $id = $this->request->getVar('id'); 
            $status = $update['status'] = $this->request->getVar('status'); 
            $user_id = $this->request->getVar('user_id'); 
            $run = $this->common_model->UpdateData('post', array('id'=> $id),$update);
            $postdata = $this->common_model->GetSingleData('post', array('id'=> $id));
            $userData = $this->common_model->GetSingleData('users', array('id'=> $user_id));
            if($run)
            {  
               
               $subject="Post approved";    
               $body = '<p>Hello '. $userData['name'].'</p>';
               $body .= '<p>Congratulation, Your Post <b>'.$postdata['title'].'</b> has been approved successfully.</p>';
               $send = $this->common_model->SendMail($userData['email'],$subject,$body);


                $notifi['user_id'] = $user_id;
                $notifi['message'] = 'Your Post has been successfully approved.';
                $notifi['is_read'] = 0;
                $notifi['created_at'] = date('Y-m-d H:i:s');
                $notifi['type'] = 'become-seller';
                $this->common_model->InsertData('notification' ,$notifi);

                $output['message']='Post has been approved successfully' ;
                $output['status']= 1 ;  
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Post has been approved successfully</div>');
                                            

            }
            else             {
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ; 
            
            }
         
         echo json_encode($output);
      
    }

	public function deletePost()
    {
        // echo "hello";
            $id = $this->request->getVar('id'); 
            $run = $this->common_model->UpdateData('post', array('id'=> $id), array('is_delete'=> 1));
            if($run)
            {  
                $output['message']='Post has been Deleted successfully' ;
                $output['status']= 1 ;  
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Post has been Deleted successfully</div>');
                                            

            }
            else             {
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ; 
            
            }
         
         echo json_encode($output);
      
    }
	public function postView($id)
    {
         //echo $id;die;
         $data['view'] = $this->common_model->GetSingleData('post',array('id' =>$id));
     // echo $this->db->lastQuery; die();
       return view('admin/post-view', $data);
    }
	
    public function post_comments($id)
    {
        $data['post_comments'] = $this->common_model->GetAllData('post_comments',array('post_id' =>$id),'id','desc');
    //  echo $this->db->lastQuery; die();

        return view('admin/post-comments', $data);
    }
	
    public function post_subscription()
    {
        $data['post_subscription'] = $this->common_model->GetAllData('is_featured_subscription','','id','desc');
    //  echo $this->db->lastQuery; die();

        return view('admin/post_subscription', $data);
    }

   
}