<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;


class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   // database/seeders/TagSeeder.php
public function run()
{
    $tags = [
        ['name' => 'Laravel', 'slug' => 'laravel'],
        ['name' => 'Vue.js', 'slug' => 'vuejs'],
        ['name' => 'React', 'slug' => 'react']
    ];

    foreach ($tags as $tag) {
        Tag::create($tag);
    }
}
}
