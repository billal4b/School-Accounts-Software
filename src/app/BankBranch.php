<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model {

    protected $table = 'tbl_bank_branches';
    protected $primaryKey = 'branch_id';
    public $timestamps = false;

}
