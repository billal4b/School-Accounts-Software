<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalarySheet extends Model {

    protected $table = 'tbl_salary_sheets';
    protected $primaryKey = 'salary_sheet_id';
    public $timestamps = false;

}
