<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseSubHead extends Model {

    protected $table = 'tbl_expense_sub_heads';
    protected $primaryKey = 'expense_sub_head_id';
    public $timestamps = false;

}
