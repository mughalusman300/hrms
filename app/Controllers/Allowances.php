<?php

namespace App\Controllers;
use App\Models\Allowancesmodel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class Allowances extends BaseController
{
 use ResponseTrait;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Karachi');
        $this->Allowancesmodel = new Allowancesmodel();
         helper(['form', 'url']);

     }
	public function index()
	{
         //$user = $this->Usermodel->find();

		return view('allowances/index');
	}
	public function getAllAllowances()
    {

        $allowances = $this->Allowancesmodel->orderBy('allow_type', 'asc')
                      ->find();
   
        return $this->response->setJSON($allowances);
    }
    public function store()
	{
		$user_id = $_SESSION['user_id'];
		$rules = [
		
			'allow_name' => ['rules' => 'required|min_length[3]|max_length[300]|is_unique[allowances.allow_name]', 'label' => 'Allowance Name'],
			'allow_type' => ['rules' => 'required|min_length[1]|max_length[1]', 'label' => 'Allowance Type'],

		];

		 if (!$this->validate($rules)) {
             $errors = $this->validator->getErrors();
			return $this->fail($errors);
		}
		else{
        $data = [
        	'allow_name'    => $this->request->getVar('allow_name'),
		    'allow_type'    => $this->request->getVar('allow_type'),
		    'created_by'    =>$user_id,
		    
		];
		$this->Allowancesmodel->insert($data);
		}
	}
	public function update($id){
		$user_id = $_SESSION['user_id'];
		$rules = [
			'allow_name' => ['rules' => 'required|min_length[3]|max_length[250]', 'label' => 'Allowance Name'],
			'allow_type' => ['rules' => 'required|min_length[1]|max_length[1]', 'label' => 'Allowance Type'],

		];

		 if (!$this->validate($rules)) {
             $errors = $this->validator->getErrors();
			return $this->fail($errors);
		}
		else{
        $data = [
        	'allow_name'    => $this->request->getVar('allow_name'),
		    'allow_type'    => $this->request->getVar('allow_type'),
		    'updated_by'    =>$user_id,
		    
		];
		$this->Allowancesmodel->update($id,$data);
		}
	}
	public function search(){
		$searchkeyword = $this->request->getVar('s');
		$search = $this->Allowancesmodel->getSearchData($searchkeyword);
		return $this->response->setJSON($search);
	}
	
}
