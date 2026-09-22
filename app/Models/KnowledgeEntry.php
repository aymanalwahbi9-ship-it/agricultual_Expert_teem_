<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KnowledgeEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_id',
        'condition_id',
        'content_type',
        'title_ar',
        'content_ar',
        'keywords',
        'source_name',
        'source_reference',
        'reviewed_at',
        'is_active',
    ];

    protected $casts = [
        'keywords' => 'array',
        'reviewed_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class);
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }

    public function diagnosisResultSources(): HasMany
    {
        return $this->hasMany(DiagnosisResultSource::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
