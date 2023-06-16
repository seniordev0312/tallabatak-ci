<?php
use App\Models\Common_model;

global $common_model;
global $session;
global $db;
$session = \Config\Services::session();
$common_model = new App\Models\Common_model();

$db = \Config\Database::connect(); 
 function UpdateActivity($user_id)
    {
      $insert['active_time'] = date('Y-m-d H:i:s');
      $insert['active_status'] = 1;
      $where['id'] = $user_id;
      $GLOBALS["common_model"]->UpdateData('users' ,$where ,$insert) ;

      return true;
       
    }

if(!function_exists('categoryName')){
    function categoryName($id)
    {
      
        $cat = $GLOBALS["common_model"]->GetSingleData('categories' , array('id'=> $id));
         return $cat['title'];      
      
    }
}
if(!function_exists('getUserById')){
    function getUserById($id)
    {
      
        $user = $GLOBALS["common_model"]->GetSingleData('users' , array('id'=> $id));
         return $user;      
      
    }
}
function getAllNotifications($id)
{
   

    $data = $GLOBALS["common_model"]->GetAllData('notification' , array('user_id' => $id) , 'id' , 'desc' , 5);
    return $data;

}
function getUnreadNotifications($id)
{

    $data = $GLOBALS["common_model"]->GetAllData('notification' , array('user_id' => $id , 'is_read' => 0));
    return $data;

}
function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}
function get_client_location()
{
    $PublicIP = get_client_ip();
    $json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
    $json     = json_decode($json, true);
    $country  = $json['country'];
    $region   = $json['region'];
    $city     = $json['city'];
    // echo $country; 
    // echo $region; 
    // echo $city; die;
    $con = $GLOBALS['common_model']->GetSingleData('countries' , "iso2 = '$country'");
    $s = $GLOBALS['common_model']->GetSingleData('states' , "name = '$region'");
    $c = $GLOBALS['common_model']->GetSingleData('cities' , "name = '$city'");
    // print_r($c);
    $data['country'] = ($con) ? $con['id'] : '';
    $data['state'] = ($s) ? $s['id'] : '';
    $data['city'] = ($c) ? $c['id'] : '';
    return $data; 
}


  function slugify($text, string $divider = '-')
  {
  // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
  }
  
  function get_post_url($post)
  {
      return base_url('post').'/'.slugify($post['title']).'-'.$post['id'];
  }
  function get_vendor_url($vendor)
  {
      return base_url('vendor').'/'.slugify($vendor['name']).'-'.$vendor['id'];
  }
  
function greeting_msg() {
   date_default_timezone_set('Asia/Calcutta');

// 24-hour format of an hour without leading zeros (0 through 23)
    $Hour = date('G');

    if ( $Hour >= 5 && $Hour <= 11 ) {
        $greeting = "Good Morning";
    } else if ( $Hour >= 12 && $Hour <= 18 ) {
        $greeting = "Good Afternoon";
    } else if ( $Hour >= 19 || $Hour <= 4 ) {
        $greeting = "Good Evening";
    }
        return $greeting;
}
function humanDate($date) {
   
   return date('d M, Y' , strtotime($date));
        
}
if (!function_exists('time_ago')) {
    function time_ago($timestamp){  
        $time_ago = strtotime($timestamp);  
        $current_time = time();  
        $time_difference = $current_time - $time_ago;  
        $seconds = $time_difference;  
        $minutes = round($seconds / 60) ;// value 60 is seconds
        $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec
        $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;
        $weeks   = round($seconds / 604800);// 7*24*60*60;
        $months  = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
        $years   = round($seconds / 31553280);//(365+365+365+365+366)/5 * 24 * 60 * 60  
        if($seconds <= 60) { 
        
            return "Just Now";
            
        } else if($minutes <=60) { 
        
            if($minutes==1) {  
                return "one minute ago";  
            } else {  
                return "$minutes minutes ago";  
            }  
            
        } else if($hours <=24) {  
            
            if($hours==1) {  
                return "an hour ago";  
            } else  {  
                return "$hours hrs ago";  
            }  
            
        } else if($days <= 7) {  
            if($days==1) {  
                return "yesterday";  
            } else  {  
                return "$days days ago";  
            }  
        } else if($weeks <= 4.3) {  
            
            if($weeks==1) {  
                return "a week ago";  
            }  else  {  
                return "$weeks weeks ago";  
            }  
        }  else if($months <=12) { 
        
            if($months==1) {  
                return "a month ago";  
            } else {  
                return "$months months ago";  
            }  
        }  else {  
            if($years==1) {  
                return "one year ago";  
            } else  {  
                return "$years years ago";  
            }  
        }  
    }
}
function chat_users($user_id , $type=0) {
        
    if (!$user_id) {
        return false;
    } else {
        
        $i = 0;
        
        $new_user = array();
        
        
        // $sql = "SELECT *, MAX(id) FROM `chat` WHERE  sender = '".$user_id."' or receiver = '".$user_id."' or (is_group = 1 and (select count(id) from groups where groups.id = chat.thread_id and FIND_IN_SET($user_id,groups.members) != 0) > 0) group by thread_id order by MAX(id) desc";

        $sql = "SELECT *, MAX(id) FROM `chat` WHERE (sender = '".$user_id."' or receiver = '".$user_id."' or (is_group = 1 and (select count(id) from groups where groups.id = chat.thread_id and (FIND_IN_SET($user_id,groups.members) or groups.create_by = $user_id) != 0) > 0)) and (is_admin = 0 || (is_admin = 1 && sender != $user_id)) group by thread_id order by MAX(id) desc";
        
        $total_records = 0;
        $run1 = $GLOBALS["db"]->query($sql);
        $total_records = count($run1->getResultArray());
        
        $results_per_page = 10;
        $number_of_page = ceil($total_records/$results_per_page);
            
        $page_number = 1;

        $page_first_result = ($page_number - 1) * $results_per_page;
        
        //$sql .= " LIMIT $page_first_result, $results_per_page";
        
        $chats = $run1->getResultArray($sql);
        
        $result = [];
        
        if($chats){
            
            foreach($chats as $row){
                
                $true = true;
                
                if($row['is_group']==1)
                {
                    if ($type == 0) {
                        continue;
                    }
                    $group = $GLOBALS["common_model"]->GetSingleData('groups' , array('id' => $row['thread_id']));
                    $if_added =  $GLOBALS["common_model"]->GetSingleData('groups' , 'id='.$row['thread_id'].' AND FIND_IN_SET('.$user_id.' , members)');
                    if (!$if_added && $group['create_by'] != $user_id) {
                        continue;
                    }
                    // echo $GLOBALS["db"]->getLastQuery();
                    $data11 = group_data($row['thread_id'],0);
                    $GLOBALS["common_model"]->GetSingleData('groups' , array('id' => $row['thread_id']));
                } else {
                    if ($type != 0) {
                        continue;
                    }
                    $other = ($row['sender']==$user_id) ? $row['receiver'] : $row['sender'];
                    $data11 = $GLOBALS["common_model"]->GetSingleData('users' , array('id' => $other));
                    
                    if(!$data11){
                        $true = false;
                    }
                }
                
                
                if($true){
                    
                    $new_user = $row;
                    $new_user['data'] = $data11;
                    
                    $where = "thread_id = '".$row['thread_id']."' and FIND_IN_SET($user_id,read_by)=0";
                    //$new_user['where'] = $where;
                    $unread = $GLOBALS["common_model"]->GetAllData('chat' , $where);
                    $unread = ($unread) ? count($unread) : 0;

                    
                    $new_user['unread'] = $unread ;
                    
                    
                    $sql1 = "SELECT message,msg_type, create_date FROM `chat` WHERE thread_id = '".$row['thread_id']."' order by id desc limit 1";
            
                    $run1 = $GLOBALS["db"]->query($sql1);
                    $row1 = $run1->getRowArray();
                    
                    $row1['create_date'] = time_ago($row1['create_date']);
                    
                    $new_user['last_message'] = $row1;
                    
                    array_push($result,$new_user);
                } else {
                    
                    $GLOBALS["common_model"]->DeleteData('chat' , "thread_id = '".$row['thread_id']."'");
                }
            }
            
            
            return $result;
            
        
            
        } else {
            return false;
        }
    }
    return false;
}
function group_data($id,$full_data=0)
    {
        $data = $GLOBALS["common_model"]->GetSingleData('groups', "id = $id");
        
        if($data){
            if($data['members']){
                $members = [];
                $members_arr = explode(',',$data['members']);
                if($full_data){
                    foreach($members_arr as $mem_id){
                        $members_data = $GLOBALS["common_model"]->GetSingleData('users', "id = $mem_id");
                        if($members_data){
                            $members[] = $members_data;
                        }
                    }
                    
                    $data['members'] = $members;
                    if ($data['create_by'] == 0) {
                        $data['create_by'] = $GLOBALS["common_model"]->GetSingleData('admin', "id = 1");
                        $data['create_by']['active_status'] = 1;
                        $data['create_by']['active_time'] = date('Y-m-d h:i:s');
                    }
                    else
                    {
                        $data['create_by'] = $GLOBALS["common_model"]->GetSingleData('users', "id = ".$data['create_by']);
                    }
                    
                }
                $data['members_count'] = count($members_arr);
                
                
         
                if($data['icon']){
                    $data['icon'] = $data['icon'];
                } else {
                    $data['icon'] =  '/assets/images/groups/icon-group.png';
                }
                
            } else {
                $data['members'] = [];
                $data['members_count'] = 0;
            }
        }
        
        return $data;
    }
function check_subscription($user_id , $is_paid=false )
{
    $where = "user_id = $user_id AND status = 1";
    if ($is_paid) 
    {
        $where .= " AND plan_id != 1";
    }
    
    $subcribtion = $GLOBALS["common_model"]->GetSingleData('plan_subscriptions' , $where);
    $data['active'] = false;
    $data['available_post'] = 0;
    if ($subcribtion) 
    {
        $current_date = strtotime(date('Y-m-d'));
        $plan_end_date =  strtotime($subcribtion['end_date']);
        if ($current_date <= $plan_end_date) 
        {
            $data['active'] = true;
            $data['plan'] = $plan = $GLOBALS["common_model"]->GetSingleData('plan_management' , array('id' => $subcribtion['plan_id'] ));
            $data['subcribtion'] = $subcribtion;
            $total_post =  $GLOBALS["common_model"]->GetSingleData('post' , array('user_id' => $user_id , 'sub_id' => $subcribtion['id']) , '' , '' , 'count(id) as total');
            $data['available_post'] = $plan['post'] - $total_post['total'] ;
            if ($data['available_post'] < 0) 
            {
                $data['available_post'] = 0;
            }
            
        }
    }
    return $data;
}
function numberOfDays($startDate, $endDate) 
{
    //1) converting dates to timestamps
     $startSeconds = strtotime($startDate);
     $endSeconds = strtotime($endDate);
   
    //2) Calculating the difference in timestamps
    $diffSeconds = $startSeconds  - $endSeconds;
     
    
    //3) converting timestamps to days
    $days=round($diffSeconds / 86400);
    
      /*  note :
          1 day = 24 hours 
          24 * 60 * 60 = 86400 seconds
      */
   
    //4) printing the number of days
    //printf("Difference between two dates: ". abs($days) . " Days ");
    
    return abs($days);
}
function initGoogleLogin()
    {
        require_once 'google-api-php-client/Google_Client.php';
        require_once 'google-api-php-client/contrib/Google_Oauth2Service.php';
        //echo APPPATH . "libraries/vendor/autoload.php";die;

        $google_client = new \Google_Client();
        $google_client->setApplicationName('chatesi');
        $google_client->setClientId(GOOGLE_CLIENT_ID);
        $google_client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $google_client->setRedirectUri(GOOGLE_REDIRECT_URL);

        $google_service = new \Google_Oauth2Service($google_client);
        return  ['client' => $google_client , 'service' => $google_service , 'btn_url' =>$google_client->createAuthUrl()];
    }

    function initFbLogin()
    {
        require_once  'facebook-api/php-graph-sdk-5.x/src/Facebook/autoload.php';
        $fb =  new \Facebook\Facebook([ 
                'app_id'                => facebook_app_id, 
                'app_secret'            => facebook_app_secret, 
                'default_graph_version' => 'v2.2'
            ]);
        $Fbhelper = $fb->getRedirectLoginHelper(); 
        $data['facebook'] = $fb;
        $data['fb_helper'] = $Fbhelper;
        $data['btn_url'] =  $Fbhelper->getLoginUrl(facebook_login_redirect_url, 
            facebook_permissions ); 
        return  $data;
    }
     function geoLocate($address)
    {
        try {
            $lat = 0;
            $lng = 0;

            $data_location = "https://maps.google.com/maps/api/geocode/json?key=".google_place_api."&address=".str_replace(" ", "+", $address)."&sensor=false";
            $data = file_get_contents($data_location);
            usleep(200000);
            // turn this on to see if we are being blocked
            // echo $data;
            $data = json_decode($data);
            if ($data->status=="OK") {
                $lat = $data->results[0]->geometry->location->lat;
                $lng = $data->results[0]->geometry->location->lng;

                if($lat && $lng) {
                    return array(
                        'status' => true,
                        'lat' => $lat, 
                        'lng' => $lng, 
                        'google_place_id' => $data->results[0]->place_id
                    );
                }
            }
            if($data->status == 'OVER_QUERY_LIMIT') {
                return array(
                    'status' => false, 
                    'message' => 'Google Amp API OVER_QUERY_LIMIT, Please update your google map api key or try tomorrow'
                );
            }

        } catch (Exception $e) {

        }

        return array('lat' => null, 'lng' => null, 'status' => false);
    }

    function get_near_by_users($user_id , $col_val , $col)
    {
        $where = "id != $user_id AND user_type = 2 AND $col = '$col_val' " ;
        
        $users = $GLOBALS["common_model"]->GetAllData('users' , $where , 'id' , 'desc' , 4);
        
        return $users;
    }