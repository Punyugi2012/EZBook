<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = [
        'name',
        'surname',
        'phone',
        'address',
        'gender',
        'birthday',
        'status',
        'isVoted',
        'image',
        'url_image',
        'user_id'
    ];
    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function comments() {
        return $this->hasMany('App\Comment');
    }
    public function purchases() {
        return $this->hasMany('App\Purchase');
    }
    public function vote() {
        return $this->hasOne('App\Vote');
    }
}
