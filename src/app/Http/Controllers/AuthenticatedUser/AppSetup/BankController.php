<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Bank;
use Validator;

class BankController extends Controller{
	
	 public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 4;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.Bank.';

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
     * Display a listing of the appSetup.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
		
		$breadcrumb = array(
            'App. Setup' => route('appSetup'),
            'Bank' => route('bank.index'),
        );		
        $this->_setBreadcrumbs($breadcrumb);
		
		
        $this->data['pageTitle'] = 'Bank Details';
        $this->data['bankList'] = Bank::get(); //--- bankList-- index.bland.php--//

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

    /**
     * Show the form for creating a new appSetup.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request) {

        if (!$request->ajax()) {
			
			$breadcrumb = array(
                'App. Setup' => route('appSetup'),
                'Bank ' => route('bank.index'),
                'New' => route('bank.create'),
            );
            $this->_setBreadcrumbs($breadcrumb);

			
            $this->data['pageTitle'] = 'Create Bank';
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
     * Store a newly created appSetup in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
		
        if (!$request->ajax()) {

            $validator = Validator::make($request->all(), array(
                        'bank_name' => 'required|max:255',
                        'bank_status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('bank.create')
                                ->withErrors($validator)
                                ->withInput();
            }

            $bank = new Bank;
            $bank->bank_name = $request->bank_name;
            $bank->is_active = $request->bank_status;
            $bank->create_time = date('Y-m-d h:i:s');
            $bank->create_logon_id = session('sessLogonId');
            $bank->create_user_id = Auth::user()->user_id;
			$bank->last_action = 'INSERT';
            $bank->save();

            return redirect()->route('bank.create')
                            ->with('successMessage', 'Data inserted successfully.');
        }
    }

    
 
    public function edit($id,Request $request){
        
		 if (!$request->ajax()) {
			 
			 $breadcrumb = array(
                'App. Setup' => route('appSetup'),
                'Bank' => route('bank.index'),
                'Update' => route('bank.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Update Bank Details';
            $this->data['bankDetails'] = Bank::findOrFail($id);
            $this->data['bankDetails'] = Bank::where('bank_id', '=', $id)->first();
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
     * Update the specified appSetup in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
         $this->data['bankDetails'] = Bank::findOrFail($id);
        
        $validator = Validator::make($request->all(), array(
                    'bank_name' => 'required|max:255',
                    'bank_status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('bank.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $bank = Bank::find($id);
        $bank->bank_name = $request->bank_name;
        $bank->is_active = $request->bank_status;
        $bank->update_time = date('Y-m-d h:i:s');
        $bank->update_logon_id = session('sessLogonId');
        $bank->update_user_id = Auth::user()->user_id;
		$bank->last_action = 'UPDATE';
        $bank->save();

        return redirect()->route('bank.index')
                        ->with('successMessage', 'Data updated successfully.');
    }

    /**
     * Remove the specified appSetup from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
