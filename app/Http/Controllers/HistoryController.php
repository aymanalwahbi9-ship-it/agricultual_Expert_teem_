<?php

namespace App\Http\Controllers;

use App\Models\HistoryRecord;
use Illuminate\Contracts\View\View;

class HistoryController extends Controller
{
    public function index(): View
    {
        $records = HistoryRecord::query()
            ->with('diagnosisCase.crop')
            ->whereNull('deleted_at')
            ->latest('occurred_at')
            ->get();

        return view('history.index', [
            'records' => $records,
        ]);
    }
}
