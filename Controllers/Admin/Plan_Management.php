<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
class Plan_Management extends BaseController {

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

  	public function plan_list()
    {
        $data['data'] = $this->common_model->GetAllData('plan_management','','id','desc');
        return view('admin/plan-list', $data);
    }

    public function add_plan()
    {
        //echo "hello";
        $this->validation->setRule('title','Title','trim|required|is_unique[plan_management.title]',array('is_unique' =>'This Plan already exit'));
        $this->validation->setRule('description','Description','trim|required');
        $this->validation->setRule('price','Price','trim|required');
        $this->validation->setRule('post','Post','trim|required');
        $this->validation->setRule('duration','Duration','trim|required');
        

        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $insert['title']= $this->request->getVar('title');
            $insert['description']= $this->request->getVar('description');
            $insert['price']= $this->request->getVar('price');
            $insert['post']= $this->request->getVar('post');
            $insert['nearby_radius']= $this->request->getVar('nearby_radius');
            // if($this->request->getVar('chat')){
            //    $insert['chat']= $this->request->getVar('chat');
            // }else{
            //     $insert['chat']= 0;
            // }
            
            // if($this->request->getVar('notification')){
            //    $insert['notification']= $this->request->getVar('notification');
            // }else{
            //     $insert['notification']= 0;
            // }


            if($this->request->getVar('groups')){
               $insert['groups']= $this->request->getVar('groups');
            }else{
                $insert['groups']= 0;
            }
            if($this->request->getVar('auction')){
               $insert['auction']= $this->request->getVar('auction');
            }else{
                $insert['auction']= 0;
            }
            if($this->request->getVar('swap')){
               $insert['swap']= $this->request->getVar('swap');
            }else{
                $insert['swap']= 0;
            }
            if($this->request->getVar('coupon')){
               $insert['coupon']= $this->request->getVar('coupon');
            }else{
                $insert['coupon']= 0;
            }

            $insert['duration']= $this->request->getVar('duration');
            $insert['created_at']= date('Y-m-d H:i:s');
            
            $run = $this->common_model->InsertData('plan_management', $insert);

            if($run)
            {  
             
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Plan has been added successfully</div>');
                $output['message']='Plan has been added successfully' ;
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

    public function editPlan()
    {
        //echo "hello";
        $this->validation->setRule('title','Title','trim|required');
        $this->validation->setRule('description','Description','trim|required');
        $this->validation->setRule('price','Price','trim|required');
        $this->validation->setRule('post','Post','trim|required');
        $this->validation->setRule('duration','Duration','trim|required');
       

        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $id = $this->request->getVar('id');
            $check = $this->common_model->GetSingleData('plan_management', array('title'=> $_POST['title'], 'id!='=>$id));
            if($check)
            {
                 $output['message']='<div class="alert alert-danger">Plan already exist</div>' ;
                $output['status']= 0 ; 
            }
         else
        {
            $id = $this->request->getVar('id');
            $insert['title']= $this->request->getVar('title');
            $insert['description']= $this->request->getVar('description');
            $insert['price']= $this->request->getVar('price');
            $insert['post']= $this->request->getVar('post');
            $insert['nearby_radius']= $this->request->getVar('nearby_radius');

            // if($this->request->getVar('chat')){
            //    $insert['chat']= $this->request->getVar('chat');
            // }else{
            //     $insert['chat']= 0;
            // }
            
            // if($this->request->getVar('notification')){
            //    $insert['notification']= $this->request->getVar('notification');
            // }else{
            //     $insert['notification']= 0;
            // }


            if($this->request->getVar('groups')){
               $insert['groups']= $this->request->getVar('groups');
            }else{
                $insert['groups']= 0;
            }
            if($this->request->getVar('auction')){
               $insert['auction']= $this->request->getVar('auction');
            }else{
                $insert['auction']= 0;
            }
            if($this->request->getVar('swap')){
               $insert['swap']= $this->request->getVar('swap');
            }else{
                $insert['swap']= 0;
            }
            if($this->request->getVar('coupon')){
               $insert['coupon']= $this->request->getVar('coupon');
            }else{
                $insert['coupon']= 0;
            }


            $insert['duration']= $this->request->getVar('duration');
            $insert['updated_at']= date('Y-m-d H:i:s');            
            
            
           
            $run = $this->common_model->UpdateData('plan_management',array('id'=>$id), $insert);

            if($run)
            {  
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Plan has been Updated successfully</div>');
             
                $output['message']='Plan has been Updated successfully' ;
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

    
  public function deletePlan()
    {
        //echo "hello";
            $id = $this->request->getVar('id'); 
            $run = $this->common_model->DeleteData('plan_management', array('id'=> $id));
            if($run)
            {  
                $output['message']='Plan has been Deleted successfully' ;
                $output['status']= 1 ;  
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Plan has been Deleted successfully</div>');
                                            

            }
            else             {
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ; 
            
            }
         
         echo json_encode($output);
      
    }

   public function plan_subsbription_list()
    {
        $data['data'] = $this->common_model->GetAllData('plan_subscriptions','','id','desc');
        return view('admin/plan-subscription-list', $data);
    }

   
}