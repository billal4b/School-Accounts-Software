<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Validator;
use PDF;
use App\SalarySheet;

class SalarySheetController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 23;
        $this->data['viewPath'] = 'AuthenticatedUser.SalarySheet.';

        if ($this->_hasPrivilegeToAccessTheMenu($this->data['menuId'], Auth::user()->role_id) == 0) {
            abort(404);
        };

        $this->data['jsArray'][] = 'SalarySheet.js';
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
            'Salary Sheet' => route('salarySheet::index'),
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'Salary Sheet';
        $this->data['user_roles'] = DB::table('tbl_roles')->select('role_id', 'role_name')->where('is_active', '=', 1)->get();
        $this->data['secInstitutes'] = DB::select('call get_sec_institute_branch_version("' . session('instituteDetails')->institute_id . '")');
        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

    private function checkHaveSalaryRecordsExist($month, $role_id) {

        //return DB::table('tbl_');
    }

    public function process(Request $request, $month, $user_role_id, $ibv_id) {

        //$add_comma_at_last_of_ibv_id = (string)$ibv_id . ',';
        $filter_user_role_id = preg_split('/[_A-Z\s,]+/', $user_role_id);
        $filter_ibv_id = preg_split('/[_A-Z\s,]+/', $ibv_id);
        //echo $filter_ibv_id;exit();
        //echo $request->session()->institute_branch_version_id;exit();
        //echo '<pre>';print_r($filter_ibv_id);echo '</pre>';exit();
        //$month          = $month;
//        $role_id = implode('', $filter_user_role_id);
//        $branch_version = implode('', $filter_ibv_id);
        //echo $role_id;exit();
//        $role_id = array_pop($filter_user_role_id);
//        $branch_version = array_pop($filter_ibv_id);
//        echo typeOf($role_id);exit();
        //echo '<pre>';print_r($filter_user_role_id);echo '</pre>';exit();

        try {

            DB::table('tbl_salary_sheets')
                    ->whereIn('role_id', $filter_user_role_id)
                    ->where('month', '=', $month)
                    ->whereIn('institute_branch_version_id', $filter_ibv_id)
                    ->delete();



            $users = DB::table('tbl_users')
                    ->select('user_id', 'institute_branch_version_id', 'role_id')
                    ->whereIn('role_id', $filter_user_role_id)
                    ->whereIn('institute_branch_version_id', $filter_ibv_id)
                    ->where('is_active', '=', 1)
                    ->get();

            //echo '<pre>';print_r($users);echo '</pre>';exit();
//            $exist_user = DB::table('tbl_salary_sheets')
//                    ->select('user_id')
//                    ->where('month', '=', $month)
//                    ->where('institute_branch_version_id', '=', Auth::user()->institute_branch_version_id)
//                    ->get();
//            $exist_user2 = array(0 => '0');
//            foreach ($exist_user as $eu) {
//
//                $exist_user2[] = $eu->user_id;
//            }
            // echo '<pre>';print_r($exist_user2);echo '</pre>';exit();
//            $branch_version = DB::table('tbl_sec_institute_branch_version')
//                    ->select('institute_branch_version_id')
//                    ->where('institute_branch_version_id', '=', $branch_version)
//                    ->get();
//            $branch_version_arr = array(0 => '0');
//            foreach ($branch_version as $bv) {
//
//                $branch_version_arr[] = $bv->institute_branch_version_id;
//            }
            //echo '<pre>';print_r($branch_version_arr);echo '</pre>';exit();

            $total_users = count($users);
            if ($total_users > 0) {
                foreach ($users as $u) {

//                    if (!in_array($u->EmpID, $exist_user2)) {

                    $salary_sheet = new SalarySheet;
                    $salary_sheet->user_id = $u->user_id;
                    $salary_sheet->month = $month;
                    $salary_sheet->institute_branch_version_id = $u->institute_branch_version_id;
                    $salary_sheet->role_id = $u->role_id;
                    $salary_sheet->create_time = date('Y-m-d h:i:s');
                    $salary_sheet->create_logon_id = session('sessLogonId');
                    $salary_sheet->create_user_id = Auth::user()->user_id;
                    $salary_sheet->last_action = 'INSERT';
                    $salary_sheet->save();
//                    }
                }
                echo 'Salary sheet has been processed.';
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function view(Request $request, $month, $user_role_id, $ibv_id) {

        //echo '<pre>';print_r($request->all());echo '</pre>';exit();
        $filter_user_role_id = preg_split('/[_A-Z\s]+/', $user_role_id);
        $filter_ibv_id = preg_split('/[_A-Z\s]+/', $ibv_id);
        
        //echo '<pre>';print_r($filter_ibv_id);echo '</pre>';exit();
        $role_id = implode('', $filter_user_role_id);
        $branch_version = implode('', $filter_ibv_id);
        
//        $month = $request->month;
//        $role_id = $request->user_role_id;
        try {
//            echo $month . '_____' . $role_id . '_____' . $branch_version;exit();

            $this->data['salary_sheets'] = DB::select('call salary_sheet_month_wise("' . $month . '", "' . $role_id . '", "' . $branch_version . '")');
//echo '<pre>';print_r($this->data['salary_sheets']);echo '</pre>';exit();
            return view($this->data['viewPath'] . 'view', array('data' => $this->data));

            //echo '<pre>';print_r($users);echo '</pre>';
        } catch (\Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function edit($id) {

        $this->data['salary_sheet_details'] = SalarySheet::findOrFail($id);

        $breadcrumb = array(
            'Salary Sheet' => route('salarySheet::index'),
            'Edit' => route('salarySheet::edit', array('salary_sheet_id' => $id)),
        );
        $this->_setBreadcrumbs($breadcrumb);
        $this->data['pageTitle'] = 'Salary Sheet';

        return view($this->data['viewPath'] . 'edit', array('data' => $this->data));
    }

    public function update(Request $request, $id) {

        //echo '<pre>';print_r($request->all());echo '</pre>';exit();
        $salary_sheet = SalarySheet::find($id);
        $salary_sheet->tax = $request->input('tax');
        $salary_sheet->absent_in_month = $request->input('absent_in_month');
        $salary_sheet->cpf_loan_adj = $request->input('cpf_loan_adj');
        $salary_sheet->remarks = $request->input('remarks');
        $salary_sheet->save();

        return redirect()->route('salarySheet::index');
    }

}
