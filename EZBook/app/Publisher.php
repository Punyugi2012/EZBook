<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = 'publishers';
    protected $fillable = [
        'name', 
        'address', 
        'phone', 
        'email', 
        'user_id'
    ];
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function books() {
        return $this->hasMany('App\Book');
    }
}
