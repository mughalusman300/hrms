<?php

namespace App\Models;

use CodeIgniter\Model;

class Documentmodel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'saimtech_document';
	protected $primaryKey           = 'doc_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['emp_id','doc_type','doc_name','doc_description','doc_path'];

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
	 $query  =$this->db->table('saimtech_document')
	 ->join('saimtech_employees', 'saimtech_employees.emp_id = saimtech_document.emp_id', 'inner')
	         ->like('doc_name',$match)
	         ->orLike('fname',$match)
	         ->orLike('lname',$match)
             ->get()
             ->getResultArray();	
    return $query;       
	}
	public function getAllDocuments()
	{
	 $query  =$this->db->table('saimtech_document')
	 ->join('saimtech_employees', 'saimtech_employees.emp_id = saimtech_document.emp_id', 'inner')
	         ->orderBy('doc_id', 'DESC')
             ->get()
             ->getResultArray();	
    return $query;       
	}
}
