<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model {

    protected $table = 'tbl_banks';
    protected $primaryKey = 'bank_id';
    public $timestamps = false;

}
