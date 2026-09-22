<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiagnosisResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnosis_case_id',
        'condition_id',
        'result_type',
        'confidence',
        'status',
        'supporting_indicators',
        'conflicts',
        'explanation_ar',
        'advisory_notice_ar',
    ];

    protected $casts = [
        'confidence' => 'decimal:4',
        'supporting_indicators' => 'array',
        'conflicts' => 'array',
    ];

    public function diagnosisCase(): BelongsTo
    {
        return $this->belongsTo(DiagnosisCase::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }

    public function sources(): HasMany
    {
        return $this->hasMany(DiagnosisResultSource::class);
    }

    public function knowledgeEntries()
    {
        return $this->belongsToMany(KnowledgeEntry::class, 'diagnosis_result_sources')
            ->withPivot('match_score')
            ->withTimestamps();
    }
}
