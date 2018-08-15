<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Salary;
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
        $this->data['salarySubHeadList'] = DB::select('call get_salary_sub_head_details("1")');

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
    public function store(Request $request) {//echo '<pre>';print_r($request->all());exit();

        if (!$request->ajax()) {

            $validator = Validator::make($request->all(), array(
                        'salary_sub_head_name' => 'required|max:255',
                        'grade_name' => 'required',
                        'salary_amount' => 'required|numeric',
                        'salary_status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('salary.create')
                                ->withErrors($validator)
                                ->withInput();
            }

            $salary = new Salary;
            $salary->salary_sub_head_name = $request->salary_sub_head_name;
            $salary->grade_id = $request->grade_name;
            $salary->salary_amount = $request->salary_amount;
            $salary->is_active = $request->salary_status;
            $salary->create_time = date('Y-m-d h:i:s');
            $salary->create_logon_id = session('sessLogonId');
            $salary->create_user_id = Auth::user()->user_id;
            $salary->last_action = 'INSERT';
            $salary->save();

            return redirect()->route('salary.create')
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
            
            $this->data['salarySubHeadList'] = Salary::findOrFail($id);
            
            $breadcrumb = array(
                'App. Setup' => route('appSetup'),
                'Salary' => route('salary.index'),
                'Update' => route('salary.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Update Salary';
			$this->data['employeeGradeList'] = DB::select('call get_employee_grades(1)');
            $this->data['salarySubHeadList'] = Salary::where('salary_sub_head_id', '=', $id)->first();
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

        $this->data['salaryDetails'] = Salary::findOrFail($id);

        $validator = Validator::make($request->all(), array(
                    'salary_sub_head_name' => 'required|max:255',
                    'grade_name' => 'required',
                    'salary_amount' => 'required|numeric',
                    'salary_status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('salary.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $salary = Salary::find($id);
        $salary->salary_sub_head_name = $request->salary_sub_head_name;
        $salary->grade_id = $request->grade_name;
        $salary->salary_amount = $request->salary_amount;
        $salary->is_active = $request->salary_status;
        $salary->update_time = date('Y-m-d h:i:s');
        $salary->update_logon_id = session('sessLogonId');
        $salary->update_user_id = Auth::user()->user_id;
        $salary->last_action = 'UPDATE';
        $salary->save();

        return redirect()->route('salary.index')
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
