<?php

namespace App\Models;

use CodeIgniter\Model;

class Allowancesmodel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'allowances';
	protected $primaryKey           = 'allow_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['allow_name','allow_type'];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	public function db(){
	  return $db      = \Config\Database::connect();  
	}

	public function getSearchData($match)
	{
	 $query  =$this->db->table('allowances')
	         ->like('allow_name',$match)
	         // ->orLike('lname',$match)
	         // ->orLike('email',$match)
             ->get()
             ->getResultArray();	
    return $query;       
	}
}
