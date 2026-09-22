<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiagnoseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $soilRequired = [
            'required_if:operation_type,soil,combined',
            'nullable',
            'numeric',
            'min:0',
        ];

        return [
            'crop_id' => [
                'required',
                'integer',
                'exists:crops,id',
            ],

            'operation_type' => [
                'required',
                Rule::in(['image', 'soil', 'combined']),
            ],

            'image' => [
                'nullable',
                'image',
                'max:5120',
                'required_if:operation_type,image,combined',
            ],

            'nitrogen' => $soilRequired,
            'phosphorus' => $soilRequired,
            'potassium' => $soilRequired,

            'ph' => [
                'required_if:operation_type,soil,combined',
                'nullable',
                'numeric',
                'between:0,14',
            ],

            'moisture' => [
                'required_if:operation_type,soil,combined',
                'nullable',
                'numeric',
                'between:0,100',
            ],

            'temperature' => [
                'required_if:operation_type,soil,combined',
                'nullable',
                'numeric',
                'between:-50,80',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'crop_id.required' => 'اختيار المحصول مطلوب.',
            'crop_id.exists' => 'المحصول المختار غير موجود.',

            'operation_type.required' => 'اختيار نوع التشخيص مطلوب.',
            'operation_type.in' => 'نوع التشخيص غير صالح.',

            'image.required_if' => 'رفع صورة النبات مطلوب لهذا النوع من التشخيص.',
            'image.image' => 'الملف المرفوع يجب أن يكون صورة.',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت.',

            'nitrogen.required_if' => 'النيتروجين مطلوب عند اختيار تحليل التربة.',
            'phosphorus.required_if' => 'الفوسفور مطلوب عند اختيار تحليل التربة.',
            'potassium.required_if' => 'البوتاسيوم مطلوب عند اختيار تحليل التربة.',
            'ph.required_if' => 'درجة الحموضة مطلوبة عند اختيار تحليل التربة.',
            'moisture.required_if' => 'الرطوبة مطلوبة عند اختيار تحليل التربة.',
            'temperature.required_if' => 'درجة الحرارة مطلوبة عند اختيار تحليل التربة.',

            'nitrogen.numeric' => 'قيمة النيتروجين يجب أن تكون رقمًا.',
            'phosphorus.numeric' => 'قيمة الفوسفور يجب أن تكون رقمًا.',
            'potassium.numeric' => 'قيمة البوتاسيوم يجب أن تكون رقمًا.',
            'ph.numeric' => 'قيمة درجة الحموضة يجب أن تكون رقمًا.',
            'moisture.numeric' => 'قيمة الرطوبة يجب أن تكون رقمًا.',
            'temperature.numeric' => 'قيمة درجة الحرارة يجب أن تكون رقمًا.',

            'nitrogen.min' => 'لا يمكن أن تكون قيمة النيتروجين سالبة.',
            'phosphorus.min' => 'لا يمكن أن تكون قيمة الفوسفور سالبة.',
            'potassium.min' => 'لا يمكن أن تكون قيمة البوتاسيوم سالبة.',

            'ph.between' => 'درجة الحموضة يجب أن تكون بين 0 و14.',
            'moisture.between' => 'الرطوبة يجب أن تكون بين 0 و100.',
            'temperature.between' => 'درجة الحرارة خارج النطاق المقبول.',
        ];
    }
}
