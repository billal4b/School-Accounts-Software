<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\AccountingSubHead;
use Validator;

class AccountingSubHeadController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 10;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.AccountingSubHead.';

        if ($this->_hasPrivilegeToAccessTheMenu($this->data['menuId'], Auth::user()->role_id) == 0) {
            // abort(404);
        };
		$this->data['jsArray'][] = 'Resource_AccountingSubHead.js';
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
            'Sub Head' => route('subHead.index'),
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'Sub Head';
        $this->data['subHeadList'] = DB::table('tbl_accounting_sub_heads')
                ->select('tbl_accounting_sub_heads.sub_head_id', 'tbl_accounting_sub_heads.sub_head_name', 'tbl_accounting_sub_heads.is_active', 'tbl_accounting_heads.head_name')
                ->join('tbl_accounting_heads', 'tbl_accounting_sub_heads.head_id', '=', 'tbl_accounting_heads.head_id')
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
                'Sub Head' => route('subHead.index'),
                'New' => route('subHead.create'),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Sub Head Account';
            $this->data['accountCategories'] = DB::table('tbl_account_categories')
                    ->select('account_category_id', 'account_category_name')
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
                        'sub_head_name' => 'required|max:255',
                        'accounting_category' => 'required',
                        'head_name' => 'required',
                        'sub_head_status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('subHead.create')
                                ->withErrors($validator)
                                ->withInput();
            }

            $subHead = new AccountingSubHead;
            $subHead->sub_head_name = $request->sub_head_name;
			$subHead->account_category_id = $request->accounting_category;
            $subHead->head_id = $request->head_name;
            $subHead->is_active = $request->sub_head_status;
            $subHead->create_time = date('Y-m-d h:i:s');
            $subHead->create_logon_id = session('sessLogonId');
            $subHead->create_user_id = Auth::user()->user_id;
            $subHead->last_action = 'INSERT';
            $subHead->save();

            return redirect()->route('subHead.create')
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
                'Sub Head' => route('subHead.index'),
                'Update' => route('subHead.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Update Sub Head';
            $this->data['subHeadDetails'] = AccountingSubHead::findOrFail($id);
            $this->data['subHeadDetails'] = AccountingSubHead::where('sub_head_id', '=', $id)->first();
            
			$this->data['accountCategories'] = DB::table('tbl_account_categories')
                    ->select('account_category_id', 'account_category_name')               
                    ->where('is_active', '=', 1)
                    ->get();
			$this->data['heads'] = DB::table('tbl_accounting_heads')
                    ->select('head_id', 'head_name')               
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $this->data['subHeadDetails'] = AccountingSubHead::findOrFail($id);

        $validator = Validator::make($request->all(), array(
                    'sub_head_name'       => 'required|max:255',
					'accounting_category' => 'required',
                    'head_name'           => 'required',
                    'sub_head_status'     => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('subHead.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $subHead = AccountingSubHead::find($id);
        $subHead->sub_head_name = $request->sub_head_name;
        $subHead->account_category_id = $request->accounting_category;
        $subHead->head_id = $request->head_name;
        $subHead->is_active = $request->sub_head_status;
        $subHead->update_time = date('Y-m-d h:i:s');
        $subHead->update_logon_id = session('sessLogonId');
        $subHead->update_user_id = Auth::user()->user_id;
        $subHead->last_action = 'UPDATE';
        $subHead->save();

        return redirect()->route('subHead.index')
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
	
	
	public function getHeadNameByAccountingCategoryId($headId) {

        $banks = DB::table('tbl_accounting_heads')
                ->select('head_id', 'head_name')
                ->where('account_category_id', '=', $headId)
                ->where('is_active', '=', 1)
                ->get();
        echo '<option value="">----- Select -----</option>';
        foreach ($banks as $bnks) {
            echo '<option value="' . $bnks->head_id . '">' . $bnks->head_name . '</option>';
        }
    }

}
