<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','title','first_name','last_name','email','image','username','linkedin_id','prononus','state','city','street_address','about_me','my_skills','free_time_act','dumbest_act','category','career_goals','privacy_status','status','token'];
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}