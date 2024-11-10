<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() :array
    {
        $status = ['pending','in-progress','completed'];
        $key = array_rand($status);
        return [
            'name' => $this->faker->unique()->word,
            'status' => $this->faker->randomElement($status),
            'description' => $this->faker->sentence,
            'start_date' => $this->faker->date('Y-m-d'),
            'end_date' => $this->faker->date('Y-m-d'),
            'manager_id' => rand(1, 5),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
