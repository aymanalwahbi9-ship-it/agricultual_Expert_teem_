<?php

namespace App\Http\Controllers;

use App\Models\Condition;
use App\Models\Crop;
use App\Models\KnowledgeEntry;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function index(Request $request): View
    {
        $term = trim((string) $request->input('term', ''));
        $cropId = $request->integer('crop_id');

        $results = collect();

        if ($term !== '' || $cropId > 0) {
            $results = KnowledgeEntry::query()
                ->with(['crop', 'condition'])
                ->where('is_active', true)
                ->when($cropId > 0, function ($query) use ($cropId) {
                    $query->where(function ($query) use ($cropId) {
                        $query
                            ->whereNull('crop_id')
                            ->orWhere('crop_id', $cropId);
                    });
                })
                ->when($term !== '', function ($query) use ($term) {
                    $query->where(function ($query) use ($term) {
                        $query
                            ->where('title_ar', 'like', "%{$term}%")
                            ->orWhere('content_ar', 'like', "%{$term}%")
                            ->orWhere('source_name', 'like', "%{$term}%");
                    });
                })
                ->orderByDesc('reviewed_at')
                ->get();
        }

        return view('knowledge.index', [
            'crops' => Crop::query()
                ->where('is_active', true)
                ->orderBy('name_ar')
                ->get(),

            'conditions' => Condition::query()
                ->where('is_active', true)
                ->orderBy('name_ar')
                ->get(),

            'results' => $results,
            'term' => $term,
            'cropId' => $cropId,
        ]);
    }
}
