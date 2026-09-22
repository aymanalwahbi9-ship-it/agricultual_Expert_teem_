<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soil_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained('crops')->cascadeOnDelete();
            $table->enum('element', ['N', 'P', 'K', 'pH', 'moisture', 'temperature', 'nitrogen', 'phosphorus', 'potassium'])->index();
            $table->string('unit')->default('%');
            $table->decimal('low_max', 10, 3);
            $table->decimal('suitable_min', 10, 3);
            $table->decimal('suitable_max', 10, 3);
            $table->decimal('high_min', 10, 3);
            $table->timestamps();

            $table->index('crop_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soil_rules');
    }
};
