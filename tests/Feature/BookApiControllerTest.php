<?php

namespace Tests\Feature;

use App\Enum\ApiStatusMessageResponse;
use App\Models\Book;
use Tests\Feature\HelperTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookApiControllerTest extends HelperTestCase
{
    use RefreshDatabase;

    /**
     * Test if a book can be created
     *
     * @return void
     */
    public function testCanBeCreated()
    {
        $response = $this->post(route('books.store'), $this->create_data());

        $book = Book::where('id', 1)->first();

        $response->assertStatus(200)->assertJson([
            "status_code" => 201,
            "status" => ApiStatusMessageResponse::SUCCESS,
            "data" => [
                "book" => [
                    "name" => $book->name,
                    "isbn" => $book->isbn,
                    "authors" => $book->authors,
                    "number_of_pages" => $book->number_of_pages,
                    "publisher" => $book->publisher,
                    "country" => $book->country,
                    "release_date" => $book->release_date
                ]
            ]
        ]);

        $this->assertNotEmpty($response);
        $this->assertEquals(1, $book->id);
        $this->assertEquals('A Game Of Thrones', $book->name);
        $this->assertEquals('123-45', $book->isbn);
        $this->assertEquals('Nigeria', $book->country);
        $this->assertEquals('Test Publisher', $book->publisher);
        $this->assertEquals('2022-03-04', $book->release_date);
        $this->assertEquals(456, $book->number_of_pages);
        $this->assertNotEmpty($book->authors);
    }

    /**
     * Test if books can be read with status 200
     *
     * @return void
     */
    public function testCanBeReadBookWithStatusCode200()
    {
        $book = $this->createBook();

        $response = $this->get(route('books.index'));

        $this->assertNotEmpty($response);

        $this->assertCount(1, Book::all());

        $response->assertStatus(200)->assertJson($this->response($book));
    }

    /**
     * Test if books can be read with status 404
     *
     * @return void
     */
    public function testCanBeReadBookWithStatusCode404()
    {
        $response = $this->get(route('books.index'));

        $this->assertNotEmpty($response);

        $this->assertCount(0, Book::all());

        $response->assertStatus(200)->assertJson([
            "status_code" => 200,
            "status" => ApiStatusMessageResponse::SUCCESS,
            "data" => []
        ]);
    }

    /**
     * Test if books can be updated
     *
     * @return void
     */
    public function testBookCanBeUpdated()
    {
        $book = Book::factory()->state([
            'name' => 'How to Become a developer 101'
        ])->create();

        $book_name = $book->book_name;

        $this->assertEquals('How to Become a developer 101', $book->name);

        $response = $this->patch(route('books.update', $book->id), $this->update_data());

        $book->refresh();

        $this->assertEquals('How to Become a Dev PRO', $book->name);

        $response->assertStatus(200)->assertJson([
            "status_code" => 200,
            "status" => ApiStatusMessageResponse::SUCCESS,
            "message" => "The Book {$book_name} was updated successfully",
            "data" => [
                "id" => $book->id,
                "name" => $book->name,
                "isbn" => $book->isbn,
                "authors" => $book->authors,
                "number_of_pages" => $book->number_of_pages,
                "publisher" => $book->publisher,
                "country" => $book->country,
                "release_date" => $book->release_date
            ]
        ]);
    }

    /**
     * Test if books can be deleted
     *
     * @return void
     */
    public function testBookCanBeDeleted()
    {
        $book = $this->createBook();

        $book_name = $book->book_name;

        $this->assertCount(1, Book::all());

        $response = $this->delete(route('books.destroy', $book->id));

        $this->assertCount(0, Book::all());

        $response->assertStatus(200)->assertJson([
            "status_code" => 204,
            "status" => ApiStatusMessageResponse::SUCCESS,
            "message" => "The Book {$book_name} was deleted successfully",
            "data" => []
        ]);
    }

    /**
     * Test if books can be shown
     *
     * @return void
     */
    public function testBookCanBeShown()
    {
        $book = $this->createBook();

        $this->assertCount(1, Book::all());

        $response = $this->get(route('books.show', $book->id));

        $response->assertStatus(200)->assertJson([
            "status_code" => 200,
            "status" => ApiStatusMessageResponse::SUCCESS,
            "data" => [
                "id" => $book->id,
                "name" => $book->name,
                "isbn" => $book->isbn,
                "authors" => $book->authors,
                "number_of_pages" => $book->number_of_pages,
                "publisher" => $book->publisher,
                "country" => $book->country,
                "release_date" => $book->release_date
            ]
        ]);
    }

    /**
     * Test if books can be search by name
     *
     * @return void
     */
    public function testBookCanBeSearchedWithNameOfBook(){
        $book = $this->createBookWithState();
        $searchParameter = ['search' => 'Book Example'];
        $response = $this->call('GET', route('search.book'), $searchParameter);
        $response->assertStatus(200)->assertJson($this->response($book));
        $this->assertEquals($searchParameter['search'], $book->name);
    }

    /**
     * Test if books can be search by country
     *
     * @return void
     */
    public function testBookCanBeSearchedWithCountry(){
        $book = $this->createBookWithState();
        $searchParameter = ['search' => 'Nigeria'];
        $response = $this->call('GET', route('search.book'), $searchParameter);
        $response->assertStatus(200)->assertJson($this->response($book));
        $this->assertEquals($searchParameter['search'], $book->country);
    }

    /**
     * Test if books can be search by publisher
     *
     * @return void
     */
    public function testBookCanBeSearchedWithPublisher(){
        $book = $this->createBookWithState();
        $searchParameter = ['search' => 'Publishing'];
        $response = $this->call('GET', route('search.book'), $searchParameter);
        $response->assertStatus(200)->assertJson($this->response($book));
        $this->assertEquals($searchParameter['search'], $book->publisher);
    }

    /**
     * Test if books can be search by release date
     *
     * @return void
     */
    public function testBookCanBeSearchedWithReleasedDate(){
        $book = $this->createBookWithState();
        $searchParameter = ['search' => '2019-01-01'];
        $response = $this->call('GET', route('search.book'), $searchParameter);
        $response->assertStatus(200)->assertJson($this->response($book));
        $this->assertEquals($searchParameter['search'], $book->release_date);
    }
}
