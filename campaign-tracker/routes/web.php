<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ElectoralAreaController;
use App\Http\Controllers\PollingStationController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\DashboardController;
use App\Models\Zone;
use App\Models\ElectoralArea;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () { return redirect()->route('dashboard'); });

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('zones', ZoneController::class)->middleware('can:admin');
    Route::resource('electoral-areas', ElectoralAreaController::class)->middleware('can:admin');
    Route::resource('polling-stations', PollingStationController::class)->middleware('can:admin');
    Route::resource('surveys', SurveyController::class)->only(['index','create','store','show']);

    // Dependent dropdown AJAX endpoints (authenticated)
    Route::get('/ajax/zones/{zone}/areas', function (Zone $zone) {
        return $zone->electoralAreas()->select('id','area_name','area_code')->orderBy('area_code')->get();
    });
    Route::get('/ajax/areas/{area}/stations', function (ElectoralArea $area) {
        return $area->pollingStations()->select('id','station_code','station_name')->orderBy('station_code')->get();
    });
});
