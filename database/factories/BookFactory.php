<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(10),
            'isbn' => $this->faker->isbn10(),
            'authors' => [$this->faker->name],
            'number_of_pages' => $this->faker->randomNumber(),
            'publisher' => $this->faker->name,
            'country' => $this->faker->country,
            'release_date' => $this->faker->date()
        ];
    }
}
