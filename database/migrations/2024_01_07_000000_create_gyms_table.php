<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gyms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('description')->nullable();
            $table->json('opening_hours')->nullable();
            $table->json('amenities')->nullable();
            $table->timestamps();

            // Add index for faster geolocation queries
            $table->index(['latitude', 'longitude']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('gyms');
    }
};
