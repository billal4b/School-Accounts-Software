<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceivedStudentPaymentSubHead extends Model {

    protected $table = 'tbl_received_student_payment_sub_heads';
    protected $primaryKey = 'received_student_payment_sub_head_id';
    public $timestamps = false;
}
