<?php

namespace Database\Factories;

use App\Models\WorkorderOperationLabourTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<WorkorderOperationLabourTime>
 */
class WorkorderOperationLabourTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start' => Carbon::now(),
        ];
    }
}
