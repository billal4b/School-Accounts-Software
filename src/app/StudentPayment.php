<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model {

    protected $table = 'tbl_student_payment_sub_head_details';
    protected $primaryKey = 'student_payment_id';
    public $timestamps = false;

}
