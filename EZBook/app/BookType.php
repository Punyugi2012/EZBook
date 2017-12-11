<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
    protected $table = 'bookstypes';
    public $timestamps = false;
    protected $fillable = [
        'pathFile', 
        'book_id'
    ];
    public function books() {
        return $this->hasMany('App\Books');
    }
}
