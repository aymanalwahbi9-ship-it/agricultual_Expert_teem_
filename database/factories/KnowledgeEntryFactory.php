<?php

namespace Database\Factories;

use App\Models\Condition;
use App\Models\Crop;
use App\Models\KnowledgeEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KnowledgeEntry>
 */
class KnowledgeEntryFactory extends Factory
{
    protected $model = KnowledgeEntry::class;

    public function definition(): array
    {
        return [
            'crop_id' => Crop::factory(),
            'condition_id' => Condition::factory(),
            'content_type' => fake()->randomElement(['symptom', 'initial_action', 'recommendation', 'explanation']),
            'title_ar' => fake()->sentence(4),
            'content_ar' => fake()->paragraph(3),
            'keywords' => [fake()->word(), fake()->word()],
            'source_name' => fake()->company(),
            'source_reference' => fake()->url(),
            'reviewed_at' => fake()->date(),
            'is_active' => true,
        ];
    }
}
