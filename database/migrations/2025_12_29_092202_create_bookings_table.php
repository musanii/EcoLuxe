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
    Schema::create('bookings', function (Blueprint $table) {
        $table->uuid('id')->primary();
        // Make user_id nullable for guest checkouts
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('service_id')->constrained();
        $table->foreignId('coupon_id')->nullable()->constrained();
        
        // Guest Details (Store these even if user_id is null)
        $table->string('customer_name');
        $table->string('customer_email');
        $table->string('customer_phone');
        
        $table->dateTime('scheduled_at');
        $table->integer('total_rooms');
        
        $table->decimal('subtotal', 8, 2); 
        $table->decimal('discount_amount', 8, 2)->default(0);
        $table->decimal('total_price', 8, 2); 
        
        $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
        $table->text('special_instructions')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
