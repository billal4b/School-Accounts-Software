<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\EmployeeScale;
use Validator;

class EmployeeScaleController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 29;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.EmployeeScale.';

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
            'Employee Scale' => route('empScale.index'),
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'Employee Scale';
        $this->data['employeeScaleList'] = EmployeeScale::get();

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
                'App. Setup'     => route('appSetup'),
                'Employee Scale' => route('empScale.index'),
                'New'            => route('empScale.create'),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Create Employee Scale';
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

        if (!$request->ajax()) {

            $validator = Validator::make($request->all(), array(
                        'scale_name'         => 'required|max:255',
                        //'branch_and_version' => 'min:1|required',
                        'scale_status'       => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('empScale.create')
                                ->withErrors($validator)
                                ->withInput();
            }
            
            //echo '<pre>';print_r($request->all());echo '</per>';exit();
            //echo $request->branch_and_version[0];exit();
            //$totalBranchAndVersion = count($request->branch_and_version);
            //for ($i = 0; $i < $totalBranchAndVersion; $i++) {

                $empScale = new EmployeeScale;
                $empScale->scale_name = $request->scale_name;
                //$empScale->institute_branch_version_id = $request->branch_and_version[$i];
                $empScale->is_active = $request->scale_status;
                $empScale->create_time = date('Y-m-d h:i:s');
                $empScale->create_logon_id = session('sessLogonId');
                $empScale->create_user_id = Auth::user()->user_id;
                $empScale->last_action = 'INSERT';
                $empScale->save();
            //}
            
            return redirect()->route('empScale.create')
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

            $this->data['empScaleDetails'] = EmployeeScale::findOrFail($id);

            $breadcrumb = array(
                'App. Setup'     => route('appSetup'),
                'Employee Scale' => route('empScale.index'),
                'Update'         => route('empScale.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Update Employee Scale';
            $this->data['empScaleDetails'] = EmployeeScale::where('employee_scale_id', '=', $id)->first();
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

        $this->data['empGradeDetails'] = EmployeeScale::findOrFail($id);

        $validator = Validator::make($request->all(), array(
                    'scale_name' => 'required|max:255',
                    //'branch_and_version' => 'min:1|required',
                    'scale_status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('empScale.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $empScale = EmployeeScale::find($id);
        $empScale->scale_name = $request->scale_name;
        //$empScale->institute_branch_version_id = $request->branch_and_version;
        $empScale->is_active = $request->scale_status;
        $empScale->update_time = date('Y-m-d h:i:s');
        $empScale->update_logon_id = session('sessLogonId');
        $empScale->update_user_id = Auth::user()->user_id;
        $empScale->last_action = 'UPDATE';
        $empScale->save();

        return redirect()->route('empScale.index')
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
