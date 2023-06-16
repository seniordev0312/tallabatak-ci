<?php namespace App\Models;

use CodeIgniter\Model;

class ContentModel extends Model
{
    protected $table = 'content_management';
    protected $primaryKey = 'id';
    protected $allowedFields = ['page','content'];
}