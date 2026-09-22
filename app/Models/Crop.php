<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Crop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function conditions(): BelongsToMany
    {
        return $this->belongsToMany(Condition::class, 'crop_conditions')
            ->withPivot('relevance_note')
            ->withTimestamps();
    }

    public function cropConditions(): HasMany
    {
        return $this->hasMany(CropCondition::class);
    }

    public function knowledgeEntries(): HasMany
    {
        return $this->hasMany(KnowledgeEntry::class);
    }

    public function soilRules(): HasMany
    {
        return $this->hasMany(SoilRule::class);
    }

    public function diagnosisCases(): HasMany
    {
        return $this->hasMany(DiagnosisCase::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
