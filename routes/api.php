<?php

use App\Http\Controllers\HTMLSnippetController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PdfFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('pdf-files', PDFController::class);
Route::apiResource('html-snippets', HTMLSnippetController::class);
Route::apiResource('links', LinkController::class);
