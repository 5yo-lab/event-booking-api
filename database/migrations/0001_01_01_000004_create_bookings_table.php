<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('customer_email');
            $table->unsignedInteger('quantity');
            $table->string('status')->default('pending');
            $table->decimal('base_price_total', 10, 2);
            $table->json('discounts');
            $table->decimal('final_price', 10, 2);
            $table->string('transaction_id')->nullable();
            $table->timestamps();

            $table->index(['event_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
