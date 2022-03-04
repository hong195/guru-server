<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain>
 */
class DomainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'url' => $this->faker->url(),
            'status' => 'unregistered',
            'product_id' => Product::factory(),
            'code' => $this->faker->regexify('[A-Za-z0-9]{20}')
        ];
    }

    public function registered(): DomainFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'registered',
            ];
        });
    }
}
