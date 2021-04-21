<?php

namespace App\Controllers;
use App\Models\Commonmodel;

class Api extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Karachi');
        $this->Commonmodel = new Commonmodel();
    }
    
    
	public function index()
	{   echo date('YmdHis');
	
	//	return view('welcome_message');
	}
	
	public function myview()
	{
	    echo date('YmdHis');
		return view('myView');
	}
	
	public function migrate(){
	$migrate = \Config\Services::migrations();
    try{$migrate->latest();}
    catch (\Throwable $e){echo($e);}    
	}
	
	
	
	//------------SERVER TO MOB------------    
	public function server_to_mob(){
    $myJSON="";
	$this->Commonmodel->Sms_Refiner();
	$sms_data=$this->Commonmodel->Get_record_by_condition('saimtech_send_sms', 'sms_status', 'N');
    if(!empty($sms_data)){
    $Meta = array(
    "status" => true,
    "message" => "Server to mobile");      
    foreach($sms_data as $rows){   
    //------------Meta Array
    if($rows->sms_phone!=""){    
    $sms[] = array(
    "smsID"         => $rows->sms_id,
 	"smsNo"         => $rows->sms_phone,
	"smsMessage"    => $rows->sms_msg,
	"smsDate"       => $rows->sms_date);
    $data =array('sms_status' => 'N');
    $this->Commonmodel->Update_record('saimtech_send_sms', 'sms_id', $rows->sms_id, $data);
    } else {
    $data =array('sms_status' => 'E');
    $this->Commonmodel->Update_record('saimtech_send_sms', 'sms_id', $rows->sms_id, $data);}
    }
     $object = array(
    'Meta' => $Meta,
    'SmsData' => $sms );    
     $myJSON = json_encode($object);
     echo $myJSON;        
    } 
    }
    
	//------------MOB TO SERVER------------
    public function mob_to_server(){
    $webhook_data   = file_get_contents('php://input');
    $mdata          = json_decode($webhook_data);  
    
    $data = array(
    "r_sms_msg" => $mdata->smsMessage,    
    "r_sms_phone" =>$mdata->smsNo,
    "r_sms_status" =>"R",
    "r_sms_date" =>date('Y-m-d'),
    );
    $this->Commonmodel->Insert_record('saimtech_receive_sms', $data);
    
    $Meta = array(
    "status" => true,
    "message" => "mobile to server");    
    $object = array(
    'Meta' => $Meta,
    'SmsData' => "HI" );
    $myJSON = json_encode($object);
    echo $myJSON;
    }
	
	public function update(){
	    
	}
	
}
