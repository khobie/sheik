<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Zone;
use App\Models\ElectoralArea;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/zones/{zone}/areas', function (Zone $zone) {
    return $zone->electoralAreas()->select('id','area_name','area_code')->orderBy('area_code')->get();
});

Route::get('/areas/{area}/stations', function (ElectoralArea $area) {
    return $area->pollingStations()->select('id','station_code','station_name')->orderBy('station_code')->get();
});
