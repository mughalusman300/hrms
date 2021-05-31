<?php

namespace App\Controllers;

use App\Models\DesignationModel;
use App\Models\Commonmodel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class Designation extends BaseController
{
	use ResponseTrait;
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Karachi');
        $this->DesignationModel = new DesignationModel();
        $this->Commonmodel = new Commonmodel();
         helper(['form', 'url']);
         $session = \Config\Services::session();
    }
	public function index()
	{
		return view('designation/index');
	}
	public function getAllDesignations()
	{
		$designations = $this->DesignationModel->orderBy('desid', 'DESC')->find();
		return $this->response->setJSON($designations);
	}
	public function store()
	{
		// echo "done";
		// exit();
		$user_id = $_SESSION['user_id'];
		$rules = [
		
			'designation_name' => ['rules' => 'required|min_length[2]|max_length[250]', 'label' => 'Designation Name'],

		];

		 if (!$this->validate($rules)) {
             $errors = $this->validator->getErrors();
			return $this->fail($errors);
		}
		else{
        $data = [
        	'designation_name'    => $this->request->getVar('designation_name'),		    
		];
		$this->DesignationModel->save($data);
		return $this->respondCreated($data);
		}
	}
	public function search(){
		$searchkeyword = $this->request->getVar('s');
		$search = $this->DesignationModel->getSearchData($searchkeyword);
		return $this->response->setJSON($search);
	}
}
