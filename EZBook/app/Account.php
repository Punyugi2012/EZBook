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
        "member_id"
    ];
    public function member() {
        return $this->belongsTo('App\Member', 'member_id', 'id');
    }
}
