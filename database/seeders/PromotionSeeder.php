<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $promotions = [
            [
                'title' => 'Standard',
                'duration' => '24:00:00',
                'price' => 2.99,
                'description' => "The sponsored apartment will appear for 24 hours on the Homepage in the “Featured Apartments” section and in the search page, it will be always positioned before a non-sponsored apartment that meets the same search criteria."
            ],
            [
                'title' => 'Plus',
                'duration' => '72:00:00',
                'price' => 5.99,
                'description' => "The sponsored apartment will appear for 48 hours on the Homepage in the “Featured Apartments” section and in the search page, it will be always positioned before a non-sponsored apartment that meets the same search criteria."
            ],
            [
                'title' => 'Premium',
                'duration' => '144:00:00',
                'price' => 9.99,
                'description' => "The sponsored apartment will appear for 144 hours on the Homepage in the “Featured Apartments” section and in the search page, it will be always positioned before a non-sponsored apartment that meets the same search criteria."
            ]
        ];

        foreach ($promotions as $promotionData) {
            // Creazione di una nuova istanza del modello Promotion
            $newPromotion = new Promotion();

            // Assegnazione dei valori dei campi
            $newPromotion->title = $promotionData['title'];
            $newPromotion->duration = $promotionData['duration'];
            $newPromotion->price = $promotionData['price'];
            $newPromotion->description = $promotionData['description'];

            // Salvataggio nel database
            $newPromotion->save();
        }
    }
}