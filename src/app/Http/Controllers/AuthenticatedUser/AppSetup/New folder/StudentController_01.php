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

class StudentController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 12;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.Student.';

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
            'App. Setup' => route('appSetup'),
            'Student' => route('student.index'),
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'Student';
        $this->data['studentList'] = Student::get();

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

        if (!$request->ajax()) {

            $breadcrumb = array(
                'App. Setup' => route('appSetup'),
                'Student' => route('student.index'),
                'New' => route('student.create'),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Add New Student';
            $this->data['studentClasses'] = DB::select('call get_student_classes(1)');
            $this->data['studentGroups'] = DB::select('call get_student_groups(1)');
            $this->data['years'] = DB::select('call get_years(1)');
            $this->data['genders'] = DB::select('call get_genders(1)');
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
                        'gender' => 'required',
                        'group_name' => 'required',
                        'branch_and_version' => 'min:1|required',
                        'contact_for_sms' => 'required|digits:11',
                        'father_name' => 'required',
                        'father_mobile' => 'required|digits:11',
                        'mother_name' => 'required',
                        'mother_mobile' => 'required|digits:11',
                        'status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('student.create')
                                ->withErrors($validator)
                                ->withInput();
            }

            $studentArr = array(
                'student_name' => $request->student_name,
                'year_of_admission' => $request->year_of_admission,
                'class_id' => $request->class_id,
                'gender' => $request->gender,
                'stu_group' => $request->group_name,
                'institute_branch_version_id' => $request->branch_and_version,
                'contact_for_sms' => $request->contact_for_sms,
                'father_name' => $request->father_name,
                'father_mobile' => $request->father_mobile,
                'mother_name' => $request->mother_name,
                'mother_mobile' => $request->mother_mobile,
                'status' => $request->status,
                'create_time' => date('Y-m-d h:i:s'),
                'create_logon_id' => session('sessLogonId'),
                'create_user_id' => Auth::user()->user_id,
                'last_action' => 'INSERT',
            );
            $studentSaving = Student::create($studentArr);
            $student_id = $studentSaving->student_id;

            $year = DB::table('tbl_years')
                    ->select('year')
                    ->where('year_id', '=', $request->year_of_admission)
                    ->where('is_active', '=', 1)
                    ->get();
            $system_generated_student_id = $year[0]->year . $request->gender . $request->branch_and_version . $student_id;

            $student = Student::find($student_id);
            $student->system_generated_student_id = $system_generated_student_id;
            $student->save();

            $user = new User();
            $user->full_name = $request->student_name;
            $user->password = bcrypt('1234');
            $user->username = 's' . $system_generated_student_id;
            $user->phone_no = $request->contact_for_sms;
            $user->is_active = 1;
            $user->role_id = 6;
            $user->institute_branch_version_id = $request->branch_and_version;
            $user->save();

            return redirect()->route('student.create')
                            ->with('successMessage', 'Student inserted successfully.');
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
                'App. Setup' => route('appSetup'),
                'Student' => route('student.index'),
                'Update' => route('student.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Update Student';
            $this->data['stdDetails'] = Student::findOrFail($id);
            $this->data['stdDetails'] = Student::where('student_id', '=', $id)->first();
            $this->data['studentClasses'] = DB::select('call get_student_classes(1)');
            $this->data['studentGroups'] = DB::select('call get_student_groups(1)');
            $this->data['years'] = DB::select('call get_years(1)');
            $this->data['genders'] = DB::select('call get_genders(1)');
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
                    'gender' => 'required',
                    'branch_and_version' => 'min:1|required',
                    'contact_for_sms' => 'required|digits:11',
                    'father_name' => 'required',
                    'father_mobile' => 'required|digits:11',
                    'mother_name' => 'required',
                    'mother_mobile' => 'required|digits:11',
                    'status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('student.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $student = Student::find($id);
        $student->student_name = $request->student_name;
        $student->year_of_admission = $request->year_of_admission;
        $student->class_id = $request->class_id;
        $student->gender = $request->gender;
        $student->stu_group = $request->group_name;
        $student->institute_branch_version_id = $request->branch_and_version;
        $student->contact_for_sms = $request->contact_for_sms;
        $student->father_name = $request->father_name;
        $student->father_mobile = $request->father_mobile;
        $student->mother_name = $request->mother_name;
        $student->mother_mobile = $request->mother_mobile;
        $student->status = $request->status;
        $student->update_time = date('Y-m-d h:i:s');
        $student->update_logon_id = session('sessLogonId');
        $student->update_user_id = Auth::user()->user_id;
        $student->last_action = 'UPDATE';
        $student->save();
        

        $userArr = array(
            'full_name' => $request->student_name,
            'phone_no' => $request->contact_for_sms,
            'is_active' => 1,
            'institute_branch_version_id' => $request->branch_and_version,
        );
        $user = User::where('username', '=', $request->system_generated_student_id)
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
    public function destroy($id) {
        //
    }

}
