<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    
    public function bookType() {
        return $this->belongsTo('App\BookType', 'book_type_id', 'id');
    }
    public function bookImages() {
        return $this->hasMany('App\BookImage');
    }
    public function authors() {
        return $this->belongsToMany('App\Author', 'authors_books');
    }
    public function comments() {
        return $this->hasMany('App\Comment');
    }
    public function publisher() {
        return $this->belongsTo('App\Publisher', 'publisher_id', 'id');
    }
    public function purchases() {
        return $this->hasMany('App\Purchase');
    }
    public function votes() {
        return $this->hasMany('App\Vote');
    }
}
