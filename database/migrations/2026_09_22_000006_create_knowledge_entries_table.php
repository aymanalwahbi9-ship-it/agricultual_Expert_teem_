<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('knowledge_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->nullable()->constrained('crops')->nullOnDelete();
            $table->foreignId('condition_id')->nullable()->constrained('conditions')->nullOnDelete();
            $table->enum('content_type', ['symptom', 'initial_action', 'recommendation', 'explanation'])->index();
            $table->string('title_ar');
            $table->text('content_ar');
            $table->json('keywords')->nullable();
            $table->string('source_name');
            $table->string('source_reference')->nullable();
            $table->date('reviewed_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['crop_id', 'condition_id']);
            $table->index('crop_id');
            $table->index('condition_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('knowledge_entries');
    }
};
