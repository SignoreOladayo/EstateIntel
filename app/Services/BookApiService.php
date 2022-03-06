<?php

namespace App\Services;

use App\Enum\ApiStatusMessageResponse;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class BookApiService
{
    use ApiResponder;

    /**
     * The base URL used for ICE AND FIRE API requests
     *
     * @var string
     */
    protected $apiBaseUrl = 'https://www.anapioficeandfire.com/api/books?name=';

    /**
     *  Fetch name of book inputted from ICE AND FIRE API
     *
     * @return JsonResponse $response
     */
    public function getBookByName($nameOfBook): JsonResponse
    {
        try {
            $response = Http::get($this->apiBaseUrl . $nameOfBook);

            $response = $response->json();

            if (count($response) > 0) {
                $response = $this->renameAndSuppressUnwantedDataFromResponse($response);

                return $this->successCall(200, ApiStatusMessageResponse::SUCCESS, $response);
            }

            return $this->successCall(404, ApiStatusMessageResponse::NOT_FOUND,  $response);

        } catch (\Throwable $th) {
            Log::error("Unable to Fetch Book By Name from the external api", ["error" => $th->getMessage()]);

            return $this->badCall(503, ApiStatusMessageResponse::ERROR,"Unable to Fetch Book By Name from the external api",  $th->getMessage());
        }

    }

    private function renameAndSuppressUnwantedDataFromResponse($response)
    {
        foreach ($response as $key => $value) {
            $response[$key]['number_of_pages'] = $value["numberOfPages"];
            $response[$key]['release_date'] = $value["released"];
            unset($response[$key]["url"]);
            unset($response[$key]["characters"]);
            unset($response[$key]["povCharacters"]);
            unset($response[$key]["mediaType"]);
            unset($response[$key]["numberOfPages"]);
            unset($response[$key]["released"]);
        }

        return $response;
    }
}
