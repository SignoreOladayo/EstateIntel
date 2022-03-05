<?php

use App\Http\Controllers\BookApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('external-books', [BookApiController::class, 'getBookThroughExternalApi']);

Route::resource('v1/books', BookApiController::class);

Route::get('search', [BookApiController::class, 'search']);
