<?php

namespace App\Contracts;

use Illuminate\Http\UploadedFile;

interface ImageAnalyzerInterface
{
    public function analyze(UploadedFile $image): array;
}
