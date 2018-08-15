<?php

namespace App\Http\Controllers\AuthenticatedUser\Resource;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\ThirdParty;
use Validator;

class ThirdPartyController extends Controller{
	
	
    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 7;
        $this->data['viewPath'] = 'AuthenticatedUser.Resource.ThirdParty.';

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
		
        $this->data['pageTitle'] = 'Third Party';
        $this->data['thirdPartyList'] = ThirdParty::get();

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request) {

        if (!$request->ajax()) {

            $this->data['pageTitle'] = 'Create Third Party';
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
                        'third_party_name' => 'required|max:255',
                        'third_party_details' => 'required|max:255',
                        'third_party_status' => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('thirdParty.create')
                                ->withErrors($validator)
                                ->withInput();
            }

            $thirdParty = new ThirdParty;
            $thirdParty->third_party_name = $request->third_party_name;
            $thirdParty->third_party_details = $request->third_party_details;
            $thirdParty->third_party_address = $request->third_party_address;
            $thirdParty->third_party_category = $request->third_party_category;
            $thirdParty->is_active = $request->third_party_status;
            $thirdParty->create_time = date('Y-m-d h:i:s');
            $thirdParty->create_logon_id = session('sessLogonId');
            $thirdParty->create_user_id = Auth::user()->user_id;
			$thirdParty->last_action = 'INSERT';
            $thirdParty->save();

            return redirect()->route('thirdParty.create')
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

            $this->data['pageTitle'] = 'Update Third Party';
            $this->data['thirdPartyDetails'] = ThirdParty::findOrFail($id);
            $this->data['thirdPartyDetails'] = ThirdParty::where('third_party_id', '=', $id)->first();
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
    public function update(Request $request, $id){
        
		 $this->data['thirdPartyDetails'] = ThirdParty::findOrFail($id);
        
        $validator = Validator::make($request->all(), array(
                    'third_party_name' => 'required|max:255',
                    'third_party_status' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('thirdParty.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

		
		    $thirdParty = ThirdParty::find($id);
		    $thirdParty->third_party_name = $request->third_party_name;
            $thirdParty->third_party_details = $request->third_party_details;
            $thirdParty->third_party_address = $request->third_party_address;
            $thirdParty->third_party_category = $request->third_party_category;		
            $thirdParty->is_active = $request->third_party_status;
			$thirdParty->update_time = date('Y-m-d h:i:s');
            $thirdParty->update_logon_id = session('sessLogonId');
            $thirdParty->update_user_id = Auth::user()->user_id;
			$thirdParty->last_action = 'UPDATE';
			$thirdParty->save();

        return redirect()->route('thirdParty.index')
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
