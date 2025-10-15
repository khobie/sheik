<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        $total = Survey::count();
        $bySupport = Survey::select('support_level', DB::raw('COUNT(*) as cnt'))
            ->groupBy('support_level')
            ->orderBy('support_level')
            ->get();

        $byZone = Survey::select('electoral_areas.zone_id', 'support_level', DB::raw('COUNT(*) as cnt'))
            ->join('polling_stations', 'polling_stations.id', '=', 'surveys.polling_station_id')
            ->join('electoral_areas', 'electoral_areas.id', '=', 'polling_stations.electoral_area_id')
            ->groupBy('electoral_areas.zone_id', 'support_level')
            ->orderBy('electoral_areas.zone_id')
            ->get()
            ->groupBy('zone_id');

        return view('reports.index', compact('total', 'bySupport', 'byZone'));
    }
}
