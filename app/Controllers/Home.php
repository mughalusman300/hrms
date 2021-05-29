<?php

namespace App\Controllers;
use App\Models\Commonmodel;
use CodeIgniter\API\ResponseTrait;
class Home extends BaseController
{
	use ResponseTrait;
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Karachi');
        $this->Commonmodel = new Commonmodel();
    }
	public function index()
	{
		$data['Employees']=$this->Commonmodel->rows_number('saimtech_employees');
		$data['Departments']=$this->Commonmodel->rows_number('saimtech_departments');
		$data['Documents']=$this->Commonmodel->rows_number('saimtech_document');
		return view('dashboard/index',$data);
	}

	
	public function myview()
	{
		return view('myView');
	}
}
