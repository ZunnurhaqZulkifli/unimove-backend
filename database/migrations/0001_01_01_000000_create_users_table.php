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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('typeable');
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('tac')->nullable(); // temporary access code for new account
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('biometrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('face_id');
            $table->boolean('passcode');
            $table->boolean('fingerprint');
            $table->boolean('enabled')->default(false);
            $table->timestamps();
        });

        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('bank_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('balance', 12, 2)->default(0);
            $table->string('card_number')->nullable();
            $table->string('card_expiry')->nullable();
            $table->string('card_ccv')->nullable();
            $table->string('card_holder')->nullable();
            $table->string('card_type')->nullable();
            $table->timestamps();
        });

        // create new account
        Schema::create('tacs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('sent_to'); // email
            $table->string('tac');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('tacs');
        Schema::dropIfExists('wallets');
        Schema::dropIfExists('biometrics');
        Schema::dropIfExists('users');
        Schema::dropIfExists('banks');
    }
};
