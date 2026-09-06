<?php

namespace Database\Factories;

use App\Models\Part;
use App\Models\User;
use App\Models\Workorder;
use App\Models\WorkorderOperation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WorkorderOperation>
 */
class WorkorderOperationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $workorder = Workorder::latest()->first() ?? Workorder::factory()->create();
        $part = Part::latest()->first() ?? Part::factory()->create();
        $user = User::latest()->first() ?? User::factory()->create();

        return [
            'workorder_id' => $workorder,
            'part_id' => $part,
            'performed_by' => $user,
        ];
    }
}
