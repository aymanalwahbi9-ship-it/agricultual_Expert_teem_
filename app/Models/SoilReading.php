<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SoilReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnosis_case_id',
        'source',
        'nitrogen',
        'phosphorus',
        'potassium',
        'ph',
        'moisture',
        'temperature',
        'units',
        'connection_status',
        'quality_status',
        'recorded_at',
    ];

    protected $casts = [
        'nitrogen' => 'decimal:3',
        'phosphorus' => 'decimal:3',
        'potassium' => 'decimal:3',
        'ph' => 'decimal:2',
        'moisture' => 'decimal:3',
        'temperature' => 'decimal:3',
        'units' => 'array',
        'recorded_at' => 'datetime',
    ];

    public function diagnosisCase(): BelongsTo
    {
        return $this->belongsTo(DiagnosisCase::class);
    }

    public function soilAssessments(): HasMany
    {
        return $this->hasMany(SoilAssessment::class);
    }
}
