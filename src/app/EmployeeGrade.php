<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeGrade extends Model {

    protected $table = 'tbl_employee_grades';
    protected $primaryKey = 'grade_id';
    public $timestamps = false;

}
