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
            $table->double('score')->nullable();
            $table->string('file_size');
            $table->integer('num_page');
            $table->double('price');
            $table->text('detail');
            $table->enum('status', ['able', 'unable']);
            $table->string('path_file');
            $table->dateTime('date_upload');
            $table->date('date_publish');
            $table->string('cover_image');
            $table->integer('book_type_id')->unsigned();
            $table->integer('publisher_id')->unsigned();
            $table->foreign('book_type_id')->references('id')->on('books_types');
            $table->foreign('publisher_id')->references('id')->on('publishers');
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
