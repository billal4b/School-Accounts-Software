<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model {

    protected $table = 'tbl_bank_accounts';
	//protected $table = 'tbl_branches';
	
    protected $primaryKey = 'account_id';
	protected $foreingKey = 'branch_id';
    public $timestamps = false;

}
