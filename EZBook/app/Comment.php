<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    public $timestamps = false;
    protected $fillable = [
        'message', 
        'date_comment', 
        'score', 
        'book_id', 
        'member_id'
    ];
    public function book() {
        return $this->belongsTo('App\Book', 'book_id', 'id');
    }
    public function member() {
        return $this->belongsTo('App\Book', 'member_id', 'id');
    }
}
