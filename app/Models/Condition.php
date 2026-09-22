<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'type',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function crops(): BelongsToMany
    {
        return $this->belongsToMany(Crop::class, 'crop_conditions')
            ->withPivot('relevance_note')
            ->withTimestamps();
    }

    public function cropConditions(): HasMany
    {
        return $this->hasMany(CropCondition::class);
    }

    public function symptoms(): BelongsToMany
    {
        return $this->belongsToMany(Symptom::class, 'condition_symptoms')
            ->withPivot('weight')
            ->withTimestamps();
    }

    public function conditionSymptoms(): HasMany
    {
        return $this->hasMany(ConditionSymptom::class);
    }

    public function knowledgeEntries(): HasMany
    {
        return $this->hasMany(KnowledgeEntry::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }

    public function imageObservations(): HasMany
    {
        return $this->hasMany(ImageObservation::class);
    }

    public function diagnosisResults(): HasMany
    {
        return $this->hasMany(DiagnosisResult::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
