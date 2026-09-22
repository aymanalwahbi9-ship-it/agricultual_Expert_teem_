<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoilAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'soil_reading_id',
        'element',
        'value',
        'status',
        'rule_id',
    ];

    protected $casts = [
        'value' => 'decimal:3',
    ];

    public function soilReading(): BelongsTo
    {
        return $this->belongsTo(SoilReading::class);
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(SoilRule::class, 'rule_id');
    }
}
