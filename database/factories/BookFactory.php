<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3), // Generates a random book title
            'author' => $this->faker->name(), // Generates a random author name
            'file' => 'uploads/books/sample.pdf', // You can update this for actual file uploads
            'status' => $this->faker->randomElement([0, 1]), // Randomly assigns status as available or not
        ];
    }
}
