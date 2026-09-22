<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('condition_symptoms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('condition_id')->constrained('conditions')->cascadeOnDelete();
            $table->foreignId('symptom_id')->constrained('symptoms')->cascadeOnDelete();
            $table->decimal('weight', 5, 2)->default(1.00);
            $table->timestamps();

            $table->unique(['condition_id', 'symptom_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('condition_symptoms');
    }
};
