<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('image_observations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosis_case_id')->constrained('diagnosis_cases')->cascadeOnDelete();
            $table->string('file_path')->nullable();
            $table->enum('source', ['camera', 'file', 'simulation'])->default('file');
            $table->foreignId('condition_id')->nullable()->constrained('conditions')->nullOnDelete();
            $table->decimal('confidence', 5, 4)->nullable();
            $table->json('visible_features')->nullable();
            $table->enum('quality_status', ['valid', 'low', 'rejected'])->default('valid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('image_observations');
    }
};
