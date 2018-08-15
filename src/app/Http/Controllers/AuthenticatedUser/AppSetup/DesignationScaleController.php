<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\DesignationScale;
use Validator;

class DesignationScaleController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 31;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.DesignationScale.';

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
               'App. Setup'     => route('appSetup'),
            'Designation Scale' => route('degScale.index'),
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'Designation Scale';
        //$this->data['designationScaleList'] = DesignationScale::get();
		 $this  ->data['designationScaleList'] = DB::table('tbl_sec_designation_scales')
                ->join('tbl_employee_scales','tbl_sec_designation_scales.employee_scale_id','=','tbl_employee_scales.employee_scale_id')
                ->join('designationinfo','tbl_sec_designation_scales.DesigID','=','designationinfo.DesigID')
                ->select('tbl_sec_designation_scales.sec_designation_scale_id','tbl_sec_designation_scales.name','tbl_sec_designation_scales.basic_salary',
				         'tbl_sec_designation_scales.is_active','tbl_employee_scales.scale_name','designationinfo.Designation')
				//->orderBy('tbl_students.student_id', 'asc')
                ->get();

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
                'App. Setup'        => route('appSetup'),
                'Designation Scale' => route('degScale.index'),
                'New'               => route('degScale.create'),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Create Designation Scale';
            $this->data['design'] = DB::table('designationinfo')
                ->select('DesigID', 'Designation')
                ->get();
		    $this->data['empScale'] = DB::table('tbl_employee_scales')
                ->select('employee_scale_id', 'scale_name')
                ->where('is_active', '=', 1)
                ->get();		
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
                        'name'           => 'required|max:255',
                        'desig_name'     => 'min:1|required',
                        'scale_name'     => 'min:1|required',
                        'desi_status'    => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('degScale.create')
                                ->withErrors($validator)
                                ->withInput();
            }
            
            //echo '<pre>';print_r($request->all());echo '</per>';exit();
            //echo $request->branch_and_version[0];exit();
            //$totalBranchAndVersion = count($request->branch_and_version);
            //for ($i = 0; $i < $totalBranchAndVersion; $i++) {

                $degScale = new DesignationScale;
                $degScale->name              = $request->name;
                $degScale->DesigID           = $request->desig_name;
                $degScale->employee_scale_id = $request->scale_name;
                $degScale->basic_salary      = $request->basic_salary;
                $degScale->cut_basic_salary_per_day_for_absent_in_tk      = $request-> cut_basic_salary_absent;
                $degScale->house_rent_of_basic_salary_in_percent          = $request-> house_rent_percent;
                $degScale->house_rent_of_basic_salary_in_tk               = $request->house_rent_tk;
                $degScale->cut_house_rent_per_day_for_absent_in_tk        = $request->cut_house_rent_absent;
                $degScale->medical_allowance_of_basic_salary_in_percent   = $request->medical_allowance_percent;
                $degScale->medical_allowance_of_basic_salary_in_tk        = $request->medical_allowance_tk;
                $degScale->cut_medical_allowance_per_day_for_absent_in_tk = $request->cut_medical_allowance;
                $degScale->transport_cost_of_basic_salary_in_percent      = $request->transport_cost_percent;
                $degScale->transport_cost_of_basic_salary_in_tk           = $request->transport_cost_tk;
                $degScale->cut_transport_cost_per_day_for_absent_in_tk    = $request->cut_transport_cost;
                $degScale->institute_branch_version_id                    = $request->branch_version;
                $degScale->is_active = $request->desi_status;
                $degScale->create_time = date('Y-m-d h:i:s');
                $degScale->create_logon_id = session('sessLogonId');
                $degScale->create_user_id = Auth::user()->user_id;
                $degScale->last_action = 'INSERT';
                $degScale->save();
            //}
            
            return redirect()->route('degScale.create')
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

            $this->data['desiScaleDetails'] = DesignationScale::findOrFail($id);

            $breadcrumb = array(
                'App. Setup'        => route('appSetup'),
                'Designation Scale' => route('degScale.index'),
                'Update'            => route('degScale.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle']        = 'Update Designation Scale';
            $this->data['desiScaleDetails'] = DesignationScale::where('sec_designation_scale_id', '=', $id)->first();
			$this->data['empScale'] = DB::select('call get_employee_scales(1)');
			$this->data['design']   = DB::table('designationinfo')
                ->select('DesigID', 'Designation')
                ->get();
            
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

        $this->data['desiScaleDetails'] = DesignationScale::findOrFail($id);

        $validator = Validator::make($request->all(), array(
                    'name'           => 'required|max:255',
					'desig_name'     => 'min:1|required',
					'scale_name'     => 'min:1|required',
					'desi_status'    => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('degScale.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $degScale = DesignationScale::find($id);
		
        $degScale->name              = $request->name;
		$degScale->DesigID           = $request->desig_name;
		$degScale->employee_scale_id = $request->scale_name;
		$degScale->basic_salary      = $request->basic_salary;
		$degScale->cut_basic_salary_per_day_for_absent_in_tk      = $request-> cut_basic_salary_absent;
		$degScale->house_rent_of_basic_salary_in_percent          = $request-> house_rent_percent;
		$degScale->house_rent_of_basic_salary_in_tk               = $request->house_rent_tk;
		$degScale->cut_house_rent_per_day_for_absent_in_tk        = $request->cut_house_rent_absent;
		$degScale->medical_allowance_of_basic_salary_in_percent   = $request->medical_allowance_percent;
		$degScale->medical_allowance_of_basic_salary_in_tk        = $request->medical_allowance_tk;
		$degScale->cut_medical_allowance_per_day_for_absent_in_tk = $request->cut_medical_allowance;
		$degScale->transport_cost_of_basic_salary_in_percent      = $request->transport_cost_percent;
		$degScale->transport_cost_of_basic_salary_in_tk           = $request->transport_cost_tk;
		$degScale->cut_transport_cost_per_day_for_absent_in_tk    = $request->cut_transport_cost;
		$degScale->institute_branch_version_id                    = $request->branch_version;
		$degScale->is_active = $request->desi_status;
		
        $degScale->update_time = date('Y-m-d h:i:s');
        $degScale->update_logon_id = session('sessLogonId');
        $degScale->update_user_id = Auth::user()->user_id;
        $degScale->last_action = 'UPDATE';
        $degScale->save();

        return redirect()->route('degScale.index')
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
