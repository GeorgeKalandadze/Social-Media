<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_categories')->insert([
            [
                'name' => 'Football',
                'category_id' => 1
            ],
            [
                'name' => 'Basketball',
                'category_id' => 1
            ],
            [
                'name' => 'Rugby',
                'category_id' => 1
            ],
            [
                'name' => 'Judo',
                'category_id' => 1
            ],
            [
                'name' => 'Hip-Hop',
                'category_id' => 2
            ],
            [
                'name' => 'Jazz',
                'category_id' => 2
            ],
            [
                'name' => 'Rock',
                'category_id' => 2
            ],
            [
                'name' => 'Pop music',
                'category_id' => 2
            ],
            [
                'name' => 'Disco',
                'category_id' => 2
            ],
            [
                'name' => 'Blues',
                'category_id' => 2
            ],
            [
                'name' => 'Horror',
                'category_id' => 3
            ],
            [
                'name' => 'Comedy',
                'category_id' => 3
            ],
            [
                'name' => 'Drama',
                'category_id' => 3
            ],
            [
                'name' => 'Action',
                'category_id' => 3
            ],
            [
                'name' => 'Ai Development',
                'category_id' => 4
            ],
            [
                'name' => 'Web Development',
                'category_id' => 4
            ],
            [
                'name' => 'Mobile App Development',
                'category_id' => 4
            ],
        ]);
    }
}
