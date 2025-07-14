<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('original_transaction_id')->index()->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('product_id')->nullable();
            $table->enum('status', ['active', 'inactive', 'expired'])->default('inactive');
            $table->boolean('is_renewal')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->enum('type', ['Sandbox', 'Production'])->default('Sandbox');
            $table->text('data')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
