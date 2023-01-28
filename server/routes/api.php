<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\NutrientController;
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

Route::resource('nutrients', NutrientController::class);
Route::resource('categories', CategoryController::class);
Route::resource('meals', MealController::class);

Route::get('favourites/nutrients', [NutrientController::class, 'getFavourites']);
Route::post('favourites/nutrients', [NutrientController::class, 'updateFavouritesOrder']);

Route::get('restore/nutrients/{id}', [NutrientController::class, 'restore']);
Route::get('restore/categories/{id}', [CategoryController::class, 'restore']);
