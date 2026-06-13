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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->enum('payment_method', [
                'cash',
                'credit',
                'paypal',
                'bank_transfer'
            ]);

            $table->decimal('amount', 10, 2);
            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed'
            ])->default('pending');
            $table->timestamp('payment_date')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
