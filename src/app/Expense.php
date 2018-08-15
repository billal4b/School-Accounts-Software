<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model {

    protected $table = 'tbl_expenses';
    protected $primaryKey = 'expense_id';
	
    public $timestamps = false;
	protected $fillable = array(
        
        'expense_id',
        'invoice_no',      
        'payment_type',
        'expense_date',
		'head_id',
		
        'bank_id',
        'branch_id',
		'account_no',
        //'check_amount',
        'amount_sub',
        'check_no',
        'check_date',
	   
        'is_active',
        'create_time',
        'create_logon_id',
        'update_time',
        'update_logon_id',
        'last_action',
		
    
    );

}
