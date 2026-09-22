<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConditionSymptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'condition_id',
        'symptom_id',
        'weight',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }

    public function symptom(): BelongsTo
    {
        return $this->belongsTo(Symptom::class);
    }
}
