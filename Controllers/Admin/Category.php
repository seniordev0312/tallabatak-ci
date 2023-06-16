<?php 
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
class Category extends BaseController {

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

  	public function index()
    {
        $data['data'] = $this->common_model->GetAllData('category',array('parent_id'=> 0),'id','desc');
        return view('admin/categorylist', $data);
    }

	public function sub_category_list()
    {
        $data['data'] = $this->common_model->GetAllData('category',array('parent_id != '=> 0),'id','desc');
        $data['category'] = $this->common_model->GetAllData('category',array('parent_id '=> 0),'id','desc');
        // echo $this->db->lastQuery; die();

        return view('admin/sub-category-list', $data);
    }
	

  	public function addCategory()
    {
        helper(['form']);
	    if ($this->request->getMethod() == "post") {
	        $validation =  \Config\Services::validation();

	        $rules = [
	            "title_eng" => [
	                "label" => "Title ", 
	                "rules" => "required|trim|is_unique[category.title_eng]"
	            ],
				
	            
	        ];

	        if ($this->validate($rules)) {
				$insert['title_eng'] = $_POST['title_eng'];
				
				$insert['user_id'] = 0;
				$insert['created_at'] = date('Y-m-d');
				if(!empty($_FILES['image']['name']))
	               {
	                    $newName = explode('.',$_FILES['image']['name']);
	                    $ext = end($newName);
	                    $fileName = 'assets/upload/'.rand().time().'.'.$ext;
	                    move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
	                    $insert['image']= $fileName ; 
	               }
	              
				$run = $this->common_model->InsertData('category', $insert);
				
		       if($run)
				{
					
						$this->session->setFlashdata('msg', '<div class="alert alert-success">Category has been Added successfully.</div>');
						$output['status']=1;
						$output['message']="Category has been Added successfully.";
				}
			} else {
	        	$output['status']= 0 ; 
	            $output["validation"] = $validation->getErrors();
	        }
	    }
		echo json_encode($output);
    }

	public function addSubCategory()
    {
        helper(['form']);
	    if ($this->request->getMethod() == "post") {
	        $validation =  \Config\Services::validation();

	        $rules = [
	            "title_eng" => [
	                "label" => "Title ", 
	                "rules" => "required|trim|is_unique[category.title_eng]"
	            ],
				
				"parent_id" => [
					"label" => "Category", 
					"rules" => "required|trim"
				],
	            
	        ];

	        if ($this->validate($rules)) {
				$insert['title_eng'] = $_POST['title_eng'];
				
				$insert['user_id'] = 0;
				$insert['parent_id'] = $_POST['parent_id'];
				$insert['created_at'] = date('Y-m-d');
				if(!empty($_FILES['image']['name']))
	               {
	                    $newName = explode('.',$_FILES['image']['name']);
	                    $ext = end($newName);
	                    $fileName = 'assets/upload/'.rand().time().'.'.$ext;
	                    move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
	                    $insert['image']= $fileName ; 
	               }
	              
				$run = $this->common_model->InsertData('category', $insert);
				
		       if($run)
				{
					
						$this->session->setFlashdata('msg', '<div class="alert alert-success">Sub Category has been Added successfully.</div>');
						$output['status']=1;
						$output['message']="Sub Category has been Added successfully.";
				}
			} else {
	        	$output['status']= 0 ; 
	            $output["validation"] = $validation->getErrors();
	        }
	    }
		echo json_encode($output);
    }

  	public function editCategory()
    {
        helper(['form']);
	    if ($this->request->getMethod() == "post") {
	        $validation =  \Config\Services::validation();

	        $rules = [
	            "title_eng" => [
	                "label" => "Title ", 
	                "rules" => "required|trim"
	            ],
				
	            
	        ];

	        if ($this->validate($rules)) {

	        	$id = $_POST['id'];
                 $check = $this->common_model->GetSingleData('category', array('title_eng'=> $_POST['title_eng'], 'id!='=>$id));
                 

		       if($check)
		        {
		             $output['message']='<div class="label alert-danger">category already exist</div>' ;
		            $output['status']= 0 ; 
		        }else
		        {
		        	$id = $_POST['id'];
				    $update['title_eng'] = $_POST['title_eng'];
				   
				    $update['updated_at'] = date('Y-m-d');
					if(!empty($_FILES['image']['name']))
	               {
	                    $newName = explode('.',$_FILES['image']['name']);
	                    $ext = end($newName);
	                    $fileName = 'assets/upload/'.rand().time().'.'.$ext;
	                    move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
	                    $update['image']= $fileName ; 
	               }
					
				    $run = $this->common_model->UpdateData('category',array('id'=>$id), $update);
				
		
				if($run)
				{
					
						$this->session->setFlashdata('msg', '<div class="alert alert-success">Category has been Updated successfully.</div>');
						$output['status']=1;
						$output['message']="Category has been Updated successfully.";
				}

		        }
				
				
			} else {
	        	$output['status']= 0 ; 
	            $output["validation"] = $validation->getErrors();
	        }
	    }
		echo json_encode($output);
    }

	public function editSubCategory()
    {
        helper(['form']);
	    if ($this->request->getMethod() == "post") {
	        $validation =  \Config\Services::validation();

	        $rules = [
	            "title_eng" => [
	                "label" => "Title ", 
	                "rules" => "required|trim"
	            ],
				
				"parent_id" => [
	                "label" => "Category", 
	                "rules" => "required|trim"
	            ],
	            
	        ];

	        if ($this->validate($rules)) {

	        	$id = $_POST['id'];
                 $check = $this->common_model->GetSingleData('category', array('title_eng'=> $_POST['title_eng'], 'id!='=>$id));
                 

		       if($check )
		        {
		             $output['message']='<div class="label alert-danger">sub category already exist</div>' ;
		            $output['status']= 0 ; 
		        }else
		        {
		        	$id = $_POST['id'];
					$update['parent_id'] = $_POST['parent_id'];
				    $update['title_eng'] = $_POST['title_eng'];
				    
				    $update['updated_at'] = date('Y-m-d');
					if(!empty($_FILES['image']['name']))
	               {
	                    $newName = explode('.',$_FILES['image']['name']);
	                    $ext = end($newName);
	                    $fileName = 'assets/upload/'.rand().time().'.'.$ext;
	                    move_uploaded_file($_FILES['image']['tmp_name'], $fileName);
	                    $update['image']= $fileName ; 
	               }
					
				    $run = $this->common_model->UpdateData('category',array('id'=>$id), $update);
				
		
				if($run)
				{
					
						$this->session->setFlashdata('msg', '<div class="alert alert-success">Sub Category has been Updated successfully.</div>');
						$output['status']=1;
						$output['message']="Sub Category has been Updated successfully.";
				}

		        }
				
				
			} else {
	        	$output['status']= 0 ; 
	            $output["validation"] = $validation->getErrors();
	        }
	    }
		echo json_encode($output);
    }

    
    public function deleteCategory() {        
        
        $id = $_POST['id'];
        $run = $this->common_model->DeleteData('category', array('id'=> $id));
        if ($run) {
            $json['message'] = 'Success! Category has been Deleted successfully';
            $json['status'] = 1;
        } else {
            $json['message'] = 'Error! Something went wrong';
            $json['status'] = 0;
        }
        echo json_encode($json);
    }
	public function deleteSubCategory() {        
        
        $id = $_POST['id'];
        $run = $this->common_model->DeleteData('category', array('id'=> $id));
        if ($run) {
            $json['message'] = 'Success! Sub Category has been Deleted successfully';
            $json['status'] = 1;
        } else {
            $json['message'] = 'Error! Something went wrong';
            $json['status'] = 0;
        }
        echo json_encode($json);
    }
	

   
}