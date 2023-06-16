<?php



namespace App\Models;



use CodeIgniter\Model;
require './google-translator/autoload.php';
use Stichoza\GoogleTranslate\GoogleTranslate;


class Common_model extends Model {



     public function __construct() {

        //parent::__construct();

        $this->db = \Config\Database::connect(); 

        $this->email = \Config\Services::email();     

    }





  public function GetAllData($table,$where=null,$ob=null,$obc='DESC',$limit=null,$offset=null,$select=null){

    //echo "hello2";

        try {

            $builder = $this->db->table($table);

            if($select) {

              $builder->select($select);

            }

            if($where) {

              $builder->where($where);

            }



            if($ob) {

              $builder->orderBy($ob,$obc);

            }

            if($limit) {

              $builder->limit($limit,$offset);

            }

            $query = $builder->get();

              //echo $this->db->getLastQuery();

            if ($query->getRow()) {

                // code...

                return $query->getResultArray();

            }

            

        } catch (\Exception $e) {

            return $e->getMessage();

            

        }

  }
  
  public function getStateID($name){
      $tr = new GoogleTranslate(); 
      
       $name_en = $tr->setSource()->setTarget('en')->translate($name);
       var_dump($name,$name_en);
       die(0);
       $state_id = $this->getSingleData('states',array('name'=>$name_en))['id'];
       return $state_id;
       
  }

  public function GetCountData($table,$where=null){

    //echo "hello2";

        try {

            $builder = $this->db->table($table);

            if($where) {

              $builder->where($where);

            }



           return $query = $builder->countAllResults();

              //echo $this->db->getLastQuery();

            

            

        } catch (\Exception $e) {

            return $e->getMessage();

            

        }

  }



  public function GetDataByOrderLimit($table,$where,$odf=NULL,$odc=NULL,$limit=NULL,$start=0) {



                    $builder = $this->db->table($table);

                    if($where) {

                      $builder->where($where);

                    }        



                    if($odf && $odc){

                      $builder->orderBy($odf,$odc);

                    }

                       

                    if($limit){

                      $builder->limit($limit, $start);

                    }



                    //$sql=$builder->get($table);

                    $query = $builder->get();

                    if ($query->getRow()) {

                        // code...

                       return $query->getResultArray();

                    }

    }



    public function GetDataById($table,$value) {

        //echo $table. $value;

         try {                

                $builder = $this->db->table($table);

                $builder->where('id', $value);

                $query = $builder->get();

                if ($query->getRow()) {

                    // code...

                   return $query->getRowArray();

                } else {

                    return array();

                }

            } catch (\Exception $e) {

                    echo $e->getMessage();

            

        }



  }



  public function InsertData($table,$data) {

    //echo $table; print_r($data); /*

    $builder = $this->db->table($table);

     if($builder->insert($data)){

      return $this->db->insertID();

    } else {

      return false;

    }

  }





  public function GetSingleData($table,$where=null,$ob=null,$obc='desc' , $select=null){

    $builder = $this->db->table($table);

    if($select) {

      $builder->select($select);

    }
    if($where) {

      $builder->where($where);

    }

    if($ob) {

      $builder->orderBy($ob,$obc);

    }

    $query = $builder->get();

        if ($query->getRow()) {

                        // code...

           return $query->getRowArray();

        } else {

            return array();

        }

  }



  public function UpdateData($table, $where, $data) {



    $builder = $this->db->table($table);

    $builder->where($where);

    $builder->update($data);

   // echo $builder->last_query();die;

    return ($this->db->affectedRows() > 0)?true:true;

  }

  

  public function DeleteData($table, $where) {

    $builder = $this->db->table($table);

    $builder->where($where);

    $builder->delete();

    

    return ($this->db->affectedRows() > 0)?true:false;     

  }



  public function GetColumnName($table,$where=null,$name=null,$double=null,$order_by=null,$order_col=null,$group_by=null) {     

    $builder = $this->db->table($table);

    if($name){

      $builder->select(implode(',',$name));

    } else {

      $builder->select('*');

    }

    

    if($where){

      $builder->where($where);

    }

        

    if($group_by) {

      $builder->groupBy($group_by);

    }

    

    if($order_by && $order_col){

      $builder->orderBy($order_by,$order_col);

    }

    

    $query = $builder->get();

    if($double){

      $data = array();

    } else {

      $data = false;

    }



    if($query->getRow()){

      if($double){

        $data = $query->getResult();

      } else {

        $data = $query->getRow();

      } 

      

    }

    return $data;

  }

   public function SendMail($toz,$sub,$body) {



    //  $to =$toz;  

    //  $from ='';

    // $headers ="From: ".$admin[0]['mail_from_title']." <".$from."> \n";

    // $headers .= "MIME-Version: 1.0\n";

    // $headers .= "Content-type: text/html; charset=iso-8859-1 \n";

    // $subject =$sub;



    $config = array();

    $config['mailType'] = "html";

    $config['charset'] = "utf-8";

    $config['newline'] = "\r\n";

    $config['CRLF'] = "\r\n";

    $config['wordwrap'] = TRUE;

    $config['validate'] = FALSE;



    $this->email->initialize($config);

    

    $this->email->setFrom(Email, Project);

   

    $this->email->setTo($toz);

    //$this->email->setMailtype("html"); 

    $this->email->setSubject($sub);

    

    $msg = view('mail/common' ,['subject' =>$sub ,'body' =>$body ]);

        

    $this->email->setMessage($msg);

    

    $run  = $this->email->send();

    

    if($run) {

      return 1;

    } else {

      return 0;

    }



  }
  public function send_and_insert_notifi($table , $dataArr = array()){
    
        if(!empty($dataArr)){ 
           // print_r($dataArr); die;
            $other = (@$dataArr['other']) ? $dataArr['other'] : array('click_action' => base_url());
            $user = $this->GetSingleData('users' , ['id' => $dataArr['user_id'] ]);

            if ($dataArr['noti_type'] != 'all') 
            {
              if (@$user[$dataArr['noti_type']] == 0) {
                return false;
              }
            }
            if(isset($dataArr['device_id']) && !empty($dataArr['device_id']))
            {
              $user['device_id'] = $dataArr['device_id'];
            }
            $insert['user_id'] = $dataArr['user_id'];
            $insert['message'] = $dataArr['message'];
            //$insert['behalf_of'] = ($dataArr['behalf_of']) ? $dataArr['behalf_of'] : 0;
            $insert['type'] =($dataArr['type']) ? $dataArr['type'] : 0;
            $insert['other'] = serialize($other);
            $insert['is_read'] = $dataArr['is_read'];
            $insert['created_at'] = date('Y-m-d H:i:s');
            //$insert['updated_at'] = date('Y-m-d H:i:s');
      
            if(isset($dataArr['onlyPushNot']) && $dataArr['onlyPushNot']==true) {
                $run = true;
            } else {
                $run = $this->InsertData('notification',$insert);
            }
      
            if($run != null){
                if(isset($user['device_id']) && !empty($user['device_id'])){
            
                    $arr['title'] = $insert['message'];
                    $arr['deviceToken'] = $user['device_id'];
                    $arr['other'] = $other;
                    $this->AndroidNotification($arr);
										
										$user_device_ids = $this->GetColumnName('device_ids',['user_id'=>$dataArr['user_id']],['device_id'],true);
										//echo '<pre>';
										//print_r($user_device_ids); 
										
										if(!empty($user_device_ids)){
											foreach($user_device_ids as $user_device_id){
												if($user['device_id'] != $user_device_id->device_id){
													$arr['deviceToken'] = $user_device_id->device_id;
													$this->AndroidNotification($arr);
												}
												//array_push($device_ids,$user_device_id->device_id);
												
											}
										}
                }
                return true;
            } else {
                return false;
            }
        }
    }
    
    public function AndroidNotification($data = array()){
    if(!empty($data)){
			
			try {
				$signal_array['notification']=array(
					'body'=>$data['title']
				);
				
				$signal_array['webpush']=array(
					'fcm_options'=>array(
						'link'=>site_url()
					)
				);
				$signal_array['registration_ids']=[$data['deviceToken']];
				$signal_array['data']=$data['other'];
				$signal_array1=$signal_array;
				//print_r($signal_array1);
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => json_encode($signal_array1),
					CURLOPT_HTTPHEADER => array(
						"authorization: key=AAAAqNqBr8A:APA91bGlm6c5xNBuR9G3HNTxiARYxkzQbF5OtRGaOWuCkVVO7FY_nEdgaoPKPDdyMByBaBedjye8G-g_SHouBbtkQeoTEFsi5OX1EG2NxtwBNEclw4dZF2Eax0f-IQxGKp5j_9G5YKs6",
						"content-type: application/json"
					),
				));

				$response = curl_exec($curl);
				
				$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
				$txt = $response;
				fwrite($myfile, $txt);
				fclose($myfile);
				
				//print_r($signal_array1); print_r($response);
				
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
					return false;
				} else {
					return $response;
				}
			} catch (Exception $e){
				//print_r($e);
			}
    
      
    } else {
      return false;
    }
  }

    public function GetLatestPost($num='3')
  {
     $query = 'select t2.file , t1.title, t1.id from  (SELECT id,title FROM post ORDER BY id DESC LIMIT '.$num.') t1 left JOIN
    post_images t2 on t1.id=t2.post_id; ';
    $results = $this->db->query($query);
    return $results->getResult('array');
  }

  public function GetDMData($user_id)
  {
    $query = "select t3.*,IF(t3.sender = '".$user_id."',t3.receiver, t3.sender) client_id,IF(t3.sender = '".$user_id."',t5.`name`,t4.`name`) client_name, IFNULL(t6.unread_count,0) unread_count from 
    (SELECT
      t1.* 
    FROM
      chat t1
      RIGHT JOIN ( SELECT max( id ) max_id, thread_id FROM `chat` WHERE is_group = 0 AND thread_id LIKE '%".$user_id."%' GROUP BY thread_id ) t2 ON t1.id = t2.max_id 
      AND t1.thread_id = t2.thread_id) t3 left join users t4 on t3.sender = t4.id left join users t5 on t3.receiver = t5.id left join (select count(*) unread_count, thread_id from chat where is_read = 0 and sender != '".$user_id."' group by thread_id) t6 on t3.thread_id = t6.thread_id";
    $results = $this->db->query($query);
    return $results->getResult('array');

  }

  public function GetUsersByKey($key,$user_id){
    $query = "SELECT name,email FROM `users` where (LOWER(name) like '%".strtolower($key)."%' or LOWER(email) like '%".strtolower($key)."%') and id != '".$user_id."'";
    $results = $this->db->query($query);
    return $results->getResult('array');
  }

  public function getGroupInfo($user_id){
    $query = "select t3.*,t4.group_name,t4.create_date group_create_date from
    (select t2.* from
    (select *,max(id) max_id from chat where is_group = 1 and (sender = ".$user_id." or receiver = ".$user_id.") group by thread_id) t1 left join chat t2 on t1.max_id = t2.id) t3 left join groups t4 on t3.thread_id = t4.id";
    $results = $this->db->query($query);
    return $results->getResult('array');
  }

  public function UpdateReadBy($user_id,$group_id,$last_message_id)
  {
    $query = "UPDATE chat SET read_by = CONCAT( read_by, ',', '".$user_id."' ) WHERE id <= '".$last_message_id."' AND thread_id = '".$group_id."'  AND read_by NOT LIKE '%".$user_id."%'";
    $results = $this->db->query($query);
    return;
  }

}