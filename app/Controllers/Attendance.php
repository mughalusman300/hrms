<?php

namespace App\Controllers;
use App\Models\AttendanceModel;
use App\Models\DepartmentModel;
use App\Models\Employeemodel;
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
        $this->Employeemodel = new Employeemodel();
         helper(['form', 'url']);
         $session = \Config\Services::session();
         // $this->config->load("payroll");
         // $this->employee_attendance = $this->config->item('employeeattendance');
         $config = config('Payroll');
          $this->employee_attendance = $config->employeeattendance;
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
    public function attendancereport()
    {
        //echo"<pre>";print_r($this->employee_attendance);exit();
        $dep_type_id = $this->request->getVar('depid');//select Role value//depid
        $shift = $this->request->getVar('shift');
        $month = $this->request->getVar('month');
        $search = $this->request->getVar('search');
        $attendencetypes = $this->AttendanceModel->getEmployeeAttendanceType();
        $data['attendencetypeslist'] = $attendencetypes;
        $data['shift'] = $shift;
        $data["dep_type_id"] = $dep_type_id;
        $data['departments'] = $this->DepartmentModel->orderBy('depid', 'DESC')->find();
        $data['working_shift']=array('Day','Night');
        $data['monthlist'] = $this->getMonthDropdown();
        $data['yearlist'] = $this->AttendanceModel->attendanceYearCount();
        //echo"<pre>";print_r($data['yearlist']);exit();
        $data['date'] = "";
        $data['month_selected'] = "";
        $data["dep_selected"] = "";//role_selected
        $data['errors']='';
        $rules = [
            'month' => ['rules' => 'required', 'label' => 'Month'],
        ]; 
         if (!$this->validate($rules) ){
             $data["dep_type_id"] = $dep_type_id;
             $data['shift'] = $shift;
             $data['month_selected'] = $month;
             $errors = $this->validator->getErrors();
             if($search =='submit'){
               $data['errors'] = $errors['month']; 
             }
             return view('attendance/attendanmonthcereport',$data);
        }
        else{
        $month = $this->request->getVar('month');     
        $searchyear = $this->request->getVar('year'); 
        $data['month_selected'] = $month; 
        $data["dep_type_id"] = $dep_type_id;  
        $employeelist = $this->Employeemodel->getEmployees($dep_type_id);
        $month_number = date("m", strtotime($month)); 
        $num_of_days = cal_days_in_month(CAL_GREGORIAN, $month_number, $searchyear);
        $attr_result = array();
        $attendence_array = array();
        $student_result = array();
        $data['no_of_days'] = $num_of_days;
        $date_result = array();
        $monthAttendance = array();

        //echo"<pre>";print_r( $shift);exit();
        for ($i = 1; $i <= $num_of_days; $i++) {
                $att_date = $searchyear . "-" . $month_number . "-" . sprintf("%02d", $i);
                $attendence_array[] = $att_date;
                $res = $this->AttendanceModel->searchAttendanceReport($dep_type_id, $att_date,$shift);
                $student_result = $res;
                //echo"<pre>";print_r( $student_result);exit();
                $s = array();
                foreach ($res as $result_k => $result_v) {
                    $date = $searchyear . "-" . $month;
                    $newdate = date('Y-m-d', strtotime($date));
                    $s[$result_v['id']] = $result_v;
                }
                $date_result[$att_date] = $s;
               // echo"<pre>";print_r( $date_result[$att_date]);exit();     

            }
            foreach ($res as $result_k => $result_v) {
                $date = $searchyear . "-" . $month;
                $newdate = date('Y-m-d', strtotime($date));
                $monthAttendance[] = $this->monthAttendance($newdate, 1, $result_v['id']);
            }
            //echo"<pre>";print_r( $this->staff_attendance);exit();     
            $data['monthAttendance'] = $monthAttendance;
            $data['resultlist'] = $date_result;
           //echo"<pre>";print_r( $date_result);exit();     

            if (!empty($searchyear)) {
                $data['attendence_array'] = $attendence_array;
                $data['student_array'] = $student_result;
            } else {
                $data['attendence_array'] = array();
                $data['student_array'] = array();
            }
        return view('attendance/attendanmonthcereport',$data);
        }
    }
     function monthAttendance($st_month, $no_of_months, $emp) {
       //echo"<pre>";print_r( $emp);exit();
        $record = array();
        $r = array();
        $month = date('m', strtotime($st_month));
        $year = date('Y', strtotime($st_month));
        foreach ($this->employee_attendance as $att_key => $att_value) {
            $s = $this->AttendanceModel->count_attendance_obj($month, $year, $emp, $att_value);

            $r[$att_key] = $s;
             //echo"<pre>";print_r(  $r[$att_key]);exit();
        }
        $record[$emp] = $r;
        //echo"<pre>";print_r( $record[$emp]);exit();     

        return $record;
    }
    public function getMonthDropdown() {
        $array = array();
        for ($m = 1; $m <= 12; $m++) {
            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
            $array[$month] = $month;
        }
        return $array;
    }
}
