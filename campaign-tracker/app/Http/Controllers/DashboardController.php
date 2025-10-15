<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\PollingStation;
use App\Models\ElectoralArea;
use App\Models\Zone;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'zones' => Zone::count(),
            'areas' => ElectoralArea::count(),
            'stations' => PollingStation::count(),
            'surveys' => Survey::count(),
        ];
        return view('dashboard', compact('stats'));
    }
}
