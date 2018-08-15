<?php

namespace App\Http\Controllers\AuthenticatedUser\Resource;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\BankBranch;
use Validator;

class BankBranchController extends Controller{
	
	public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 5;
        $this->data['viewPath'] = 'AuthenticatedUser.Resource.BankBranch.';

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
    public function index(){
        
		$this->data['pageTitle'] = 'Bank Branch';
        $this->data['branchList'] = DB::table('tbl_bank_branches')
                ->select('tbl_bank_branches.branch_id', 'tbl_bank_branches.branch_name', 'tbl_bank_branches.is_active', 'tbl_banks.bank_name')
                ->join('tbl_banks', 'tbl_bank_branches.bank_id', '=', 'tbl_banks.bank_id')
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

            $this->data['pageTitle'] = 'Create Bank Branch';
            $this->data['banks'] = DB::table('tbl_banks')
                    ->select('bank_id', 'bank_name')
                    ->where('is_active', '=', 1)
                    ->get();
            //echo '<pre>';print_r($this->data['banks']);echo '</pre>';exit();
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
                        'branch_name' => 'required|max:255',
                        'bank_name' => 'required',
                        'branch_status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('branch.create')
                                ->withErrors($validator)
                                ->withInput();
            }

            $branch = new BankBranch;
            $branch->branch_name = $request->branch_name;
            $branch->bank_id = $request->bank_name;
            $branch->is_active = $request->branch_status;
            $branch->create_time = date('Y-m-d h:i:s');
            $branch->create_logon_id = session('sessLogonId');
            $branch->create_user_id = Auth::user()->user_id;
			$branch->last_action = 'INSERT';
            $branch->save();

            return redirect()->route('branch.create')
                            ->with('successMessage', 'Data inserted successfully.');
        }
    }

    public function edit($id, Request $request) {

        if (!$request->ajax()) {

            $this->data['pageTitle'] = 'Update Bank Branch';
            $this->data['branchDetails'] = BankBranch::findOrFail($id);
            $this->data['branchDetails'] = BankBranch::where('branch_id', '=', $id)->first();
            $this->data['banks'] = DB::table('tbl_banks')
                    ->select('bank_id', 'bank_name')
                    ->where('is_active', '=', 1)
                    ->get();
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
        
        $this->data['branchDetails'] = BankBranch::findOrFail($id);
        
        $validator = Validator::make($request->all(), array(
                    'branch_name' => 'required|max:255',
                    'bank_name' => 'required',
                    'branch_status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('branch.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $branch = BankBranch::find($id);
        $branch->branch_name = $request->branch_name;
        $branch->bank_id = $request->bank_name;
        $branch->is_active = $request->branch_status;
        $branch->update_time = date('Y-m-d h:i:s');
        $branch->update_logon_id = session('sessLogonId');
        $branch->update_user_id = Auth::user()->user_id;
		$branch->last_action = 'UPDATE';
        $branch->save();

        return redirect()->route('branch.index')
                        ->with('successMessage', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
