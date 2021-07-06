<?php

namespace App\Controllers;
use App\Models\Commonmodel;
use App\Models\Payrollmodel;
use App\Models\Allowancesmodel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class Payroll extends BaseController
{
 use ResponseTrait;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Karachi');
        $this->Payrollmodel = new Payrollmodel();
        $this->Commonmodel = new Commonmodel();
        $this->Allowancesmodel = new Allowancesmodel();

         helper(['form', 'url']);

     }
	public function index()
	{
         $payroll = $this->Payrollmodel->find($id);

	}
	public function detail($id)
	{
		$data['emp_id'] = $id;
	    return view('payroll/detail',$data);	
	}
	public function getPayrollByEmpID($id)
	{
        $payroll = $this->Payrollmodel->PayrollByEmpID($id); 
		return $this->response->setJSON($payroll);	
	}
	
	public function store($id)
	{
        $user_id = $_SESSION['user_id'];
		$rules = [
			'total_salary' => ['rules' => 'required', 'label' => 'Salary'],
		];
		 if (!$this->validate($rules)) {
             $errors = $this->validator->getErrors();
			return $this->fail($errors);
		}
		else{

        ////Deactivate the Recent Salary Head/////
        $Salary_Data = $this->Payrollmodel->checkActivatHead($id);
        if($Salary_Data!=[]){
        	$salary_id= $Salary_Data[0]['salary_id'];
        	$data = [
        	'salary_status'    =>'Deactived', 
        	'updated_by'       =>$user_id,
            ];
            $this->Payrollmodel->update($salary_id,$data);
        }
        ///////////////////////////////////////////
        $total_salary = $this->request->getVar('total_salary');
        $house_rent = (40/100) * $total_salary ;
        $utilities = (10/100) * $total_salary ;
        $basic_salary = $total_salary - ($house_rent + $utilities);
        //print_r($basic_salary);exit();

        $data = [
            'emp_id'               => $id,  	
            'basic_salary'         => $basic_salary,  	
            'house_rent'           => $house_rent,  	
            'utilities'            => $utilities,  	
            'total_salary'         => $total_salary,  	
        	'salary_start_date'    => $this->request->getVar('salary_start_date'),
		    'salary_end_date'      => $this->request->getVar('salary_end_date'),
		    'salary_status'        =>'Active',
		    'created_by'    =>$user_id,
		    
		];
		//Insert_id is salary_id of table payroll_salary_main//
		$insert_id = $this->Payrollmodel->insert($data);

	    //LOG Start//////////
		if($insert_id!=null){
        $salary_data = $this->Payrollmodel->PayrollBySalaryID($insert_id);
        $emp_id = ($salary_data[0]['emp_id']);
        $total_salary = ($salary_data[0]['total_salary']);
        $Employee_name = ($salary_data[0]['fname'].' '.$salary_data[0]['lname']);
        $date    = date('h:i:sa d-m-y');
        $user_id    = $_SESSION['user_id'];
		$user_name  = $_SESSION['user_name'];

        $log_event   = 'A  new Payroll Head has been Added in Employee Payroll';
        $log_narration  = 'A new payroll of Salary: '.$total_salary.' for employee ID:'.$emp_id.' has been Added By: '.$user_name.' of User ID:'.$user_id.' at '.$date ;
        $data = [
              'log_event'     => $log_event,
              'log_narration' => $log_narration,
              'employee_id'   => $emp_id,
              'created_by'    => $user_id,
        ];	
        $this->Commonmodel->Insert_record('saimtech_log',$data);
		}///LOG End//////////
        
		}
	}

	/////////////////////////Deduction And Allowances Functions//////////////////////////////

	public function getSalaryAllowances($id)
	{
        $salaryAllowances = $this->Payrollmodel->SalaryAllowances($id); 
		return $this->response->setJSON($salaryAllowances);
	}
	public function getSalaryDeductions($id)
	{
        $salaryDeductions = $this->Payrollmodel->SalaryDeductions($id); 
		return $this->response->setJSON($salaryDeductions);
	}
	Public function getAllAllowances(){
	    $allowances = $this->Commonmodel->Get_record_by_condition('allowances','allow_type','A');	
		return $this->response->setJSON($allowances);
	}
	Public function getAllDeductions(){
	    $deductions = $this->Commonmodel->Get_record_by_condition('allowances','allow_type','D');	
		return $this->response->setJSON($deductions);
	}
	public function createSalaryAllowance()
	{
		$user_id = $_SESSION['user_id'];
		$rules = [
		
			'salary_id' => ['rules' => 'required', 'label' => 'Salary ID'],
			'allow_id' => ['rules' => 'required', 'label' => 'Allowance'],
			'allow_amount' => ['rules' => 'required|greater_than[0]|is_natural_no_zero', 'label' => 'Allowance Amount'],

		];

		 if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
			return $this->fail($errors);
		}
		else{
	        $data = [ 	
	        	'salary_id'    => $this->request->getVar('salary_id'),
			    'allow_id'      => $this->request->getVar('allow_id'),
			    'allow_amount'      => $this->request->getVar('allow_amount'),
			    'created_by'    =>$user_id,
			    
			];
		$insert_id = $this->Commonmodel->Insert_record('payroll_salary_detail',$data);

		////////////////Log Start////////////////////////////////////
        if($insert_id!=""){
        $detail_data= $this->Payrollmodel->salaryDetailByID($insert_id); 
        $allow_name = ($detail_data[0]['allow_name']);
        $allow_type = ($detail_data[0]['allow_type']);
        $allow_amount = ($detail_data[0]['allow_amount']);
        $emp_id = ($detail_data[0]['emp_id']);
        $date    = date('h:i:sa d-m-y');
        $user_id    = $_SESSION['user_id'];
		$user_name  = $_SESSION['user_name'];

        $log_event   = $allow_name.' has been Added in Employee Payroll';
        $log_narration  = 'Name: '.$allow_name. ' type: (' .$allow_type.') Amount:'.$allow_amount.' of employee ID:'.$emp_id.' has been Added By: '.$user_name.' of User ID:'.$user_id.' at '.$date ;
        $data = [
              'log_event'     => $log_event,
              'log_narration' => $log_narration,
              'employee_id'   => $emp_id,
              'created_by'    => $user_id,
        ];	
        $this->Commonmodel->Insert_record('saimtech_log',$data);
        }/////////////LOG END/////////////////////////////////
		}
	}
	public function deleteSalaryAllowance($id)
	{
		/////////////////LOG Start//////////////////////////////
        $detail_data= $this->Payrollmodel->salaryDetailByID($id); 
        $allow_name = ($detail_data[0]['allow_name']);
        $allow_type = ($detail_data[0]['allow_type']);
        $allow_amount = ($detail_data[0]['allow_amount']);
        $emp_id = ($detail_data[0]['emp_id']);
        $date    = date('h:i:sa d-m-y');
        $user_id    = $_SESSION['user_id'];
		$user_name  = $_SESSION['user_name'];

        $log_event   = $allow_name.' has been Deleted in Employee Payroll';
        $log_narration  = 'Name: '.$allow_name. ' type: (' .$allow_type.') Amount:'.$allow_amount.' of employee ID:'.$emp_id.' has been Deleted By: '.$user_name.' of User ID:'.$user_id.' at '.$date ;
        $data = [
              'log_event'     => $log_event,
              'log_narration' => $log_narration,
              'employee_id'   => $emp_id,
              'created_by'    => $user_id,
        ];
        ///////////////////////////////////////////////////////////////////
        $response = $this->Commonmodel->Delete_record('payroll_salary_detail','detail_id',$id);
        if($response == true){
        $this->Commonmodel->Insert_record('saimtech_log',$data);
        }
	}
}
