<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('condition_id')->constrained('conditions')->cascadeOnDelete();
            $table->foreignId('knowledge_entry_id')->constrained('knowledge_entries')->cascadeOnDelete();
            $table->string('title_ar');
            $table->text('content_ar');
            $table->text('warning_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('condition_id');
            $table->index('knowledge_entry_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
