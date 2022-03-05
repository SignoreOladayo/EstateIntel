<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\SearchRequest;
use App\Traits\ApiResponder;
use App\Enum\ApiStatusMessageResponse;
use App\Http\Requests\Book\CreateBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Services\BookApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookApiController extends Controller
{
    use ApiResponder;

    protected $apiService;

    public function __construct(BookApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * External APi to Fetch Book by name.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getBookThroughExternalApi(Request $request): JsonResponse
    {
        $param = $request->input('name');

        return $this->apiService->getBookByName($param);
    }

    /**
     * Get all Books.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->successCall(200, ApiStatusMessageResponse::SUCCESS, BookResource::collection(Book::all()));
    }

    /**
     * Show a Book.
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function show(Book $book): JsonResponse
    {
        return $this->successCall(200, ApiStatusMessageResponse::SUCCESS, new BookResource($book));
    }

    /**
     * Create a Book.
     *
     * @param CreateBookRequest $request
     * @return JsonResponse
     */
    public function store(CreateBookRequest $request): JsonResponse
    {

        $book = Book::create([
            'name' => $request->name,
            'isbn' => $request->isbn,
            'authors' => $request->authors,
            'country' => $request->country,
            'number_of_pages' => $request->number_of_pages,
            'publisher' => $request->publisher,
            'release_date' => $request->release_date
        ]);

        return $this->successCall(201, ApiStatusMessageResponse::SUCCESS, ['book' => BookResource::make($book)->hide(['id'])]);
    }

    /**
     * Update a Book.
     *
     * @param UpdateBookRequest $request
     * @param Book $book
     * @return JsonResponse
     */
    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {

        $book_name = $book->book_name;

        $book->name = $request->name ?? $book->name;
        $book->isbn = $request->isbn ?? $book->isbn;
        $book->authors = $request->authors ?? $book->authors;
        $book->country = $request->country ?? $book->country;
        $book->number_of_pages = $request->number_of_pages ?? $book->number_of_pages;
        $book->publisher = $request->publisher ?? $book->publisher;
        $book->release_date = $request->release_date ?? $book->release_date;

        $book->save();

        return $this->successCall(200, ApiStatusMessageResponse::SUCCESS, new BookResource($book), "The Book {$book_name} was updated successfully");
    }

    /**
     * Delete a Book.
     *
     * @param Book $book
     * @return JsonResponse
     */
    public function destroy(Book $book): JsonResponse
    {
        $book_name = $book->book_name;

        $book->delete();

        return $this->successCall(204, ApiStatusMessageResponse::SUCCESS, [], "The Book {$book_name} was deleted successfully");
    }

    /**
     * Search for a book by name, country, publisher and release date
     *
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function search(SearchRequest $request): JsonResponse
    {
        $search = $request->search;

        $book = Book::query()->whereLike(['name', 'country', 'publisher', 'release_date'], $search)->get();

        if (count($book) > 0){
            return $this->successCall(200, ApiStatusMessageResponse::SUCCESS, $book);
        }

        return $this->successCall(404, ApiStatusMessageResponse::NOT_FOUND);

    }
}
