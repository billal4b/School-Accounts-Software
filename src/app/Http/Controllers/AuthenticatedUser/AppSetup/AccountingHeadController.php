<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\AccountingHead;
use Validator;

class AccountingHeadController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 9;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.AccountingHead.';

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
            'Head' => route('head.index'),
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'Acciunt Head Details';
        $this->data['headList'] = DB::table('tbl_accounting_heads')
                ->select('tbl_accounting_heads.head_id', 'tbl_accounting_heads.head_name', 'tbl_accounting_heads.is_active', 'tbl_account_categories.account_category_name')
                ->join('tbl_account_categories', 'tbl_accounting_heads.account_category_id', '=', 'tbl_account_categories.account_category_id')
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
                'App. Setup' => route('appSetup'),
                ' Head' => route('head.index'),
                'New' => route('head.create'),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Create Head';
            $this->data['categories'] = DB::table('tbl_account_categories')
                    ->select('account_category_id', 'account_category_name')
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
                        'head_name' => 'required|max:255',
                        'account_category_name' => 'required',
                        'head_status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('head.create')
                                ->withErrors($validator)
                                ->withInput();
            }

            $head = new AccountingHead;
            $head->head_name = $request->head_name;
            $head->account_category_id = $request->account_category_name;
            $head->is_active = $request->head_status;
            $head->create_time = date('Y-m-d h:i:s');
            $head->create_logon_id = session('sessLogonId');
            $head->create_user_id = Auth::user()->user_id;
            $head->last_action = 'INSERT';
            $head->save();

            return redirect()->route('head.create')
                            ->with('successMessage', 'Data inserted successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
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
                'Head' => route('head.index'),
                'Update' => route('head.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Update Head Details';
            $this->data['headDetails'] = AccountingHead::findOrFail($id);
            $this->data['headDetails'] = AccountingHead::where('head_id', '=', $id)->first();
            $this->data['categories'] = DB :: table('tbl_account_categories')
                    ->select('account_category_id', 'account_category_name')
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
        $this->data['headDetails'] = AccountingHead::findOrFail($id);

        $validator = Validator::make($request->all(), array(
                    'head_name' => 'required|max:255',
                    'account_category_name' => 'required',
                    'head_status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('head.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $head = AccountingHead::find($id);
        $head->head_name = $request->head_name;
        $head->account_category_id = $request->account_category_name;
        $head->is_active = $request->head_status;
        $head->update_time = date('Y-m-d h:i:s');
        $head->update_logon_id = session('sessLogonId');
        $head->update_user_id = Auth::user()->user_id;
        $head->last_action = 'UPDATE';
        $head->save();

        return redirect()->route('head.index')
                        ->with('successMessage', 'Data updated successfully.');
        $this->data['subHeadDetails'] = SubHead::findOrFail($id);

        $validator = Validator::make($request->all(), array(
                    'sub_head_name' => 'required|max:255',
                    'head_name' => 'required',
                    'sub_head_status' => 'required',
        ));
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
