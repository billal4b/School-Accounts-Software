<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\GenMenu;

class AppSetupController extends Controller {

    public function __construct() {

        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 1;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.';

        if ($this->_hasPrivilegeToAccessTheMenu($this->data['menuId'], Auth::user()->role_id) == 0) {
            abort(404);
        }
    }
    
    private function _setBreadcrumbs($brdcrmb) {
        foreach($brdcrmb as $key => $value){
            $this->data['brdcrmb'][] = array(
                array('title' => $key, 'url' => $value)
            );
        }
    }

    private function _hasPrivilegeToAccessTheMenu($menuId, $roleId) {

        $hasPrivilegeToAccessTheMenu = DB::select('call has_privilege_to_access_the_menu(' . $menuId . ', ' . $roleId . ')');
        return count($hasPrivilegeToAccessTheMenu) > 0 ? $hasPrivilegeToAccessTheMenu[0]->role_menu_id : 0;
    }

    public function index() {
        
        $breadcrumb = array(
            'App. Setup' => route('appSetup')
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'App. Setup';
        $this->data['childMenuList'] = DB::select('call get_child_menu_list(' . $this->data['menuId'] . ')');

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

}
