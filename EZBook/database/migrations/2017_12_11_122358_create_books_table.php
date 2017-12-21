<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->double('score')->default(0.0);
            $table->string('file_size');
            $table->integer('num_page');
            $table->integer('num_read')->default(0);
            $table->double('price');
            $table->integer('discount_percent')->default(0);
            $table->text('detail')->nullable();
            $table->enum('status', ['able', 'unable']);
            $table->enum('recommend', ['yes', 'not']);
            $table->string('path_file');
            $table->string('url_file');
            $table->date('date_publish');
            $table->string('cover_image');
            $table->string('url_cover_image');
            $table->integer('book_type_id')->unsigned();
            $table->integer('publisher_id')->unsigned();
            $table->foreign('book_type_id')->references('id')->on('books_types');
            $table->foreign('publisher_id')->references('id')->on('publishers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
