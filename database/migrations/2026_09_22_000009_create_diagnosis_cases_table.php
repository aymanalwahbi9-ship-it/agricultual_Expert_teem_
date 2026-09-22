<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosis_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained('crops')->cascadeOnDelete();
            $table->enum('operation_type', ['image', 'soil', 'combined', 'search'])->index();
            $table->enum('status', ['started', 'completed', 'inconclusive', 'failed'])->default('started');
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('created_at');
            $table->index('crop_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis_cases');
    }
};
