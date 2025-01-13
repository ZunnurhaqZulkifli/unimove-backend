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
        Schema::create('reasons', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('value');
            $table->timestamps();
        });
        
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->integer('x');
            $table->integer('y');
            $table->decimal('price', 12,2)->default(0);
            $table->decimal('estimation_time', 2,0)->default(0);
            $table->string('image_l')->nullable();
            $table->string('image_p')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // pending, accepted, cancelled, completed
        Schema::create('booking_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        // order is created by user
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('orderable'); // booked by user
            $table->foreignId('pickup_from')->nullable()->constrained('destinations')->nullOnDelete();
            $table->foreignId('dropoff_to')->nullable()->constrained('destinations')->nullOnDelete();
            $table->decimal('price', 12,2)->default(0);
            $table->decimal('estimation_time', 2,0)->default(0);
            $table->decimal('distance', 2,0)->default(0);
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // once order is accepted, booking is created by driver
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->unique(); // unique code generated by system

            $table->string('status')->default('active');
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('accepted_by')->nullable()->constrained('drivers')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        // once booking is accepted, booking details are created
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->unique(); // unique code generated by system

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('user_wallet_id')->nullable()->constrained('wallets')->nullOnDelete();
            $table->foreignId('driver_wallet_id')->nullable()->constrained('wallets')->nullOnDelete();

            $table->foreignId('destination_id')->nullable()->constrained()->nullOnDelete();
            
            $table->foreignId('pickup_from')->nullable()->constrained('destinations')->nullOnDelete();
            $table->dateTime('pickup_time');

            $table->foreignId('dropoff_to')->nullable()->constrained('destinations')->nullOnDelete();
            $table->dateTime('dropoff_time');

            $table->boolean('cancellable')->default(true); // false > 3 minutes after booking is placed

            $table->string('reason')->nullable(); // reason for cancellation
            $table->decimal('price', 12,2)->default(0);
            $table->decimal('estimation_time', 2,0)->default(0);
            $table->decimal('distance', 2,0)->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_details');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('booking_statuses');
        Schema::dropIfExists('destinations');
        Schema::dropIfExists('reasons');
    }
};
