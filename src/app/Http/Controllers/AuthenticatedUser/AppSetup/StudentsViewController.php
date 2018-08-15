<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use App\ReceivedStudentPayment;
use Auth;
use App\Student;
//use App\User;
use DB;
use PDF;
//use Validator;

class StudentsViewController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

         $this->data = array();
		$this->data['menuId'] = 29;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.StudentsView.';
		
	    $this->data['jsArray'][] = 'Students_view.js';
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
            'Students View' => route('studentsView.index'),
        );
        $this->_setBreadcrumbs($breadcrumb);
		
		$this->data['pageTitle'] = 'Students View';
		
		$this->data['secInstitutes'] = DB::select('call get_sec_institute_branch_version("' . session('instituteDetails')->institute_id . '")');
		$this->data['classWise']   = DB::select('call get_student_classes(1)');	
		$this->data['groupWise']   = DB::select('call get_student_groups(1)');	

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }
    /********************view method***********************/

    public function view(Request $request) {

		
        if($request->ajax()) {
            try {
                $this->data['pageTitle'] = 'View Students';
             
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
				
				$this->data['studentsView'] = DB::select('call students_view("'.$branch_and_version.'","'.$class_name.'",
				"'.$section_name.'","'.$group_name.'")'); 			
				
                  /* echo '<pre>';
                  		print_r($this->data['studentsView']);
			     echo '</pre>'; exit();
  			    */
				
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
			
            return view($this->data['viewPath'] . 'view', array('data' => $this->data));
            		
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
	

	
	/****************** Print Method ************************/

	public function print_student(Request $request) {
               echo '<pre>';print_r($request->all());echo '</pre>';	 	
        if (!$request->ajax()) {			

            try {
               $this->data['pageTitle'] = 'Print Students';

                if(empty($request->branchVersion)){
                    $branch_and_version = 0;
                }else{
                    $branch_and_version = $request->branchVersion;
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

                $this->data['studentsViewPrint'] = DB::select('call students_view("'.$branch_and_version.'","'.$class_name.'",
				"'.$section_name.'","'.$group_name.'")');

                    /*echo '<pre>';
                         print_r($this->data['studentsViewPrint']);
                   echo '</pre>'; exit();*/

            } catch (\Exception $ex) {
                echo $ex->getMessage();

            }
              
			$pdf = PDF::loadView($this->data['viewPath'] . 'print', array('data' => $this->data));
                  return $pdf->download('print_Students.pdf');
        } else {

            throw new Exception('Invalid request!');

        }

    }

	
	
	
	

}
