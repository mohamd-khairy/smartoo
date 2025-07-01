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
        // Create the users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('device_type')->nullable();
            $table->string('uuid')->nullable()->unique();
            $table->string('device_token')->nullable()->unique();
            $table->string('subscription_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('first_name')->nullable(); // Allow name to be nullable for anonymous users
            $table->string('last_name')->nullable(); // Allow name to be nullable for anonymous users
            $table->string('name')->nullable(); // Allow name to be nullable for anonymous users
            $table->text('image')->nullable();
            $table->string('email')->unique()->nullable(); // Allow email to be nullable
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(); // Allow password to be nullable
            $table->string('country_code')->nullable()->default('EG'); // Nullable for users without email
            $table->string('phone')->unique()->nullable(); // Required phone number for registration
            $table->string('phone_verification_code', 6)->nullable();
            $table->enum('gender', ['male', 'female'])->nullable(); // Nullable for users without gender('age')
            $table->boolean('contact_permission')->default(false);
            $table->boolean('notification_permission')->default(false);
            $table->boolean('tracking_permission')->default(false);
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('role')->default('user');
            $table->string('locale')->default('en');
            $table->string('status')->default('pending'); // Default status for new users
            $table->string('timezone')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->softDeletes(); // Soft delete column (deleted_at)
            $table->timestamps(); // Automatically creates created_at and updated_at columns
        });

        // Create the password_reset_tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->id();  // Auto-incremented primary key
            $table->foreignId('user_id')->constrained('users'); // Foreign key to users table
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Create the sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index(); // Foreign key for user_id
            $table->string('ip_address', 45)->nullable(); // 45 characters for IPv6 compatibility
            $table->text('user_agent')->nullable(); // Store the user agent
            $table->longText('payload'); // Long text field for session data
            $table->integer('last_activity')->index(); // Index on last_activity for performance
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
