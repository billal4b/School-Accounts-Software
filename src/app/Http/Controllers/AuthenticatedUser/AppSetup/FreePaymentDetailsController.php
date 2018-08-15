<?php

namespace App\Http\Controllers\AuthenticatedUser\AppSetup;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\FreePaymentDetails;
use DB;
use PDF;
use Validator;
//use Validator;

class FreePaymentDetailsController extends Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Dhaka');

         $this->data = array();
		$this->data['menuId'] = 47;
        $this->data['viewPath'] = 'AuthenticatedUser.AppSetup.FreePaymentDetails.';
		
	    $this->data['jsArray'][] = 'Free_Payment_Details.js';
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
            'Free Payment View' => route('freePaymentDetails.index'),
        );
        $this->_setBreadcrumbs($breadcrumb);
		
		$this->data['pageTitle'] = 'Free Payment View';
		//$this->data['FreePaymentList'] = FreePaymentDetails::get();
	     $this->data['FreePaymentList'] = DB::table('tbl_stu_free_payment_view')
			->join('classinfo','tbl_stu_free_payment_view.class_id','=','classinfo.id')
			->join('stugrp','tbl_stu_free_payment_view.group_id','=','stugrp.id')
			->join('tbl_student_payment_sub_head_details','tbl_stu_free_payment_view.head_id','=','tbl_student_payment_sub_head_details.student_payment_id')
			->join('tbl_stu_free_payment','tbl_stu_free_payment_view.stu_free_payment_id','=','tbl_stu_free_payment.stu_free_payment_id')
			->select('tbl_stu_free_payment_view.free_payment_view_id','tbl_stu_free_payment_view.brn_version_id',
			        'tbl_stu_free_payment_view.amount','tbl_stu_free_payment_view.is_active','classinfo.ClassName','stugrp.GroupName',
			        'tbl_student_payment_sub_head_details.student_payment_name','tbl_stu_free_payment.free_catagory')
			//->orderBy('tbl_stu_free_payment_view.student_id', 'asc')
->groupBy('tbl_stu_free_payment_view.free_payment_view_id')
			->get();	

        return view($this->data['viewPath'] . 'index', array('data' => $this->data));
    }
    /******************** Create method ***********************/
	
     public function create(Request $request) {

        if (!$request->ajax()) {

            $breadcrumb = array(
                'App. Setup'         => route('appSetup'),
                'Free Payment View ' => route('freePaymentDetails.index'),
                'New'                => route('freePaymentDetails.create'),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle'] = 'Create Free Payment Details';
			
		   $this->data['classWise']     = DB::select('call get_student_classes(1)');	
		   $this->data['groupWise']     = DB::select('call get_student_groups(1)');	
		   $this->data['freePayment']   = DB::select('call get_stu_free_payment(1)');	
					
            try {

                $this->data['secInstitutes'] = DB::select('call get_sec_institute_branch_version("' . session('instituteDetails')->institute_id . '")');
                return view($this->data['viewPath'] . 'create', array('data' => $this->data));
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            throw new Exception('Invalid request!');
        }
    }
	
	    public function store(Request $request) {

        if (!$request->ajax()) {

            $validator = Validator::make($request->all(), array(
                        'branch_and_version' => 'min:1|required',
                        'class_name'         => 'min:1|required',
                        'branch_and_version' => 'min:1|required',
                        'group_name'         => 'min:1|required',
                        'head_name'          => 'min:1|required',
                        'free_catagory'      => 'min:1|required',
                        'amount'             => 'required|numeric',
                        'status'             => 'required',
            ));
            if ($validator->fails()) {
                return redirect()->route('freePaymentDetails.create')
                                ->withErrors($validator)
                                ->withInput();
            }

                $freePaymentDetails = new FreePaymentDetails;
                $freePaymentDetails->brn_version_id      = $request->branch_and_version;
                $freePaymentDetails->class_id            = $request->class_name;
                $freePaymentDetails->group_id            = $request->group_name;
                $freePaymentDetails->head_id             = $request->head_name;
                $freePaymentDetails->stu_free_payment_id = $request->free_catagory;
                $freePaymentDetails->amount              = $request->amount;
                $freePaymentDetails->is_active           = $request->status;
                $freePaymentDetails->created_at          = date('Y-m-d h:i:s');
                $freePaymentDetails->create_user_id      = Auth::user()->user_id;
                $freePaymentDetails->save();
            
            
            return redirect()->route('freePaymentDetails.create')
                            ->with('successMessage', 'Data inserted successfully.');
        }
    }
	
	  public function edit($id, Request $request) {

        if (!$request->ajax()) {

            $this->data['freePyDetails'] = FreePaymentDetails::findOrFail($id);

            $breadcrumb = array(
                'App. Setup'         => route('appSetup'),
                'Free Payment View ' => route('freePaymentDetails.index'),
                'Update'             => route('freePaymentDetails.edit', array('id' => $id)),
            );
            $this->_setBreadcrumbs($breadcrumb);

            $this->data['pageTitle']     = 'Update Free Payment Details';
			$this->data['classWise']     = DB::select('call get_student_classes(1)');	
		    $this->data['groupWise']     = DB::select('call get_student_groups(1)');	
		    $this->data['freePayment']   = DB::select('call get_stu_free_payment(1)');
		    $this->data['headWise']      = DB::select('call get_payment_heads(1)');
			
            $this->data['freePyDetails'] = FreePaymentDetails::where('free_payment_view_id', '=', $id)->first();
			
			$this->data['desigScale']   = DB::table('tbl_sec_designation_scales')
                ->select('sec_designation_scale_id', 'name')
                ->get();
            try {
                
                 $this->data['secInstitutes'] = DB::select('call get_sec_institute_branch_version("' . session('instituteDetails')->institute_id . '")');
                return view($this->data['viewPath'] . 'edit', array('data' => $this->data));
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        } else {
            throw new Exception('Invalid request!');
        }
    }
	
	 public function update(Request $request, $id) {

        $this->data['freePyDetails'] = FreePaymentDetails::findOrFail($id);

        $validator = Validator::make($request->all(), array(
                        'branch_and_version' => 'min:1|required',
                        'class_name'         => 'min:1|required',
                        'branch_and_version' => 'min:1|required',
                        'group_name'         => 'min:1|required',
                        'head_name'          => 'min:1|required',
                        'free_catagory'      => 'min:1|required',
                        'amount'             => 'required|numeric',
                        'status'             => 'required',
                    
        ));
        if ($validator->fails()) {
            return redirect()->route('freePaymentDetails.edit', array('id' => $id))
                            ->withErrors($validator)
                            ->withInput();
        }

        $freePaymentDetails = FreePaymentDetails::find($id);
		$freePaymentDetails->brn_version_id      = $request->branch_and_version;
		$freePaymentDetails->class_id            = $request->class_name;
		$freePaymentDetails->group_id            = $request->group_name;
		$freePaymentDetails->head_id             = $request->head_name;
		$freePaymentDetails->stu_free_payment_id = $request->free_catagory;
		$freePaymentDetails->amount              = $request->amount;
		$freePaymentDetails->is_active           = $request->status;
		$freePaymentDetails->created_at          = date('Y-m-d h:i:s');
		//$freePaymentDetails->create_user_id      = Auth::user()->user_id;
		$freePaymentDetails->updated_at          = date('Y-m-d h:i:s');

		
        $freePaymentDetails->save();

        return redirect()->route('freePaymentDetails.index')
                        ->with('successMessage', 'Data updated successfully.');
    }
	
	/******************** getHeadNameByClassID method ***********************/
	
	
		public function getHeadNameByClassID($BranchID,$classID) {
                $vbid = explode('_', $BranchID);
        $headWise   = DB::table('tbl_student_payment_sub_head_details')
					-> select('student_payment_id','student_payment_name')
					-> where('class_name', '=', $classID)
					 -> where('institute_branch_version_id', '=', $vbid[0])
					//-> where('institute_branch_version_id', '=', $BranchID)
					-> where ('is_active', '=',1)
					-> get();           
			
        echo '<option value="">----- Select -----</option>';
         foreach ($headWise as $sid) {
            echo '<option value="' . $sid->student_payment_id . '">' . $sid->student_payment_name . '</option>';
       }
    }
	

	
	
	
	

}
