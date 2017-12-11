<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = [
        'username', 
        'password', 
        'email', 
        'type'
    ];
    public function member() {
        return $this->hasOne('App\Member');
    }
    public function publisher() {
        return $this->hasOne('App\Publisher');
    }
}
