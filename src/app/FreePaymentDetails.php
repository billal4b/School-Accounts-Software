<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreePaymentDetails extends Model {

    protected $table      = 'tbl_stu_free_payment_view';
    protected $primaryKey = 'free_payment_view_id';
    public $timestamps    = false;

}
