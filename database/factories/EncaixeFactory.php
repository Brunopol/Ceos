<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Encaixe>
 */
class EncaixeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'referencia' => fake()->phoneNumber(),
        ];
    }

    public function withMovimentos(): self
    {
        return $this->has(Encaixe_movimentoFactory::times(2), 'movimentos'); // Adjust the number as needed
    }
}
