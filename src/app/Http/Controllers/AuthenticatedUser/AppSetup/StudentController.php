<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Student;
use Validator;
use App\User;
//use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 18;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.Student.';
		
		$this->data['jsArray'][] = 'Students.js';
		$this->data['jsArray'][] = 'Student_Search.js';

        if ($this->_hasPrivilegeToAccessTheMenu($this->data['menuId'], Auth::user()->role_id) == 0) {
            abort(404);
        };
    }

    private function _setBreadcrumbs($brdcrmb) {
        foreach ($brdcrmb as $key => $value) {
            $this->data['brdcrmb'][] = array(
                array('title' => $key, 'url' => $value)
            );
        }
    }

    private function _hasPrivilegeToAccessTheMenu($menuId, $roleId) {

        $hasPrivilegeToAccessTheMenu = DB::select('call has_privilege_to_access_the_menu(' . $menuId . ', ' . $roleId . ')');
        return count($hasPrivilegeToAccessTheMenu) > 0 ? $hasPrivilegeToAccessTheMenu[0]->role_menu_id : 0;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $breadcrumb = array(
            //'App. Setup' => route('appSetup'),
            'Student' => route('student.index'),
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'Student';
		
        $this->data['studentList'] = DB::table('tbl_students')
                ->join('classinfo','tbl_students.class_id','=','classinfo.id')
                ->join('stugrp','tbl_students.stu_group','=','stugrp.id')
                ->join('sectioninfo','tbl_students.section_id','=','sectioninfo.section_id')
                ->select('tbl_students.student_id','tbl_students.system_generated_student_id','tbl_students.student_name','tbl_students.status','classinfo.ClassName','stugrp.GroupName','sectioninfo.SectionName')
				->orderBy('tbl_students.student_id', 'asc')
				->paginate(50);
                //->get();

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }
	
	public function search(Request $request) {
           //echo '<pre>';print_r($request->all());echo '</pre>';exit();

        $this->data['studentList'] = DB::table('tbl_students')
             ->join('classinfo','tbl_students.class_id','=','classinfo.id')
             ->join('stugrp','tbl_students.stu_group','=','stugrp.id')
             ->join('sectioninfo','tbl_students.section_id','=','sectioninfo.section_id')
             ->select('tbl_students.student_id','tbl_students.system_generated_student_id','tbl_students.student_name','tbl_students.status','classinfo.ClassName','stugrp.GroupName','sectioninfo.SectionName')
             ->where('tbl_students.student_name', 'LIKE', '%' . $request->search . '%')
             ->orWhere('tbl_students.system_generated_student_id', '=', $request->search)
             ->orWhere('classinfo.ClassName',  'LIKE','%' . $request->search . '%')
             ->orWhere('sectioninfo.SectionName', 'LIKE', '%' . $request->search . '%')
             ->get();

        return view($this->data['viewPath'] . 'viewSearch',array('data' => $this->data));
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

        if (!$request->ajax()) {

            $breadcrumb = array(
                //'App. Setup' => route('appSetup'),
                'Student' => route('student.index'),
                'New' => route('student.create'),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Add New Student';
            $this->data['studentClasses'] = DB::select('call get_student_classes(1)');
            $this->data['studentGroups']  = DB::select('call get_student_groups(1)');
			$this->data['studentSection'] = DB::select('call get_student_sections(1)');	
            $this->data['years']          = DB::select('call get_years(1)');
			                            
            $this->data['genders']        = DB::select('call get_genders(1)');
            try {
                $this->data['secInstitutes'] = DB::select('call get_sec_institute_branch_version("' . session('instituteDetails')->institute_id . '")');
                return view($this->data['viewPath'] . 'create', array('data' => $this->data));
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            throw new Exception('Invalid request!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
//        echo "<pre>";
//        print_r($request->all());
//        exit();
        if (!$request->ajax()) {
            $validator = Validator::make($request->all(), array(
                        'student_name' => 'required|max:255',
                        'year_of_admission' => 'required|max:4',
                        'class_id' => 'required',
                        'section_name' => 'required',
                        'gender' => 'required',
                        'group_name' => 'required',
                        'branch_and_version' => 'min:1|required',
                        'contact_for_sms' => 'required|digits:9',
//                        'father_name' => 'required',
//                        'father_mobile' => 'required|digits:9',
//                        'mother_name' => 'required',
//                        'mother_mobile' => 'required|digits:9',
                        'status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('student.create')
                                ->withErrors($validator)
                                ->withInput();
            }
            $gender=$request->gender;
            //echo $version=array_shift(explode("_", $request->branch_and_version));exit();
            $studentArr = array(
                'student_name' => $request->student_name,
                'year_of_admission' => $request->year_of_admission,
                'class_id' => $request->class_id,
                'section_id' => $request->section_name,
                'roll_no' => $request->roll_no,
                'gender' => $gender{0},
                'stu_group' => $request->group_name,
                'institute_branch_version_id' => $request->branch_and_version{0} ,
                'contact_for_sms' => "8801".$request->contact_for_sms,
//                'father_name' => $request->father_name,
//                'father_mobile' => "8801".$request->father_mobile,
//                'mother_name' => $request->mother_name,
//                'mother_mobile' => "8801".$request->mother_mobile,
                'status' => $request->status,
                'create_time' => date('Y-m-d h:i:s'),
                'create_logon_id' => session('sessLogonId'),
                'create_user_id' => Auth::user()->user_id,
                'last_action' => 'INSERT',
            );
//            echo "<pre>";
//            print_r($studentArr);exit();
            $studentSaving = Student::create($studentArr);
            $student_id = $studentSaving->student_id;

            $year = DB::table('tbl_years')
                    ->select('year')
                    ->where('year_id', '=', $request->year_of_admission)
                    ->where('is_active', '=', 1)
                    ->get();
            $system_generated_student_id = $year[0]->year .  substr($request->gender, strpos($request->gender, "_") + 1) . substr($request->branch_and_version, strpos($request->branch_and_version, "_") + 1) . (str_pad($student_id, 5, '0', STR_PAD_LEFT));

            $student = Student::find($student_id);
            $student->system_generated_student_id = $system_generated_student_id;
            $student->save();

            $user = new User();
            $user->full_name = $request->student_name;
            $user->password = bcrypt('1234');
            $user->username = 's' . $system_generated_student_id;
            $user->phone_no = "8801".$request->contact_for_sms;
            $user->is_active = 1;
            $user->role_id = 6;
            $user->institute_branch_version_id = $request->branch_and_version;
            $user->save();

            return redirect()->route('student.create')
                            ->with('successMessage', 'Student inserted successfully.<br>
                                    Student Name: <strong>'.$request->student_name.'</strong><br>Student ID: <strong>'.$system_generated_student_id.'</strong>');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request) {

        if (!$request->ajax()) {
            $breadcrumb = array(
                //'App. Setup' => route('appSetup'),
                'Student'    => route('student.index'),
                'Update'     => route('student.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle']      = 'Update Student';
            $this->data['stdDetails']     = Student::findOrFail($id);
            $this->data['stdDetails']     = Student::where('student_id', '=', $id)->first();
            $this->data['studentClasses'] = DB::select('call get_student_classes(1)');
			//$this->data['studentSection'] = DB::select('call get_student_sections(1)');
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        
        $this->data['studentDetails'] = Student::findOrFail($id);

        $validator = Validator::make($request->all(), array(
            
                    'student_name' => 'required|max:255',
                    'year_of_admission' => 'required|max:4',
                    'class_id' => 'required',
                    'group_name' => 'required',
					'section_name' => 'required',
					'system_generated_student_id' => 'required',
                    'gender' => 'required',
                    'branch_and_version' => 'min:1|required',
                    'contact_for_sms' => 'required|digits:9',
//                    'father_name' => 'required',
//                    'father_mobile' => 'required|digits:9',
//                    'mother_name' => 'required',
//                    'mother_mobile' => 'required|digits:9',
                    'status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('student.edit', array('id' => $id))
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
        $student->class_id = $request->class_id;
		
        $student->section_id = $request->section_name;
        $student->roll_no = $request->roll_no;
        $student->system_generated_student_id = $request->system_generated_student_id;
		
        $student->gender = $request->gender;
        $student->stu_group = $request->group_name;
        $student->institute_branch_version_id = $request->branch_and_version;
        $student->contact_for_sms = "8801".$request->contact_for_sms;
		
		$student->free_payment_view_id = $free_category;
        /* $student->father_name = $request->father_name;
        $student->father_mobile = "8801".$request->father_mobile;
        $student->mother_name = $request->mother_name;
        $student->mother_mobile = "8801".$request->mother_mobile; */
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

        return redirect()->route('student.index')
                        ->with('successMessage', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
}
