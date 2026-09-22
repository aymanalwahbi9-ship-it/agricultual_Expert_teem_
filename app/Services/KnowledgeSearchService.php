<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class KnowledgeSearchService
{
    public function search(array $filters = []): Collection
    {
        $query = DB::table('knowledge_entries as ke')
            ->leftJoin('crops as c', 'c.id', '=', 'ke.crop_id')
            ->leftJoin('conditions as cond', 'cond.id', '=', 'ke.condition_id')
            ->where('ke.is_active', true)
            ->select([
                'ke.id',
                'ke.title_ar',
                'ke.content_ar',
                'ke.content_type',
                'ke.keywords',
                'ke.source_name',
                'ke.reviewed_at',
                'c.name_ar as crop_name',
                'cond.name_ar as condition_name',
            ]);

        if (! empty($filters['crop'])) {
            $query->where('c.name_ar', 'like', '%'.$filters['crop'].'%');
        }

        if (! empty($filters['condition'])) {
            $query->where('cond.name_ar', 'like', '%'.$filters['condition'].'%');
        }

        if (! empty($filters['symptom'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('ke.keywords', 'like', '%'.$filters['symptom'].'%')
                    ->orWhere('ke.content_ar', 'like', '%'.$filters['symptom'].'%');
            });
        }

        if (! empty($filters['keyword'])) {
            $kw = $filters['keyword'];
            $query->where(function ($q) use ($kw) {
                $q->where('ke.title_ar', 'like', '%'.$kw.'%')
                    ->orWhere('ke.content_ar', 'like', '%'.$kw.'%')
                    ->orWhere('ke.keywords', 'like', '%'.$kw.'%');
            });
        }

        return $query->orderByDesc('ke.reviewed_at')->limit(50)->get();
    }
}
