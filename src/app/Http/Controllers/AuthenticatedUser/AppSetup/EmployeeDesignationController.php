<?php

namespace App\Http\Controllers\AuthenticatedUser\Resource;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\EmployeeDesignation;
use Validator;

class EmployeeDesignationController extends Controller{

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 3;
        $this->data['viewPath'] = 'AuthenticatedUser.Resource.EmployeeDesignation.';//------Designation-------//

        if ($this->_hasPrivilegeToAccessTheMenu($this->data['menuId'], Auth::user()->role_id) == 0) {
            abort(404);
        };  
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

        $this->data['pageTitle'] = 'Employee Designation';
        $this->data['employeeDesignationList'] = EmployeeDesignation::get();//------Designation-------//

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {

        if (!$request->ajax()) {

            $this->data['pageTitle'] = 'Create Designation';
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
                        'designation_name' => 'required|max:255',
                        'designation_status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('empDesignation.create')
                                ->withErrors($validator)
                                ->withInput();
            }

            $empDesignation = new EmployeeDesignation;  //------Designation-------//
            $empDesignation->designation_name = $request->designation_name;
            $empDesignation->is_active = $request->designation_status;
            $empDesignation->create_time = date('Y-m-d h:i:s');
            $empDesignation->create_logon_id = session('sessLogonId');
            $empDesignation->create_user_id = Auth::user()->user_id;
            $empDesignation->last_action = 'INSERT';
            $empDesignation->save();

            return redirect()->route('empDesignation.create')
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

            $this->data['pageTitle'] = 'Update Designation Grade';
            $this->data['empDesignationDetails'] = EmployeeDesignation::findOrFail($id);  //------Designation-------//
            $this->data['empDesignationDetails'] = EmployeeDesignation::where('designation_id', '=', $id)->first(); //------Designation-------//
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
        
        $this->data['empDesignationDetails'] = EmployeeDesignation::findOrFail($id); //------Designation-------//
        
        $validator = Validator::make($request->all(), array(
                    'designation_name' => 'required|max:255',
                    'designation_status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('empDesignation.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $empDesignation = EmployeeDesignation::find($id); //------Designation-------//
        $empDesignation->designation_name = $request->designation_name;
        $empDesignation->is_active = $request->designation_status;
        $empDesignation->update_time = date('Y-m-d h:i:s');
        $empDesignation->update_logon_id = session('sessLogonId');
        $empDesignation->update_user_id = Auth::user()->user_id;
        $empDesignation->last_action = 'UPDATE';
        $empDesignation->save();

        return redirect()->route('empDesignation.index')
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
