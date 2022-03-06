<?php

namespace Tests\Feature;

use App\Enum\ApiStatusMessageResponse;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JetBrains\PhpStorm\ArrayShape;
use Tests\TestCase;

class HelperTestCase extends TestCase
{
    protected function create_data(): array
    {
        return [
            'name' => 'A Game Of Thrones',
            'isbn' => '123-45',
            'authors' => ['Test Author'],
            'number_of_pages' => 456,
            'publisher' => 'Test Publisher',
            'country' => 'Nigeria',
            'release_date' => '2022-03-04'
        ];
    }

    protected function update_data(): array
    {
        return [
            'name' => 'How to Become a Dev PRO',
        ];
    }

    protected function createBook(): Collection|Model
    {
        return Book::factory()->create();
    }

    protected function createBookWithState(): Collection|Model
    {
        return Book::factory()->state([
            'name' => 'Book Example',
            'isbn' => '459-99883330',
            'authors' => ['Test Author'],
            "number_of_pages" => 350,
            "publisher" => "Publishing",
            "country" => "Nigeria",
            "release_date" => "2019-01-01"
        ])->create();
    }

    protected function response($book): array
    {
        return [
            "status_code" => 200,
            "status" => ApiStatusMessageResponse::SUCCESS,
            "data" => [
                [
                    "id" => $book->id,
                    "name" => $book->name,
                    "isbn" => $book->isbn,
                    "authors" => $book->authors,
                    "number_of_pages" => $book->number_of_pages,
                    "publisher" => $book->publisher,
                    "country" => $book->country,
                    "release_date" => $book->release_date
                ]
            ]
        ];
    }
}
