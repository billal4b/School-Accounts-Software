<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

    protected $table = 'tbl_roles';
    protected $primaryKey = 'role_id';
    public $timestamps = false;

}
