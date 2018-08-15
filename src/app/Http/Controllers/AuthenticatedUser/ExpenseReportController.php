<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Expense;
use App\ExpenseSubHead;
use Auth;
use DB;
use PDF;
use Validator;

class ExpenseReportController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

         $this->data = array();
		$this->data['menuId'] = 25;
        $this->data['viewPath'] = 'AuthenticatedUser.ExpenseReport.';
		
	    $this->data['jsArray'][] = 'Expense_Report.js';
    }

    private function _setBreadcrumbs($brdcrmb) {
        foreach($brdcrmb as $key => $value){
            $this->data['brdcrmb'][] = array(
                array('title' => $key, 'url' => $value)
            );
        }
    }
	
	public function index() {
        
        $breadcrumb = array(
            'Expense Report' => route('expenseReport::index')
        );
        $this->_setBreadcrumbs($breadcrumb);  
		
		$this->data['pageTitle']       = 'Expense Report';		
		
        $this->data['accountingHeads'] = DB::table('tbl_accounting_heads')
                ->select('head_id', 'head_name')
                ->where('account_category_id', '=', '6')
                ->where('is_active', '=', 1)
                ->get();
	
        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }
    /********************view method***********************/

    public function view(Request $request) {
        if($request->ajax()) {
            try {				
			
                $payment_type = $request->payment_type;		
				
				if(empty($request->head_name)){
					$head_name = 0;
				}else{
					$head_name = $request->head_name;
				}   
				  
                   //echo ($request->payment_type);  exit();
			   
				 
				$this->data['ExpenseReport'] = DB::select('call expense_report("' . date('Y-m-d',
                        strtotime(str_replace('-', '-', $request->from_date))) . ' 00:00:00", "'. date('Y-m-d',
				        strtotime(str_replace('-', '-', $request->to_date))) . ' 23:59:59", "'.$payment_type.'","'.$head_name.'")');
				
              /*   echo '<pre>';
                    print_r($this->data['ExpenseReport']);
			    echo '</pre>'; exit(); */
				
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
            return view($this->data['viewPath'] . 'view', array('data' => $this->data));
        } else {
            throw new Exception('Invalid request!');
        }
    } 
	
}
