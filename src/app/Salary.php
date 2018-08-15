<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model {

    protected $table = 'tbl_salary_sub_head_details';
    protected $primaryKey = 'salary_sub_head_id';
    public $timestamps = false;

}
