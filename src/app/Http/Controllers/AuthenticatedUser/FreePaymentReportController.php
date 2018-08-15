<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\FreePaymentDetails;
use Auth;
use DB;
use PDF;
use Validator;

class FreePaymentReportController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

         $this->data = array();
		$this->data['menuId'] = 52;
        $this->data['viewPath'] = 'AuthenticatedUser.FreePaymentReport.';
		
	    $this->data['jsArray'][] = 'free_payment_Report.js';
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
            'Free Payment Report' => route('freePaymentReport::index')
        );
        $this->_setBreadcrumbs($breadcrumb);               
		$this->data['pageTitle'] = 'Free Payment Report';
		
		$this->data['secInstitutes'] = DB::select('call get_sec_institute_branch_version("' . session('instituteDetails')->institute_id . '")');
		  
		$this->data['freeCategory'] = DB::table('tbl_stu_free_payment')
		     ->select('stu_free_payment_id','free_catagory')
             ->get();		
		$this->data['classWise']   = DB::select('call get_student_classes(1)');	
		$this->data['groupWise']   = DB::select('call get_student_groups(1)');	
        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }
    /********************view method***********************/

    public function view(Request $request) {
        if($request->ajax()) {

            try {
                $this->data['pageTitle'] = 'Free Payment Report';
				
                if(empty($request->free_catagory)){
					$free_catagory = 0;
				}else{
					$free_catagory = $request->free_catagory;
				}
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

				
			

				$this->data['totalIncomeReport'] = DB::select('call income_report("'.$branch_and_version.'",
				"'.$class_name.'","'.$section_name.'", "'.$group_name.'","'.Auth::user()->user_id.'")');				
				
              echo '<pre>';print_r($this->data['totalIncomeReport']);echo '</pre>'; exit(); 
			
				
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
//			if($request->head_name ==!0){
//				 return view($this->data['viewPath'] . 'viewHead', array('data' => $this->data));
//			}else{
                 return view($this->data['viewPath'] . 'view', array('data' => $this->data));
            
//		    }	
			
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
	

	
		/******************** getHeadNameByClassID method ***********************/
	
	
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

    

	
}
