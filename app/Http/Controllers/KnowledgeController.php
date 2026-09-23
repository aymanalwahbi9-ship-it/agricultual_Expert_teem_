<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Services\KnowledgeSearchService;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function __construct(
        private readonly KnowledgeSearchService $searchService
    ) {}

    public function index(Request $request)
    {
        $term = (string) $request->input('term', '');
        $cropId = (int) $request->input('crop_id', 0);

        // بناء الفلاتر من طلب الواجهة
        $filters = [
            'keyword' => $term !== '' ? $term : null,
            'crop' => $cropId > 0
                ? optional(Crop::find($cropId))->name_ar
                : null,
        ];

        $results = $this->searchService->search(array_filter($filters));

        // استجابة JSON لمن يطلب API
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'count' => $results->count(),
                'filters' => array_filter($filters),
                'data' => $results,
            ]);
        }

        // استجابة HTML للواجهة
        return view('knowledge.index', [
            'term' => $term,
            'cropId' => $cropId,
            'crops' => Crop::query()
                ->where('is_active', true)
                ->orderBy('name_ar')
                ->get(),
            'results' => $results,
        ]);
    }
}
