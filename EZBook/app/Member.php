<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = [
        'id_card',
        'name',
        'surname',
        'phone',
        'address',
        'gender',
        'birthday',
        'status',
        'account_number',
        'image',
        'url_image',
        'user_id',
        'account_id'
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
    public function votes() {
        return $this->hasMany('App\Vote');
    }
    public function account() {
        return $this->belongsTo('App\Account', 'account_id', 'id');
    }
}
