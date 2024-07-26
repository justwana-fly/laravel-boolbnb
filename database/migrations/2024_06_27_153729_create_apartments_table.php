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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug', 255)->unique();
            $table->text('description');
            $table->integer('rooms');
            $table->integer('beds');
            $table->integer('bathrooms');
            $table->integer('square_meters');
            $table->string('image_cover', 255)->nullable();
            $table->string('address', 255);
            $table->decimal('longitude', 16, 14);   //37.84772130275286
            $table->decimal('latitude', 16, 14);
            $table->boolean('visibility');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};