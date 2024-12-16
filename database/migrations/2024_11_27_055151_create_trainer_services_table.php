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
        Schema::create('trainer_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained()->onDelete('cascade'); // Link to trainers table
            $table->string('service_name'); // Name of the service
            $table->text('description'); // Description of the service
            $table->decimal('price', 8, 2); // Price of the service
            $table->timestamps(); // Created and updated timestamps
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_services');
    }
};
