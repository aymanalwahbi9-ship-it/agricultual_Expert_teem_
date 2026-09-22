<?php

namespace App\Providers;

use App\Contracts\ImageAnalyzerInterface;
use App\Services\MockImageAnalyzer;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImageAnalyzerInterface::class, MockImageAnalyzer::class);
    }

    public function boot(): void
    {
        //
    }
}