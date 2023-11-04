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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donors_id')->references('id')->on('donors')->cascadeOnDelete();
            $table->enum('donation_type', ["fitrah", "mal", "sodaqah", "infaq"]);
            $table->enum('payment_method', ["cash", "transfer"]);
            $table->decimal('total_money', 15, 2)->nullable();
            $table->integer('total_good')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
