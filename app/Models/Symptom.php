<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'description',
    ];

    public function conditions(): BelongsToMany
    {
        return $this->belongsToMany(Condition::class, 'condition_symptoms')
            ->withPivot('weight')
            ->withTimestamps();
    }

    public function conditionSymptoms(): HasMany
    {
        return $this->hasMany(ConditionSymptom::class);
    }
}
