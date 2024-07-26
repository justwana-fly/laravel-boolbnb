<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; 
use App\Models\Apartment;

class Search extends Model
{
    use HasFactory;
    public static function formatAddress($streetName, $houseNumber, $city, $cap)
    {
        $addressF = trim($streetName) . ' ' . trim($houseNumber) . ' ' . trim($city) . ' ' . trim($cap);
        return $addressF;
    }
    public static function apiFormatAddress($address)
    {
        $addressF = str_replace(' ', '%20', $address);
        return $addressF;
    }
    public function getLocationAttribute($value)
    {
        $coords = sscanf($value, 'POINT(%f %f)');
        return [
            'latitude' => $coords[0],
            'longitude' => $coords[1],
        ];
    }
}

