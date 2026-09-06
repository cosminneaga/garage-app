<?php

namespace Database\Factories;

use App\Models\WorkorderOperation;
use App\Models\WorkorderOperationLabourTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'workorder_operation_id' => WorkorderOperation::factory()->create(),
        ];
    }
}
