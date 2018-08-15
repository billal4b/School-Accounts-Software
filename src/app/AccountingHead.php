<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountingHead extends Model {

    protected $table = 'tbl_accounting_heads';
    protected $primaryKey = 'head_id';
    public $timestamps = false;

}
