<?php

namespace Database\Factories;

use App\Enums\FileStatus;
use App\Enums\RepairStatus;
use App\Models\Repair;
use App\Models\RepairFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RepairFile>
 */
class RepairFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'extension' => fake()->fileExtension(),
            'path' => fake()->randomElement([
                'https://t4.ftcdn.net/jpg/06/04/83/37/240_F_604833714_K2s2I8HaqUGBWGhDZiwiCDMaQvQUCogD.jpg',
                'https://t3.ftcdn.net/jpg/00/99/59/22/240_F_99592236_B1cZL1h44chDx3W6I2AfePC6scfzwaNx.jpg',
                'https://t3.ftcdn.net/jpg/17/53/39/58/240_F_1753395823_YbftgqVbHSNQY3yQjdU0goVbZSTUN0WC.jpg',
            ]),
            'type' => fake()->mimeType(),
            'status' => fake()->randomElement(FileStatus::class),
            'repair_status' => fake()->randomElement(RepairStatus::class),
            'description' => fake()->text(30),
            'repair_id' => Repair::factory(),
        ];
    }
}
