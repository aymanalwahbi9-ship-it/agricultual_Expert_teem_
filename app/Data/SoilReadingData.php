<?php

namespace App\Data;

use InvalidArgumentException;

final readonly class SoilReadingData
{
    public function __construct(
        public float $nitrogen,
        public float $phosphorus,
        public float $potassium,
        public float $ph,
        public float $moisture,
        public float $temperature,
        public string $source = 'manual',
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        $values = [
            'nitrogen' => $this->nitrogen,
            'phosphorus' => $this->phosphorus,
            'potassium' => $this->potassium,
            'ph' => $this->ph,
            'moisture' => $this->moisture,
            'temperature' => $this->temperature,
        ];

        foreach ($values as $name => $value) {
            if (! is_finite($value)) {
                throw new InvalidArgumentException(
                    "قيمة التربة غير صالحة: {$name}"
                );
            }
        }

        if ($this->ph < 0 || $this->ph > 14) {
            throw new InvalidArgumentException(
                'قيمة pH يجب أن تكون بين 0 و14.'
            );
        }

        if ($this->moisture < 0 || $this->moisture > 100) {
            throw new InvalidArgumentException(
                'قيمة الرطوبة يجب أن تكون بين 0 و100.'
            );
        }
    }
}
