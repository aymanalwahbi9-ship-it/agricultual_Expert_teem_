<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soil_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosis_case_id')->constrained('diagnosis_cases')->cascadeOnDelete();
            $table->enum('source', ['sensor', 'manual', 'simulation'])->default('simulation');
            $table->decimal('nitrogen', 10, 3)->default(0);
            $table->decimal('phosphorus', 10, 3)->default(0);
            $table->decimal('potassium', 10, 3)->default(0);
            $table->decimal('ph', 5, 2)->default(7.00);
            $table->decimal('moisture', 10, 3)->default(0);
            $table->decimal('temperature', 10, 3)->default(0);
            $table->json('units')->nullable();
            $table->enum('connection_status', ['connected', 'disconnected', 'not_applicable'])->default('not_applicable');
            $table->enum('quality_status', ['valid', 'low', 'rejected'])->default('valid');
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soil_readings');
    }
};
