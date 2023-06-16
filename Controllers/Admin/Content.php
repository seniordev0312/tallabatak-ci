<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
class Content extends BaseController {

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
        $data['data'] = $this->common_model->GetAllData('content_management','','id','desc');
        return view('admin/content-list', $data);
    }

    public function editContent()
    {
    	
         $this->validation->setRule('content','Content','trim|required');
        
     if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['validation']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
        else
        {
        	$id = $_POST['id'];
			$update['content'] = $_POST['content'];
			
			$run = $this->common_model->UpdateData('content_management',array('id' =>$id), $update);
			if($run)
			{
				
					$this->session->setFlashdata('msg', '<div class="alert alert-success">Content has been Updated successfully.</div>');
					$output['status']=1;
					$output['message']="Content has been Updated successfully.";
			}else{
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Something Went Wrong.</div>');
                    $output['status']=1;
                    $output['message']="Something Went Wrong.";
            }
	    }
		echo json_encode($output);
    }

    public function social_list()
    {
        $data['data'] = $this->common_model->GetAllData('social_management','','id','desc');
        return view('admin/social-list', $data);
    }
    public function add_social()
    {
        //echo "hello";
        $this->validation->setRule('link','Social Link','trim|required');
       

        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $insert['link']= $this->request->getVar('link');
            
           if(!empty($_FILES['image']['name']))
               {
                    $newName = explode('.',$_FILES['image']['name']);
                    $ext = end($newName);
                    $fileName = 'assets/social_img/'.rand().time().'.'.$ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
                    $insert['image']= $fileName ; 
               }
             $insert['created_at'] = date('Y-m-d H:i:s');
             $run = $this->common_model->InsertData('social_management', $insert);

            if($run)
            {  
             
              $this->session->setFlashdata('msg', '<div class="alert alert-success">Social Link has been added successfully</div>');
                $output['message']='Social Link has been added successfully' ;
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
    public function editSocial()
    {
        //echo "hello";
        $this->validation->setRule('link','Social Link','trim|required');
       

        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $id = $this->request->getVar('id');
            $check = $this->common_model->GetSingleData('social_management', array('link'=> $_POST['link'], 'id!='=>$id));
            if($check)
            {
                 $output['message']='<div class="alert alert-danger">Social link already exist</div>' ;
                $output['status']= 0; 
            }
         else
        {
            $id = $this->request->getVar('id');
            $update['link'] = $this->request->getVar('link'); 
            
            
             if(!empty($_FILES['image']['name']))
               {
                    $newName = explode('.',$_FILES['image']['name']);
                    $ext = end($newName);
                    $fileName = 'assets/social_img/'.rand().time().'.'.$ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
                    $update['image']= $fileName ; 
               }
            $update['updated_at'] = date('Y-m-d H:i:s'); 
            $run = $this->common_model->UpdateData('social_management',array('id'=>$id), $update);

            if($run)
            {  
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Social link has been Updated successfully</div>');
             
                $output['message']='Social link has been Updated successfully' ;
                $output['status']= 1 ;                               

            }
            else 
            {
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ;  
            
            }
        }
}
         echo json_encode($output);
      
    }

    public function deleteSocial()
    {
        //echo "hello";
            $id = $this->request->getVar('id'); 
            $run = $this->common_model->DeleteData('social_management', array('id'=> $id));
            if($run)
            {  
                $output['message']='Social link has been Deleted successfully' ;
                $output['status']= 1 ;  
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Social link has been Deleted successfully</div>');
                                            

            }
            else             {
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ; 
            
            }
         
         echo json_encode($output);
      
    }


    
}