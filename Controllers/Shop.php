<?php

namespace App\Controllers;
use App\Models\Common_model;
use App\Models\Search_model;
class Shop extends BaseController {
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->common_model = new Common_model();
        $this->search_model = new Search_model();
        $this->user_id =  $this->session->get('user_id');
        $this->user = $this->common_model->GetSingleData('users', array('id' => $this->user_id));
        helper(['form', 'url' , 'cookie']);
    }
    public function check_login()
    {
      if ($this->session->has('user_id')) {
        return true ;
      }
      else
      {
        return false;
      }
       
    }
    public function index($slug=false)
    {
        $data['active_cat'] = 0;
        if ($slug) {
            $split = explode('-', $slug);
            $cat_id = end($split);
            if ($this->common_model->GetSingleData("category", array("id"=>$cat_id))) {
                $data['active_cat'] = $cat_id;
            }
            else
            {
               return view('site/404');
            }
            
        }
        $data['categories'] = $this->common_model->GetAllData("category", 'parent_id=0' , 'id' , 'desc');
        

        return view('site/shop' , $data);
    }
    function post_detail($slug)
    {
        $url = explode('-', $slug);
        $id  = end($url);
        $data['post'] = $this->common_model->GetSingleData("post", array("id"=>$id));
       
        
        if($data['post'])
        { 
            $data["post_images"] = $this->common_model->GetAllData("post_images", array("post_id"=>$id));
            $data["post_user"] = $this->common_model->GetSingleData("users", array("id"=> $data['post']['user_id']));
            $data["post_comments"] = $this->common_model->GetAllData("post_comments", array("post_id"=> $id));
            $data['post']["category"] = $this->common_model->GetSingleData("category", array("id"=> $data['post']["category"]));
            return view('site/post-detail', $data);
        }
        return view('site/404');
    }
    

    private function randomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i=0; $i<13; $i++) 
        {
         $randomString.= $characters[rand(0, $charactersLength - 1)];
        }
       return $randomNumber= $randomString;
    }

    
    function fetch_data()
     {
      sleep(1);
      
      $pager = \Config\Services::pager();
      $config = array();
      
      $config['total_rows'] = $this->search_model->count_all($_POST);
      $config['per_page'] = 9;
      
      // $this->pagination->initialize($config);
      $page = $this->request->uri->getSegment(3);
      $total = $config['total_rows'];
      $start = ($page - 1) * $config['per_page'];
      $output = array(
       'pagination_link'  => $pager->makeLinks($page, $config['per_page'], $total, 'ajax_full'),
       'post_list'   => $this->search_model->fetch_data($config["per_page"], $start, $_POST),
       'total' => 'There are '.$config['total_rows'].' Posts.'
      );
      echo json_encode($output);
     }
    public function do_comment()
    {

         $this->validation->setRule('post_id','Post Id','trim|required');
         $this->validation->setRule('comment','comment','trim|required');
         $this->validation->setRule('rating','rating','trim|required');
         
        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $insert['post_id'] = $this->request->getVar('post_id');
            $insert['user_id'] = $this->user_id;
            if ($_POST['post_user_id'] == $this->user_id) 
            {
               $output['message']='You are not allowed to rate and comment on your own post.' ;
               $output['icon']= 'error' ;
               $output['title']= 'Oops' ;
               $output['status']= 1 ;
               echo json_encode($output);
               exit;
            }
            $run = $this->common_model->GetSingleData('post_comments', $insert );
            if ($run) 
            {
               $output['message']='You are not allowed to rate and comment twice.' ;
               $output['icon']= 'error' ;
               $output['title']= 'Oops' ;
               $output['status']= 1 ;
               echo json_encode($output);
               exit;
            }          
            $insert['comment'] = $this->request->getVar('comment');            
            $insert['rating'] = $this->request->getVar('rating');            
            $insert['seller_id'] = $this->request->getVar('post_user_id');            
            $insert['created_at'] = date('Y-m-d');
            $insert['updated_at'] = date('Y-m-d');
            

            $run = $this->common_model->InsertData('post_comments', $insert );
            $seller_rating = $this->getAvgRating($insert['seller_id'] , 'seller_id');
            $this->common_model->UpdateData('users',array('id'=> $insert['seller_id']), array('rating'=> $seller_rating));
            $product_rating = $this->getAvgRating($insert['post_id'] , 'post_id');
            $this->common_model->UpdateData('post',array('id'=> $insert['post_id']), array('rating'=> $product_rating));
            // echo $this->db->lastQuery; die(); 
            if($run)
            {  
             
                $output['message']='Your Comment has been added successfully.' ;
                $output['icon']= 'success' ;
                $output['title']= 'Success' ;
                $output['status']= 1 ;                               

            }
            else 
            {
            
                $output['message']='Something went wrong' ;
                $output['icon']='error' ;
                $output['title']='Oops' ;
                $output['status']= 0 ;  
            
            }
         }
         echo json_encode($output);
    }
    public function getAvgRating($col_id , $col)
    {
      $sellerData = $this->common_model->GetAllData('post_comments',array($col=> $col_id) ,'' ,'','' ,'' , 'AVG(rating)');
      return $sellerData[0]['AVG(rating)'];
   }
}
