<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\EmployeeGrade;
use Validator;

class SalaryController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 11;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.Salary.';

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
            'Salary' => route('salary.index'),
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'Salary';
        $this->data['employeeGradeList'] = EmployeeGrade::get();

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
                'Salary' => route('salary.index'),
                'New' => route('salary.create'),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Create Salary';
            $this->data['employeeGradeList'] = DB::select('call get_employee_grades(1)');
            try {
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
                        'grade_name' => 'required|max:255',
                        'grade_status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('empGrade.create')
                                ->withErrors($validator)
                                ->withInput();
            }

            $empGrade = new EmployeeGrade;
            $empGrade->grade_name = $request->grade_name;
            $empGrade->is_active = $request->grade_status;
            $empGrade->create_time = date('Y-m-d h:i:s');
            $empGrade->create_logon_id = session('sessLogonId');
            $empGrade->create_user_id = Auth::user()->user_id;
            $empGrade->last_action = 'INSERT';
            $empGrade->save();

            return redirect()->route('empGrade.create')
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
            
            $this->data['empGradeDetails'] = EmployeeGrade::findOrFail($id);
            
            $breadcrumb = array(
                'App. Setup' => route('appSetup'),
                'Employee Grade' => route('empGrade.index'),
                'Update' => route('empGrade.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Update Employee Grade';
            $this->data['empGradeDetails'] = EmployeeGrade::where('grade_id', '=', $id)->first();
            try {
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

        $this->data['empGradeDetails'] = EmployeeGrade::findOrFail($id);

        $validator = Validator::make($request->all(), array(
                    'grade_name' => 'required|max:255',
                    'grade_status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('empGrade.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $empGrade = EmployeeGrade::find($id);
        $empGrade->grade_name = $request->grade_name;
        $empGrade->is_active = $request->grade_status;
        $empGrade->update_time = date('Y-m-d h:i:s');
        $empGrade->update_logon_id = session('sessLogonId');
        $empGrade->update_user_id = Auth::user()->user_id;
        $empGrade->last_action = 'UPDATE';
        $empGrade->save();

        return redirect()->route('empGrade.index')
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
