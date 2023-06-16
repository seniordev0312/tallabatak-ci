<?php

namespace App\Controllers;
use App\Models\Common_model;
use App\Models\SwapModel;
class Swap extends BaseController
{
    public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->common_model = new Common_model();
        $this->SwapModel = new SwapModel();
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

    public function addswapForm() {
        //  echo $id;die;
      //$data['view'] = $this->common_model->GetAllData('swap',array('user_id' =>$this->user_id),'id','desc');
       $this->check_login();
        $plan_data = check_subscription($this->user_id);
        if ($plan_data["active"] && $plan_data['plan']['swap'] == 1) {
            return view('site/add-swap');
        } else {
            header('Location: '.base_url('upgrade-plan?plan=1'));
                exit();
        }
    }
    public function editswapForm($edit_id) {
        //  echo $id;die;
      //$data['view'] = $this->common_model->GetAllData('swap',array('user_id' =>$this->user_id),'id','desc');
        $plan_data = check_subscription($this->user_id);
        if ($plan_data["active"] && $plan_data['plan']['swap'] == 1) {
            $data['edit'] = $this->common_model->GetSingleData('swap' , array('user_id' =>$this->user_id , 'id' =>$edit_id));
            if (!$data['edit']) 
            {
                $this->session->setFlashdata('error', 'You are not allowed to edit that swap');
                return redirect('swap');
            }
            return view('site/edit-swap' , $data);

        } else {
            header('Location: '.base_url('upgrade-plan?plan=1'));
                exit();
        }
    }

 public function add_swap($edit_id = 0) {
        $this->check_login();
         $this->validation->setRule('title','Title','trim|required');
         $this->validation->setRule('description','Description','trim|required');
         
         
        $code = rand();
        if($this->validation->withRequest($this->request)->run()==false) {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0;       
        } else {
            
           
            $insert['user_id'] = $this->user_id;
            $insert['title'] = $this->request->getVar('title');            
            $insert['description'] = $this->request->getVar('description');            
            
              if(!empty($_FILES['image']['name']))
               {
                    $newName = explode('.',$_FILES['image']['name']);
                    $ext = end($newName);
                    $fileName = 'assets/upload/'.rand().time().'.'.$ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
                    $insert['image']= $fileName ; 
               }
            if ($edit_id) 
            {
                $text = 'Updated';
                $where['id'] = $edit_id;
                $this->common_model->UpdateData('swap', $where ,$insert);
                $run = $edit_id;
            }
            else
            {
                $text = 'Added';
                $insert['created_at'] = date('Y-m-d H:i:s');
                $run = $this->common_model->InsertData('swap', $insert);
            }
            
           
            if($run) 
            {

                 //$this->session->setFlashdata('success', 'Your swap '.$text.' successfully');
                $output['message'] = 'Your swap '.$text.' successfully' ;
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

    public function delete_swap()
    {
        $this->common_model->DeleteData('swap' , ['id' => $_POST['id']]);
        $output['message'] = 'Your swap has been deleted successfully' ;
        $output['status'] = 1 ;  
        echo json_encode($output);
    }

    public function all_swap_list()
    {
        //  echo $id;die;
      $data['all_swap'] = $this->common_model->GetAllData('swap','','id','desc');
       return view('site/all_swap_list',$data);
    }

     function fetch_data()
     {
       // print_r($_POST);
        sleep(1);

      $pager = \Config\Services::pager();
      $config = array();
      
      $config['total_rows'] = $this->SwapModel->count_all($_POST);
      $config['per_page'] = 9;
      
      // $this->pagination->initialize($config);
      $page = $this->request->uri->getSegment(3);
      $total = $config['total_rows'];
      $start = ($page - 1) * $config['per_page'];
      $output = array(
       'pagination_link'  => $pager->makeLinks($page, $config['per_page'], $total, 'ajax_full'),
       'swap_list'   => $this->SwapModel->fetch_data($config["per_page"], $start, $_POST),
       'total' => 'There are '.$config['total_rows'].' Swaps.'
      );
      echo json_encode($output);
     }
    public function swap_detail($id)
    {
        //echo $id;die;
        $this->check_login();
      $data['swap_detail'] = $this->common_model->GetSingleData('swap',array('id'=>$id));
       return view('site/swap_detail',$data);
    }
   
   
}
