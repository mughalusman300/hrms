<?php

namespace App\Controllers;
use App\Models\Usermodel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class User extends BaseController
{
 use ResponseTrait;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Karachi');
        $this->Usermodel = new Usermodel();
         helper(['form', 'url']);
         $session = \Config\Services::session();

     }
	public function index()
	{
         $user = $this->Usermodel->find();

		return view('users/index');
	}
	public function getAllUsers()
    {

        $user = $this->Usermodel->orderBy('id', 'DESC')->find();
   
        return $this->response->setJSON($user);
    }
	public function store()
	{
		helper('form');
		$data = [];
		$rules = [
			'name' => ['rules' => 'required|min_length[3]|max_length[20]', 'label' => 'Name'],
			'email' => 'required|valid_email|is_unique[saimtech_users.saimtech_email],',
			'password' => 'required|min_length[8]',
			'company_id' => ['rules' => 'required', 'label' => 'company_id'],
			'user_power' => ['rules' => 'required', 'label' => 'user_power'],
		];

		 if (!$this->validate($rules)) {
             $errors = $this->validator->getErrors();
			return $this->fail($errors);
		}
		else{
        $data = [
        	'saimtech_comp_id'    => $this->request->getVar('company_id'),
		    'saimtech_uname' => $this->request->getVar('name'),
		    'saimtech_password'    => $this->request->getVar('password'),
		    'saimtech_email'    => $this->request->getVar('email'),
		    'saimtech_power'    => $this->request->getVar('user_power')
		    
		];
		$this->Usermodel->insert($data);
		}
	}
	public function register()
	{
		return view('users/registerView');
	}
	public function login()
	{
		return view('users/loginView');
	}
	public function loginValidation()
	{
		// return redirect()->to('addemployee');
 
	}
	public function update($id){
		helper('form');
		$data = [];
		$rules = [
			'name' => ['rules' => 'required|min_length[3]|max_length[20]', 'label' => 'Name'],
			'email' => 'required|valid_email|is_unique[saimtech_users.saimtech_email,id,{id}]',
			'password' => 'required|min_length[8]',
			'company_id' => ['rules' => 'required', 'label' => 'company_id'],
			'user_power' => ['rules' => 'required', 'label' => 'user_power'],
		];

		 if (!$this->validate($rules)) {
             $errors = $this->validator->getErrors();
			return $this->fail($errors);
		}
		else{
        $data = [
        	'saimtech_comp_id'    => $this->request->getVar('company_id'),
		    'saimtech_uname' => $this->request->getVar('name'),
		    'saimtech_password'    => $this->request->getVar('password'),
		    'saimtech_email'    => $this->request->getVar('email'),
		    'saimtech_power'    => $this->request->getVar('user_power')
		    
		];
		$this->Usermodel->update($id,$data);
		}
	}
	public function delete($id)
	{
		 $this->Usermodel->where('id', $id)->delete();
		 return $this->respondDeleted(['id' => $id]);
	}
	public function search(){
		$searchkeyword = $this->request->getVar('s');
		$search = $this->Usermodel->getSearchData($searchkeyword);
		return $this->response->setJSON($search);
	}
	public function unauthorized(){
		return view('users/403');
	}
	public function edit()
	{
		$user = $this->Usermodel->find(5);
        echo"<pre>";print_r($user);exit();

	}
}
