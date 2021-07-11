<?php

namespace Database\Factories;

use App\Models\SuperHeroes;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuperHeroesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SuperHeroes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nickname' => $this->faker->name(),
            'real_name' => $this->faker->name(),
            'origin_description' => $this->faker->text(),
            'superpowers' => $this->faker->text(),
            'catch_phrase' => $this->faker->text(),
        ];
    }
}
