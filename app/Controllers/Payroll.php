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
		
			'salary_start_date' => ['rules' => 'required', 'label' => 'Start Date'],
			'salary_end_date' => ['rules' => 'required', 'label' => 'End Date'],

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
            ];
            $this->Payrollmodel->update($salary_id,$data);
        }
        ///////////////////////////////////////////
        $data = [
            'emp_id'               => $id,  	
        	'salary_start_date'    => $this->request->getVar('salary_start_date'),
		    'salary_end_date'      => $this->request->getVar('salary_end_date'),
		    'salary_status'        =>'Active',
		    'created_by'    =>$user_id,
		    
		];
		$this->Payrollmodel->insert($data);
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
			'allow_amount' => ['rules' => 'required|is_natural_no_zero', 'label' => 'Allowance Amount'],

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
		$this->Commonmodel->Insert_record('payroll_salary_detail',$data);
		}
	}
	public function deleteSalaryAllowance($id)
	{
		$this->Commonmodel->Delete_record('payroll_salary_detail','detail_id',$id);
	}
	
	
}
