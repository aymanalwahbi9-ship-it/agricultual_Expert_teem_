<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('soil_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soil_reading_id')->constrained('soil_readings')->cascadeOnDelete();
            $table->string('element');
            $table->decimal('value', 10, 3);
            $table->enum('status', ['low', 'suitable', 'high']);
            $table->foreignId('rule_id')->nullable()->constrained('soil_rules')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('soil_assessments');
    }
};
