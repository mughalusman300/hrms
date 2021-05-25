<?php

namespace App\Models;

use CodeIgniter\Model;

class Employeemodel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'saimtech_employees';
	protected $primaryKey           = 'emp_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['fname', 'lname', 'father_name', 'cnic', 'email', 'contact_no', 'gender', 'marital_status', 'blood_group', 'dob', 'family_members', 'emergency_contact_no', 'emergency_contact_relation', 'image', 'city', 'province', 'address', 'designation_id', 'department_id', 'category', 'division_id', 'company_id', 'doj', 'reporting_area', 'reporting_region', 'machine_id', 'shift', 'rank', 'education_type', 'education', 'previous_comp', 'previous_comp_designation', 'experience', 'bank_name', 'account_title', 'account_no', 'account_iban', 'ntn', 'is_taxable', 'is_flag', 'falg_color', 'flag_reason', 'created_by'];

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
	 $query  =$this->db->table('saimtech_employees')
	         ->like('fname',$match)
	         ->orLike('lname',$match)
	         ->orLike('email',$match)
             ->get()
             ->getResultArray();	
    return $query;       
	}
	public function allEmployees()
	{
		$query  =$this->db->table('saimtech_employees')
	 ->join('saimtech_designations', 'saimtech_employees.designation_id = saimtech_designations.desid', 'inner')
	         ->orderBy('emp_id', 'DESC')
             ->get()
             ->getResultArray();	
    return $query; 
	}
	public function detailByID($id)
	{
		$query  =$this->db->table('saimtech_employees')
	 ->join('saimtech_designations', 'saimtech_employees.designation_id = saimtech_designations.desid', 'inner')
	 ->join('saimtech_departments', 'saimtech_employees.department_id = saimtech_departments.depid', 'inner')
	         ->where('emp_id',$id)
             ->get()
             ->getResultArray();	
    return $query; 
	}
}
