<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

use App\AccountCategory ;
use Validator;

class AccountingCategoryController extends Controller{
	
    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 8;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.AccountingCategory.';

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
    public function index(){
		
		$breadcrumb = array(
            'App. Setup' => route('appSetup'),
            'Account Category' => route('accountCategory.index'),
        );
        $this->_setBreadcrumbs($breadcrumb);
		
        $this->data['pageTitle'] = 'Account Category';
        $this->data['accountCategoryList'] = AccountCategory::get();

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        
		if (!$request->ajax()) {
			
			$breadcrumb = array(
                'App. Setup' => route('appSetup'),
                'Account Category' => route('accountCategory.index'),
                'New' => route('accountCategory.create'),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Create Account Category';
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
    public function store(Request $request){
        
		if (!$request->ajax()) {

            $validator = Validator::make($request->all(), array(
                        'account_category_name' => 'required|max:255',
                        'account_category_status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('accountCategory.create')
                                ->withErrors($validator)
                                ->withInput();
            }

            $accountCategory = new AccountCategory;
            $accountCategory->account_category_name = $request->account_category_name;
            $accountCategory->is_active = $request->account_category_status;
            $accountCategory->create_time = date('Y-m-d h:i:s');
            $accountCategory->create_logon_id = session('sessLogonId');
            $accountCategory->create_user_id = Auth::user()->user_id;
            $accountCategory->last_action = 'INSERT';
            $accountCategory->save();

            return redirect()->route('accountCategory.create')
                            ->with('successMessage', 'Data inserted successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
                'Account Category' => route('accountCategory.index'),
                'Update' => route('accountCategory.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Update Account Category';
            $this->data['accountCategoryDetails'] = AccountCategory::findOrFail($id);
            $this->data['accountCategoryDetails'] = AccountCategory::where('account_category_id', '=', $id)->first();
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
        
        $this->data['accountCategoryDetails'] = AccountCategory::findOrFail($id);
        
        $validator = Validator::make($request->all(), array(
                    'account_category_name' => 'required|max:255',
                    'account_category_status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('accountCategory.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $accountCategory = AccountCategory::find($id);
        $accountCategory->account_category_name = $request->account_category_name;
        $accountCategory->is_active = $request->account_category_status;
        $accountCategory->update_time = date('Y-m-d h:i:s');
        $accountCategory->update_logon_id = session('sessLogonId');
        $accountCategory->update_user_id = Auth::user()->user_id;
        $accountCategory->last_action = 'UPDATE';
        $accountCategory->save();

        return redirect()->route('accountCategory.index')
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
