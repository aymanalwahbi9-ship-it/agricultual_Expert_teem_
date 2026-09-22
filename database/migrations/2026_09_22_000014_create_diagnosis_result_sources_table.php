<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosis_result_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosis_result_id')->constrained('diagnosis_results')->cascadeOnDelete();
            $table->foreignId('knowledge_entry_id')->constrained('knowledge_entries')->cascadeOnDelete();
            $table->decimal('match_score', 5, 4)->nullable();
            $table->timestamps();

            $table->unique(['diagnosis_result_id', 'knowledge_entry_id'], 'drs_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis_result_sources');
    }
};
