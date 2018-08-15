<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThirdParty extends Model {

    protected $table = 'tbl_third_parties';
    protected $primaryKey = 'third_party_id';
    public $timestamps = false;

}
