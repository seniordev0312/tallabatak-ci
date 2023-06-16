<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\Common_model;
class CouponModel extends Model {

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

   function make_query($data)
   {
      $current_date = date('Y-m-d');
      $query = 'Select * FROM coupons WHERE status = 1';

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
    if(isset($data['search_keyword']) && !empty($data['search_keyword']))
      {
       $search = $data['search_keyword'];
       $query .= " AND (title LIKE '%".$search."%' OR description LIKE '%".$search."%' ) ";
      }
      if(isset($data['user_id']) && !empty($data['user_id']))
      {
         
         $query .= " AND user_id = ".$data['user_id']." ";
         
      }
       $query .= " AND date(end_date) >= date('".$current_date."')  ";
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
      
      $order_by = ' id desc';

      if (isset($data['sortby']) && !empty($data['sortby']) ) 
      {
         $expl = explode('_' , $data['sortby']);
         $obc = $expl[0];
         $ob = $expl[1];
         $order_by = $obc.' '.$ob;
      }
       $query .= ' ORDER BY '.$order_by.' LIMIT '.$start.', ' . $limit;
      
   // echo $query;

      //return $query;
      $data = $this->db->query($query);

      return view('loop/coupon', ['posts'=>$data->getResultArray() , 'col'=>'col-sm-6 col-xl-4']);
      
    }

}