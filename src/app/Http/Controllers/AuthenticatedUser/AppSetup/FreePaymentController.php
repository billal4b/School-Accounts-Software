<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\FreePayment;
use Validator;

class FreePaymentController extends Controller{
	
	 public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 46;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.FreePayment.';

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
            'App. Setup'   => route('appSetup'),
            'Free Payment' => route('freePayment.index'),
        );		
        $this->_setBreadcrumbs($breadcrumb);
		
		
        $this->data['pageTitle'] = 'Free Payment Details';
		
        $this->data['FreePaymentList'] = FreePayment::get(); 

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

    /**
     * Show the form for creating a new appSetup.
     *
     * @return \Illuminate\Http\Response
     */
    
 
    public function edit($id,Request $request){
        
		 if (!$request->ajax()) {
			 
			 $breadcrumb = array(
                'App. Setup' => route('appSetup'),
                'Free Payment' => route('freePayment.index'),
                'Update' => route('freePayment.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Free Payment Details';
            $this->data['freePaymentDetails'] = FreePayment::findOrFail($id);
            $this->data['freePaymentDetails'] = FreePayment::where('stu_free_payment_id', '=', $id)->first();
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
         $this->data['freePaymentDetails'] = FreePayment::findOrFail($id);
        
        $validator = Validator::make($request->all(), array(
                    'free_catagory' => 'required|max:255',
                    'free_type'     => 'required|max:255',
                    'status'        => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('freePayment.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $freePayment = FreePayment::find($id);
        $freePayment->free_catagory = $request->free_catagory;
        $freePayment->free_type = $request->free_type;
        $freePayment->is_active = $request->status;
        $freePayment->created_at = date('Y-m-d h:i:s');
        $freePayment->updated_at = date('Y-m-d h:i:s');
        $freePayment->save();

        return redirect()->route('freePayment.index')
                        ->with('successMessage', 'Data updated successfully.');
    }

   
}
