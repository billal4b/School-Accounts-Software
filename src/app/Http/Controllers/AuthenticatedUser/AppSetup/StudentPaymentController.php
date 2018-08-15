<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\StudentPayment;
use Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentPaymentController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 13;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.StudentPayment.';

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
            'Student Payment' => route('studentPayment.index'),
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'Student Payment';
        //$this->data['studentPaymentList'] = StudentPayment::get();
		$this-> data['studentPaymentList'] = DB::table('tbl_student_payment_sub_head_details AS spshd ')
			 -> join('classinfo','classinfo.id','=','spshd.class_name')
			 -> join('stugrp','stugrp.id','=','spshd.group_name')
			 -> select ('spshd.student_payment_id','spshd.student_payment_name','spshd.payment_amount','spshd.is_active','classinfo.ClassName','stugrp.GroupName')	
			 -> orderBy('student_payment_id', 'asc')
			 -> paginate(50);
			 // -> get();

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
                'Student Payment' => route('studentPayment.index'),
                'New' => route('studentPayment.create'),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Create Student Payment';
            $this->data['studentClasses'] = DB::select('call get_student_classes(1)');
            $this->data['studentGroups'] = DB::select('call get_student_groups(1)');
            $this->data['feesTypes'] = DB::select('call get_student_fees_types(1)');
            try {
                
                $this->data['secInstitutes'] = DB::select('call get_sec_institute_branch_version("' . session('instituteDetails')->institute_id . '")');
                //echo '<pre>';print_r($this->data['secInstitutes']);echo '</pre>';exit();
                
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

        if (!$request->ajax()) {

            $validator = Validator::make($request->all(), array(
                        'student_payment_name' => 'required|max:255',
                        'class_name' => 'required',
                        'group_name' => 'required',
                        'fees_type' => 'required',
                        'branch_and_version' => 'min:1|required',
                        'payment_amount' => 'required|numeric',
                        'student_payment_status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('studentPayment.create')
                                ->withErrors($validator)
                                ->withInput();
            }
            
            $totalBranchAndVersion = count($request->branch_and_version);
            for ($i = 0; $i < $totalBranchAndVersion; $i++) {

             
                $studentPayment = new StudentPayment;

                $studentPayment->student_payment_name = $request->student_payment_name;
                $studentPayment->class_name = $request->class_name;
                $studentPayment->group_name = $request->group_name;
                $studentPayment->fees_type = $request->fees_type;
                $studentPayment->payment_month = $request->payment_month;
                $studentPayment->payment_amount = $request->payment_amount;
                $studentPayment->institute_branch_version_id = $request->branch_and_version[$i];
                $studentPayment->is_active = $request->student_payment_status;
                $studentPayment->create_time = date('Y-m-d h:i:s');
                $studentPayment->create_logon_id = session('sessLogonId');
                $studentPayment->create_user_id = Auth::user()->user_id;
                $studentPayment->last_action = 'INSERT';
                $studentPayment->save();
            }
            return redirect()->route('studentPayment.create')
                            ->with('successMessage', 'Data inserted successfully.');
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
                'Student Payment' => route('studentPayment.index'),
                'Update' => route('studentPayment.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Update Student Payment';
            $this->data['stdPaymentDetails'] = StudentPayment::findOrFail($id);
            $this->data['stdPaymentDetails'] = StudentPayment::where('student_payment_id', '=', $id)->first();
            $this->data['studentClasses'] = DB::select('call get_student_classes(1)');
            $this->data['studentGroups'] = DB::select('call get_student_groups(1)');
            $this->data['feesTypes'] = DB::select('call get_student_fees_types(1)');
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

        $this->data['studentPaymentDetails'] = StudentPayment::findOrFail($id);

        $validator = Validator::make($request->all(), array(
                    'student_payment_name' => 'required|max:255',
                    'class_name' => 'required',
                    'group_name' => 'required',
                    'fees_type' => 'required',
                    'branch_and_version' => 'min:1|required',
                    'payment_amount' => 'required|numeric',
                    'student_payment_status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('studentPayment.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $studentPayment = StudentPayment::find($id);

        $studentPayment->student_payment_name = $request->student_payment_name;
        $studentPayment->class_name = $request->class_name;
        $studentPayment->group_name = $request->group_name;
        $studentPayment->fees_type = $request->fees_type;
        $studentPayment->payment_month = $request->payment_month;
        $studentPayment->payment_amount = $request->payment_amount;
        $studentPayment->is_active = $request->student_payment_status;
        $studentPayment->update_time = date('Y-m-d h:i:s');
        $studentPayment->update_logon_id = session('sessLogonId');
        $studentPayment->update_user_id = Auth::user()->user_id;
        $studentPayment->last_action = 'UPDATE';
        $studentPayment->institute_branch_version_id = $request->branch_and_version;
        $studentPayment->save();

        return redirect()->route('studentPayment.index')
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
