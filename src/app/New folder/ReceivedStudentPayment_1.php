<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivedStudentPayment extends Model {

    protected $table = 'tbl_received_student_payments';
    protected $primaryKey = 'received_student_payment_id';
    public $timestamps = false;
    protected $fillable = array(
        
        'student_id',
        'system_generated_student_id',
        'generated_month',
        'class_id',
        'group_id',
        'received_amount_by_bank',
        'bank_user_id',
        'received_time',
        'is_active',
        'create_time',
        'create_logon_id',
        'create_user_id',
        'last_action',
        'bank_id',
        'bank_branch_id',
        'book_sl_no',
	'confrim_by_bank_admin',
	'institute_branch_version_id'
    );

}
