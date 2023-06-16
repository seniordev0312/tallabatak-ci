<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Common_model;
require './google-translator/autoload.php';
use Stichoza\GoogleTranslate\GoogleTranslate;
class Search_model extends Model {

     public function __construct() {
        //parent::__construct();
       $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect(); 
        $this->email = \Config\Services::email();
        $this->common_model = new Common_model();
        $builder = $this->db->table('users');  
        $this->user_id =  $this->session->get('user_id'); 
        $this->user = $this->common_model->GetSingleData('users', array('id' => $this->user_id));  
    }

    function fetch_filter_type($type)
   {

    $this->builder->distinct();
    $this->builder->select($type);
    $this->builder->where('product_status', '1');
    $query = $builder->get();
    return $query->getResultArray();
   }
   function make_query($data)
   {
      $current_date = date('Y-m-d');
    
      $select = 'FROM (SELECT t1.*,t2.name FROM post t1 LEFT JOIN (SELECT id, name FROM users) t2 ON t1.user_id = t2.id) t3 WHERE';
      if (isset($data['search_lat']) && !empty($data['search_lat'])) 
      {
        $select = ', ( 3959 * acos( cos( radians('.$data['search_lat'].') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('.$data['search_lng'].') ) + sin( radians('.$data['search_lat'].') ) * sin( radians( lat ) ) ) ) AS distance FROM post HAVING distance < 25 AND ';
      }
      $query = "SELECT * $select  is_delete = 0 ";
      $minimum_price = @$data['min_price'];
      $maximum_price = @$data['max_price'];
      
       if(isset($minimum_price) && !empty($minimum_price))
       {
        $query .= " AND price >= ".$minimum_price;
       }
       if(isset($maximum_price) && !empty($maximum_price))
       {
        $query .= " AND price <= ".$maximum_price;
       }

      if(isset($data['category']) && !empty($data['category']))
      {
       $category = $data['category'];
       $query .= ' AND (';
       foreach ($category as $key => $value) {
        if (count($category) == $key +1 ) {
          $query .= " category = '".$value."' ";
        }
        else
        {
         $query .= "category = '".$value."' OR ";
        }
       }
       $query .= ') ';
      }
     

      if(isset($data['search_keyword']) && !empty($data['search_keyword']))
      {
       $search = $data['search_keyword'];
       $tr = new GoogleTranslate(); 
       $search_en = $tr->setSource()->setTarget('en')->translate($search);
       $search_ar = $tr->setSource()->setTarget('ar')->translate($search);
       $query .= " AND (title LIKE '%".$search_en."%' OR description LIKE '%".$search_en."%' OR name LIKE '%".$search_en."%' OR title LIKE '%".$search_ar."%' OR description LIKE '%".$search_ar."%' OR name LIKE '%".$search_ar."%') ";
      }

      if(isset($data['is_auction']) && !empty($data['is_auction']))
      {
         
         $query .= " AND post_type = 1 ";
         
      }

      if(isset($data['user_id']) && !empty($data['user_id']))
      {
         
         $query .= " AND user_id = ".$data['user_id']." ";
         
      }
      $query .= " AND (date(auction_expire_date) >= date('".$current_date."') OR auction_expire_date is null) ";
      // else
      // {
      //    $query .= " AND post_type = 1 ";
      // }

      
      //echo $query;
      return $query;
   }
   function count_all($data)
   {
      $query = $this->make_query($data);
      $data = $this->db->query($query);
      return $data->getNumRows();
   }
   function fetch_data($limit, $start, $data)
   {
      $query = $this->make_query($data);
      //$order_by = ' id desc';

  $query .= " ORDER BY CASE WHEN is_featured = 1 THEN created_at END desc";
  $query .= ", CASE WHEN is_featured = 0 THEN id END DESC";
      /*if (isset($data['sortby']) && !empty($data['sortby']) ) 
      {
         $expl = explode('_' , $data['sortby']);
         $obc = $expl[0];
         $ob = $expl[1];
         $order_by = $obc.' '.$ob;
      }*/
      $col = 'col-sm-6 col-xl-4';
      if(isset($data['user_id']) && !empty($data['user_id']))
      {
         $col = 'col-sm-6 col-xl-6';
      }
      $query .= ' LIMIT '.$start.', ' . $limit;
     // echo $query;

      //return $query;
      $data = $this->db->query($query);

      //print_r($data->getResultArray());
      return view('loop/post', ['posts'=>$data->getResultArray() , 'col'=>$col]);
      
    }

}