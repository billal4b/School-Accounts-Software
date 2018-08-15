<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class HomeController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['viewPath'] = 'AuthenticatedUser.Home.';
    }

    private function _setBreadcrumbs($brdcrmb) {
        foreach($brdcrmb as $key => $value){
            $this->data['brdcrmb'][] = array(
                array('title' => $key, 'url' => $value)
            );
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function onlineInformation() {
        
        $breadcrumb = array(
            'Home' => route('home::onlineInfo')
        );
        $this->_setBreadcrumbs($breadcrumb);
        
        $this->data['pageTitle'] = 'Online Information of ' . Auth::user()->full_name;
        
        return view($this->data['viewPath'] . 'onlineInformation', array('data' => $this->data));
    }
    
    public function signOut(Request $request){
        
        Auth::logout();
        $request->session()->flush();
        
        return redirect(route('signInForm'));
    }

}
