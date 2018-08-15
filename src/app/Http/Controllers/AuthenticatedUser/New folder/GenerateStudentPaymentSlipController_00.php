<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Validator;
use PDF;
use App\ReceivedStudentPayment;
use App\ReceivedStudentPaymentSubHead;

class GenerateStudentPaymentSlipController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 16;
        $this->data['viewPath'] = 'AuthenticatedUser.GenerateStudentPaymentSlip.';

        if ($this->_hasPrivilegeToAccessTheMenu($this->data['menuId'], Auth::user()->role_id) == 0) {
            abort(404);
        };

        $this->data['jsArray'][] = 'GenerateStudentPaymentSlip.js';
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $breadcrumb = array(
            'Generate Student Payment Slip' => route('generateStudentPaymentSlip::index'),
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'Generate Student Payment Slip';
        //$this->data['studentPaymentList'] = StudentPayment::get();
//        $this->data['studentClasses']  = DB::select('call get_student_classes(1)');
//        $this->data['studentGroups']   = DB::select('call get_student_groups(1)');
//        $this->data['studentSections'] = DB::select('call get_student_sections(1)');

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

    public function viewOrPrint(Request $request) {
        //echo '<pre>';print_r($request->all());echo '</pre>';exit();
        if ($request->ajax()) {

            try {

                //$generateType = $request->generateType;

                /* if (Auth::user()->role_id == 8) {
                  $receiptNo = $request->receiptNo;
                  $studentId = 0;
                  $generateMonth = 0;
                  } else {
                  $receiptNo = 0;
                  $studentId = $request->studentId;
                  /      $generateMonth = $request->generateMonth;
                  } */
                $receiptNo = $request->receiptNo;
                $studentId = $request->studentId;
                //$generateMonth = $request->generateMonth;
                $generateMonth = 0;

//echo '<pre>';
//print_r($request->all());
                //              echo $receiptNo . '---' . $studentId . '---' . $generateMonth;
                //             exit();

                if ($studentId != 0) {

                    /* $this->data['studentDetails'] = DB::table('studentinfo AS si')
                      ->select('si.id', 'si.FullName', 'si.RollNo', 'ci.id AS class_id', 'ci.ClassName', 'sci.section_id', 'sci.SectionName', 'sg.id AS group_id', 'sg.GroupName')
                      ->join('classinfo AS ci', 'ci.ClassID', '=', 'si.ClassID')
                      ->join('sectioninfo AS sci', 'sci.SectionID', '=', 'si.SectionID')
                      ->join('stugrp AS sg', 'sg.GroupName', '=', 'si.StuGroup')
                      ->where('si.StudentID', '=', $studentId)
                      ->first(); */
                    $this->data['studentDetails'] = DB::table('tbl_students AS si')
                            ->select('si.section_id', 'si.institute_branch_version_id', 'si.student_id', 'si.system_generated_student_id', 'si.student_name', 'si.roll_no', 'ci.id AS class_id', 'ci.ClassName'/* , 'sci.section_id', 'sci.SectionName' */, 'sg.id AS group_id', 'sg.GroupName', 'si.stu_group')
                            ->join('classinfo AS ci', 'ci.ClassID', '=', 'si.class_id')
                            /* ->join('sectioninfo AS sci', 'sci.SectionID', '=', 'si.SectionID') */
                            ->join('stugrp AS sg', 'sg.id', '=', 'si.stu_group')
                            ->where('si.system_generated_student_id', '=', $studentId)
                            ->first();
//                    echo '<pre>';
//                    print_r($this->data['studentDetails']);
//                    exit();
                    if (empty($this->data['studentDetails'])) {
                        echo '<h6 class="text-danger text-uppercase">No data found.</h6>';
                        return;
                    }
//                    echo '<pre>';print_r($this->data['studentDetails']);echo '</pre>';exit();

                    $generateClass = $this->data['studentDetails']->class_id;
                    $generateGroup = $this->data['studentDetails']->stu_group;
                    $generateInstituteBranchVersionId = $this->data['studentDetails']->institute_branch_version_id;

                    $this->data['paymentMonth'] = $request->generateMonth;

//                    $this->data['checkIsReceivedByBank'] = DB::select('call checkIsReceivedByBank("' . $this->data['studentDetails']->student_id . '", "' . $this->data['studentDetails']->system_generated_student_id . '", "' . $generateClass . '", "' . $generateGroup . '",  "' . $generateMonth . '")');
//                    echo '<pre>';
//                    print_r($this->data['checkIsReceivedByBank']);
//                    echo '</pre>'; exit();
                    //if (empty($this->data['checkIsReceivedByBank'])) {
                    //$this->data['paymentDetails'] = DB::select('call generate_month_wise_student_payment_slip("' . $generateClass . '", "' . $generateInstituteBranchVersionId . '", "' . $generateGroup . '",  "' . $generateMonth . '")');
//                    echo '<pre>';
//                    print_r($this->data['paymentDetails']);
//                    echo '</pre>';
//                    exit();
//                    if (empty($this->data['paymentDetails'])) {
//                        echo '<h6 class="text-danger text-uppercase">No data found.</h6>';
//                        return;
//                    }
                    //}
                } else if ($receiptNo != 0) {

                    $this->data['checkIsReceivedByBank'] = DB::select('call get_receipt_details_by_receipt_no_bank_edit("' . $receiptNo . '" , "'.Auth::user()->role_id.'")');
//                    echo '<pre>';
//                      print_r($this->data['checkIsReceivedByBank']);
//                        echo '</pre>';exit();
                    if (empty($this->data['checkIsReceivedByBank'])) {
                        echo '<h6 class="text-danger text-uppercase">No data found.</h6>';
                        return;
                    }/*  else{
                        if($this->data['checkIsReceivedByBank'][0]->confirm_by_school_user_id != NULL){
                            echo '<h6 class="text-danger text-uppercase">Already Confirmed.</h6>';
                            return;
                        }
                    } */
//                    $this->data['paymentDetails'] = DB::select('call generate_month_wise_student_payment_slip("' . $this->data['checkIsReceivedByBank'][0]->class_id . '", "' . $this->data['checkIsReceivedByBank'][0]->institute_branch_version_id . '", "' . $this->data['checkIsReceivedByBank'][0]->group_id . '",  "' . $this->data['checkIsReceivedByBank'][0]->generated_month . '")');
//                    echo '<pre>';
//                    print_r($this->data['paymentDetails']);
//                    echo '</pre>';exit();
                } else {
                    echo '<h6 class="text-danger text-uppercase">No data found.</h6>';
                    return;
                }
                return view($this->data['viewPath'] . 'viewOrPrint', array('data' => $this->data));
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            throw new Exception('Invalid request!');
        }
    }

    public function pay(Request $request) {

        if (Auth::user()->role_id == 9) {
            if ($request->ajax()) {
//                echo '<pre>';print_r($request->all());echo '</pre>';
//                echo date("Y-m-d H:i:s", strtotime($request->received_date));
//                exit();
                if (Auth::user()->user_id !== 444 && Auth::user()->user_id !== 445 && Auth::user()->user_id !== 446 && Auth::user()->user_id !== 447) {
                    $validator = Validator::make($request->all(), array(
                                'student_id' => 'required|integer',
                                'system_generated_student_id' => 'required|alpha_num',
                                //'generated_month' => 'required|integer',
                                'class_id' => 'required|integer',
                                'group_id' => 'required|integer',
                                //--------------//
                                'institute_branch_version_id' => 'required',
                                'received_amount' => 'required|regex:/^\d*(\.\d{2})?$/',
                                'book_sl_no' => 'required|max:10',
                    ));
                    $received_date = date('Y-m-d H:i:s');
                } else {
                    $validator = Validator::make($request->all(), array(
                                'student_id' => 'required|integer',
                                'system_generated_student_id' => 'required|alpha_num',
                                //'generated_month' => 'required|integer',
                                'class_id' => 'required|integer',
                                'group_id' => 'required|integer',
                                //--------------//
                                'institute_branch_version_id' => 'required',
                                'received_amount' => 'required|regex:/^\d*(\.\d{2})?$/',
                                'book_sl_no' => 'required|max:10',
                                'received_date' => 'required|date',
                    ));
                    $received_date = date('Y-m-d H:i:s', strtotime($request->received_date));
                }
                if ($validator->fails()) {
                    return $validator->messages()->toJson();
                }//exit();
                /*
                  $totalStudentPaymentId = count($request->student_payment_id);
                  $totalStudentPaymentName = count($request->student_payment_name);
                  $totalPaymentAmount = count($request->payment_amount);
                  if ($totalStudentPaymentId > 0 && $totalStudentPaymentName > 0 && $totalPaymentAmount && $totalStudentPaymentId == $totalStudentPaymentName && $totalStudentPaymentId == $totalPaymentAmount && $totalStudentPaymentName == $totalPaymentAmount) {
                 */
                //echo session('instituteDetails')->branch_id;                exit();
                $paymentDetailsArr = array(
                    'student_id' => $request->student_id,
                    'system_generated_student_id' => $request->system_generated_student_id,
                    'class_id' => $request->class_id,
                    'group_id' => $request->group_id,
                    //--------------//
                    'institute_branch_version_id' => $request->institute_branch_version_id,
                    'section_id' => $request->section_id,
                    'received_amount_by_bank' => $request->received_amount,
                    'bank_user_id' => Auth::user()->user_id,
                    'received_time' => $received_date,
                    'is_active' => 1,
                    'create_time' => date('Y-m-d H:i:s'),
                    'create_logon_id' => session('sessLogonId'),
                    'create_user_id' => Auth::user()->user_id,
                    'last_action' => 'INSERT',
                    'bank_id' => session('instituteDetails')->bank_id,
                    'bank_branch_id' => session('instituteDetails')->branch_id,
                    'book_sl_no' => $request->book_sl_no,
                );
                $receivedStudentPayment   = ReceivedStudentPayment::create($paymentDetailsArr);
                $receivedStudentPaymentId = $receivedStudentPayment->received_student_payment_id;
				
                /* $_receiptNo = date("Ymd") . $receivedStudentPaymentId;
                  $receiptNoArr = array(
                  'receipt_no' => $_receiptNo,
                  );
                  $receiptNo = ReceivedStudentPayment::where('received_student_payment_id', '=', $receivedStudentPaymentId)
                  ->update($receiptNoArr);

                  // for ($i = 0; $i < $totalStudentPaymentId; $i++) {

                  $receivedStudentPaymentSubHead = new ReceivedStudentPaymentSubHead;
                  //$receivedStudentPaymentSubHead->student_payment_id = $request->student_payment_id[$i];
                  // $receivedStudentPaymentSubHead->student_payment_name = $request->student_payment_name[$i];
                  // $receivedStudentPaymentSubHead->payment_amount = $request->payment_amount[$i];
                  $receivedStudentPaymentSubHead->received_student_payment_id = $receivedStudentPaymentId;
                  $receivedStudentPaymentSubHead->save();
                  //   }
                  //}
                  //echo 'Receipt No. : <strong class="text-info">' . $_receiptNo . '</strong>';
                  //echo 'Receipt No. : <strong class="text-info">' . $receivedStudentPaymentId . '</strong>'; */
                return redirect()->route('generateStudentPaymentSlip::viewOrPrint', array(
                            'generateType' => 'View',
                            'studentId' => 0,
                            //'generateMonth' => 0,
                            'receiptNo' => $receivedStudentPaymentId
                ));
            }
            //echo '<pre>';print_r($request->all());echo '</pre>';exit();
        }
    }

    public function confirm(Request $request) {

//        echo '<pre>';
//        print_r($request->all());
//        echo '</pre>';
//        exit();
        if (Auth::user()->role_id == 8) {
            if ($request->ajax()) {

                $validator = Validator::make($request->all(), array(
                            'student_id' => 'required|integer',
                            'system_generated_student_id' => 'required|alpha_num',
                            'monthSelect' => 'required|integer',
                            'class_id' => 'required|integer',
                            'group_id' => 'required|integer',
                ));

                if ($validator->fails()) {
                    return $validator->messages()->toJson();
                }

//                $paymentConfirmArr = array(
//                    
//                    'confirm_by_school_user_id' => Auth::user()->user_id,
//                    'confirm_time' => date('Y-m-d h:i:s'),
//                    'update_time' => date('Y-m-d h:i:s'),
//                    'update_logon_id' => session('sessLogonId'),
//                    'update_user_id' => Auth::user()->user_id,
//                    'last_action' => 'UPDATE',
//                );
//
//                ReceivedStudentPayment::where('system_generated_student_id', '=', $request->system_generated_student_id)
//                        ->update($paymentConfirmArr);











                $receipt_no = $request->input('receipt_no');
                $class_id   = $request->input('class_id');
                $group_id   = $request->input('group_id');
				// --------//
                $section_id = $request->input('section_id');
                $ibv_id     = $request->input('ibv_id');
				$received_time     = $request->input('received_time');
				
                $system_generated_student_id = $request->input('system_generated_student_id');
                $student_id = $request->input('student_id');
                $month      = $request->input('monthSelect');

                $student_payment_id = $request->input('student_payment_id');
                $student_payment_name = $request->input('student_payment_name');
                $payment_amount = $request->input('payment_amount');
                $received_flag_by_school = $request->input('received_flag_by_school');

                $total_student_payment_id = count($student_payment_id);
                $total_student_payment_name = count($student_payment_name);
                $total_payment_amount = count($payment_amount);
                $total_received_flag_by_school = count($received_flag_by_school);

                $received_flag_by_school_arr = array();
                if ($total_received_flag_by_school > 0) {
                    foreach ($received_flag_by_school as $key => $value) {

                        $cutUnderscore = explode('_', $value);
                        $received_flag_by_school_arr[] = $cutUnderscore[0];
                    }
                }

                $total = 0;
                if (($total_student_payment_id == $total_student_payment_name) && ($total_student_payment_name == $total_payment_amount)) {

                    for ($i = 0; $i < $total_student_payment_id; $i++) {

                        //$total += (float) $payment_amount[$i];
                        $receivedStudentPaymentSubHead = DB::table('tbl_received_student_payment_sub_heads')->select('received_student_payment_sub_head_id', 'pay_status')
                                ->where('class_id', '=', $class_id)
                                ->where('group_id', '=', $group_id)
								// --------//
                                ->where('section_id', '=', $section_id)
                                ->where('institute_branch_version_id', '=', $ibv_id)
								
                                ->where('system_generated_student_id', '=', $system_generated_student_id)
  								->where('student_id', '=', $student_id)
                                ->where('month', '=', $month)
                                ->where('student_payment_id', '=', $student_payment_id[$i])
                                ->where('payment_amount', '=', $payment_amount[$i])
                                ->first();
                        //echo '<pre>';print_r($receivedStudentPaymentSubHead);echo '</pre>';exit();
                        if (empty($receivedStudentPaymentSubHead)) {

                            $new_data = array();
                            $new_data['class_id'] = $class_id;
                            $new_data['group_id'] = $group_id;
			                $new_data['received_student_payment_id'] = $receipt_no;
							// --------//
                            $new_data['section_id'] = $section_id;
                            $new_data['institute_branch_version_id'] = $ibv_id;
							$new_data['received_time'] = $received_time ;
							
                            $new_data['system_generated_student_id'] = $system_generated_student_id;
                            $new_data['student_id'] = $student_id;
                            $new_data['month'] = $month;
                            $new_data['student_payment_id'] = $student_payment_id[$i];
                            $new_data['payment_amount'] = $payment_amount[$i];
                            $new_data['student_payment_name'] = $student_payment_name[$i];
                            if (in_array($student_payment_id[$i], $received_flag_by_school_arr)) {

                                $new_data['pay_status'] = 1;
                                $total += (float) $payment_amount[$i];
                            } else {
                                $new_data['pay_status'] = 0;
                            }

                            $new_data['create_time'] = date('Y-m-d h:i:s');
                            $new_data['create_logon_id'] = session('sessLogonId');
                            $new_data['create_user_id'] = Auth::user()->user_id;
                            $new_data['last_action'] = 'INSERT';
                            DB::table('tbl_received_student_payment_sub_heads')->insert($new_data);
                        } else {

                            $received_student_payment_sub_head_id = $receivedStudentPaymentSubHead->received_student_payment_sub_head_id;
                            $pay_status_curr = $receivedStudentPaymentSubHead->pay_status;
                            //if(isset())
                            if (in_array($student_payment_id[$i], $received_flag_by_school_arr)) {

                                $pay_status = 1;
                                $total += (float) $payment_amount[$i];
                            } else {

                                if ($pay_status_curr == 1) {
                                    $pay_status = 1;
                                } else {
                                    $pay_status = 0;
                                }
                            }
                            DB::table('tbl_received_student_payment_sub_heads')
                                    ->where('received_student_payment_sub_head_id', $received_student_payment_sub_head_id)
                                    ->update(array(
                                        'student_payment_name' => $student_payment_name[$i],
                                        'pay_status' => $pay_status,
                                        'update_time' => date('Y-m-d h:i:s'),
                                        'update_logon_id' => session('sessLogonId'),
                                        'update_user_id' => Auth::user()->user_id,
                                        'last_action' => 'UPDATE',
                            ));
                        }
                    }








                    $received_amount = DB::table('tbl_students')->select('cash_in_hands')->where('student_id', $student_id)->first();

                    DB::table('tbl_students')
                            ->where('student_id', $student_id)
                            ->update(['cash_in_hands' => abs((float) $received_amount->cash_in_hands - (float) $total)]);
                    DB::table('tbl_received_student_payments')
                            ->where('received_student_payment_id', $receipt_no)
                            ->update([
                                'confirm_by_school_user_id' => Auth::user()->user_id,
                                'confirm_time' => date('Y-m-d H:i:s')
                            ]);
                }




                echo '<strong class="text-success">Confirmed Successfully.</strong>';
                //echo 'Receipt No. : <strong class="text-info">' . $receivedStudentPaymentId . '</strong>';
//                return redirect()->route('generateStudentPaymentSlip::viewOrPrint', array('generateType' => 'View', 'studentId' => $request->system_generated_student_id, 'generateMonth' => $request->generated_month, 'receiptNo' => 0));
            }
            //echo '<pre>';print_r($request->all());echo '</pre>';exit();
        }
    }

    public function generate_month_wise_student_payment_slip(Request $request) {

        echo '<script type="text/javascript">document.getElementById("availableCashInHands").innerHTML = "";</script>';

        $class_id = $request->class_id;
        $group_id = $request->group_id;
		// --------//
        $section_id = $request->section_id;
		
        $ibv_id = $request->ibv_id;
        $month = $request->month;
        $studentId = $request->studentId;
        $student_id = $request->student_id;

        $cash_in_hands = DB::table('tbl_students')
                ->select('cash_in_hands')
                ->where('system_generated_student_id', $studentId)
                ->where('student_id', $student_id)
                ->first();
        if (empty($cash_in_hands)) {
            echo '<strong class="text-danger  text-center">NO DATA FOUND.</strong>';
            return;
        }


        $previous_payment_details = DB::table('tbl_received_student_payment_sub_heads')->select('received_student_payment_sub_head_id', 'student_payment_id', 'student_payment_name', 'payment_amount', 'pay_status')
                ->where('class_id', '=', $class_id)
                ->where('group_id', '=', $group_id)
                ->where('system_generated_student_id', '=', $studentId)
                ->where('student_id', '=', $student_id)
                ->where('month', '=', $month)
                ->get();
        //echo '<pre>';print_r($previous_payment_details);echo '</pre>';exit();
        if (!empty($previous_payment_details)) {

            echo '<script type="text/javascript">document.getElementById("availableCashInHands").innerHTML = "<strong>' . $cash_in_hands->cash_in_hands . '</strong>";document.getElementById("tempCashInHands").value = "' . $cash_in_hands->cash_in_hands . '";</script>';

            $i = 0;
            echo '<div class="table-responsive"><table class="table table-condensed table-bordered text-uppercase"><thead><tr class="warning"><th>Sl.</th><th>Head</th><th>Amount</th><th>Select</th></tr></thead><tbody>';

            $paid_heads_count = 0;
            $totalAmount = 0;
            foreach ($previous_payment_details as $mwh) {

                echo '<tr class="active">';
                echo '<td>' . ++$i . '</td>';
                echo '<td>' . $mwh->student_payment_name . '</td>';
                echo '<td>' . $mwh->payment_amount . '</td>';
                echo '<td>';

                if ($mwh->pay_status == 1) {

                    echo '<strong>Paid</strong>';
                    $paid_heads_count++;
                } else {

                    echo '<div class="checkbox">
    <label>
      <input type="checkbox" name="received_flag_by_school[]" value="' . $mwh->student_payment_id . '_' . $mwh->payment_amount . '"> &nbsp;&nbsp;
    </label>
  </div>';
                    $totalAmount += (float) $mwh->payment_amount;
                }

                echo '</td>';
                echo '<input type="hidden" name="student_payment_name[]" value="' . $mwh->student_payment_name . '">';
                echo '<input type="hidden" name="student_payment_id[]" value="' . $mwh->student_payment_id . '">';
                echo '<input type="hidden" name="payment_amount[]" value="' . $mwh->payment_amount . '">';
                //echo '<input type="hidden" name="month[]" value="' . $month . '">';
                echo '</tr>';
            }
            echo '<tfoot>';
            echo '<tr>';
            echo '<td colspan="2" class="text-right text-bold">Total :</td>';
            echo '<td>' . $totalAmount . '</td><td>&nbsp;</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td colspan="4">';
            if ($paid_heads_count == count($previous_payment_details)) {
                echo '<div class="alert alert-success text-center" role="alert">Full Paid.</div>';
            } else {


                echo '<button id="confirmBtn" type="button" class="btn btn-success btn-sm btn-block">Confirm</button>';
            }
            echo '</td>';
            echo '</tr>';
            echo '</tbody></table></div>';
        } else {


            $monthWiseHeads = DB::select('call generate_month_wise_student_payment_slip("' . $class_id . '", "' . $ibv_id . '", "' . $group_id . '",  "' . $month . '")');
            //echo '<pre>';print_r($cash_in_hands);echo '</pre>';exit();
            if (empty($monthWiseHeads)) {
                echo '<strong class="text-danger text-center">NO DATA FOUND.</strong>';
                return;
            }

            $totalAmount = 0;
            foreach ($monthWiseHeads as $mwh) {
                $totalAmount += (float) $mwh->payment_amount;
            }
            if (((float) $cash_in_hands->cash_in_hands - (float) $totalAmount) >= 0) {

                $i = 0;
                echo '<div class="table-responsive"><table class="table table-condensed table-bordered text-uppercase"><thead><tr class="warning"><th>Sl.</th><th>Head</th><th>Amount</th></tr></thead><tbody>';

                foreach ($monthWiseHeads as $mwh) {

                    echo '<tr class="active">';
                    echo '<td>' . ++$i . '</td>';
                    echo '<td>' . $mwh->student_payment_name . '</td>';
                    echo '<td>' . $mwh->payment_amount . '</td>';
                    echo '<input type="hidden" name="student_payment_name[]" value="' . $mwh->student_payment_name . '">';
                    echo '<input type="hidden" name="student_payment_id[]" value="' . $mwh->student_payment_id . '">';
                    echo '<input type="hidden" name="payment_amount[]" value="' . $mwh->payment_amount . '">';
                    //echo '<input type="hidden" name="month[]" value="' . $month . '">';
                    echo '</tr>';
                    echo '<input type="hidden" name="received_flag_by_school[]" value="' . $mwh->student_payment_id . '_' . $mwh->payment_amount . '">';
                }
                echo '<tfoot>';
                echo '<tr>';
                echo '<td colspan="2" class="text-right text-bold">Total :</td>';
                echo '<td>' . $totalAmount . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td colspan="3"><button id="confirmBtn" type="button" class="btn btn-success btn-sm btn-block">Confirm</button></td>';
                echo '</tr>';
                echo '</tbody></table></div>';
            } else {

                echo '<script type="text/javascript">document.getElementById("availableCashInHands").innerHTML = "<strong>' . $cash_in_hands->cash_in_hands . '</strong>";document.getElementById("tempCashInHands").value = "' . $cash_in_hands->cash_in_hands . '";</script>';

                $i = 0;
                echo '<div class="table-responsive"><table class="table table-condensed table-bordered text-uppercase"><thead><tr class="warning"><th>Sl.</th><th>Head</th><th>Amount</th><th>Select</th></tr></thead><tbody>';

                foreach ($monthWiseHeads as $mwh) {

                    echo '<tr class="active">';
                    echo '<td>' . ++$i . '</td>';
                    echo '<td>' . $mwh->student_payment_name . '</td>';
                    echo '<td>' . $mwh->payment_amount . '</td>';
                    echo '<td><div class="checkbox">
    <label>
      <input type="checkbox" name="received_flag_by_school[]" value="' . $mwh->student_payment_id . '_' . $mwh->payment_amount . '"> &nbsp;&nbsp;
    </label>
  </div></td>';
                    echo '<input type="hidden" name="student_payment_name[]" value="' . $mwh->student_payment_name . '">';
                    echo '<input type="hidden" name="student_payment_id[]" value="' . $mwh->student_payment_id . '">';
                    echo '<input type="hidden" name="payment_amount[]" value="' . $mwh->payment_amount . '">';
                    //echo '<input type="hidden" name="month[]" value="' . $month . '">';
                    echo '</tr>';
                }
                echo '<tfoot>';
                echo '<tr>';
                echo '<td colspan="2" class="text-right text-bold">Total :</td>';
                echo '<td>' . $totalAmount . '</td><td>&nbsp;</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td colspan="4"><button id="confirmBtn" type="button" class="btn btn-success btn-sm btn-block">Confirm</button></td>';
                echo '</tr>';
                echo '</tbody></table></div>';
            }
        }
    }

}
