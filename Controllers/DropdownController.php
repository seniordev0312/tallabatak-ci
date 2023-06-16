<?php

namespace App\Controllers;
use App\Models\Common_model;
class DropdownController extends BaseController
{
    public function __construct() {   
        helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->common_model = new Common_model();
        $this->user_id =  $this->session->get('user_id');
        $this->user = $this->common_model->GetSingleData('users', array('id' => $this->user_id));
        

    } 
    public function fetchCity()
    {
        $data['cities'] = $this->common_model->GetAllData('cities' , ["state_id" => $_POST['state_id'] ] , 'name' , 'asc' , '' , ["name", "id"]);
        return json_encode($data);
    }

    public function fetchState()
    {
        $data['states'] = $this->common_model->GetAllData('states' , ["country_id" => $_POST['country_id'] ] , 'name' , 'asc' , '' , ["name", "id"]);
        return json_encode($data);
    }

}
