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
        Schema::create('inquiry_responses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('inquiry_id')->constrained()->onDelete('cascade');
        $table->text('message');
        $table->string('admin_name')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry_responses');
    }
};
