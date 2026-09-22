<?php

namespace App\Http\Controllers;

use App\Services\KnowledgeSearchService;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function __construct(
        private readonly KnowledgeSearchService $searchService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['crop', 'condition', 'symptom', 'keyword']);

        $results = $this->searchService->search($filters);

        return response()->json([
            'success' => true,
            'count' => $results->count(),
            'filters' => array_filter($filters),
            'data' => $results,
        ]);
    }
}
