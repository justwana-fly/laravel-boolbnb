<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Apartment;
use Carbon\Carbon;

class UpdatePromotions extends Command
{
    // Nome e descrizione del comando
    protected $signature = 'promotions:update';
    protected $description = 'Aggiorna lo stato delle promozioni degli appartamenti';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $apartments = Apartment::all();

        foreach ($apartments as $apartment) {
            $isPromoted = $apartment->isPromoted();
            $apartment->visibility = $isPromoted ? 'promoted' : 'normal';
            $apartment->save();
        }

        $this->info('Stato delle promozioni aggiornato con successo.');
    }
}
