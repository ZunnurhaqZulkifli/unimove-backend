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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nric')->unique();
            $table->string('phone');
            $table->string('driver_id')->unique(); // custom driver id generated for the driver
            $table->string('license_no')->unique();
            $table->string('license_expiry');
            $table->string('address');
            $table->string('status')->default('active');
            $table->string('profile_picture')->nullable();
            $table->string('ratings')->default(0);
            $table->string('total_trips')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained();
            $table->string('plate_no')->unique();
            $table->string('model');
            $table->string('brand');
            $table->string('color');
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
