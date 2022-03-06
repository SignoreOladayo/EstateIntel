<?php

namespace Tests\Feature;

use App\Enum\ApiStatusMessageResponse;
use App\Services\BookApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use function Symfony\Component\Translation\t;

class BookApiServiceTest extends TestCase
{

    protected BookApiService $bookApiService;

    protected function setUp(): void
    {

        parent::setUp();
        $this->bookApiService = $this->app->make(BookApiService::class);
    }

    /**
     * Test api returns data with status 200
     *
     * @return void
     */
    public function testApiReturnsBookWithStatus200()
    {
        $mockedApiResponse = [
            [
                "name" => "A Game Of Thrones",
                "isbn" => "978-0553103540",
                "authors" => [
                    "Micheal Jackson"
                ],
                "publisher" => "Jade",
                "country" => "Nigeria",
                "numberOfPages" => 900,
                "released" => "1996-08-01"
            ]
        ];

        $expectedResponse = [
            "status_code" => 200,
            "status" => ApiStatusMessageResponse::SUCCESS,
            "data" => [
                [
                    "name" => "A Game Of Thrones",
                    "isbn" => "978-0553103540",
                    "authors" => [
                        "Micheal Jackson"
                    ],
                    "publisher" => "Jade",
                    "country" => "Nigeria",
                    "number_of_pages" => 900,
                    "release_date" => "1996-08-01"
                ]
            ]
        ];

        Http::fake([
            '*/api/books?*' => Http::response($mockedApiResponse),
        ]);

        $response = $this->bookApiService->getBookByName('A Game Of Thrones');
        $response = json_decode($response->getContent(), true);
        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * Test api returns data with status 404
     *
     * @return void
     */
    public function testApiReturnsBookWithStatus404()
    {
        $mockedApiResponse = [];

        $expectedResponse = [
            "status_code" => 404,
            "status" => ApiStatusMessageResponse::NOT_FOUND,
            "data" => []
        ];

        Http::fake([
            '*/api/books?*' => Http::response($mockedApiResponse),
        ]);

        $response = $this->bookApiService->getBookByName('Not a real book');
        $response = json_decode($response->getContent(), true);
        $this->assertEquals($expectedResponse, $response);
    }
}
