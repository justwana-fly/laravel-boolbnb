<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Apartment;
use Illuminate\Database\Seeder;

class ApartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = json_decode(file_get_contents(__DIR__ . '\apartments.json'), true);

        foreach ($data as $apartment) {
            $new_apartment = new Apartment();
            $new_apartment->name = $apartment['name'];
            $new_apartment->slug = Apartment::generateSlug($apartment['name']);
            $new_apartment->description = $apartment['description'];
            $new_apartment->rooms = $apartment['rooms'] ?? null;
            $new_apartment->beds = $apartment['beds'] ?? null;
            $new_apartment->bathrooms = $apartment['bathrooms'] ?? null;
            $new_apartment->square_meters = $apartment['square_meters'] ?? null;
            $new_apartment->image_cover = $apartment['image_cover'] ?? null;
            $new_apartment->address = $apartment['address'];
            $new_apartment->longitude = $apartment['longitude'];
            $new_apartment->latitude = $apartment['latitude'];
            $new_apartment->visibility = $apartment['visibility'];
            $new_apartment->setLocationAttribute($apartment['latitude'], $apartment['longitude']); // Usa due parametri
            $new_apartment->save();
        };
    }
}

// php artisan db:seed --class=ApartmentsSeeder