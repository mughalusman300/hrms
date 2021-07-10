<?php

namespace App\Controllers;
use App\Models\DepartmentModel;
use App\Models\LeaveTypesModel;
use App\Models\Commonmodel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class LeaveTypes extends BaseController
{
	use ResponseTrait;
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Karachi');
        $this->DepartmentModel = new DepartmentModel();
        $this->LeaveTypesModel = new LeaveTypesModel();
        $this->Commonmodel = new Commonmodel();
         helper(['form', 'url']);
         $session = \Config\Services::session();
    }
	public function index()
	{
		$departments = $this->LeaveTypesModel->orderBy('id', 'DESC')->findAll();
		return view('leaves/types');
	}	
	public function getAllLeaveTypes()
	{
		$leave_types = $this->LeaveTypesModel->orderBy('id', 'DESC')->findAll();
		return $this->response->setJSON($leave_types);
	}
	public function createLeaveTypes()
	{
		$user_id = $_SESSION['user_id'];
		$rules = [
		
			'type' => ['rules' => 'required|min_length[2]|max_length[250]|is_unique[leave_types.type]', 'label' => 'Leave Type'],
			'days' => ['rules' => 'required|greater_than[0]|is_natural_no_zero', 'label' => 'Days'],

		];

		 if (!$this->validate($rules)) {
             $errors = $this->validator->getErrors();
			return $this->fail($errors);
		}
		else{
        $data = [
        	'type'    => $this->request->getVar('type'),		    
        	'days'    => $this->request->getVar('days'),		    
        	'is_active'    => 'Yes',		    
		];
		$this->LeaveTypesModel->insert($data);
		}
	}
}
