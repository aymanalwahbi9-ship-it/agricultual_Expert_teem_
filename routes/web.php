<?php

use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\KnowledgeController;
use App\Models\Crop;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'crops' => Crop::query()
            ->where('is_active', true)
            ->orderBy('name_ar')
            ->get(),
    ]);
})->name('home');

Route::get('/diagnosis', [
    DiagnosisController::class,
    'create',
])->name('diagnosis.create');

Route::post('/diagnosis', [
    DiagnosisController::class,
    'store',
])->name('diagnosis.store');

Route::get('/knowledge', [
    KnowledgeController::class,
    'index',
])->name('knowledge.index');

Route::get('/history', [
    HistoryController::class,
    'index',
])->name('history.index');
