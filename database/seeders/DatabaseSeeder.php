<?php

namespace Database\Seeders;

use App\Product;
use App\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
       // Product::factory(15)->create();
              Tag::factory(10)->create();

    }
}
