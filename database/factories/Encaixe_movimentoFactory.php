<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Encaixe_movimentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'largura' =>  fake()->name(),
            'tecido' =>  fake()->name(),
            'quantidade' =>  fake()->randomNumber(),
            'parImper' =>  fake()->name(),
            'notas' =>  fake()->name(),
        ];
    }

    public function withConsumos(): self
    {
        return $this->has(Encaixe_movimento_consumoFactory::times(3), 'consumos'); // Adjust the number as needed
    }
}
