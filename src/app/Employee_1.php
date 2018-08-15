<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

    protected $table      = 'employeeinfo';
    protected $primaryKey = 'EmpID';
    public $timestamps    = false;

}
