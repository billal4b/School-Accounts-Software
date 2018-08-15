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

class IncomeReportVersionGenderController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

         $this->data = array();
		$this->data['menuId'] = 23;
        $this->data['viewPath'] = 'AuthenticatedUser.IncomeReportVersionGender.';
		
	    $this->data['jsArray'][] = 'Income_Report_Version_Gender.js';
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
            'Income Report' => route('incomeReportVersionGender::index')
        );
        $this->_setBreadcrumbs($breadcrumb);               
		$this->data['pageTitle']       = 'Income Report in version and gender';
		
		$this->data['genderWise']      = DB::select('call get_genders(1)');	
		/* $this->data['versionWise']     = DB::table('tbl_school_versions')
		      ->select('school_version_id','school_version_name')
              ->get(); */
			  
        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }
    /********************view method***********************/

    public function view(Request $request) {
        if($request->ajax()) {
            try {				
				if(empty($request->gender)){
					$gender = 0;
				}else{
					$gender = $request->gender;
				}				
				if(empty($request->version)){
					$version = 0;
				}else{
					$version = $request->version;
				}   
				//$gender = $request->gender;
				 
				$this->data['IncomeReportBoyGirl'] = DB::select('call income_version_gender_report("' . date('Y-m-d',
                        strtotime(str_replace('-', '-', $request->from_date))) . ' 00:00:00", "'. date('Y-m-d',
				        strtotime(str_replace('-', '-', $request->to_date))) . ' 23:59:59", "'.$gender.'","'.$version.'")');
				
               // echo '<pre>';
                   // print_r($this->data['IncomeReportBoyGirl']);
			   // echo '</pre>'; exit();
				
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
            return view($this->data['viewPath'] . 'view', array('data' => $this->data));
        } else {
            throw new Exception('Invalid request!');
        }
    } 
	
}
