<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = 'purchases';
    public $timestamps = false;
    protected $fillable = [
        'date_purchase', 
        'price', 
        'member_id', 
        'book_id'
    ];
    public function book() {
        return $this->belongsTo('App\Book', 'book_id', 'id');
    }
    public function member() {
        return $this->belongsTo('App\Member', 'member_id', 'id');
    }
    
}
