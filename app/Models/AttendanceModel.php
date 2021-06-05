<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'employee_attendance';
	protected $primaryKey           = 'att_id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['date','emp_id','emp_attendance_type_id','remarks'];

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
	//and employee_attendance.date =".$date."
    public function searchAttendenceDepartmentType($department_type,$date,$shift){

     if ($department_type == "select") {	
	    $query ="Select employee_attendance.att_id as id,employee_attendance.emp_attendance_type_id,employee_attendance.remark,CONCAT(saimtech_employees.fname,' ',saimtech_employees.lname) as fname,saimtech_designations.designation_name,saimtech_departments.department_name,IFNULL(employee_attendance.date, 'xxx') as date,  IFNULL(employee_attendance.att_id, 0) as id,saimtech_employees.emp_id from saimtech_employees
	        left join saimtech_departments on saimtech_departments.depid = saimtech_employees.department_id
	        left join saimtech_designations on saimtech_designations.desid = saimtech_employees.designation_id
	        left join employee_attendance on (employee_attendance.emp_id =saimtech_employees.emp_id) and 
	            employee_attendance.date =".$this->db->escape($date)."
	            where saimtech_employees.emp_status='active' and saimtech_employees.shift=".$this->db->escape($shift)."order by saimtech_departments.department_name";
	}
	else{
		$query ="Select employee_attendance.att_id as id,employee_attendance.emp_attendance_type_id,employee_attendance.remark,CONCAT(saimtech_employees.fname,' ',saimtech_employees.lname) as fname,saimtech_designations.designation_name,saimtech_departments.department_name,IFNULL(employee_attendance.date, 'xxx') as date,  IFNULL(employee_attendance.att_id, 0) as id,saimtech_employees.emp_id from saimtech_employees
	        left join saimtech_departments on saimtech_departments.depid = saimtech_employees.department_id
	        left join saimtech_designations on saimtech_designations.desid = saimtech_employees.designation_id
	        left join employee_attendance on (employee_attendance.emp_id =saimtech_employees.emp_id) and 
	            employee_attendance.date =".$this->db->escape($date)."
	            where saimtech_employees.department_id='" .$department_type."'  and saimtech_employees.emp_status='active' and saimtech_employees.shift=".$this->db->escape($shift)."order by saimtech_departments.department_name";

	}
	    $res = $this->db->query($query);
	    return $res->getResultArray();
    }
    public function searchAttendanceReport($department_type,$date,$shift)
    {
    	if ($department_type == "select") {	
	    $query ="Select employee_attendance.emp_attendance_type_id,employee_attendance.remark,CONCAT(saimtech_employees.fname,' ',saimtech_employees.lname) as name,employee_attendance_type.type as `att_type`,employee_attendance_type.key_value as `key`,saimtech_designations.designation_name,saimtech_departments.department_name,IFNULL(employee_attendance.date, 'xxx') as date,  IFNULL(employee_attendance.att_id, 0) as attendence_id,saimtech_employees.emp_id as id from 
	        saimtech_employees
	        left join employee_attendance on (employee_attendance.emp_id =saimtech_employees.emp_id) and 
	            employee_attendance.date =".$this->db->escape($date)."
	        left join employee_attendance_type on employee_attendance_type.id = employee_attendance.emp_attendance_type_id    
	        left join saimtech_departments on saimtech_departments.depid = saimtech_employees.department_id
	        left join saimtech_designations on saimtech_designations.desid = saimtech_employees.designation_id
	            where saimtech_employees.emp_status='active' and saimtech_employees.shift=".$this->db->escape($shift)."order by saimtech_departments.department_name";
	}
	else{
		$query ="Select employee_attendance.emp_attendance_type_id,employee_attendance.remark,CONCAT(saimtech_employees.fname,' ',saimtech_employees.lname) as name,employee_attendance_type.type as `att_type`,employee_attendance_type.key_value as `key`,saimtech_designations.designation_name,saimtech_departments.department_name,IFNULL(employee_attendance.date, 'xxx') as date,  IFNULL(employee_attendance.att_id, 0) as attendence_id,saimtech_employees.emp_id as id from
		    saimtech_employees
	        left join employee_attendance on (employee_attendance.emp_id =saimtech_employees.emp_id) and 
	            employee_attendance.date =".$this->db->escape($date)."
	        left join employee_attendance_type on employee_attendance_type.id = employee_attendance.emp_attendance_type_id     
	        left join saimtech_departments on saimtech_departments.depid = saimtech_employees.department_id
	        left join saimtech_designations on saimtech_designations.desid = saimtech_employees.designation_id
	            where saimtech_employees.department_id='" .$department_type."'  and saimtech_employees.emp_status='active' and saimtech_employees.shift=".$this->db->escape($shift)."order by saimtech_departments.department_name";

	}
	    $res = $this->db->query($query);
	    return $res->getResultArray();
    }
    public function getEmployeeAttendanceType()
    {
    	$query = $this->db->table('employee_attendance_type')
             ->get()
             ->getResultArray();
        return $query;

    }
    public function add($data)

    {
    if (isset($data['att_id'])) {
    	//echo"<pre>";print_r($data);exit();
            $this->db->table('employee_attendance')
             ->where('att_id',$data['att_id'] )
             ->update($data); 
    return $this->db->affectedRows();

    } 
    else {	
     $this->db->table("employee_attendance")->insert($data);  
    return $this->db->insertID();
    }
    }
    public function attendanceYearCount() {
        $query ="select distinct year(date) as year from employee_attendance";
	    $res = $this->db->query($query);
	    return $res->getResultArray();

    }
    public function count_attendance_obj($month, $year, $employee_id, $attendance_type = 1) {

       $query = "SELECT * FROM employee_attendance WHERE emp_id =".$this->db->escape($employee_id)." AND  MONTH(date) = ".$this->db->escape($month)." AND YEAR(date) = ".$this->db->escape($year)." AND emp_attendance_type_id=".$this->db->escape($attendance_type)."";
       $res = $this->db->query($query);
	    return $res->getNumRows();
    }
      
}
