<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountingSubHead extends Model {

    protected $table = 'tbl_accounting_sub_heads';
	
    protected $primaryKey = 'sub_head_id';
	//protected $foreingKey = 'branch_id';
    public $timestamps = false;

}
