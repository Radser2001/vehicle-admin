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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->unsignedInteger('year')->nullable();
            $table->bigInteger('condition')->default(1);
            $table->string('color')->nullable();
            $table->unsignedInteger('mileage')->nullable();
            $table->string('fuel_type')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // Adjust precision and scale as needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
