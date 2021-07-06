<?php

namespace App\Models;

use CodeIgniter\Model;

class Payrollmodel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'payroll_salary_main';
	protected $primaryKey           = 'salary_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['emp_id','basic_salary','house_rent','utilities','total_salary','salary_status','created_by','updated_by'];

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

	public function PayrollByEmpID($id){
    $query = $this->db->table('payroll_salary_main')
             ->join('saimtech_employees', 'saimtech_employees.emp_id = payroll_salary_main.emp_id', 'inner')
             ->where('payroll_salary_main.emp_id', $id)
             ->get()
             ->getResult();
    return $query;
    }
    public function PayrollBySalaryID($id){
    $query = $this->db->table('payroll_salary_main')
             ->join('saimtech_employees', 'saimtech_employees.emp_id = payroll_salary_main.emp_id', 'inner')
             ->where('payroll_salary_main.salary_id', $id)
             ->get()
             ->getResultArray();
    return $query;
    }
    public function checkActivatHead($id){
    $query = $this->db->table('payroll_salary_main')
             ->where('emp_id', $id)
             ->where('salary_status', 'Active')
             ->get()
             ->getResultArray();
    return $query;	
    }

/////////////////////////Deduction And Allowances Functions//////////////////////////////
    public function SalaryAllowances($id){
    $query = $this->db->table('payroll_salary_detail')
             ->join('allowances', 'allowances.allow_id = payroll_salary_detail.allow_id', 'inner')
             ->where('payroll_salary_detail.salary_id', $id)
             ->where('allowances.allow_type', 'A')
             ->get()
             ->getResult();
    return $query;	
    }
    public function SalaryDeductions($id){
    $query = $this->db->table('payroll_salary_detail')
             ->join('allowances', 'allowances.allow_id = payroll_salary_detail.allow_id', 'inner')
             ->where('payroll_salary_detail.salary_id', $id)
             ->where('allowances.allow_type', 'D')
             ->get()
             ->getResult();
    return $query;	
    }
    public function salaryDetailByID($id){
    $query = $this->db->table('payroll_salary_detail')
             ->join('payroll_salary_main', 'payroll_salary_main.salary_id = payroll_salary_detail.salary_id', 'inner')
             ->join('allowances', 'allowances.allow_id = payroll_salary_detail.allow_id', 'inner')
             ->where('payroll_salary_detail.detail_id', $id)
             ->get()
             ->getResultArray();
    return $query;	
    }
}
