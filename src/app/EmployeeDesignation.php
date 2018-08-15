<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeDesignation extends Model {

    protected $table = 'tbl_employee_designations';
    protected $primaryKey = 'designation_id';
    public $timestamps = false;

}
