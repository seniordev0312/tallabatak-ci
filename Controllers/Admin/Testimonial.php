<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
class Testimonial extends BaseController {

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

  	public function testimonial_list()
    {
        $data['data'] = $this->common_model->GetAllData('testimonial','','id','desc');
        return view('admin/testimonial-list', $data);
    }

    public function add_testimonial()
    {
        //echo "hello";
        $this->validation->setRule('title','Title','trim|required');
        $this->validation->setRule('description','Description','trim|required');
        $this->validation->setRule('name','Name','trim|required');
        $this->validation->setRule('position','Position','trim|required');
        $this->validation->setRule('rate','Rate','trim|required');
       

        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $insert['title']= $this->request->getVar('title');
            $insert['description']= $this->request->getVar('description');
            $insert['name']= $this->request->getVar('name');
            $insert['position']= $this->request->getVar('position');
            $insert['rate']= $this->request->getVar('rate');
            
           if(!empty($_FILES['image']['name']))
               {
                    $newName = explode('.',$_FILES['image']['name']);
                    $ext = end($newName);
                    $fileName = 'assets/testimonial_img/'.rand().time().'.'.$ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
                    $insert['image']= $fileName ; 
               }
             $insert['created_at'] = date('Y-m-d H:i:s');
             $run = $this->common_model->InsertData('testimonial', $insert);

            if($run)
            {  
             
              $this->session->setFlashdata('msg', '<div class="alert alert-success">Testimonial has been added successfully</div>');
                $output['message']='Testimonial has been added successfully' ;
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

    public function edittestimonial()
    {
        //echo "hello";
        $this->validation->setRule('title','Title','trim|required');
        $this->validation->setRule('description','Description','trim|required');
        $this->validation->setRule('name','Name','trim|required');
        $this->validation->setRule('position','Position','trim|required');
        $this->validation->setRule('rate','Rate','trim|required');
       

        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $id= $this->request->getVar('id');
            $insert['title']= $this->request->getVar('title');
            $insert['description']= $this->request->getVar('description');
            $insert['name']= $this->request->getVar('name');
            $insert['position']= $this->request->getVar('position');
            $insert['rate']= $this->request->getVar('rate');
            
           if(!empty($_FILES['image']['name']))
               {
                    $newName = explode('.',$_FILES['image']['name']);
                    $ext = end($newName);
                    $fileName = 'assets/testimonial_img/'.rand().time().'.'.$ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
                    $insert['image']= $fileName ; 
               }
             $insert['created_at'] = date('Y-m-d H:i:s');
             $run = $this->common_model->UpdateData('testimonial',array('id'=>$id) ,$insert);

            if($run)
            {  
             
              $this->session->setFlashdata('msg', '<div class="alert alert-success">Testimonial has been updated successfully</div>');
                $output['message']='Testimonial has been updated successfully' ;
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

    
  public function deleteTestimonial()
    {
        //echo "hello";
            $id = $this->request->getVar('id'); 
            $run = $this->common_model->DeleteData('testimonial', array('id'=> $id));
            if($run)
            {  
                $output['message']='Testimonial has been Deleted successfully' ;
                $output['status']= 1 ;  
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Testimonial has been Deleted successfully</div>');
                                            

            }
            else             {
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ; 
            
            }
         
         echo json_encode($output);
      
    }

   
}