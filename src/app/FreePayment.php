<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreePayment extends Model {

    protected $table      = 'tbl_stu_free_payment';
    protected $primaryKey = 'stu_free_payment_id';
    public $timestamps    = false;

}
