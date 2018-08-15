<?php

namespace App\Http\Controllers\AuthenticatedUser\BankEmployee;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class StudentPaymentController extends Controller {

    public function __construct() {

        date_default_timezone_set('Asia/Dhaka');

        $this->data = array();
        $this->data['menuId'] = 17;
        $this->data['viewPath'] = 'AuthenticatedUser.BankEmployee.StudentPayment.';

        if ($this->_hasPrivilegeToAccessTheMenu($this->data['menuId'], Auth::user()->role_id) == 0) {
            abort(404);
        }

        $this->data['jsArray'][] = 'BankEmployee_StudentPayment.js';
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

    public function index() {

        $breadcrumb = array(
            'Student Payment' => route('bankEmp::studentPayment::index')
        );
        $this->_setBreadcrumbs($breadcrumb);

        $this->data['pageTitle'] = 'Student Payment';


        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }

    public function slip(Request $request) {

        if ($request->ajax()) {

            try {

                $generateType = $request->generateType;
                $studentId = $request->studentId;
                $generateMonth = $request->generateMonth;

                if ($studentId != 0) {

                    $this->data['studentDetails'] = DB::table('studentinfo AS si')
                            ->select('si.id', 'si.FullName', 'si.RollNo', 'ci.id AS class_id', 'ci.ClassName', 'sci.section_id', 'sci.SectionName', 'sg.id AS group_id', 'sg.GroupName')
                            ->join('classinfo AS ci', 'ci.ClassID', '=', 'si.ClassID')
                            ->join('sectioninfo AS sci', 'sci.SectionID', '=', 'si.SectionID')
                            ->join('stugrp AS sg', 'sg.GroupName', '=', 'si.StuGroup')
                            ->where('si.StudentID', '=', $studentId)
                            ->first();
                    if (empty($this->data['studentDetails'])) {
                        echo '<h6 class="text-danger text-uppercase">No data found.</h6>';
                        return;
                    }
                    //echo '<pre>';print_r($this->data['studentDetails']);echo '</pre>';exit();

                    $generateClass = $this->data['studentDetails']->class_id;
                    $generateGroup = $this->data['studentDetails']->group_id;

                    $this->data['paymentMonth'] = $request->generateMonth;
                    $this->data['paymentDetails'] = DB::select('call generate_month_wise_student_payment_slip("' . $generateClass . '", "' . $generateGroup . '", "' . $generateMonth . '")');

                    if (empty($this->data['paymentDetails'])) {
                        echo '<h6 class="text-danger text-uppercase">No data found.</h6>';
                        return;
                    }

                    return view($this->data['viewPath'] . 'viewOrPrint', array('data' => $this->data));
                }
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            throw new Exception('Invalid request!');
        }
    }

}
