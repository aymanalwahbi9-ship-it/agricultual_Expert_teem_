<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageObservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnosis_case_id',
        'file_path',
        'source',
        'condition_id',
        'confidence',
        'visible_features',
        'quality_status',
    ];

    protected $casts = [
        'confidence' => 'decimal:4',
        'visible_features' => 'array',
    ];

    public function diagnosisCase(): BelongsTo
    {
        return $this->belongsTo(DiagnosisCase::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }
}
