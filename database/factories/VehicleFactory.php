<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Vehicle::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'name' => $this->faker->word(),
            'plate_number' => $this->faker->unique()->regexify('[A-Z0-9]{6}'),
        ];
    }
}
