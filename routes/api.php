<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{AreaController, CountryController, CityController};


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resources([
    'countries' => CountryController::class,
    'areas' => AreaController::class,
    'cities' => CityController::class,
],['except' => ['create']]);

//Route::resource('country.cities', CityController::class)->except('create')->shallow();
Route::get('country/{country_id}/cities', [CityController::class, 'index']);
Route::get('country/{country_id}/areas', [AreaController::class, 'index']);
