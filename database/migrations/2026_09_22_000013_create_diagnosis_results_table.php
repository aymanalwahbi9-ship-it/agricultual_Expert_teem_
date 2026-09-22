<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosis_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosis_case_id')->constrained('diagnosis_cases')->cascadeOnDelete();
            $table->foreignId('condition_id')->nullable()->constrained('conditions')->nullOnDelete();
            $table->enum('result_type', ['image', 'soil', 'knowledge', 'combined', 'inconclusive'])->index();
            $table->decimal('confidence', 5, 4)->nullable();
            $table->enum('status', ['preliminary', 'inconclusive', 'conflicting', 'confirmed'])->default('preliminary');
            $table->json('supporting_indicators')->nullable();
            $table->json('conflicts')->nullable();
            $table->text('explanation_ar');
            $table->text('advisory_notice_ar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis_results');
    }
};
