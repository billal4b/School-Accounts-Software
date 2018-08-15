<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

/*
 * 
  Route::get('/', function () {
  return view('welcome');
  });
 * 
 */

Route::filter('guest', function() {
    if (Auth::check()) {
        return redirect('/AuthenticatedUser/Home/OnlineInformation');
    }
});

Route::get('auth/login', function() {
    return redirect('Authentication/SignIn');
});

Route::get('/', function() {

    return redirect('Authentication/SignIn');
});

Route::get('Authentication/SignIn', array(
    'as' => 'signInForm',
    'uses' => 'AuthenticationController@signIn'
))->before('guest');
Route::post('Authentication/SignIn', array(
    'as' => 'signInAction',
    'uses' => 'AuthenticationController@signInAction'
))->before('guest');

Route::group(array(
    'middleware' => 'auth',
    'prefix' => 'AuthenticatedUser',
    'namespace' => 'AuthenticatedUser'
        ), function() {


   /******************** Expense *************************/

    Route::get('ThreeInOne/{pageType}', array(// available page types are income, expense, fixed assets
        'as' => '3in1',
        'uses' => 'ThreeInOneController@index'
    ))->where('pageType', '[A-Za-z]+');

    Route::post('ThreeInOne/{pageType}', array(
        'as' => '3in1p',
        'uses' => 'ThreeInOneController@store'
    ))->where('pageType', '[A-Za-z]+');
	
	
    Route::get('ThreeInOne/GetAccountingSubHeadsByAccountingHeadId/{headId}', array(// available page types are income, expense, fixed assets
        'uses' => 'ThreeInOneController@getAccountingSubHeadsByAccountingHeadId'
    ))->where('headId', '[0-9]+');
 
 /******************** Expense Report **********************/

   
Route::group(array(
	   'prefix'  => 'ExpenseReport',
	    'as'     => 'expenseReport::',
		 ), function(){
			 
		Route::get('/', array(
            'as'   => 'index',
            'uses' => 'ExpenseReportController@index'
        ));
		Route::get('View', array(
             'as'   => 'viewExpenseReport',
             'uses' => 'ExpenseReportController@view'
        )); 
	});
   
   
   /******************** User profile *************************/

    Route::group(array(
        'prefix' => 'Home',
        'as' => 'home::',
            ), function() {

        Route::get('OnlineInformation', array(
            'as' => 'onlineInfo',
            'uses' => 'HomeController@onlineInformation'
        ));

        Route::get('UpdateOwnProfile', array(
            'as' => 'updateOwnProfile',
            'uses' => 'HomeController@edit'
        ));
        Route::post('UpdateOwnProfile', array(
            'as' => 'updateOwnProfileAction',
            'uses' => 'HomeController@update'
        ));

        Route::post('UpdateOwnProfilePic', array(
            'as' => 'updateProfile',
            'uses' => 'HomeController@update_image'
        ));

        Route::get('UpdateProfilePassword', array(
            'as' => 'updateProfilePassword',
            'uses' => 'HomeController@edit_password'
        ));
        Route::post('UpdateProfilePassword', array(
            'as' => 'updatePasswordAction',
            'uses' => 'HomeController@update_password'
        ));


        Route::get('SignOut', array(
            'as' => 'signOut',
            'uses' => 'HomeController@signOut'
        ));
    });

    
   
   /********************Student Payment Report*************************/  
   
   Route::group(array(	  
     'prefix' => 'StudentReport',	  
     'as'     => 'studentReport::',		
   ), function(){		
	   Route::get('/', array(        
	      'as'   => 'index',          
	      'uses' => 'StudentPaymentReportController@index'   
	   )); 		
	   Route::get('View/{fromDate}/{toDate}', array(     
	      'as'   => 'viewReport',      
	      'uses' => 'StudentPaymentReportController@generate_student_payment_report_by_date'  
	   ));		
	   
	   Route::get('Print/{fromDate}/{toDate}', array(	
	      'as'   => 'printReport',		
	      'uses' => 'StudentPaymentReportController@print_generate_student_payment_report_by_date'	
	   )); 	
	   
	   Route::get('Confirm/{received_student_payment_id}', array(		
	      'as'   => 'confirm',		
	      'uses' => 'StudentPaymentReportController@confirm_bank_admin'	
	   ))->where('received_student_payment_id', '[0-9]+'); 	
	   
	   Route::get('Edit/{received_student_payment_id}', array(	
	      'as'   => 'editPaymentAmount',		
	      'uses' => 'StudentPaymentReportController@edit'	
	   ))->where('received_student_payment_id', '[0-9]+');		
	   
	   Route::post('Update/{received_student_payment_id}', array(	
	      'as'   => 'updatePaymentAmount',		
		  'uses' => 'StudentPaymentReportController@update'		
	   ))->where('received_student_payment_id', '[0-9]+');  
   });
   
      /******************** Free payment Report **********************/

   
    Route::group(array(
	   'prefix'  => 'FreePaymentReport',
	    'as'     => 'freePaymentReport::',
		 ), function(){
			 
		Route::get('/', array(
            'as'   => 'index',
            'uses' => 'FreePaymentReportController@index'
        ));
		Route::get('View', array(
             'as'   => 'viewExpenseReport',
             'uses' => 'ExpenseReportController@view'
        )); 
	});
   
	/********************Income Report*************************/
	
 Route::group(array(
	'prefix' => 'IncomeReport',
	'as'     => 'incomeReport::',
		 ), function(){
		Route::get('/', array(
            'as'   => 'index',
            'uses' => 'IncomeReportController@index'
        ));
		Route::get('View', array(
             'as'   => 'viewIncomeReport',
             'uses' => 'IncomeReportController@view'
        ));
		
		Route::get('Print/{from_date}/{to_date}/{branch?}/{class?}/{section?}/{group?}/{sID?}/{head?}/{bank?}', array(
            'as'   => 'incomeReportPrint',
            'uses' => 'IncomeReportController@view_print'
        ));
		
        Route::get('View/GetBranchSection/{BranchVersionID}/{ClassID}', array(
             'uses' => 'IncomeReportController@getBranchSection'
        ))->where(array(
			'BranchVersionID', '[0-9]+',
			'ClassID', '[0-9]+',
		));  
		Route::get('View/GetStudentIdBySectionIdBranchID/{sectionID}/{BranchID}', array(
             'uses' => 'IncomeReportController@getStudentIdBySectionIdBranchID'
        ))->where(array(		
			'sectionID', '[0-9]+',
			'BranchID', '[0-9]+',
		)); 
		/* Route::get('View/GetHeadNameByClassID/{ClassID}/', array(
             'uses' => 'IncomeReportController@getHeadNameByClassID'
         ))->where('ClassID', '[0-9]+');  */
		 
		 Route::get('View/GetHeadNameByClassID/{BranchID}/{ClassID}', array(
             'uses' => 'IncomeReportController@getHeadNameByClassID'
        ))->where(array(
		    'BranchID', '[0-9]+',	
		    'ClassID', '[0-9]+',				
		)); 
	  });

/************ Students wise payment report ************/
			
			Route::resource('StudentwisePaymentReport', 'StudentwisePaymentReportController', array(
                'names' => array(
                    'index'  => 'studentwisePaymentReport.index',
                )
            ));
            Route::get('StudentwisePaymentReport/{BranchVersionID}/{ClassID}', array(
				 'uses' => 'StudentwisePaymentReportController@getBranchSection'
			))->where(array(
				'BranchVersionID', '[0-9]+',
				'ClassID', '[0-9]+',
		    ));
			Route::post('StudentwisePaymentReport/View', array(
                'uses' => 'StudentwisePaymentReportController@view'
            ));
	  
	  
/********************Confirmation Report for chairman/Principal *************************/	

     Route::group(array(	
	    'prefix' => 'ConfirmationReport',	
		'as'     => 'confirmationReport::',		
		    ), function(){		
			Route::get('/', array(          
     			'as'   => 'index',            
				'uses' => 'ConfirmationReportController@index'      
			));		
			Route::get('View/{fromDate}/{toDate}', array(    
			   'as'   => 'viewConfirmationReport',          
 			   'uses' => 'ConfirmationReportController@student_payment_confirmation_report'       
			)); 	
		});	
		
	/********************All income Report for chairman/Principal *************************/
	
    	Route::group(array(	
		   'prefix' => 'IncomeReportInAll',	
		   'as'     => 'incomeReportInAll::',		
		), function(){		
		Route::get('/', array(         
		  'as'   => 'index',         
		  'uses' => 'IncomeReportInAllController@index'     
		));		
		Route::get('View', array(      
		   'as'   => 'viewIncomeReportInAll',        
		   'uses' => 'IncomeReportInAllController@view'    
		 ));   
		Route::get('View/GetStudentIdByClassIDSectionIdGroupID/{ClassID}/{GroupID}', array(       
		    'uses' => 'IncomeReportInAllController@getStudentIdByClassIDSectionIdGroupID'     
		))->where(array(		
		       'ClassID', '[0-9]+',		
		       'GroupID', '[0-9]+',		
		   ));  
		});
		
		
		
	/********************Version and Gender Income Report for chairman/Principal *************************/

	Route::group(array(
	'prefix' => 'IncomeReportVersionGender',
	'as'     => 'incomeReportVersionGender::',
		 ), function(){
		Route::get('/', array(
            'as'   => 'index',
            'uses' => 'IncomeReportVersionGenderController@index'
        ));
		Route::get('View', array(
             'as'   => 'viewIncomeReportBoyGirl',
             'uses' => 'IncomeReportVersionGenderController@view'
        )); 
	});

		


/******************** Student Transaction Report *************************/

	Route::group(array(
	'prefix' => 'StudentTransactionReport',
	'as'     => 'studentTransactionReport::',
		 ), function(){
		Route::get('/', array(
            'as'   => 'index',
            'uses' => 'StudentTransactionReportController@index'
        ));
		
		 Route::get('MonthWiseStudentTransactionSlip/{class_id}/{group_id}/{ibv_id}/{month}/{studentId}/{student_id}', array(
            'as' => 'monthWiseStudentTransactionSlip',
            'uses' => 'StudentTransactionReportController@month_wise_student_transaction_report'
        ))->where(array(
            'class_id' => '[0-9]+',
            'group_id' => '[0-9]+',
            'ibv_id' => '[0-9]+',
            'month' => '[0-9]+',
            'student_id' => '[0-9]+',
            'studentId' => '[0-9A-Za-z]+',
        ));
	});

	/***************** Student Information for accounts ****************/


    Route::group(array(
	'prefix' => 'StudentInformation',
	'as'     => 'studentInformation::',
		 ), function(){
			 
		Route::get('/', array(
            'as'   => 'index',
            'uses' => 'StudentInformationController@index'
        )); 
		Route::post('Search', array(
            'as'   => 'search',
            'uses' => 'StudentInformationController@search'
        ));
	});
	
	/************ Students view for accounts ************/
			
			
			Route::post('StudentsViewAccount/View', array(
                'uses' => 'StudentsViewAccountsController@view'
            ));
			
            Route::group(array(
                'prefix' => 'StudentViewPrint',
                'as'     => 'studentViewPrint::'
            ), function() {

                Route::get('StudentsViewAccount/Print/{branchVersion?}/{class?}/{section?}/{group?}', array(
                    'as'   => 'studentPrint',
                    'uses' => 'StudentsViewAccountsController@print_student'
                ));

            });

			Route::resource('StudentsViewAccount', 'StudentsViewAccountsController', array(
                'names' => array(
                    'index'   => 'studentsViewAccount.index',
					'edit'    => 'studentsViewAccount.edit',
                    'update'  => 'studentsViewAccount.update',
                )
            ));
			Route::get('StudentsViewAccount/edit/{BranchVersionID}/{ClassID}', array(
				 'uses' => 'StudentsViewAccountsController@getBranchSection'
			))->where(array(
				'BranchVersionID', '[0-9]+',
				'ClassID', '[0-9]+',
		    ));
	
	
	
	
	
/*********************Generate Student Payment Slip***********************/





Route::group(array(
        'prefix' => 'GenerateStudentPaymentSlip',
        'as' => 'generateStudentPaymentSlip::',
            ), function() {

        Route::get('/', array(
            'as' => 'index',
            'uses' => 'GenerateStudentPaymentSlipController@index'
        ));
//        Route::get('{generateType}/{studentId}/{generateMonth}/{generateClass}/{generateSection}/{generateGroup}', array(
//            'as' => 'viewOrPrint',
//            'uses' => 'GenerateStudentPaymentSlipController@viewOrPrint'
//        ))->where(array(
//            'generateType' => '[A-Za-z]+',
//            'studentId' => '[0-9A-Za-z]+',
//            'generateMonth' => '[0-9]+',
//            'generateClass' => '[0-9]+',
//            'generateSection' => '[0-9]+',
//            'generateGroup' => '[0-9]+',
////            'generateReceipt' => '[0-9]+',
//        ));

        /*Route::get('{generateType}/{studentId}/{generateMonth}/{receiptNo}', array(
            'as' => 'viewOrPrint',
            'uses' => 'GenerateStudentPaymentSlipController@viewOrPrint'
        ))->where(array(
            'generateType' => '[A-Za-z]+',
            'studentId' => '[0-9A-Za-z]+',
            'generateMonth' => '[0-9]+',
            'receiptNo' => '[0-9]+',
        ));*/
        Route::get('{generateType}/{studentId}/{receiptNo}', array(
            'as' => 'viewOrPrint',
            'uses' => 'GenerateStudentPaymentSlipController@viewOrPrint'
        ))->where(array(
            'generateType' => '[A-Za-z]+',
            'studentId' => '[0-9A-Za-z]+',
            'receiptNo' => '[0-9]+',
        ));

        Route::post('Pay', array(
            'as' => 'pay',
            'uses' => 'GenerateStudentPaymentSlipController@pay'
        ));

        Route::post('Confirm', array(
            'as' => 'confirm',
            'uses' => 'GenerateStudentPaymentSlipController@confirm'
        ));
        
        Route::get('GenerateMonthWiseStudentPaymentSlip/{class_id}/{group_id}/{ibv_id}/{month}/{studentId}/{student_id}', array(
            'as' => 'generateMonthWiseStudentPaymentSlip',
            'uses' => 'GenerateStudentPaymentSlipController@generate_month_wise_student_payment_slip'
        ))->where(array(
            'class_id' => '[0-9]+',
            'group_id' => '[0-9]+',
            'ibv_id' => '[0-9]+',
            'month' => '[0-9]+',
            'student_id' => '[0-9]+',
            'studentId' => '[0-9A-Za-z]+',
        ));
    });








/*********************Bank Employee***********************/



    Route::group(array(
        'prefix' => 'BankEmployee',
        'as' => 'bankEmp::',
        'namespace' => 'BankEmployee'
            ), function() {

        Route::group(array(
            'prefix' => 'StudentPayment',
            'as' => 'studentPayment::'
                ), function() {

            Route::get('/', array(
                'as' => 'index',
                'uses' => 'StudentPaymentController@index'
            ));

            Route::get('Slip/{generateType}/{studentId}/{generateMonth}', array(
                'as' => 'viewOrPrint',
                'uses' => 'StudentPaymentController@slip'
            ));
        });
    });

/*********************  AppSetup **********************/

    Route::group(array(
        'prefix' => 'AppSetup',
            //'as' => 'resource::',
            ), function() {

        Route::get('/', array(
            'as' => 'appSetup',
            'uses' => 'AppSetupController@index'
        ));

        Route::group(array(
            'namespace' => 'AppSetup'
                ), function() {


            Route::resource('EmployeeGrade', 'EmployeeGradeController', array(
                'names' => array(
                    'create' => 'empGrade.create',
                    'edit' => 'empGrade.edit',
                    'index' => 'empGrade.index',
                    'store' => 'empGrade.store',
                    'update' => 'empGrade.update',
                )
            ));
            Route::resource('EmployeeDesignation', 'EmployeeDesignationController', array(
                'names' => array(
                    'create' => 'empDesignation.create',
                    'edit' => 'empDesignation.edit',
                    'index' => 'empDesignation.index',
                    'store' => 'empDesignation.store',
                    'update' => 'empDesignation.update',
                )
            ));
            Route::resource('Bank', 'BankController', array(
                'names' => array(
                    'create' => 'bank.create',
                    'edit' => 'bank.edit',
                    'index' => 'bank.index',
                    'store' => 'bank.store',
                    'update' => 'bank.update',
                )
            ));
            Route::resource('BankBranch', 'BankBranchController', array(
                'names' => array(
                    'create' => 'branch.create',
                    'edit' => 'branch.edit',
                    'index' => 'branch.index',
                    'store' => 'branch.store',
                    'update' => 'branch.update',
                )
            ));
            Route::get('BankAccount/GetBranchNameByBankId/{bank_id}', array('uses' => 'BankAccountController@getBranchNameByBankId'))->where('bank_id', '[0-9]+');
            Route::resource('BankAccount', 'BankAccountController', array(
                'names' => array(
                    'create' => 'bankAccount.create',
                    'edit' => 'bankAccount.edit',
                    'index' => 'bankAccount.index',
                    'store' => 'bankAccount.store',
                    'update' => 'bankAccount.update',
                )
            ));
            Route::resource('ThirdParty', 'ThirdPartyController', array(
                'names' => array(
                    'create' => 'thirdParty.create',
                    'edit' => 'thirdParty.edit',
                    'index' => 'thirdParty.index',
                    'store' => 'thirdParty.store',
                    'update' => 'thirdParty.update',
                )
            ));
            Route::resource('AccountingCategory', 'AccountingCategoryController', array(
                'names' => array(
                    'create' => 'accountCategory.create',
                    'edit' => 'accountCategory.edit',
                    'index' => 'accountCategory.index',
                    'store' => 'accountCategory.store',
                    'update' => 'accountCategory.update',
                )
            ));
            Route::resource('AccountingHead', 'AccountingHeadController', array(
                'names' => array(
                    'create' => 'head.create',
                    'edit' => 'head.edit',
                    'index' => 'head.index',
                    'store' => 'head.store',
                    'update' => 'head.update',
                )
            ));
            Route::get('AccountingSubHead/GetHeadNameByAccountingCategoryId/{head_id}', array('uses' => 'AccountingSubHeadController@getHeadNameByAccountingCategoryId'))->where('head_id', '[0-9]+');
            Route::resource('AccountingSubHead', 'AccountingSubHeadController', array(
                'names' => array(
                    'create' => 'subHead.create',
                    'edit' => 'subHead.edit',
                    'index' => 'subHead.index',
                    'store' => 'subHead.store',
                    'update' => 'subHead.update',
                )
            ));
            Route::resource('Salary', 'SalaryController', array(
                'names' => array(
                    'create' => 'salary.create',
                    'edit' => 'salary.edit',
                    'index' => 'salary.index',
                    'store' => 'salary.store',
                    'update' => 'salary.update',
                )
            ));
            Route::resource('StudentPayment', 'StudentPaymentController', array(
                'names' => array(
                    'create' => 'studentPayment.create',
                    'edit' => 'studentPayment.edit',
                    'index' => 'studentPayment.index',
                    'store' => 'studentPayment.store',
                    'update' => 'studentPayment.update',
                )
            ));
            
			
			/************ Student Free Payment ************/
			
			Route::resource('FreePayment', 'FreePaymentController', array(
                'names' => array(                  
                    'index'  => 'freePayment.index',
					'edit'   => 'freePayment.edit',
                    'update' => 'freePayment.update',
                )
            ));
			
			/************ Student Free payment Details ************/
			
			Route::resource('FreePaymentDetails', 'FreePaymentDetailsController', array(
                'names' => array(                  
				    'create' => 'freePaymentDetails.create',
					'edit'   => 'freePaymentDetails.edit',
                    'index'  => 'freePaymentDetails.index',				
					'store'  => 'freePaymentDetails.store',				
					'update' => 'freePaymentDetails.update',
                )
            ));
			Route::get('FreePaymentDetails/create/{BranchID}/{ClassID}', array(
               'uses' => 'FreePaymentDetailsController@getHeadNameByClassID'
            ))->where(array(
				'BranchID', '[0-9]+',	
				'ClassID', '[0-9]+',				
		    )); 
			
			/************ student ************/
			
			 Route::post('Student/Search', array(
                'uses' => 'StudentController@search'
            ));	
			 Route::get('Student/create/{BranchVersionID}/{ClassID}', array(
				 'uses' => 'StudentController@getBranchSection'
			))->where(array(
				'BranchVersionID', '[0-9]+',
				'ClassID', '[0-9]+',
		    ));
            Route::resource('Student', 'StudentController', array(
                'names' => array(
                    'create' => 'student.create',
                    'edit' => 'student.edit',
                    'index' => 'student.index',
                    'store' => 'student.store',
                    'update' => 'student.update',
                )
            ));
				/************ Students view ************/
			
		/* 	Route::get('StudentsView/{BranchVersionID}/{ClassID}', array(
				 'uses' => 'StudentsViewController@getBranchSection'
			))->where(array(
				'BranchVersionID', '[0-9]+',
				'ClassID', '[0-9]+',
		    ));
			Route::post('StudentsView/View', array(
                'uses' => 'StudentsViewController@view'
            ));				
			Route::resource('StudentsView', 'StudentsViewController', array(
                'names' => array(
                    'index'  => 'studentsView.index',
                )
            )); */
			
			Route::get('StudentsView/{BranchVersionID}/{ClassID}', array(
				 'uses' => 'StudentsViewController@getBranchSection'
			))->where(array(
				'BranchVersionID', '[0-9]+',
				'ClassID', '[0-9]+',
		    ));
			Route::post('StudentsView/View', array(
                'uses' => 'StudentsViewController@view'
            ));
			
            Route::group(array(
                'prefix' => 'StudentViewPrint',
                'as'     => 'studentViewPrint::'
            ), function() {

                Route::get('StudentsView/Print/{branchVersion?}/{class?}/{section?}/{group?}', array(
                    'as'   => 'studentPrint',
                    'uses' => 'StudentsViewController@print_student'
                ));

            });

			Route::resource('StudentsView', 'StudentsViewController', array(
                'names' => array(
                    'index'  => 'studentsView.index',
                )
            ));
			/************ employee scale ************/
			
			Route::resource('EmployeeScale', 'EmployeeScaleController', array(
                'names' => array(
                    'create' => 'empScale.create',
                    'edit'   => 'empScale.edit',
                    'index'  => 'empScale.index',
                    'store'  => 'empScale.store',
                    'update' => 'empScale.update',
                )
            ));
			/************ Designation scale ************/
			
			Route::resource('DesignationScale', 'DesignationScaleController', array(
                'names' => array(
                    'create' => 'degScale.create',
                    'edit'   => 'degScale.edit',
                    'index'  => 'degScale.index',
                    'store'  => 'degScale.store',
                    'update' => 'degScale.update',
                )
            ));
			/************ Employee  ************/
			
			Route::resource('Employee', 'EmployeeController', array(
                'names' => array(
                    //'create' => 'employee.create',
                    'edit'   => 'employee.edit',
                    'index'  => 'employee.index',
                    'store'  => 'employee.store',
                    'update' => 'employee.update',
'create' => 'employee.create',
                )
            ));
			
			
        });
    });




    /*     * ******* Salary Sheet ****** */
    Route::group(array(
        'prefix' => 'SalarySheet',
        'as' => 'salarySheet::'
            ), function() {

        Route::get('/', array(
            'uses' => 'SalarySheetController@index',
            'as' => 'index'
        ));

        /*Route::get('Process/{month}/{user_role_id}', array(
            'uses' => 'SalarySheetController@process',
            'as' => 'process'
        ))->where(array(
            'month', '[0-9]+',
            'user_role_id', '[0-9]+',
        ));

        Route::get('View/{month}/{user_role_id}', array(
            'uses' => 'SalarySheetController@view',
            'as' => 'view'
        ))->where(array(
            'month', '[0-9]+',
            'user_role_id', '[0-9]+',
        ));*/

Route::get('Process/{month}/{user_role_id}/{ibv_id}', array(
            'uses' => 'SalarySheetController@process',
            'as' => 'process'
        ))->where(array(
            'month', '[0-9]+',
            'user_role_id', '[0-9,]+',
            'ibv_id', '[0-9A-Z_,]+',
        ));

        Route::get('View/{month}/{user_role_id}/{ibv_id}', array(
            'uses' => 'SalarySheetController@view',
            'as' => 'view'
        ))->where(array(
            'month', '[0-9]+',
            'user_role_id', '[0-9,]+',
            'ibv_id', '[0-9A-Z_,]+',
        ));

        Route::get('Edit/{salary_sheet_id}', array(
            'uses' => 'SalarySheetController@edit',
            'as' => 'edit'
        ))->where(array(
            'salary_sheet_id', '[0-9]+',
        ));

        Route::post('Edit/{salary_sheet_id}', array(
            'uses' => 'SalarySheetController@update',
            'as' => 'update'
        ))->where(array(
            'salary_sheet_id', '[0-9]+',
        ));
    });
    /*     * *************************** */
});


