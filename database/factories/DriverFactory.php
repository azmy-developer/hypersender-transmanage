<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Driver::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'license_number' => $this->faker->unique()->regexify('[A-Z0-9]{8}'),
        ];
    }
}
