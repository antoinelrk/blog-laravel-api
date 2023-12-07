<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert($this->specificCategories());

        /**
         * Génération de catégories aléatoires
         */
        // Category::factory()->count(5)->create();
    }

    /**
     * Fonction qui retourne un tableau de données avec plusieurs catégories en Français
     */
    private function specificCategories (): array
    {
        $categories = ["Technologie", "Nature", "Sport", "Art", "Science", "Histoire", "Voyage", "Cuisine", "Mode", "Musique"];

        $dataToInsert = [];

        foreach ($categories as $category)
        {
            $dataToInsert[] = ['name' => strtoupper($category)];
        }

        return $dataToInsert;
    }
}
