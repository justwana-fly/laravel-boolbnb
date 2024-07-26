<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Apartment;
class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'icon'
    ];
    //Relazione uno a molti tra servizi e appartamenti 
    public function apartments()
{
    return $this->belongsToMany(Apartment::class, 'apartment_service');
}
}
