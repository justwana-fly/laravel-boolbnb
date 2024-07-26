<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Apartment;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'aparmnet_id',
        'ip_address',
        'date'
    ];

    // Relazione con l'entita Apartment (una visualizzazione appartiene a un appartamento)
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

}
