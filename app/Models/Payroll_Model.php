<?php

namespace App\Models;

use CodeIgniter\Model;

class Payroll_Model extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'employee_payslip';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = [];

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
    public function searchEmployee($month, $year, $emp_name,$shift, $dep_type_id){
        if (!empty($dep_type_id)) {
        $query ="Select employee_payslip.status, 
        IFNULL(employee_payslip.id, 0) as payslip_id,saimtech_employees.*,saimtech_departments.department_name as department,saimtech_designations.designation_name as designation from saimtech_employees
            left join employee_payslip on saimtech_employees.emp_id = employee_payslip.emp_id and month = '" . $month . "' and year = '" . $year . "' 
            left join saimtech_departments on saimtech_departments.depid = saimtech_employees.department_id
            left join saimtech_designations on saimtech_designations.desid = saimtech_employees.designation_id
            where saimtech_employees.emp_status='active' and saimtech_departments.depid=".$this->db->escape($dep_type_id)." and saimtech_employees.shift=".$this->db->escape($shift)."order by saimtech_departments.department_name";
        }
        else{
        $query ="Select employee_payslip.status, 
        IFNULL(employee_payslip.id, 0) as payslip_id,saimtech_employees.*,saimtech_departments.department_name as department,saimtech_designations.designation_name as designation from saimtech_employees
            left join employee_payslip on saimtech_employees.emp_id = employee_payslip.emp_id and month = '" . $month . "' and year = '" . $year . "' 
            left join saimtech_departments on saimtech_departments.depid = saimtech_employees.department_id
            left join saimtech_designations on saimtech_designations.desid = saimtech_employees.designation_id
            where saimtech_employees.emp_status='active' and saimtech_employees.shift=".$this->db->escape($shift)."order by saimtech_departments.department_name";
        }
        $res = $this->db->query($query);
        return $res->getResultArray();
    }
    public function searchEmployeeById($id){
    $query ="Select saimtech_employees.*,saimtech_departments.department_name as department,saimtech_designations.designation_name as designation from saimtech_employees
            left join saimtech_departments on saimtech_departments.depid = saimtech_employees.department_id
            left join saimtech_designations on saimtech_designations.desid = saimtech_employees.designation_id
            where saimtech_employees.emp_id=".$this->db->escape($id)."";
        $res = $this->db->query($query);
        return $res->getResultArray();
    }
    public function checkPayslip($month, $year, $emp_id) {
        $query = $this->db->table('employee_payslip')
             ->where(array('month' => $month, 'year' => $year, 'emp_id' => $emp_id))
             ->get()->getNumRows();
        if ($query > 0) {
            return false;
        } else {
            return true;
        }
    }
    public function createPayslip($data) {
        if (isset($data['id'])) {
            $this->db->table('employee_payslip')
             ->where('id', $data['id'])
             ->update($data);

        } else {
            $this->db->table('employee_payslip')->insert($data);  
            return $this->db->insertID();
        }
    }
    public  function add_allowance($data) {
        if (isset($data['id'])) {
            $this->db->table('payslip_allowance')
             ->where('id', $data['id'])
             ->update($data);
        } else {
            $this->db->table('payslip_allowance')->insert($data);  
            return $this->db->insertID();
        }

    }
    public function searchPayment($id, $month, $year) {
        $query  =$this->db->table('saimtech_employees')
        ->select('saimtech_employees.fname,saimtech_employees.lname,saimtech_employees.emp_id as employee_id,saimtech_employees.emp_card_id,employee_payslip.*')
        ->join("employee_payslip", "saimtech_employees.emp_id = employee_payslip.emp_id", "inner")
        ->where(array('employee_payslip.month' => $month, 'employee_payslip.year' => $year, 'employee_payslip.emp_id' => $id))
        ->get()
        ->getResultArray();    
    return $query;
    }
    public function paymentSuccess($data, $payslipid) {
        $this->db->table('employee_payslip')
             ->where('id', $payslipid)
             ->update($data); 
    return $this->db->affectedRows(); 
    }
    public function getPayslip($id) {
        $query  =$this->db->table('employee_payslip')
        ->select('saimtech_employees.fname,saimtech_employees.lname,saimtech_departments.department_name as department,saimtech_designations.designation_name as designation,saimtech_employees.emp_id as employee_id,saimtech_employees.emp_card_id ,employee_payslip.*,payroll_salary_main.*')
        ->join("saimtech_employees", "saimtech_employees.emp_id = employee_payslip.emp_id", "inner")
        ->join("saimtech_designations", "saimtech_employees.designation_id = saimtech_designations.desid", "inner")
        ->join("saimtech_departments", "saimtech_employees.department_id = saimtech_departments.depid", "inner")
        ->join("payroll_salary_main", "payroll_salary_main.emp_id = employee_payslip.emp_id", "left")
        ->where("employee_payslip.id", $id)
        ->get()
        ->getResultArray();    
    return $query;
    }
    public function getAllowance($id, $type ) {
         
     
        if (!empty($type)) {
            // echo"<pre>";print_r($type);exit();
            $query  =$this->db->table('payslip_allowance')
            ->select('allowance_type,amount,cal_type')
            ->where(array('payslip_id' => $id, 'cal_type' => $type))
            ->get()
            ->getResultArray();
        } else {
            $query  =$this->db->table('payslip_allowance')
            ->select('allowance_type,amount,cal_type')
            ->where("payslip_id", $id)
            ->get()
            ->getResultArray();
        }
        return  $query;
    }
    public function Delete_record($tablename, $columnname, $conditionvalue){
    $this->db->table($tablename)
             ->where($columnname, $conditionvalue)
             ->delete();
    return true; 
    }
    public function deletePayslip($payslipid) {
    $this->db->table('employee_payslip')
             ->where('id', $payslipid)
             ->delete();
    $this->db->table('payslip_allowance')
             ->where('payslip_id', $payslipid)
             ->delete();         
    return true;
    }  
    public function revertPayslipStatus($payslipid) {
    $data = array('status' => "generated");
    $this->db->table('employee_payslip')
             ->where('id', $payslipid)
             ->update($data); 
    return $this->db->affectedRows();
    }
    public function searchEmployeeSalaryMainById($id) {
    $query  =$this->db->table('payroll_salary_main')
        ->select('payroll_salary_main.*,sum(payroll_salary_detail.allow_amount) as allowances')
        ->join("payroll_salary_detail", "payroll_salary_detail.salary_id = payroll_salary_main.salary_id", "left")
        ->where("payroll_salary_main.salary_status", "Active")
        ->where("emp_id", $id)
        ->get()
        ->getResultArray(); 
         return $query;
    }   
    public function searchEmployeeAllowances($id) {
    $query  =$this->db->table('payroll_salary_main')
        ->select('payroll_salary_main.*,allowances.allow_name,payroll_salary_detail.allow_amount')
        ->join("payroll_salary_detail", "payroll_salary_detail.salary_id = payroll_salary_main.salary_id", "inner")
        ->join("allowances", "allowances.allow_id = payroll_salary_detail.allow_id", "inner")
        ->where("payroll_salary_main.salary_status", "Active")
        ->where("emp_id", $id)
        ->get()
        ->getResultArray(); 
         return $query;
    }  

}
