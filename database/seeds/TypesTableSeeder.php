<?php

use Illuminate\Database\Seeder;
use App\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::insert([
            [ 'name' => 'like'],
            [ 'name' => 'comment'],
            [ 'name' => 'follow'],
            [ 'name' => 'like-comment'],
        ]);
    }
}
