<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiagnosisResultSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'diagnosis_result_id',
        'knowledge_entry_id',
        'match_score',
    ];

    protected $casts = [
        'match_score' => 'decimal:4',
    ];

    public function diagnosisResult(): BelongsTo
    {
        return $this->belongsTo(DiagnosisResult::class);
    }

    public function knowledgeEntry(): BelongsTo
    {
        return $this->belongsTo(KnowledgeEntry::class);
    }
}
