<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['category' => 'Technology', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['category' => 'Health', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['category' => 'Travel', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['category' => 'Education', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['category' => 'Finance', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('categories')->insert($categories);
    }
}
