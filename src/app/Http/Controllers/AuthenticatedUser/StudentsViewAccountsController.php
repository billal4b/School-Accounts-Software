<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Student;
use App\User;
use DB;
use PDF;
use Validator;

class StudentsViewAccountsController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

         $this->data = array();
		$this->data['menuId'] = 55;
        $this->data['viewPath'] = 'AuthenticatedUser.StudentsView.';
		
	    $this->data['jsArray'][] = 'Students_view_account.js';
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
            'Students View' => route('studentsViewAccount.index'),
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
              // echo '<pre>';print_r($request->all());echo '</pre>';	 	
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
	/**********************student edit **************************************/
	
	  public function edit($id, Request $request) {
       
        if (!$request->ajax()) {
            $breadcrumb = array(
                'Student View' => route('studentsViewAccount.index'),
                'Update'       => route('studentsViewAccount.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle']      = 'Update Student';
            $this->data['stdDetails']     = Student::findOrFail($id);
            $this->data['stdDetails']     = Student::where('student_id', '=', $id)->first();
            $this->data['studentClasses'] = DB::select('call get_student_classes(1)');
			
		    //echo "<pre>"; print_r($this->data['studentClasses']);exit();
		   
			$this->data['freePayment']    = DB::select('call get_sec_stu_free_payment_view(1)');	
			
			$this->data['studentSection'] = DB::select('call get_student_sections(1)');
            $this->data['studentGroups']  = DB::select('call get_student_groups(1)');
            $this->data['years']          = DB::select('call get_years(1)');
            $this->data['genders']        = DB::select('call get_genders(1)');
            try {
                $this->data['secInstitutes'] = DB::select('call get_sec_institute_branch_version("' . session('instituteDetails')->institute_id . '")');
                return view($this->data['viewPath'] . 'edit', array('data' => $this->data));
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            throw new Exception('Invalid request!');
        }
    }

	public function update(Request $request, $id) {

        
        $this->data['studentDetails'] = Student::findOrFail($id);

        $validator = Validator::make($request->all(), array(
            
                    'student_name'        => 'required|max:255',
                    'year_of_admission'   => 'required|max:4',
                    'class_name'          => 'required',
                    'group_name'          => 'required',
					'section_name'        => 'required',
					'system_generated_student_id' => 'required',
                    'gender'              => 'required',
                    'branch_and_version'  => 'min:1|required',
                    'contact_for_sms'     => 'required|digits:9',
                    'status'              => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('studentsViewAccount.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }
        
        $free_category = '';
        if(isset($request->free_catagory)){
            foreach($request->free_catagory as $key => $value){
                $free_category .= $value . ',';
            }
        }
        $free_category = rtrim(trim($free_category), ',');

        $student = Student::find($id);
        $student->student_name = $request->student_name;
        $student->year_of_admission = $request->year_of_admission;
        $student->class_id = $request->class_name;
		
        $student->section_id = $request->section_name;
        $student->roll_no = $request->roll_no;
        $student->system_generated_student_id = $request->system_generated_student_id;
		
        $student->gender = $request->gender;
        $student->stu_group = $request->group_name;
        $student->institute_branch_version_id = $request->branch_and_version;
        $student->contact_for_sms = "8801".$request->contact_for_sms;
		
		$student->free_payment_view_id = $free_category;
        $student->status = $request->status;
        $student->update_time = date('Y-m-d h:i:s');
        $student->update_logon_id = session('sessLogonId');
        $student->update_user_id = Auth::user()->user_id;
        $student->last_action = 'UPDATE';
        $student->save();
        

        $userArr = array(
            'full_name' => $request->student_name,
            'phone_no' => "8801".$request->contact_for_sms,
            'is_active' => 1,
            'institute_branch_version_id' => $request->branch_and_version,
        );
        $user = User::where('username', '=', "s".$request->system_generated_student_id)
                ->update($userArr);

        return redirect()->route('studentsViewAccount.index')
                        ->with('successMessage', 'Data updated successfully.');
    }
	

}
