<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'votes';
    protected $fillable = [
        'score', 
        'member_id', 
        'book_id'
    ];
    public function member() {
        $this->belongsTo('App\Member', 'member_id', 'id');
    }
    public function book() {
        $this->belongsTo('App\Book', 'book_id', 'id');
    }
}
