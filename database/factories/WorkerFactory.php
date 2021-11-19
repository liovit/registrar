<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Worker;

class WorkerFactory extends Factory
{

    // https://fakerphp.github.io/formatters/numbers-and-strings/
    // link only as a reminder

    protected $model = Worker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => '3706' . $this->faker->randomNumber(7, true),
            'company_id' => $this->faker->numberBetween(1, 10)
        ];
    }
}
