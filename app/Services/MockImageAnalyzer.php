<?php

namespace App\Services;

use App\Contracts\ImageAnalyzerInterface;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

class MockImageAnalyzer implements ImageAnalyzerInterface
{
    private const ALLOWED_MIMES = [
        'image/jpeg',
        'image/png',
        'image/jpg',
        'image/webp',
    ];

    private const MAX_SIZE_BYTES = 5 * 1024 * 1024;

    public function analyze(UploadedFile $image): array
    {
        $this->validateImage($image);

        return [
            'label' => 'نقص النيتروجين',
            'confidence' => 0.72,
            'indicators' => [
                'اصفرار الأوراق السفلية',
                'ضعف النمو العام',
                'شحوب لون الأوراق',
            ],
            'notes' => 'هذه نتيجة محاكاة تعليمية وليست تشخيصًا زراعيًا قطعيًا.',
            'is_definitive' => false,
        ];
    }

    private function validateImage(UploadedFile $image): void
    {
        if (! $image->isValid()) {
            throw new InvalidArgumentException('الملف المرفوع غير صالح.');
        }

        if (! in_array($image->getMimeType(), self::ALLOWED_MIMES, true)) {
            throw new InvalidArgumentException('صيغة الصورة غير مدعومة. الصيغ المقبولة: JPEG, PNG, WEBP.');
        }

        if ($image->getSize() > self::MAX_SIZE_BYTES) {
            throw new InvalidArgumentException('حجم الصورة يتجاوز الحد الأقصى (5 ميجابايت).');
        }
    }
}
