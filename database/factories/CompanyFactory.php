<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;

class CompanyFactory extends Factory
{

    // name of model
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'web_url' => $this->faker->url(),
            'logo' => $this->faker->imageUrl(640, 480, 'logos', true)
        ];
    }
}
