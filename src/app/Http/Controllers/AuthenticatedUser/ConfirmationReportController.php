<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ReceivedStudentPayment;
use Auth;
use DB;

class ConfirmationReportController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
		$this->data['menuId'] = 21;
        $this->data['viewPath'] = 'AuthenticatedUser.ConfirmationReport.';
		
		 $this->data['jsArray'][] = 'Student_payment_confirmation_report.js';
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
      public function index() {
        
        $breadcrumb = array(
          'Payment Confirmation Report' => route('confirmationReport::index')
        );
        $this->_setBreadcrumbs($breadcrumb);
                
		$this->data['pageTitle'] = 'Confirmation Report';
        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

	public function student_payment_confirmation_report(Request $request) {
		
        if ($request->ajax()) {			
			
            try {
               $this->data['pageTitle'] = 'Confirmation Report by date wise';
			   
			   
			$this->data['paymentConfirmationReport'] = DB::select('call received_payment_confirmation_report("' . date('Y-m-d', strtotime(str_replace('-', '-', $request->from_date))) . ' 00:00:00","' . date('Y-m-d', strtotime(str_replace('-', '-', $request->to_date))) . ' 23:59:59")');
			
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
			return view($this->data['viewPath'] . 'view', array('data' => $this->data));
        } else {
            throw new Exception('Invalid request!');
        }
    }  
	
	
}
