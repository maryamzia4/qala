<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\RecommendationController;

Route::get('/interactions', [RecommendationController::class, 'getInteractions']);
Route::get('/products', [RecommendationController::class, 'getProducts']);
Route::get('/recommend/{user_id}', [RecommendationController::class, 'getRecommendations']);

use App\Http\Controllers\InteractionController;

Route::get('/interactions', [InteractionController::class, 'index']);
Route::post('/interactions', [RecommendationController::class, 'storeInteraction']);

Route::post('/interactions', [InteractionController::class, 'store']);

