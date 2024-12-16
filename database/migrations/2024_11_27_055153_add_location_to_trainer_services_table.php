<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trainer_services', function (Blueprint $table) {
            $table->string('location')->nullable()->after('price');
        });
    }

    public function down()
    {
        Schema::table('trainer_services', function (Blueprint $table) {
            $table->dropColumn('location');
        });
    }
};
