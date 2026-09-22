<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('history_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosis_case_id')->nullable()->constrained('diagnosis_cases')->nullOnDelete();
            $table->enum('operation_type', ['image', 'soil', 'combined', 'search', 'report']);
            $table->text('summary_ar');
            $table->timestamp('occurred_at')->useCurrent()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('history_records');
    }
};
