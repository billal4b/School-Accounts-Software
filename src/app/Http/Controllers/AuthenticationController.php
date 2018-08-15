<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\SecUserLogon;
use App\Role;
use DB;

class AuthenticationController extends Controller {

    public function __construct() {

        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
    }

    public function signIn(Request $request) {

        if (!$request->ajax()) {

            $this->data['pageTitle'] = 'Sign In';
            try {
                return view('Authentication.SignIn', array('data' => $this->data));
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            throw new Exception('Invalid request!');
        }
    }

    public function signInAction(Request $request) {

        if (!$request->ajax()) {
            /**             * *********************************************** */
            $validator = Validator::make($request->all(), array(
                        'identifiers' => 'required|max:255',
                        'password' => 'required|max:20',
            ));
            if ($validator->fails()) {
                return redirect()->route('signInForm')
                                ->withErrors($validator)
                                ->withInput();
            }

            try {

                $loginBy = NULL;
                $loginByValue = $request->identifiers;
                if (is_numeric($loginByValue)) {

                    if (strlen($loginByValue) > 3 && substr($loginByValue, 0, 3)) {
                        $loginBy = 'phone_no';
                    } else {
                        $loginBy = 'user_id';
                    }
                } else if (filter_var($loginByValue, FILTER_VALIDATE_EMAIL)) {
                    $loginBy = 'email';
                } else {
                    $loginBy = 'username';
                }
                //echo '<pre>';/*print_r($request->all());*/echo $loginBy . '-----' . $loginByValue;echo '</pre>';exit();
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }

            $loginCredentials = array(
                $loginBy => $loginByValue,
                'password' => $request->password,
                'is_active' => 1
            );

            if (Auth::attempt($loginCredentials, $request->remember)) {

                // Authentication passed...
                //echo '<pre>';print_r(LoginLogoutLog::all());echo '</pre>';exit();
                $secUserLogon = DB::select('call insert_into_sec_user_logons('
                                . '"' . Auth::user()->user_id . '", '
                                . '"' . date('Y-m-d h:i:s') . '", '
                                . '"' . 0 . '", '
                                . '"' . $request->server('REMOTE_ADDR') . '", '
                                . '"' . $request->session()->getId() . '", '
                                . '"' . $request->server('HTTP_USER_AGENT') . '", '
                                . '"' . $loginBy . '"'
                                . ')');
                //echo '<pre>';print_r($secUserLogon);echo '</pre>';exit();
                $logonId = $secUserLogon[0]->logon_id;
                $request->session()->put('sessLogonId', $logonId);


                $instituteDetails = DB::select('call get_institute_details("' . Auth::user()->institute_branch_version_id . '", "' . Auth::user()->role_id . '")');
//echo '<pre>';print_r($instituteDetails);echo '</pre>';exit();
                $request->session()->put('instituteDetails', $instituteDetails[0]);
                //echo '<pre>';print_r($request->session()->get('instituteDetails'));echo '</pre>';exit();

                $roleName = DB::select('call get_role_name_by_role_id("' . Auth::user()->role_id . '")');
                $request->session()->put('roleName', $roleName[0]->role_name);

                $parentMenuList = DB::select('call gen_parent_menu_list( ' . Auth::user()->user_id . ')');
                //echo '<pre>';print_r($parentMenuList);echo '</pre>';exit();
                $request->session()->put('parentMenuList', $parentMenuList);

                return redirect()->intended(route('home::onlineInfo'));
            } else {
                return redirect()->route('signInForm')
                                ->with('errorMessage', 'The identifiers and password you entered don\'t match.')
                                ->withInput();
            }
        } else {
            throw new Exception('Invalid request!');
        }
    }

}
