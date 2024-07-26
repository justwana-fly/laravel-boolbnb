<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apartment_promotion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('apartment_id');
            $table->unsignedBigInteger('promotion_id');

            //nicolai 
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
           // fine
            
            $table->foreign('apartment_id')->references('id')->on('apartments');
            $table->foreign('promotion_id')->references('id')->on('promotions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartment_promotion');
    }
};