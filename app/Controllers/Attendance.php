<?php

namespace App\Controllers;
use App\Models\AttendanceModel;
use App\Models\DepartmentModel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class Attendance extends BaseController
{
 use ResponseTrait;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Karachi');
        $this->AttendanceModel = new AttendanceModel();
        $this->DepartmentModel = new DepartmentModel();
         helper(['form', 'url']);
         $session = \Config\Services::session();

     }
	public function index()
	{
		$data['date'] = date('Y-m-d');
		$dep_type_id = $this->request->getVar('depid');//select Role value//depid
		$shift = $this->request->getVar('shift');
		$data['shift'] = $shift;
        $data["dep_type_id"] = $dep_type_id;
        $data['departments'] = $this->DepartmentModel->orderBy('depid', 'DESC')->find();
        $data['working_shift']=array('Day','Night');
        //echo"<pre>";print_r($data['working_shift']);exit();
		if(!isset($dep_type_id)){
         return view('attendance/attendancelist',$data);
		}
		else{
			$dep_type = $this->request->getVar('depid');
			$date = $this->request->getVar('date');
			$data['date'] = $date;
			$data['dep_type_id'] = $dep_type_id;
			$attendencetypes = $this->AttendanceModel->getEmployeeAttendanceType();
			$resultlist = $this->AttendanceModel->searchAttendenceDepartmentType($dep_type,$date,$shift);
            //echo"<pre>";print_r($resultlist);exit();
            $data['attendencetypeslist'] = $attendencetypes;
			$data['resultlist']= $resultlist;
		return view('attendance/attendancelist',$data);
		}
	}
	public function add(){
		    $dep_type_id = $this->request->getVar('depid');
		    $dep_type = $this->request->getVar('depid');
			$date = $this->request->getVar('date');
			$data['date'] = $date;
			$data['dep_type_id'] = $dep_type_id;
			$data['date'] = $date;
			$search = $this->request->getVar('search');
            $holiday = $this->request->getVar('holiday');
            if ($search == "saveattendence") {
                $user_type_ary = $this->request->getVar('student_session');
                //echo"<pre>";print_r($user_type_ary);exit();
                $absent_student_list = array();
                foreach ($user_type_ary as $key => $value) {
                    $checkForUpdate = $this->request->getVar('attendendence_id' . $value);
                    //echo"<pre>";print_r($checkForUpdate);exit();
                    if ($checkForUpdate != 0) {

                        if (isset($holiday)) {
                        	//echo"<pre>";print_r($checkForUpdate);exit();
                            $arr = array(
                                'att_id' => $checkForUpdate,
                                'emp_id' => $value,
                                'emp_attendance_type_id' => 5,
                                'remark' => $this->request->getVar("remark" . $value),
                                'date' => $date,
                            );

                        } else {
                        	//echo"<pre>";print_r($checkForUpdate);exit();
                            $arr = array(
                                'att_id' => $checkForUpdate,
                                'emp_id' => $value,
                                'emp_attendance_type_id' => $this->request->getVar('attendencetype' . $value),
                                'remark' => $this->request->getVar("remark" . $value),
                                'date' => $date,
                            );
                        }
                        $insert_id = $this->AttendanceModel->add($arr);
                    } else {

                        if (isset($holiday)) {
                            $arr = array(
                                'emp_id' => $value,
                                'emp_attendance_type_id' => 5,
                                'date' => $date,
                                'remark' => ''
                            );
                        } else {
                            $arr = array(
                                'emp_id' => $value,
                                'emp_attendance_type_id' => $this->request->getVar('attendencetype' . $value),
                                'date' => $date,
                                'remark' => $this->request->getVar("remark" . $value),
                            );
                        }
                        $insert_id = $this->AttendanceModel->add($arr);
                    }
                }
                $session = \Config\Services::session();
                $session->setFlashdata('msg', 'Attendance Saved Successfully');
                return redirect()->to('/Attendance');
            }
	}
}
