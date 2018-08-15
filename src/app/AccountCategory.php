<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountCategory extends Model {

    protected $table = 'tbl_account_categories';
    protected $primaryKey = 'account_category_id';
    public $timestamps = false;

}
