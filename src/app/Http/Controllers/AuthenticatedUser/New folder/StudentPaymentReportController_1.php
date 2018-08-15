<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ReceivedStudentPayment;
use Auth;
use DB;
use PDF;
use Validator;

class StudentPaymentReportController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
		$this->data['menuId'] = 19;
        $this->data['viewPath'] = 'AuthenticatedUser.StudentReport.';
		
		 $this->data['jsArray'][] = 'Student_payment_report.js';
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
            'Payment Report' => route('studentReport::index')
        );
        $this->_setBreadcrumbs($breadcrumb);
                
		$this->data['pageTitle'] = 'Payment Report';
        //$this->data['paymentReport'] = ReceivedStudentPayment::get(); 	
        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }
	
	public function generate_student_payment_report_by_date(Request $request) {
		
        if ($request->ajax()) {			
			
            try {
               $this->data['pageTitle'] = 'Payment Report by date ';
			   
			   if(Auth::user()->role_id == 9){
				   $bank_id=session('instituteDetails')->bank_id;
				   $bank_branch_id=session('instituteDetails')->branch_id;
			   }elseif(Auth::user()->role_id == 8){
				   $bank_id=0;
				   $bank_branch_id=0;
			   }
			$this->data['paymentReport'] = DB::select('call received_student_payment_report("' . date('Y-m-d', strtotime(str_replace('-', '-', $request->from_date))) . ' 00:00:00","' . date('Y-m-d', strtotime(str_replace('-', '-', $request->to_date))) . ' 23:59:59","'.$bank_id.'","'.$bank_branch_id.'","'.Auth::user()->role_id.'","'.Auth::user()->user_id.'","'.Auth::user()->bank_user_rank.'")');
			/*
			$this->data['paymentReport'] = DB::select('call received_student_payment_report("' . date('Y-m-d', strtotime(str_replace('-', '/', $request->from_date))) . ' 00:00:00", "' . date('Y-m-d', strtotime(str_replace('-', '/', $request->to_date))) . ' 23:59:59" ,"'.$bank_id.'","'.$bank_branch_id.'","'.Auth::user()->role_id.'")');
			*/
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
			return view($this->data['viewPath'] . 'view', array('data' => $this->data));
        } else {
            throw new Exception('Invalid request!');
        }
    }
	
	/****************** Confirm payment Method ***********************/
	public function confirm_bank_admin(Request $request, $received_student_payment_id) {
		//echo $received_student_payment_id;exit();
       if ($request->ajax()) {			
		
            try {
			   
			  ReceivedStudentPayment::where('confirm_by_bank_admin', 0)
          ->where('received_student_payment_id', $received_student_payment_id)
          ->update(['confirm_by_bank_admin' => 1]);
			
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
			
        } else {
            throw new Exception('Invalid request!');
        }
    }
	
	/****************** Edit payment Method ***********************/
	public function edit(Request $request, $receiptNo){
        
		 if (!$request->ajax()) {
			 $breadcrumb = array(
                'Payment Report' => route('studentReport::index'),
                'Edit Payment Details' => route('studentReport::editPaymentAmount', array('received_student_payment_id' => $receiptNo)),
            );
            $this->_setBreadcrumbs($breadcrumb);
			 
			//$receiptNo = $receiptNo;
            $this->data['pageTitle'] = 'Update Payment';
   
			$this->data['paymentReport'] = DB::select('call get_receipt_details_by_receipt_no("' . $receiptNo . '")');
			 //  echo '<pre>';
                 //   print_r($this->data['paymentReport']);
                 // echo '</pre>';exit();
			$this->data['paymentDetails'] = DB::select('call generate_month_wise_student_payment_slip("' . $this->data['paymentReport'][0]->class_id . '", "' . $this->data['paymentReport'][0]->institute_branch_version_id . '", "' . $this->data['paymentReport'][0]->group_id . '",  "' . $this->data['paymentReport'][0]->generated_month . '")');
			
			       //echo '<pre>';
                     //print_r($this->data['paymentDetails']);
                   //echo '</pre>';exit();
                   
               
			 
            try {		
                return view($this->data['viewPath'] . 'edit', array('data' => $this->data));
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            throw new Exception('Invalid request!');
        }
    }
	/****************** Update paynemt Method ***********************/
	public function update(Request $request, $id) {

        //$this->data['paymentReport'] = ReceivedStudentPayment::findOrFail($id);
	
                   

        $validator = Validator::make($request->all(), array(
            'received_amount' => 'required',
            'book_sl_no' => 'required',
        ));
        if ($validator->fails()) {
            return redirect()->route('studentReport::editPaymentAmount', array('received_student_payment_id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $studentPayment = ReceivedStudentPayment::find($id);
        $studentPayment->received_amount_by_bank = $request->received_amount;
		
        $studentPayment->book_sl_no = $request->book_sl_no;
		
        //$studentPayment->confrim_by_bank_admin = $request->confrim_by_bank_admin;
		
        $studentPayment->update_time = date('Y-m-d h:i:s');
        $studentPayment->update_logon_id = session('sessLogonId');
        $studentPayment->update_user_id = Auth::user()->user_id;
        $studentPayment->last_action = 'UPDATE';
        $studentPayment->save();

        return redirect()->route('studentReport::editPaymentAmount', array('received_student_payment_id' => $id))
                        ->with('successMessage', 'Data updated successfully.');
    }
	
	
	
	/****************** Print Method ************************/
	public function print_generate_student_payment_report_by_date(Request $request) {
		
        if (!$request->ajax()) {			
			
            try {
               $this->data['pageTitle'] = 'Payment Report by date ';
			   
			   if(Auth::user()->role_id == 9){
				   $bank_id=session('instituteDetails')->bank_id;
				   $bank_branch_id=session('instituteDetails')->branch_id;
			   }elseif(Auth::user()->role_id == 8){
				   $bank_id=0;
				   $bank_branch_id=0;
			   }
			$this->data['paymentReport'] = DB::select('call received_student_payment_report("' . date('Y-m-d', strtotime(str_replace('-', '-', $request->fromDate))) . ' 00:00:00","' . date('Y-m-d', strtotime(str_replace('-', '-', $request->toDate))) . ' 23:59:59","'.$bank_id.'","'.$bank_branch_id.'","'.Auth::user()->role_id.'","'.Auth::user()->user_id.'","'.Auth::user()->bank_user_rank.'")');
		
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
              /*
			return view($this->data['viewPath'] . 'print', array('data' => $this->data));
			$html = View::make($this->data['viewPath'] . 'print', array('data' => $this->data));
			PDF::SetTitle('Hello World');
			PDF::AddPage();
			PDF::Write(0, $html->render());
			PDF::Output('Payment_report.pdf');  */
			
			$pdf = PDF::loadView($this->data['viewPath'] . 'print', array('data' => $this->data));
            return $pdf->download('Student_payment_report.pdf');
			
			
        } else {
            throw new Exception('Invalid request!');
        }
    }
	
	//DB::select('call received_student_payment_report("' . $from_date . ' 00:00:00", "' . $to_date . ' 23:59:59")');

	
	
}
