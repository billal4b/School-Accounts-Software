<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class ThreeInOneController extends Controller {

    public function __construct(Request $request) {

        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();

        $pageType = $request->pageType;

        if (!$request->ajax()) {
            try {
                if ($pageType == 'Income') {
                    $this->data['menuId'] = 13;
                } else if ($pageType == 'Expense') {
                    $this->data['menuId'] = 14;
                } else if ($pageType == 'FixedAsset') {
                    $this->data['menuId'] = 15;
                } else {
                    //abort(404);
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        $this->data['viewPath'] = 'AuthenticatedUser.3in1.';

        /* if ($this->_hasPrivilegeToAccessTheMenu($this->data['menuId'], Auth::user()->role_id) == 0) {
          //abort(404);
          } */

        $this->data['jsArray'][] = 'ThreeInOne_Self.js';
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

    public function index(Request $request) {

        $breadcrumb = array(
            $request->pageType => route('3in1', array('pageType' => $request->pageType))
        );
        $this->_setBreadcrumbs($breadcrumb);

        $string = preg_replace('/(?<=\\w)(?=[A-Z])/', " $1", $request->pageType);
        $string = trim($string);

        try {

            $columnValue = 'account+';
            if ($request->pageType == 'Income') {
                $columnValue = 4;
            } else if ($request->pageType == 'Expense') {
                $columnValue = 5;
            } else if ($request->pageType == 'FixedAsset') {
                $columnValue = 6;
            }
        } catch (\Exception $ex) {
            throw new Exception($ex->getMessage());
        }

        $this->data['pageTitle'] = $this->data['pageType'] = $string;
        $this->data['accountingHeads'] = DB::table('tbl_accounting_heads')
                ->select('head_id', 'head_name')
                ->where('account_category_id', '=', $columnValue)
                ->where('is_active', '=', 1)
                ->get();

        $this->data['banks'] = DB::table('tbl_banks')
                ->select('bank_id', 'bank_name')
                ->where('is_active', '=', 1)
                ->get();

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

    public function getAccountingSubHeadsByAccountingHeadId($headId) {

        $subHeadLists = DB::table('tbl_accounting_sub_heads')
                ->select('sub_head_id', 'sub_head_name')
                ->where('head_id', '=', $headId)
                ->where('is_active', '=', 1)
                ->get();
        //echo '<pre>';print_r($subHeadLists);echo '</pre>';exit();
        $str = '';
        $str .= '<table class="table table-condensed table-bordered" id="subHeadTable">';
        $str .= '<thead><tr>';
        $str .= '<th>Name</th><th>Unit</th><th>Unit Price</th><th>Total</th>';
        $str .= '</thead></tr>';
        $str .= '<tbody>';
        foreach ($subHeadLists as $s) {

            $str .= '<tr>';
            $str .= '<td>';
            $str .= $s->sub_head_name;
            $str .= '</td>';
            $str .= '<td>';
            $str .= '<input type="text" class="form-control units" name="units[]" value="0">';
            $str .= '</td>';
            $str .= '<td>';
            $str .= '<input type="text" class="form-control unit_prices" name="unit_prices[]" value="0">';
            $str .= '</td>';
            $str .= '<td>';
            $str .= '<span class="total">0</span>';
            $str .= '</td>';
            $str .= '</tr>';
        }
        $str .= '</tbody>';
        $str .= '<tfoot>';
        $str .= '<tr>';
        $str .= '<td colspan="3" class="text-right">';
        $str .= 'Grand Total :';
        $str .= '</td>';
        $str .= '<td>';
        $str .= '<span id="gtotal">0</span>';
        $str .= '</td>';
        $str .= '</tr>';
        $str .= '</tfoot>';
        $str .= '</table>';

        echo $str;
    }

}
