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

class IncomeReportController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

         $this->data = array();
		$this->data['menuId'] = 21;
        $this->data['viewPath'] = 'AuthenticatedUser.IncomeReport.';
		
	    $this->data['jsArray'][] = 'Income_Report.js';
    }

    private function _setBreadcrumbs($brdcrmb) {
        foreach($brdcrmb as $key => $value){
            $this->data['brdcrmb'][] = array(
                array('title' => $key, 'url' => $value)
            );
        }
    }
	
	public function index() {
        
        $breadcrumb = array(
            'Income Report' => route('incomeReport::index')
        );
        $this->_setBreadcrumbs($breadcrumb);               
		$this->data['pageTitle'] = 'Income Report';
		
		$this->data['secInstitutes'] = DB::select('call get_sec_institute_branch_version("' . session('instituteDetails')->institute_id . '")');
		  /*
		$this->data['headWise'] = DB::table('tbl_student_payment_sub_head_details')
		     ->select('student_payment_id','student_payment_name')
             ->groupBy('student_payment_name')
             ->get();
		$this->data['sectionWise'] = DB::select('call get_student_sections(1)');	
		   */	
		
		$this->data['classWise']   = DB::select('call get_student_classes(1)');	
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
                        'to_date' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('incomeReport::index')
                                ->withErrors($validator)
                                ->withInput();
            } */

            try {
                $this->data['pageTitle'] = 'View Report';
             
				if(empty($request->branch_and_version)){
					$branch_and_version = 0;
				}else{
					$branch_and_version = $request->branch_and_version;
				}
				if(empty($request->class_name)){
					$class_name = 0;
				}else{
					$class_name = $request->class_name;
				}
				if(empty($request->section_name)){
					$section_name = 0;
				}else{
					$section_name = $request->section_name;
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
				if(empty($request->head_name)){
					$head_name = 0;
				}else{
					$head_name = $request->head_name;
				} 
				if(empty($request->bank_name)){
					$bank_name = 0;
				}else{
					$bank_name = $request->bank_name;
				} 
				
				$this->data['totalIncomeReport'] = DB::select('call income_report("' . date('Y-m-d', strtotime(str_replace('-', '-', $request->from_date))) . ' 00:00:00","' . date('Y-m-d', strtotime(str_replace('-', '-', $request->to_date))) . ' 23:59:59","'.$branch_and_version.'","'.$class_name.'","'.$section_name.'",
				"'.$group_name.'","'.$student_id.'", "'.$head_name.'", "'.$bank_name.'","'.Auth::user()->user_id.'")');				
				
                /* echo '<pre>';
                   print_r($this->data['totalIncomeReport']);
			   echo '</pre>'; exit();  */
  			   
				
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
			if($request->head_name ==!0){
				 return view($this->data['viewPath'] . 'viewHead', array('data' => $this->data));
			}else{
                 return view($this->data['viewPath'] . 'view', array('data' => $this->data));
            
		    }	
			
        } else {
            throw new Exception('Invalid request!');
        }
    } 
	
	/******************** getBranchSection method ***********************/
	
	public function getBranchSection($BranchVersionID,$ClassID) {
     
        $vbid = explode('_', $BranchVersionID);
        $Section = DB::table('tbl_sec_sections')
		        -> join ('sectioninfo', 'sectioninfo.section_id' ,'=','tbl_sec_sections.section_id')
                -> select('tbl_sec_sections.*', 'sectioninfo.SectionName')
                -> where('institute_branch_version_id', '=', $vbid[0])
                -> where('class_id', '=', $ClassID)
                -> get();

        echo '<option value="">----- Select -----</option>';
        foreach ($Section as $sid) {
            echo '<option value="' . $sid->section_id . '">' . $sid->SectionName . '</option>';
        }

    }
	
	
	/******************** getStudentIdByClassIdGroupId method ***********************/

	public function getStudentIdBySectionIdBranchID($sectionID,$BranchID) {
                
        $IDWise   = DB::table('tbl_students')
					-> select('student_id', 'system_generated_student_id')
					-> where('section_id', '=', $sectionID)
					-> where('institute_branch_version_id', '=', $BranchID)
					-> get();
		//echo '<pre>';print_r($request->all());echo '</pre>';	 	           
			
        echo '<option value="">----- Select -----</option>';
         foreach ($IDWise as $sid) {
            echo '<option value="' . $sid->student_id . '">' . $sid->system_generated_student_id . '</option>';
       }
    }
	
		/******************** getHeadNameByClassID method ***********************/
	
	/* public function getHeadNameByClassID($classID) {
                
        $headWise   = DB::table('tbl_received_student_payment_sub_heads')
					-> select('student_payment_id','student_payment_name')
					-> where('class_id', '=', $classID)
					-> where ('is_active', '=',1)
					-> get();           
			
        echo '<option value="">----- Select -----</option>';
         foreach ($headWise as $sid) {
            echo '<option value="' . $sid->student_payment_id . '">' . $sid->student_payment_name . '</option>';
       }
    }  */
	
		public function getHeadNameByClassID($BranchID,$classID) {
                $vbid = explode('_', $BranchID);
        $headWise   = DB::table('tbl_student_payment_sub_head_details')
					-> select('student_payment_id','student_payment_name')
					-> where('class_name', '=', $classID)
					 -> where('institute_branch_version_id', '=', $vbid[0])
					//-> where('institute_branch_version_id', '=', $BranchID)
					-> where ('is_active', '=',1)
					-> get();           
			
        echo '<option value="">----- Select -----</option>';
         foreach ($headWise as $sid) {
            echo '<option value="' . $sid->student_payment_id . '">' . $sid->student_payment_name . '</option>';
       }
    }
	
/******************** view Print method ***********************/

  public function view_print(Request $request) {
	  
	  
	  
        if(!$request->ajax()) {
            try {
                $this->data['pageTitle'] = 'View Report Print';
               
				if(empty($request->branch)){
					$branch_and_version = 0;
				}else{
					$branch_and_version = $request->branch;
				}
				
				if(empty($request->class)){
					$class_name = 0;
				}else{
					$class_name = $request->class;
				}
				if(empty($request->section)){
					$section_name = 0;
				}else{
					$section_name = $request->section;
				}
				if(empty($request->group)){
					$group_name = 0;
				}else{
					$group_name = $request->group;
				}  
				if(empty($request->sID)){
					$student_id = 0;
				}else{
					$student_id = $request->sID;
				} 
				if(empty($request->head)){
					$head_name = 0;
				}else{
					$head_name = $request->head;
				} 
				if(empty($request->bank)){
					$bank_name = 0;
				}else{
					$bank_name = $request->bank;
					
				} 
			
				$this->data['IncomeReportPrint'] = DB::select('call income_report("' . date('Y-m-d', strtotime(str_replace('-', '-', $request->from_date))) . ' 00:00:00",
				      "' . date('Y-m-d', strtotime(str_replace('-', '-', $request->to_date))) . ' 23:59:59","'.$branch_and_version.'",
					  "'.$class_name.'","'.$section_name.'","'.$group_name.'","'.$student_id.'", "'.$head_name.'", "'.$bank_name.'","'.Auth::user()->user_id.'")');		
				/*
				echo '<pre>';
                   print_r($this->data['IncomeReportPrint']);
			   echo '</pre>'; exit(); */
              
  			   
				
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
			if($request->head_name ==!0){
				
				$pdf = PDF::loadView($this->data['viewPath'] . 'viewHead_print', array('data' => $this->data));				
                   return $pdf->download('print_income_report_head.pdf');
			}else{
				
				$pdf = PDF::loadView($this->data['viewPath'] . 'view_print', array('data' => $this->data));
                   return $pdf->download('print_income_report.pdf');
            
		    }	
			
        } else {
            throw new Exception('Invalid request!');
        }
    } 
    

	
}
