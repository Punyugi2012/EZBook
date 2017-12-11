<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookImage extends Model
{
    protected $table = 'booksimages';
    public $timestamps = false;
    protected $fillable = [
        'pathFile', 
        'book_id'
    ];
    public function book() {
        return $this->belongsTo('App\Book', 'book_id', 'id');
    }
}
