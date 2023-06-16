<?php namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{

    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','group_name','create_by','members','description','icon','create_date'];
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}