<?php

namespace App\Http\Controllers;

use App\Data\SoilReadingData;
use App\Http\Requests\DiagnoseRequest;
use App\Models\Condition;
use App\Models\Crop;
use App\Models\DiagnosisCase;
use App\Models\HistoryRecord;
use App\Services\MockImageAnalyzer;
use App\Services\SoilAnalysisService;
use Illuminate\Contracts\View\View;

class DiagnosisController extends Controller
{
    public function create(): View
    {
        return view('diagnosis.create', [
            'crops' => Crop::query()
                ->where('is_active', true)
                ->orderBy('name_ar')
                ->get(),
        ]);
    }

    public function store(
        DiagnoseRequest $request,
        SoilAnalysisService $soilAnalysisService,
        MockImageAnalyzer $imageAnalyzer,
    ): View {
        $data = $request->validated();

        $crop = Crop::query()->findOrFail($data['crop_id']);

        $diagnosisCase = DiagnosisCase::create([
            'crop_id' => $crop->id,
            'operation_type' => $data['operation_type'],
            'status' => 'started',
            'started_at' => now(),
        ]);

        $result = [
            'crop' => $crop,
            'operation_type' => $data['operation_type'],
            'soil' => null,
            'image' => null,
            'recommendation' => null,
        ];

        if (in_array($data['operation_type'], ['soil', 'combined'], true)) {
            $reading = new SoilReadingData(
                nitrogen: (float) $data['nitrogen'],
                phosphorus: (float) $data['phosphorus'],
                potassium: (float) $data['potassium'],
                ph: (float) $data['ph'],
                moisture: (float) $data['moisture'],
                temperature: (float) $data['temperature'],
            );

            $result['soil'] = $soilAnalysisService->analyze($reading);
        }

        if (in_array($data['operation_type'], ['image', 'combined'], true)) {
            $imageFile = $request->file('image');

            $result['image'] = $imageAnalyzer->analyze($imageFile);

            $condition = Condition::query()
                ->where('name_ar', $result['image']['label'])
                ->where('is_active', true)
                ->with([
                    'recommendations' => fn ($query) => $query
                        ->where('is_active', true)
                        ->with('knowledgeEntry'),
                ])
                ->first();

            $result['recommendation'] = $condition?->recommendations?->first();
        }

        $summary = $this->buildSummary($result);

        $diagnosisCase->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        HistoryRecord::create([
            'diagnosis_case_id' => $diagnosisCase->id,
            'operation_type' => $data['operation_type'],
            'summary_ar' => $summary,
            'occurred_at' => now(),
        ]);

        return view('diagnosis.result', [
            'result' => $result,
        ]);
    }

    private function buildSummary(array $result): string
    {
        if ($result['image']) {
            return 'الحالة المحتملة: '.$result['image']['label'];
        }

        if ($result['soil']) {
            return 'تم إكمال تحليل بيانات التربة للمحصول: '
                .$result['crop']->name_ar;
        }

        return 'تم إكمال عملية التشخيص للمحصول: '
            .$result['crop']->name_ar;
    }
}
