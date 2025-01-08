<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trainer_services', function (Blueprint $table) {
            if (!Schema::hasColumn('trainer_services', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable();
            }
            if (!Schema::hasColumn('trainer_services', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable();
            }
            if (!Schema::hasColumn('trainer_services', 'location_address')) {
                $table->string('location_address')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('trainer_services', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'location_address']);
        });
    }
};
