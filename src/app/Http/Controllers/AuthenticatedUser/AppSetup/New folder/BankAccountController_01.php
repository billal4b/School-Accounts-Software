<?php

namespace App\Http\Controllers\AuthenticatedUser\Resource;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\BankAccount;
use Validator;

class BankAccountController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 6;
        $this->data['viewPath'] = 'AuthenticatedUser.Resource.BankAccount.';

        if ($this->_hasPrivilegeToAccessTheMenu($this->data['menuId'], Auth::user()->role_id) == 0) {
            abort(404);
        };

        $this->data['jsArray'][] = 'Resource_BankAccount.js';
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

        $this->data['pageTitle'] = 'Bank Account';

        $this->data['bankAccountList'] = DB::table('tbl_bank_accounts')
                ->select('tbl_bank_accounts.account_id', 'tbl_bank_accounts.account_no', 'tbl_bank_accounts.is_active', 'tbl_banks.bank_name', 'tbl_bank_branches.branch_name')
                ->join('tbl_bank_branches', 'tbl_bank_branches.branch_id', '=', 'tbl_bank_accounts.branch_id')
                ->join('tbl_banks', 'tbl_banks.bank_id', '=', 'tbl_bank_branches.bank_id')
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

            $this->data['pageTitle'] = 'Create Bank Account';
            $this->data['banks'] = DB::table('tbl_banks')
                    ->select('bank_id', 'bank_name')
                    ->where('is_active', '=', 1)
                    ->get();

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
                        'account_no' => 'required|max:255',
                        'bank_name' => 'required',
                        'branch_name' => 'required',
                        'account_status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('bankAccount.create')
                                ->withErrors($validator)
                                ->withInput();
            }

            $bankAccount = new BankAccount;
            $bankAccount->account_no = $request->account_no;
            $bankAccount->branch_id = $request->branch_name;
            $bankAccount->is_active = $request->account_status;
            $bankAccount->create_time = date('Y-m-d h:i:s');
            $bankAccount->create_logon_id = session('sessLogonId');
            $bankAccount->create_user_id = Auth::user()->user_id;
			$bankAccount->last_action = 'INSERT';
            $bankAccount->save();

            return redirect()->route('bankAccount.create')
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

            $this->data['pageTitle'] = 'Update Bank Account';
            $this->data['bankAccountDetails'] = BankAccount::findOrFail($id);
            $this->data['bankAccountDetails'] = BankAccount::where('account_id', '=', $id)->first();
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

        $this->data['bankAccountDetails'] = BankAccount::findOrFail($id);

        $validator = Validator::make($request->all(), array(
                    'account_no' => 'required|max:255',
                    'bank_name' => 'required',
                    'branch_name' => 'required',
                    'account_status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('bankAccount.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }


        $bankAccount = BankAccount::find($id);
        $bankAccount->account_no = $request->account_no;
        $bankAccount->branch_id = $request->branch_name;
        $bankAccount->is_active = $request->account_status;
        $bankAccount->update_time = date('Y-m-d h:i:s');
        $bankAccount->update_logon_id = session('sessLogonId');
        $bankAccount->update_user_id = Auth::user()->user_id;
		$bankAccount->last_action = 'UPDATE';
        $bankAccount->save();

        return redirect()->route('bankAccount.index')
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

    public function getBranchNameByBankId($bankId) {

        $banks = DB::table('tbl_bank_branches')
                ->select('branch_id', 'branch_name')
                ->where('bank_id', '=', $bankId)
                ->where('is_active', '=', 1)
                ->get();
        echo '<option value="">----- Select -----</option>';
        foreach ($banks as $bnks) {
            echo '<option value="' . $bnks->branch_id . '">' . $bnks->branch_name . '</option>';
        }
    }

}
