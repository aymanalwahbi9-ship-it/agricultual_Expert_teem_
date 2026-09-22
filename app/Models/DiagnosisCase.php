<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiagnosisCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_id',
        'operation_type',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }

    public function imageObservations(): HasMany
    {
        return $this->hasMany(ImageObservation::class);
    }

    public function soilReadings(): HasMany
    {
        return $this->hasMany(SoilReading::class);
    }

    public function diagnosisResults(): HasMany
    {
        return $this->hasMany(DiagnosisResult::class);
    }

    public function historyRecords(): HasMany
    {
        return $this->hasMany(HistoryRecord::class);
    }
}
