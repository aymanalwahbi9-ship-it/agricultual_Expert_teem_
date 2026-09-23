<?php

namespace App\Services;

use App\Models\KnowledgeEntry;
use Illuminate\Support\Collection;

class KnowledgeSearchService
{
    /**
     * البحث في قاعدة المعرفة الزراعية.
     *
     * @param  array{
     *     crop?: string|null,
     *     condition?: string|null,
     *     symptom?: string|null,
     *     keyword?: string|null
     * }  $filters
     * @return Collection<int, KnowledgeEntry>
     */
    public function search(array $filters = []): Collection
    {
        $query = KnowledgeEntry::query()
            ->with(['crop', 'condition'])
            ->where('is_active', true);

        if (! empty($filters['crop'])) {
            $cropName = $filters['crop'];
            $query->whereHas('crop', function ($q) use ($cropName) {
                $q->where('name_ar', 'like', '%'.$cropName.'%');
            });
        }

        if (! empty($filters['condition'])) {
            $condName = $filters['condition'];
            $query->whereHas('condition', function ($q) use ($condName) {
                $q->where('name_ar', 'like', '%'.$condName.'%');
            });
        }

        if (! empty($filters['symptom'])) {
            $symptom = $filters['symptom'];
            $query->where(function ($q) use ($symptom) {
                $q->where('keywords', 'like', '%'.$symptom.'%')
                    ->orWhere('content_ar', 'like', '%'.$symptom.'%');
            });
        }

        if (! empty($filters['keyword'])) {
            $kw = $filters['keyword'];
            $query->where(function ($q) use ($kw) {
                $q->where('title_ar', 'like', '%'.$kw.'%')
                    ->orWhere('content_ar', 'like', '%'.$kw.'%')
                    ->orWhere('keywords', 'like', '%'.$kw.'%');
            });
        }

        return $query->orderByDesc('reviewed_at')->limit(50)->get();
    }
}
