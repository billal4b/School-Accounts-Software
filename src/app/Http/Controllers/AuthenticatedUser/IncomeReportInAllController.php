<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ReceivedStudentPayment;
use Auth;
use DB;
use PDF;
use Validator;

class IncomeReportInAllController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
		$this->data['menuId'] = 22;
        $this->data['viewPath'] = 'AuthenticatedUser.IncomeReportInAll.';
		
		 $this->data['jsArray'][] = 'Income_Report_In_All.js';
    }
   
   
   
    private function _setBreadcrumbs($brdcrmb) {
        foreach($brdcrmb as $key => $value){
            $this->data['brdcrmb'][] = array(
                array('title' => $key, 'url' => $value)
            );
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        $breadcrumb = array(
            'All Income Report' => route('incomeReportInAll::index')
        );
        $this->_setBreadcrumbs($breadcrumb);               
		$this->data['pageTitle'] = 'All Income Report';
		
		$this->data['secInstitutes'] = DB::select('call get_sec_institute_branch_version("' . session('instituteDetails')->institute_id . '")');
		$this->data['headWise'] = DB::table('tbl_student_payment_sub_head_details')
		     ->select('student_payment_name')
             ->groupBy('student_payment_name')
             ->get();
		$this->data['classWise']   = DB::select('call get_student_classes(1)');	
		$this->data['sectionWise'] = DB::select('call get_student_sections(1)');	
		$this->data['groupWise']   = DB::select('call get_student_groups(1)');	
		$this->data['bankWise']    = DB::table('tbl_banks')
		      ->select('bank_id','bank_name')
              ->get();
			  
        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }
    /********************view method***********************/

    public function view(Request $request) {
        if($request->ajax()) {
			/*
		  $validator = Validator::make($request->all(), array(
                        'from_date' => 'required',
                        'to_date'   => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('incomeReportInAll::index')
                                ->withErrors($validator)
                                ->withInput();
            } */

            try {
                $this->data['pageTitle'] = 'View Report';
             
				
				if(empty($request->branch_version_name)){
					$branch_version_name = 0;
				}else{
					$branch_version_name = $request->branch_version_name;
				}
				
				if(empty($request->class_name)){
					$class_name = 0;
				}else{
					$class_name = $request->class_name;
				}
			
				if(empty($request->group_name)){
					$group_name = 0;
				}else{
					$group_name = $request->group_name;
				}
				if(empty($request->student_id)){
					$student_id = 0;
				}else{
					$student_id = $request->student_id;
				}
				if(empty($request->bank_name)){
					$bank_name = 0;
				}else{
					$bank_name = $request->bank_name;
				}  
				 
				$this->data['totalIncomeReport'] = DB::select('call income_stu_all_report("' . date('Y-m-d', strtotime(str_replace('-', '-', $request->from_date))) . ' 00:00:00","' . date('Y-m-d', strtotime(str_replace('-', '-', $request->to_date))) . ' 23:59:59","'.$branch_version_name.'","'.$class_name.'","'.$group_name.'","'.$student_id.'","'.$bank_name.'")');				
				
                //echo '<pre>';
                //    print_r($this->data['totalIncomeReport']);
			   // echo '</pre>'; exit(); 			
				
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
            return view($this->data['viewPath'] . 'view', array('data' => $this->data));
        } else {
            throw new Exception('Invalid request!');
        }
    } 
	/********************getStudentIdByClassIdGroupId method***********************/
	public function getStudentIdByClassIDSectionIdGroupID($classID,$groupID) {
                
        $IDWise   = DB::table('tbl_students')
					-> select('student_id', 'system_generated_student_id')
					-> where('class_id', '=', $classID)
					-> where('stu_group', '=', $groupID)
					-> get();           
			
        echo '<option value="">----- Select -----</option>';
         foreach ($IDWise as $sid) {
            echo '<option value="' . $sid->student_id . '">' . $sid->system_generated_student_id . '</option>';
       }
    }
	
	/****************** Print Method ************************/
	/*
	public function print_generate_student_payment_report_by_date(Request $request) {
		
        if (!$request->ajax()) {			
			
            try {
               $this->data['pageTitle'] = 'Payment Report by date ';
			   
			   if(Auth::user()->role_id == 9){
				   $bank_id=session('instituteDetails')->bank_id;
				   $bank_branch_id=session('instituteDetails')->branch_id;
			   }elseif(Auth::user()->role_id == 8){
				   $bank_id=0;
				   $bank_branch_id=0;
			   }
			$this->data['paymentReport'] = DB::select('call received_student_payment_report("' . date('Y-m-d', strtotime(str_replace('-', '-', $request->fromDate))) . ' 00:00:00","' . date('Y-m-d', strtotime(str_replace('-', '-', $request->toDate))) . ' 23:59:59","'.$bank_id.'","'.$bank_branch_id.'","'.Auth::user()->role_id.'","'.Auth::user()->user_id.'","'.Auth::user()->bank_user_rank.'")');
		
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
			
			$pdf = PDF::loadView($this->data['viewPath'] . 'print', array('data' => $this->data));
            return $pdf->download('Student_payment_report.pdf');
			
			
        } else {
            throw new Exception('Invalid request!');
        }
    }
	
	*/
}
