<?php

namespace App\Controllers;
use App\Models\AttendanceModel;
use App\Models\DepartmentModel;
use App\Models\Payroll_Model;
use App\Models\Employeemodel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class payroll1 extends BaseController
{
 use ResponseTrait;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        date_default_timezone_set('Asia/Karachi');
        $this->AttendanceModel = new AttendanceModel();
        $this->DepartmentModel = new DepartmentModel();
        $this->Payroll_Model = new Payroll_Model();
        $this->Employeemodel = new Employeemodel();
         helper(['form', 'url']);
         $session = \Config\Services::session();
         // $this->config->load("payroll");
         // $this->employee_attendance = $this->config->item('employeeattendance');
         $config = config('Payroll');
          $this->employee_attendance = $config->employeeattendance;
          $this->payment_mode = $config->payment_mode;
          $this->payroll_status = $config->payroll_status;
     }
    public function index()
    {
        //echo"<pre>";print_r($this->employee_attendance);exit();
        $dep_type_id = $this->request->getVar('depid');//select Role value//depid
        $shift = $this->request->getVar('shift');
        $month = $this->request->getVar('month');
        $search = $this->request->getVar('search');
        $data["month"] = date("F", strtotime("-1 month"));
        $data["payment_mode"] = $this->payment_mode;
        $data['shift'] = $shift;
        $data["dep_type_id"] = $dep_type_id;
        $data['departments'] = $this->DepartmentModel->orderBy('depid', 'DESC')->find();
        $data['working_shift']=array('Day','Night');
        $data['monthlist'] = $this->getMonthDropdown();
        $data['yearlist'] = $this->AttendanceModel->attendanceYearCount();
        $data['date'] = "";
        $data['month'] = "";
        $data["dep_selected"] = "";//role_selected
        $data['errors']='';
        $data['years']='';
        $rules = [
            'month' => ['rules' => 'required', 'label' => 'Month'],
        ]; 
         if (!$this->validate($rules) ){
             $data["dep_type_id"] = $dep_type_id;
             $data['shift'] = $shift;
             $data['month'] = $month;
             $errors = $this->validator->getErrors();
             if($search =='submit'){
               $data['errors'] = $errors['month']; 
             }
             return view('payroll1/employeelist',$data);
        }
        else{
        $month = $this->request->getVar('month');     
        $year = $this->request->getVar('year'); 
        $emp_name = $this->request->getVar('name'); 
        $data['month'] = $month; 
        $data["dep_type_id"] = $dep_type_id;  
        $employeelist = $this->Employeemodel->getEmployees($dep_type_id);
        if (isset($search) && $search == "submit") {
             $searchEmployee = $this->Payroll_Model->searchEmployee($month, $year, $emp_name,$shift, $dep_type_id);
             $data["resultlist"] = $searchEmployee;
             $data["years"] = $year;
         //echo"<pre>";print_r($searchEmployee);exit();
        }
        $data["payroll_status"] = $this->payroll_status;     
        return view('payroll1/employeelist',$data);
        }
    }
    Public function search($month, $year,$shift,$dep_type_id='') {
    $data['departments'] = $this->DepartmentModel->orderBy('depid', 'DESC')->find();
    $data['working_shift']=array('Day','Night');
    $data['monthlist'] = $this->getMonthDropdown();
    $data['yearlist'] = $this->AttendanceModel->attendanceYearCount();
    $searchEmployee = $this->Payroll_Model->searchEmployee($month, $year, $emp_name='',$shift, $dep_type_id);
    $data["resultlist"] = $searchEmployee;
    $data['shift'] = $shift;
    $data["month"] = $month;
    $data["years"] = $year;
    $data["dep_type_id"]= $dep_type_id;
    $data["payroll_status"] = $this->payroll_status;
    $data["resultlist"] = $searchEmployee;
    $data["payment_mode"] = $this->payment_mode;
    return view('payroll1/employeelist',$data);
    }
    function create($month, $year, $id, $shift, $dep_type_id='') {
        $data["staff_id"] = "";
        $data["basic"] = "";
        $data["name"] = "";
        $data["month"] = "";
        $data["year"] = "";
        $data["present"] = 0;
        $data["absent"] = 0;
        $data["late"] = 0;
        $data["half_day"] = 0;
        $data["holiday"] = 0;
        $data["leave_count"] = 0;
        $data["alloted_leave"] = 0;
        $data["shift"] = $shift;
        $data["dep_type_id"] = $dep_type_id;
        $departments = $this->DepartmentModel->orderBy('depid', 'DESC')->find();//$user_type = $this->staff_model->getStaffRole();
        $data['classlist'] = $departments;
        $date = $year . "-" . $month;
        $searchEmployee = $this->Payroll_Model->searchEmployeeById($id);
        $data['result'] = $searchEmployee[0];
        //echo"<pre>";print_r($data['result']);exit();
        $data["month"] = $month;
        $data["year"] = $year;

        //$alloted_leave = $this->staff_model->alloted_leave($id);
        $newdate = date('Y-m-d', strtotime($date . " +1 month"));
        $data['monthAttendance'] = $this->monthAttendance($newdate, 3, $id);
        //$data['monthLeaves'] = $this->monthLeaves($newdate, 3, $id);
        $data["attendanceType"] = $this->AttendanceModel->getEmployeeAttendanceType();
        //$data["alloted_leave"] = $alloted_leave[0]["alloted_leave"];
        return view('payroll1/create',$data);

    }
     function monthAttendance($st_month, $no_of_months, $emp) {
        $record = array();
        for ($i = 1; $i <= $no_of_months; $i++) {
            $r = array();
            $month = date('m', strtotime($st_month . " -$i month"));
            $year = date('Y', strtotime($st_month . " -$i month"));
            foreach ($this->employee_attendance as $att_key => $att_value) {
                $s = $this->AttendanceModel->count_attendance_obj($month, $year, $emp, $att_value);
                $r[$att_key] = $s;
            }
            $record['01-' . $month . '-' . $year] = $r;
        }
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
    Public function payslip() {
        
        $shift =$this->request->getVar("shift");
        $dep_type_id =$this->request->getVar("dep_type_id");
        $basic = $this->request->getVar("basic");
        $total_allowance = $this->request->getVar("total_allowance");
        $total_deduction = $this->request->getVar("total_deduction");
        $net_salary = $this->request->getVar("net_salary");
        $status = $this->request->getVar("status");
        $emp_id = $this->request->getVar("emp_id");
        $month = $this->request->getVar("month");
        $name = $this->request->getVar("name");
        $year = $this->request->getVar("year");
        $tax = $this->request->getVar("tax");
        $fullname = $this->request->getVar("fullname");
        // echo $fullname;exit();
        $rules = [
            'net_salary' => ['rules' => 'required|trim', 'label' => 'Net Salary'],
        ];

        if (!$this->validate($rules)) {
            $this->create($month, $year, $emp_id);
        } else {
            $data = array('emp_id' => $emp_id,
                'basic' => $basic,
                'total_allowance' => $total_allowance,
                'total_deduction' => $total_deduction,
                'net_salary' => $net_salary,
                'payment_date' => date("Y-m-d"),
                'status' => $status,
                'month' => $month,
                'year' => $year,
                'tax' => $tax,
                'leave_deduction' => '0'
            );
            $checkForUpdate = $this->Payroll_Model->checkPayslip($month, $year, $emp_id);
            if ($checkForUpdate == true) {
                $insert_id = $this->Payroll_Model->createPayslip($data);
                $payslipid = $insert_id;
                $allowance_type = $this->request->getVar("allowance_type");
                $deduction_type = $this->request->getVar("deduction_type");
                $allowance_amount = $this->request->getVar("allowance_amount");
                $deduction_amount = $this->request->getVar("deduction_amount");
                if (!empty($allowance_type)) {
                    $i = 0;
                    foreach ($allowance_type as $key => $all) {
                        $all_data = array('payslip_id' => $payslipid,
                            'allowance_type' => $allowance_type[$i],
                            'amount' => $allowance_amount[$i],
                            'emp_id' => $emp_id,
                            'cal_type' => "positive",
                        );
                        $insert_payslip_allowance = $this->Payroll_Model->add_allowance($all_data);
                        $i++;
                    }
                }
                if (!empty($deduction_type)) {
                    $j = 0;
                    foreach ($deduction_type as $key => $type) {
                        $type_data = array('payslip_id' => $payslipid,
                            'allowance_type' => $deduction_type[$j],
                            'amount' => $deduction_amount[$j],
                            'emp_id' => $emp_id,
                            'cal_type' => "negative",
                        );

                        $insert_payslip_allowance = $this->Payroll_Model->add_allowance($type_data);
                        $j++;
                    }
                }
                $session = \Config\Services::session();
                $session->setFlashdata('successmsg', ''.$fullname.'Payslip generated Successfully');
                return redirect()->to('/Payroll1/search/' . $month . "/" . $year . "/" . $shift . "/" . $dep_type_id);
            } else {
                $session = \Config\Services::session();
                $session->setFlashdata('msg', ''.$fullname.' Payslip of this month already generated');
                return redirect()->to('/Payroll1/search/' . $month . "/" . $year . "/" . $shift . "/" . $dep_type_id);
            }

        }

    }
    public function paymentRecord() {
        

        $month = $this->request->getVar("month");
        $year = $this->request->getVar("year");
        $emp_id = $this->request->getVar("emp_id");
        $searchEmployee = $this->Payroll_Model->searchPayment($emp_id, $month, $year);
        // echo"<pre>";print_r($searchEmployee);exit();
        $searchEmployee = $searchEmployee[0];
        $data['result'] = $searchEmployee;
        $data["month"] = $month;
        $data["year"] = $year;
        echo json_encode($data);
    }
    public function paymentSuccess(){
        $payment_mode =$this->request->getVar("payment_mode");
        $date = $this->request->getVar("payment_date");
        $payment_date = date('Y-m-d', strtotime($date));
        $remark = $this->request->getVar("remarks");
        $status = 'paid';
        $payslipid = $this->request->getVar("paymentid");
        $rules = [
            'payment_mode' => ['rules' => 'required|trim', 'label' => 'payment mode']
        ];
        if ($this->validate($rules)) {
        $data =[ 
                'payment_mode' => $payment_mode,
                 'payment_date' => $payment_date, 
                 'remark' => $remark, 
                 'status' => $status
             ];
            $this->Payroll_Model->paymentSuccess($data, $payslipid); 
        $array = array('status' => 'success', 'error' => '', 'message' => 'Record Saved Successfully');     
        }
        echo json_encode($array);            
    }
    public function payslipView() {
        $data["payment_mode"] = $this->payment_mode;
        $id = $this->request->getVar("payslipid");
        $result = $this->Payroll_Model->getPayslip($id);
         $ret = $result[0]['fname'];
        $allowance = $this->Payroll_Model->getAllowance($result[0]["id"],'');        
        $data["allowance"] = $allowance;
        $positive_allowance = $this->Payroll_Model->getAllowance($result[0]["id"], "positive");
        $data["positive_allowance"] = $positive_allowance;
        $negative_allowance = $this->Payroll_Model->getAllowance($result[0]["id"], "negative");
        $data["negative_allowance"] = $negative_allowance;
        $data["result"] = $result[0];
        //echo"<pre>";print_r($data["result"] );exit();
        return view("payroll1/payslipview", $data);
    }
    Public function deletepayroll($payslipid, $month, $year,$shift,$dep_type_id ='' ) {
        if (!empty($payslipid)) {
            $this->Payroll_Model->deletePayslip($payslipid);
        }
        return redirect()->to('/Payroll1/search/' . $month . "/" . $year . "/" . $shift . "/" . $dep_type_id);
    }
    Public function revertpayroll($payslipid, $month, $year,$shift,$dep_type_id ='') {
        if (!empty($payslipid)) {
            $this->Payroll_Model->revertPayslipStatus($payslipid);
        }
        return redirect()->to('/Payroll1/search/' . $month . "/" . $year . "/" . $shift . "/" . $dep_type_id);
        //$this->search($month,$year,$role);
        //redirect("admin/payroll");
    }
}
