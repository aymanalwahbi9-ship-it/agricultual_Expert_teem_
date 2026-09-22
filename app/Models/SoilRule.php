<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SoilRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_id',
        'element',
        'unit',
        'low_max',
        'suitable_min',
        'suitable_max',
        'high_min',
    ];

    protected $casts = [
        'low_max' => 'decimal:3',
        'suitable_min' => 'decimal:3',
        'suitable_max' => 'decimal:3',
        'high_min' => 'decimal:3',
    ];

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }

    public function soilAssessments(): HasMany
    {
        return $this->hasMany(SoilAssessment::class, 'rule_id');
    }
}
