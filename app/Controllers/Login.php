<?php

namespace App\Controllers;
use App\Models\Commonmodel;
use CodeIgniter\API\ResponseTrait;

class Login extends BaseController
{
    use ResponseTrait;    
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger){
    helper('form');
    parent::initController($request, $response, $logger);
    date_default_timezone_set('Asia/Karachi');
    $this->Commonmodel = new Commonmodel();
    $session = \Config\Services::session();
    }
    
	public function index(){
	$data['error'] ='';	
	return view('users/loginView',$data);
	}
	
	public function login_process(){

	$email       =  $this->request->getVar('email');
	$password       =  $this->request->getVar('password');
	$data['error'] ='';
		if($email!="" && $password!=""){
		$user_data=$this->Commonmodel->Get_record_by_double_condition_array('saimtech_users', 'saimtech_email', $email, 'is_enable', '1'); 
	    if(!empty($user_data)){
		if($user_data[0]['saimtech_password']==($password)){
		$_SESSION['user_id']    = $user_data[0]['id'];
		$_SESSION['user_name']  = $user_data[0]['saimtech_uname'];
		$_SESSION['user_power']  = $user_data[0]['saimtech_power'];
		return redirect()->to('/Home'); 
		} else {
			 $data['error'] ='Invalid password';
	         return view('users/loginView',$data);
		       }    
		} 
		else {
	        $data['error'] ='Invalid Email';
	         return view('users/loginView',$data);
		   }
		}
		else {
		    $data['error'] ='Please enter the Email and Password Correctly';
	         return view('users/loginView',$data);    
		}
	}
	public function logout(){
	$data['error'] ='';	
	session_destroy();
	return redirect()->to('/');
	}
	
    
}
