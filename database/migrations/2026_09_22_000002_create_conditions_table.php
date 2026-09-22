<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conditions', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->index();
            $table->string('name_en')->nullable();
            $table->enum('type', ['disease', 'pest', 'nutrient_deficiency', 'soil_disorder'])->index();
            $table->text('description');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conditions');
    }
};
