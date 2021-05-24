<?php

namespace App\Controllers;
use App\Models\DepartmentModel;
use App\Models\Commonmodel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class Department extends BaseController
{
	use ResponseTrait;
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Karachi');
        $this->DepartmentModel = new DepartmentModel();
        $this->Commonmodel = new Commonmodel();
         helper(['form', 'url']);
         $session = \Config\Services::session();
    }
	public function index()
	{
		$departments = $this->DepartmentModel->orderBy('depid', 'DESC')->findAll();
		return view('departments/index');
	}	
	public function getAllDepartments()
	{
		$departments = $this->DepartmentModel->orderBy('depid', 'DESC')->find();
		return $this->response->setJSON($departments);
	}
	public function store()
	{
		$user_id = $_SESSION['user_id'];
		$rules = [
		
			'department_name' => ['rules' => 'required|min_length[2]|max_length[250]|is_unique[saimtech_departments.department_name]', 'label' => 'Department Name'],

		];

		 if (!$this->validate($rules)) {
             $errors = $this->validator->getErrors();
			return $this->fail($errors);
		}
		else{
        $data = [
        	'department_name'    => $this->request->getVar('department_name'),		    
		];
		$this->DepartmentModel->insert($data);
		}
	}
	public function search(){
		$searchkeyword = $this->request->getVar('s');
		$search = $this->DepartmentModel->getSearchData($searchkeyword);
		return $this->response->setJSON($search);
	}
}
