<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{
        return [
            'title'     => $this->faker->words(3, true),
            'pdf_file' => 'books_pdf/sample.pdf', // <-- Diubah ke 'pdf_file'
            'image'     => null, // Gambar diset null terlebih dahulu untuk dummy
            'is_active' => $this->faker->boolean(80), // 80% kemungkinan bernilai true
            'clicks'    => $this->faker->numberBetween(0, 250),
        ];
    }
	}