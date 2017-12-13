<?php

use Illuminate\Database\Seeder;
use App\BookType;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BookType::create(['name' => 'การศึกษา']);
        BookType::create(['name' => 'นิตยสาร']);
        BookType::create(['name' => 'นวนิยาย']);
        BookType::create(['name' => 'การ์ตูน']);
    }
}
