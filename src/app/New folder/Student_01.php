<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {

    protected $table = 'tbl_students';
    protected $primaryKey = 'student_id';
    public $timestamps = false;
    protected $fillable = ['student_name','year_of_admission','class_id','gender','institute_branch_version_id','contact_for_sms','father_name','father_mobile','mother_name','mother_mobile','status','status','create_time','create_logon_id','create_user_id','last_action', 'stu_group'];
}