<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::factory()->count(3000)->create();

        /**
         * Essai d'un multiple-enregistrement pour la relation 'hasMany'
         */
        // Article::factory()->count(10)->create()->each(function ($article) {
        //     $article->category()->save(Category::factory())->make();
        // });
    }
}
