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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('id_number')->unique()->nullable(); // National ID
            $table->string('student_id')->unique()->nullable();
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();

            $table->string('name');
            $table->string('phone');
            $table->string('status')->default('active');

            $table->boolean('verified')->default(false); // account verification
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('id_number')->unique()->nullable(); // National ID
            $table->string('staff_id')->unique()->nullable(); // 
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();

            $table->string('name');
            $table->string('phone');
            $table->string('status')->default('active');

            $table->boolean('verified')->default(false); // account verification

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('id_number')->unique();
            $table->string('phone');
            $table->string('address');
            
            $table->string('driver_id')->unique(); // custom driver id generated for the driver
            $table->string('license_no')->unique();
            $table->string('license_expiry');
            
            // for location
            $table->string('avatar')->nullable();
            
            // untuk rating dan total trips
            $table->string('ratings')->default(0);
            $table->string('total_trips')->default(0);

            $table->string('status')->default('active'); // active, suspended, terminated
            
            $table->boolean('verified')->default(false); // account verification

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
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('staffs');
        Schema::dropIfExists('students');
    }
};
