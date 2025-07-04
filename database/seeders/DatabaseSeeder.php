<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
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

          Article::factory(10)->create([
            'image' => 'images/default.jpg'

        ]);
        


       
        Category::factory()->count(5)->create();
        Tag::factory()->count(8)->create();

        $articles = Article::factory(20)->create([
        'image' => 'default.jpg'
    ]);

        // Attach random tags to each article
    $tags = Tag::all();

    foreach ($articles as $article) {
        // Attach 2–4 random tags per article
        $article->tags()->attach(
            $tags->random(rand(2, 4))->pluck('id')->toArray()
        );
    }
        
    }
}
