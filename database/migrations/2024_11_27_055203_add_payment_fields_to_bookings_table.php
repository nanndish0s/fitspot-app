<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('payment_id')->nullable();
            $table->string('payment_status')->default('pending');
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->timestamp('paid_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'payment_id',
                'payment_status',
                'amount_paid',
                'stripe_payment_intent_id',
                'paid_at'
            ]);
        });
    }
};
