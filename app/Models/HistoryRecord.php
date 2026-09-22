<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'diagnosis_case_id',
        'operation_type',
        'summary_ar',
        'occurred_at',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
    ];

    public function diagnosisCase(): BelongsTo
    {
        return $this->belongsTo(DiagnosisCase::class);
    }
}
