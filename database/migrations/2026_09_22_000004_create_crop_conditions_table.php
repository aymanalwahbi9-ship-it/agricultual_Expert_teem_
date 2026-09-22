<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crop_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained('crops')->cascadeOnDelete();
            $table->foreignId('condition_id')->constrained('conditions')->cascadeOnDelete();
            $table->text('relevance_note')->nullable();
            $table->timestamps();

            $table->unique(['crop_id', 'condition_id']);
            $table->index('crop_id');
            $table->index('condition_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crop_conditions');
    }
};
