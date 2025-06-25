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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Plan name (e.g., Basic, Premium)
            $table->text('description')->nullable(); // Plan description
            $table->decimal('price', 8, 2); // Price of the plan
            $table->string('currency')->default('USD'); // Currency of the plan
            $table->integer('duration_days')->default(30); // Duration in days
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status of the plan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
