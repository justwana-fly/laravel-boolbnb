<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Apartment;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'apartment_id',
        'date',
        'content',
        'email',
        'name',
        'last_name',
    ];

    // Relazione con l'entità Apartment (un messaggio appartiene a un appartamento)
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}

