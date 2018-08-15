<?php

namespace App\Http\Controllers\AuthenticatedUser;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Student;
use Validator;
use App\User;

class StudentInformationController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 28;
        $this->data['viewPath'] = 'AuthenticatedUser.StudentInformation.';
		
		$this->data['jsArray'][] = 'Student_Search.js';

        if ($this->_hasPrivilegeToAccessTheMenu($this->data['menuId'], Auth::user()->role_id) == 0) {
            abort(404);
        };
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
            'Student Information' => route('studentInformation::index')
        );
        $this->_setBreadcrumbs($breadcrumb);              

		$this->data['pageTitle'] = 'Students Information';
		
		 return view($this->data['viewPath'] . 'index',array('data' => $this->data));
		
	}
	public function search(Request $request) {
		     
		
           //echo '<pre>';print_r($request->all());echo '</pre>';exit();

        $this->data['studentList'] = DB::table('tbl_students')
             ->join('classinfo','tbl_students.class_id','=','classinfo.id')
             ->join('stugrp','tbl_students.stu_group','=','stugrp.id')
			 
             ->join('tbl_school_branches','tbl_students.branch','=','tbl_school_branches.school_branch_id')
             ->join('tbl_school_versions','tbl_students.version','=','tbl_school_versions.school_version_id')
			 
             ->join('sectioninfo','tbl_students.section_id','=','sectioninfo.section_id')
              ->select('tbl_students.student_id',
			          'tbl_students.system_generated_student_id',
			          'tbl_students.student_name',
			          'tbl_students.institute_branch_version_id',			          
					  'tbl_students.roll_no',
					  'tbl_students.status',
					  'tbl_students.cash_in_hands',
	
					  'classinfo.ClassName',
					  'stugrp.GroupName',
					  'sectioninfo.SectionName'
				)
             ->where('tbl_students.student_name', 'LIKE', '%' . $request->search . '%')
             ->orWhere('tbl_students.system_generated_student_id', '=', $request->search)
             ->orWhere('classinfo.ClassName',  'LIKE','%' . $request->search . '%')
             ->orWhere('sectioninfo.SectionName', 'LIKE', '%' . $request->search . '%')
             ->get();

			  /* echo '<pre>';
			     print_r($this->data['studentList']);
			  echo '</pre>';exit(); */
			  
        return view($this->data['viewPath'] . 'view_info',array('data' => $this->data));
		
    }

}
