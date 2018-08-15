<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeScale extends Model {

    protected $table      = 'tbl_employee_scales';
    protected $primaryKey = 'employee_scale_id';
    public $timestamps    = false;

}
