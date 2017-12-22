<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = "accounts";
    protected $fillable = [
        "account_number",
        "expired_date",
        "cvv",
    ];
    public function member() {
        return $this->hasOne('App\Member');
    }
}
