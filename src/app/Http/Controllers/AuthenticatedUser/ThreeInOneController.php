<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Expense;
use App\ExpenseSubHead;
use Auth;
use DB;
use Validator;

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
                $columnValue = 6;
            } else if ($request->pageType == 'FixedAsset') {
                $columnValue = 5;
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
			 
        $this->data['branches'] = DB::table('tbl_bank_branches')
			 ->select('branch_id', 'branch_name')
			 ->where('is_active', '=', 1)
			 ->get();
			 
		$this->data['accounts'] = DB::table('tbl_bank_accounts')
			 ->select('account_id','account_no')
			 ->where('is_active', '=', 1)
			 ->get();
        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

	
	 public function store(Request $request){	
		
     /*  echo '<pre>';
                print_r($request->all());
        echo '</pre>';
        exit(); */
		
        if (!$request->ajax()) {

            $validator = Validator::make($request->all(), array(
                        'invoice_no'   => 'required',
                        'dateOf'       => 'required|date',
                        'payment_type' => 'required',
                        'head_name'    => 'required|max:255',
						
                        // 'bank_name'    => 'required',
                        // 'branch_name'  => 'required|max:255',
                        // 'account_no'   => 'required|max:255',
                        // 'check_no'     => 'required|max:255',
                        // 'check_date'   => 'required',                      
                        
            ));
			
			$validator->sometimes(['bank_name', 'branch_name', 'account_no', 'check_no'], 'required|max:255', function($input){
               return $input->payment_type == 'check';
            });
		
			$validator->sometimes(['check_date'], 'required|date', function($input) {
               return $input->payment_type == 'check';
            });
			
            if ($validator->fails()) {
                return redirect()->route('3in1',array('pageType' => $request->pageType))
                                ->withErrors($validator)
                                ->withInput();
            }

            $totalunits     = count($request->units);
            $totalunitprice = count($request->unit_prices);
            $totalSubHead   = count($request->sub_head_id);
			
            if ($totalunits == $totalunitprice && $totalunitprice == $totalSubHead) {

                $expenseArray = array(

                    'invoice_no'      => $request->invoice_no,
                    'expense_date'    => date('Y-m-d H:i:s'),
                    'payment_type'    => $request->payment_type,
                    'head_id'         => $request->head_name,
                    'bank_id'         => $request->bank_name,
                    'branch_id'       => $request->branch_name,
                    'account_no'      => $request->account_no,
                    'check_no'        => $request->check_no,
                    'check_date'      => date('Y-m-d H:i:s'),
                    'is_active'       => 1,
                    'create_time'     => date('Y-m-d h:i:s'),
                    'create_logon_id' => session('sessLogonId'),
                    'last_action'     => 'INSERT',
                );
                $expense   = Expense::create($expenseArray);
                $expenseId = $expense->expense_id;

                for ($i = 0; $i < $totalunits; $i++) {

				//echo $request->sub_head_id[$i] . '-' .$request->units[$i] . '-' . $request->unit_prices[$i] . '<br>';
                    				
               					
					if((int)$request->sub_head_id[$i] > 0 && (int)$request->units[$i] > 0 && (int)$request->unit_prices[$i] > 0){
						
					$expenseSubHead = new ExpenseSubHead;
                    $expenseSubHead->payment_type  = $request->payment_type;
                    $expenseSubHead->head_id       = $request->head_name;
                    $expenseSubHead->invoice_no    = $request->invoice_no;
                    $expenseSubHead->bank_id       = $request->bank_name;
                    $expenseSubHead->expense_date  = date('Y-m-d H:i:s');
                    $expenseSubHead->check_no      = $request->check_no;
					
                    $expenseSubHead->sub_head_id   = $request->sub_head_id[$i];
                    $expenseSubHead->units         = $request->units[$i];
                    $expenseSubHead->unit_price    = $request->unit_prices[$i];					   					   
					$expenseSubHead-> sub_total = $request->units[$i] * $request->unit_prices[$i];
					
				    $expenseSubHead->is_active     = '1';
                    $expenseSubHead->expense_id    = $expenseId;
                    $expenseSubHead->save();
					  				
					}
					
                }
            }
			//exit;
            return redirect()->route('3in1', array('pageType' => $request->pageType)) 
			                 ->with('successMessage', 'Data inserted successfully.');
        }
    }
	
	
	
    public function getAccountingSubHeadsByAccountingHeadId($headId) {

       $subHeadLists = DB::table('tbl_accounting_sub_heads')
					-> select('sub_head_id', 'sub_head_name')
					-> where('head_id', '=', $headId)
					-> where('is_active', '=', 1)
					-> get();
        //echo '<pre>';print_r($subHeadLists);echo '</pre>';exit();
        $str = '';
        $str .= '<table class="table table-condensed table-bordered" id="subHeadTable">';
        $str .= '<thead><tr>';
        $str .= '<th>Name</th> <th>Unit</th> <th>Unit Price</th> <th>Total</th>';
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
            $str .= '<input type="hidden"  name="sub_head_id[]" value="' . $s->sub_head_id . '">';
            $str .= '<td>';
            $str .= '<span class="total" >0</span>';
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
