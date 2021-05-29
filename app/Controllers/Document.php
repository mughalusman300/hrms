<?php

namespace App\Controllers;
use App\Models\Documentmodel;
use App\Models\Commonmodel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\API\ResponseTrait;
// use CodeIgniter\HTTP\Files\UploadedFile;

use App\Controllers\BaseController;

class Document extends BaseController
{
use ResponseTrait;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Karachi');
        $this->Documentmodel = new Documentmodel();
        $this->Commonmodel = new Commonmodel();
         helper(['form', 'url']);
         $session = \Config\Services::session();
    }
	public function index()
	{

		return view('document/index');
	}
	public function getAllDocuments()
    {

        $documents = $this->Documentmodel->getAllDocuments();
   
        return $this->response->setJSON($documents);
    }
    public function create()
    {

         $user_id = $_SESSION['user_id'];
         $rules = [
			'doc_name' => ['rules' => 'required|min_length[2]|max_length[30]', 'label' => 'Name'],
			'doc_description' => ['rules' => 'required|min_length[3]|max_length[250]', 'label' => 'Description'],
			'emp_id' => ['rules' => 'required', 'label' => 'Employee'],
			'onefile' =>['rules' => 'uploaded[onefile]|max_size[onefile,20480]|mime_in[onefile,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf]', 'label' => 'File'],

		
		];
		 if (!$this->validate($rules)) {
             $errors = $this->validator->getErrors();
			return $this->fail($errors);
		}
    	else{
    		$img = $this->request->getFile('onefile');
		    if($img!=""){
             $extension = $img->getClientExtension();
             $newName = $img->getRandomName();
             $path = "public/img/";
             $full_db_path = $path."".$newName;
             $img->move($path, $newName);
             }
             $data =[
                 'doc_name'  => $this->request->getVar('doc_name'),
                 'doc_description'  => $this->request->getVar('doc_description'),
                 'doc_type'  => $extension,
                 'doc_path'  => $newName,
                 'created_by'  => $user_id,
                 'emp_id'  => $this->request->getVar('emp_id'),

		    ];
		    $this->Documentmodel->insert($data);
		    }   
    }
    public function deleteDocument($id)
	{
		 $this->Documentmodel->where('doc_id', $id)->delete();
	}
    // public function download($file)
    // {

    //    // echo $file;
    // // $pathToFile = storage_path('public/img/'.$file);
    // 	$path ='/public/img/1.jpg';
    // 	//echo $path;
    //     return $this->response->download($path, null);
    // }
    public function search(){
		$searchkeyword = $this->request->getVar('s');
		$search = $this->Documentmodel->getSearchData($searchkeyword);
		return $this->response->setJSON($search);
	}
	Public function getEmployees(){
	    $employees = $this->Commonmodel->Get_all_record('saimtech_employees');	
		return $this->response->setJSON($employees);
	}
}
