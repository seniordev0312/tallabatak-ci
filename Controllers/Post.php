<?php

namespace App\Controllers;
use App\Models\Common_model;
class Post extends BaseController
{
    public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->common_model = new Common_model();
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
      else
      {
        header('Location: '.base_url('/'));
        exit();
      }
       
    }
   
    public function index()
    {
        $this->check_login();
        if (check_subscription($this->user_id)['active']) 
        {
            return view('site/add_post');
        }
        $this->session->setFlashdata('toast_error', 'You dont have active plan. Please upgrade your plan');
       
        return redirect('upgrade-plan');
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

    public function editPost($id)
    {
        $data['edit'] = $this->common_model->GetSingleData('post',array('id'=>$id));
        return view('site/edit_post', $data);
    }

    public function update_post()
    {
         $this->validation->setRule('title','Title','trim|required');
    	 $this->validation->setRule('category','Category','trim|required');
         $this->validation->setRule('description','Description','trim|required');
         $this->validation->setRule('zipcode','Zipcode','trim|required');
         $this->validation->setRule('country','Country','trim|required');
         $this->validation->setRule('address','Address','trim|required');
         $this->validation->setRule('state','State','trim|required');
         $this->validation->setRule('city','City','trim|required');
         $this->validation->setRule('price','Price','trim|required');
         
         if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['validation']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
        else
        {
        	$id = $_POST['id'];
            $update['title'] = $_POST['title'];
			$update['category'] = $_POST['category'];
			$update['user_id'] =  $this->user_id ;
            $update['description'] = $_POST['description'];
            $update['state'] = $_POST['state'];
            $update['city'] = $_POST['city'];
            $update['country'] = $_POST['country'];
            $update['zipcode'] = $_POST['zipcode'];
            $latLng = geoLocate($_POST['address'].', '.$_POST['city'].', '.$_POST['state'].', '.$_POST['country']);

            $insert['lat'] = $latLng['lat'];
            $insert['lng'] = $latLng['lat'];
            
            if ($_POST['lat'] && $_POST['lng']) 
            {
                $insert['lat'] = $this->request->getVar('lat');
                $insert['lng'] = $this->request->getVar('lng');
            }
            $update['address'] = $_POST['address'];
            $update['currency'] = $_POST['currency'];
            $update['price'] = $_POST['price'];
            $update['duration'] = $_POST['duration'];
            $update['auction_qty'] = $_POST['auction_qty'];
            $update['auction_expire_date'] = $_POST['auction_expire_date'];
            $update['auction_currency'] = $_POST['auction_currency'];
            $update['auction_price'] = $_POST['auction_price'];
            $update['updated_at'] = date('Y-m-d H:i:s');
            
			
			$run = $this->common_model->UpdateData('post',array('id' =>$id), $update);
			if($run)
            {  
                $c = count($_FILES['file']['name']);
                if(!empty($_FILES['file']['name']))
                {
                    for($i =0; $i < $c; $i++)
                    {
                        if(!empty($_FILES['file']['name'][$i]))
                        {
                            $newName = explode('.',$_FILES['file']['name'][$i]);
                            $ext = end($newName);
                            
                            $fileName = 'assets/upload/'.rand().time().'.'.$ext;
                            move_uploaded_file($_FILES['file']['tmp_name'][$i], $fileName);
                            $inserFile['file']= $fileName ; 
                            $inserFile['post_id']= $id; 

                            $run2 = $this->common_model->InsertData('post_images', $inserFile);
                            // $this->db->getLastQuery();
                        }
                        
                    }
                    
                }
                // $post = $this->common_model->GetSingleData('post' , array('id' => $run));
                 $this->sendNotiftoNearbyUsers($insert['lat'] , $insert['lng'] , $post);
                $output['message']='Post has been updated successfully.' ;
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
   

    public function add_post()
    {
        
         $this->validation->setRule('title','Title','trim|required|max_length[50]');
         $this->validation->setRule('description','description','trim|required|max_length[1500]');
         $this->validation->setRule('country','country','trim|required');
         $this->validation->setRule('city','city','trim|required');
         $this->validation->setRule('state','state','trim|required');
         $this->validation->setRule('zipcode','zipcode','trim|required');
         
        if($this->validation->withRequest($this->request)->run()==false)
        {
       
            $output['message']=$this->validation->getErrors();
            $output['status']= 0 ;       
        }
    
        else
        {
            $sub = check_subscription($this->user_id);
            if ($sub['active'] == false || $sub['available_post'] == 0) 
            {
                 $output['message']='<div class="alert alert-danger">Please Upgrade Your Plan</div>' ;
                $output['status']= 0 ;
                echo json_encode($output);
                exit;  
            }
            $insert['category'] = $this->request->getVar('category');            
            $insert['title'] = $this->request->getVar('title');            
            $insert['user_id'] = $this->user_id;            
            
            $insert['description'] = $this->request->getVar('description');
            if(isset($_POST['post_type']))
            {
                $insert['post_type'] = 1;
                $insert['auction_qty'] = $this->request->getVar('auction_qty');
                $insert['auction_expire_date'] = $this->request->getVar('auction_expire_date');
                $insert['auction_currency'] = $this->request->getVar('auction_currency');
                $insert['auction_price'] = $this->request->getVar('auction_price');
            }
            
            $insert['city'] = $this->request->getVar('city');
            $insert['state'] = $this->request->getVar('state');
            $insert['country'] = $this->request->getVar('country');
            $insert['zipcode'] = $this->request->getVar('zipcode');
            $latLng = geoLocate($_POST['address'].', '.$_POST['city'].', '.$_POST['state'].', '.$_POST['country']);

            $insert['lat'] = $latLng['lat'];
            $insert['lng'] = $latLng['lat'];
            
            if ($_POST['lat'] && $_POST['lng']) 
            {
                $insert['lat'] = $this->request->getVar('lat');
                $insert['lng'] = $this->request->getVar('lng');
            }
            $insert['address'] = $this->request->getVar('address');
            $insert['currency'] = $this->request->getVar('currency');
            $insert['price'] = $this->request->getVar('price');
            $insert['duration'] = $this->request->getVar('duration');
            $insert['sub_id'] = $sub['subcribtion']['id'];
            $insert['created_at'] = date('Y-m-d H:i:s');           
            

            $run = $this->common_model->InsertData('post',$insert );

            if($run)
            {
                $subupdate['used_post'] = $sub['subcribtion']['used_post'] + 1;
                $this->common_model->UpdateData('plan_subscriptions' , array('id' => $sub['subcribtion']['id']) , $subupdate);  
                $c = count($_FILES['file']['name']);
                if(!empty($_FILES['file']['name']))
                {
                    for($i =0; $i < $c; $i++)
                    {
                        if(!empty($_FILES['file']['name'][$i]))
                        {
                            $newName = explode('.',$_FILES['file']['name'][$i]);
                            $ext = end($newName);
                            
                            $fileName = 'assets/upload/'.rand().time().'.'.$ext;
                            move_uploaded_file($_FILES['file']['tmp_name'][$i], $fileName);
                            $inserFile['file']= $fileName ; 
                            $inserFile['post_id']= $run ; 

                            $run2 = $this->common_model->InsertData('post_images', $inserFile);
                        }
                        
                    }
                    
                }
                
                $post = $this->common_model->GetSingleData('post' , array('id' => $run));
                $this->sendNotiftoNearbyUsers($insert['lat'] , $insert['lng'] , $post);
                $output['message']='Post has been added successfully.' ;
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
    private function sendNotiftoNearbyUsers($lat , $lng , $post)
    {
        $sql = "Select * FROM users WHERE city = '".$post['city']."'  AND id != ".$post['user_id'];
        $query = $this->db->query($sql);
        $users = $query->getResultArray();
        foreach ($users as $key => $user) 
        {
            
            $interest = $user['interested_in'];
            if($user['interested_in'] == $post['category'] || $user['interested_in'] == 1)
            {
                $email = $user['email'];
                $subject="New Post has been posted near you";
                $dis = $this->calculateDistanceBetweenTwoPoints($lat , $lng , $user['lat'] , $user['lng'] , 'KM');
                $nearby_radius = $this->session->get('nearby_radius');
                // if($dis < $nearby_radius)
                if(1==1)
                {
                    $post_image = $this->common_model->getSingleData('post_images',array('post_id'=>$post['id']));
                    $image_url = 'https://www.tekhalini.com/'.$post_image['file'];
                    $body = '
                    <p>Hello  , </p>
                    <p>'.$user['name'].' You have a nearby post "'.$post['title'].'" in your city “'.$user['city'].'” its '.$dis.'km far from you.</p></p>'.substr($post['description'], 0, 50).'</p><p>Thank you</p>
                    <a href="'.get_post_url($post).'">
                    <img src="'.$image_url.'"/>
                    <p>'.$post['description'].'</p></a>
                    <a href="https://www.tekhalini.com/">
                        <p> Click here to become one of us</p>
                    </a>';
                    $notifi['user_id'] = $user['id'];
                    $notifi['message'] = "Hello  ".$user['name'].", You have a nearby post \"".$post['title']."\" in your city “".$user['city']."” its ".$dis."km far from you. \n ".substr($post['description'], 0, 50)." \n Thank you";
                    $notifi['is_read'] = 0;
                    $notifi['created_at'] = date('Y-m-d H:i:s');
                    $notifi['type'] = 'post-detail';
                    $notifi['other'] = ['screen' => 'post-detail' , 'click_action' => get_post_url($post) , 'id' => $post['id']];
                    $notifi['noti_type'] = 'near_by_ads';
                    // $notifi['onlyPushNot'] = true;

                    $this->common_model->send_and_insert_notifi('notification' ,$notifi);          
                    $send = $this->common_model->SendMail($email,$subject,$body);
                } 
            }
        }
           
    }
   private function calculateDistanceBetweenTwoPoints($latitudeOne='', $longitudeOne='', $latitudeTwo='', $longitudeTwo='',$distanceUnit ='',$round=false,$decimalPoints='')
    {
        if (empty($decimalPoints)) 
        {
            $decimalPoints = '3';
        }
        if (empty($distanceUnit)) {
            $distanceUnit = 'KM';
        }
        $distanceUnit = strtolower($distanceUnit);
        $pointDifference = $longitudeOne - $longitudeTwo;
        $toSin = (sin(deg2rad($latitudeOne)) * sin(deg2rad($latitudeTwo))) + (cos(deg2rad($latitudeOne)) * cos(deg2rad($latitudeTwo)) * cos(deg2rad($pointDifference)));
        $toAcos = acos($toSin);
        $toRad2Deg = rad2deg($toAcos);

        $toMiles  =  $toRad2Deg * 60 * 1.1515;
        $toKilometers = $toMiles * 1.609344;
        $toNauticalMiles = $toMiles * 0.8684;
        $toMeters = $toKilometers * 1000;
        $toFeets = $toMiles * 5280;
        $toYards = $toFeets / 3;


              switch (strtoupper($distanceUnit)) 
              {
                  case 'ML'://miles
                         $toMiles  = ($round == true ? round($toMiles) : round($toMiles, $decimalPoints));
                         return $toMiles;
                      break;
                  case 'KM'://Kilometers
                        $toKilometers  = ($round == true ? round($toKilometers) : round($toKilometers, $decimalPoints));
                        return $toKilometers;
                      break;
                  case 'MT'://Meters
                        $toMeters  = ($round == true ? round($toMeters) : round($toMeters, $decimalPoints));
                        return $toMeters;
                      break;
                  case 'FT'://feets
                        $toFeets  = ($round == true ? round($toFeets) : round($toFeets, $decimalPoints));
                        return $toFeets;
                      break;
                  case 'YD'://yards
                        $toYards  = ($round == true ? round($toYards) : round($toYards, $decimalPoints));
                        return $toYards;
                      break;
                  case 'NM'://Nautical miles
                        $toNauticalMiles  = ($round == true ? round($toNauticalMiles) : round($toNauticalMiles, $decimalPoints));
                        return $toNauticalMiles;
                      break;
              }


    }
    public function delete_post()
    {
        $where['id'] = $_POST['id'] ;
        $insert['is_delete'] = 1;
        $this->common_model->DeleteData('post' ,  $where );  
        $output['message']='Post has been Deteled successfully' ;
        $output['status']= 1 ;  
        
         echo json_encode($output);
    }
    
    public function deleteImage()
    {
        // echo "hello";
            $id = $this->request->getVar('id'); 
            $run3 = $this->common_model->DeleteData('post_images', array('id'=> $id));
            if($run3)
            {  
                $output['message']='Post Image has been Deleted successfully' ;
                $output['status']= 1 ;  
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Post Image has been Deleted successfully</div>');
                                            

            }
            else{
            
                $output['message']='<div class="alert alert-danger">Something went wrong</div>' ;
                $output['status']= 0 ; 
            
            }
         
         echo json_encode($output);
      
    }

    public function upgradePost()
    {

       $insert['user_id'] = $this->user_id;            
       $post_id = $insert['post_id'] = $this->request->getVar('postId');
       $insert['amount'] = $this->request->getVar('amt');
       $insert['transaction_id'] = $this->request->getVar('trans_id');
       $insert['no_days'] = $this->request->getVar('no_days');
       $insert['status'] = 1;
       
        $post_data =  $this->common_model->GetSingleData('post', array('id'=>$post_id));

        $insert['end_date'] =   $post_data['end_date'];
        $insert['start_date'] = $post_data['start_date'];
        $insert['created_at'] = date('Y-m-d H:i:s');
        

         $this->common_model->UpdateData('post' , ['user_id' => $this->user_id ,'id' =>$post_id ] , ['is_featured' => 1]);
        $run = $this->common_model->InsertData('is_featured_subscription' , $insert);

            if($run)
            {  
                $this->session->setFlashdata('msg', '<div class="alert alert-success">Your post has been featured successfully.</div>');
                $output['status'] = 1;  
                $output['message'] = 'Your post has been featured successfully.';
                
            }
            else 
            {
            
                $output['status']= 0 ;  
                $output['message']='<div class="alert alert-danger">Something went wrong</div>';
            }
         
         echo json_encode($output);
   }



   
}
