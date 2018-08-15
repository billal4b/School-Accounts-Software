<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GenMenu extends Model {

    protected $table = 'tbl_gen_menus';
    protected $primaryKey = 'menu_id';
    public $timestamps = false;

}
