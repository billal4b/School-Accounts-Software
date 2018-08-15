<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Student;
use App\User;
use Auth;
use DB;
use PDF;
use Validator;

class StudentTransactionReportController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

         $this->data = array();
		$this->data['menuId'] = 26;
        $this->data['viewPath'] = 'AuthenticatedUser.StudentTransactionReport.';
		
	    $this->data['jsArray'][] = 'Student_Transaction_Report.js';
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
            'Transaction Report' => route('studentTransactionReport::index')
        );
        $this->_setBreadcrumbs($breadcrumb);               
		$this->data['pageTitle'] = 'Student Transaction Report';
		
        $this -> data['userStudent'] = Student::find( Auth::user()->student_id);

      /*   $this -> data['studentID'] = DB::table('tbl_students')
              -> select( 'system_generated_student_id', 'roll_no','class_id','stu_group','section_id','cash_in_hands')
              -> join ('tbl_users', 'tbl_users.student_id' ,'=','tbl_students.student_id')
              -> where('tbl_users.student_id', '=', $this->data['userStudent']->student_id)
              -> get();  */


       $this-> data['studentID'] = DB::table('tbl_students AS si')
			-> select('si.section_id', 
					  'si.system_generated_student_id', 
					  'si.student_name', 
					  'si.roll_no', 
					  'ci.id AS class_id',           'ci.ClassName',   'si.class_id',
					  'sci.section_id AS section_id','sci.SectionName','si.section_id',
					  'sg.id AS group_id',           'sg.GroupName',   'si.stu_group'
				 )
			-> join('classinfo AS ci', 'ci.ClassID',        '=', 'si.class_id')
		    -> join('sectioninfo AS sci', 'sci.section_id', '=', 'si.section_id') 
			-> join('stugrp AS sg', 'sg.id',                '=', 'si.stu_group')
			-> join ('tbl_users','tbl_users.student_id' ,   '=', 'si.student_id')
			
            -> where('tbl_users.student_id', '=', $this->data['userStudent']->student_id)
			-> first();


          if (empty($this->data['studentID'])) {
                        echo '<h6 class="text-danger text-uppercase">No data found.</h6>';
                        return;
                    }

			  
        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }
	
    /******************** month_wise_student_transaction_report method ***********************/
   
    public function month_wise_student_transaction_report(Request $request) {

        $class_id   = $request->class_id;
        $group_id   = $request->group_id;
        $ibv_id     = $request->ibv_id;
        $month      = $request->month;
        $studentId  = $request->studentId;
        $student_id = $request->student_id;

       

        $this-> data['studentTransaction']= DB::table('tbl_received_student_payment_sub_heads')->select('received_student_payment_sub_head_id','student_payment_id', 'student_payment_name', 'payment_amount', 'pay_status','create_time')
            ->where('class_id', '=', $class_id)
            ->where('group_id', '=', $group_id)
            ->where('system_generated_student_id', '=', $studentId)
            ->where('student_id', '=', $student_id)
            ->where('month', '=', $month)
            ->get();
           
		  /*    echo '<pre>';
          print_r($this-> data['studentTransaction']);
        echo '<pre>';  exit();  */
		
      return view($this->data['viewPath'] . 'view', array('data' => $this->data));
	}
	 
}
