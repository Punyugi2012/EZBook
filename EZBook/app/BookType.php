<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
    protected $table = 'books_types';
    public $timestamps = false;
    protected $fillable = [
        'name', 
    ];
    public function books() {
        return $this->hasMany('App\Book');
    }
}
