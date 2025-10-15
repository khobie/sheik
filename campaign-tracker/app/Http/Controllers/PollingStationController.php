<?php

namespace App\Http\Controllers;

use App\Models\PollingStation;
use App\Models\ElectoralArea;
use Illuminate\Http\Request;

class PollingStationController extends Controller
{
    public function index()
    {
        $stations = PollingStation::with('electoralArea.zone')->orderBy('station_code')->paginate(20);
        return view('polling_stations.index', compact('stations'));
    }

    public function create()
    {
        $areas = ElectoralArea::with('zone')->orderBy('area_code')->get();
        return view('polling_stations.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'electoral_area_id' => ['required','exists:electoral_areas,id'],
            'station_code' => ['required','string','max:15','unique:polling_stations,station_code'],
            'station_name' => ['required','string','max:150'],
            'location' => ['nullable','string','max:150'],
            'agent_name' => ['nullable','string','max:120'],
            'agent_phone' => ['nullable','string','max:20'],
            'voter_population' => ['nullable','integer','min:0'],
        ]);
        PollingStation::create($data);
        return redirect()->route('polling-stations.index')->with('status','Polling station created');
    }

    public function show(PollingStation $polling_station)
    {
        return view('polling_stations.show', ['station' => $polling_station->load('electoralArea.zone','surveys')]);
    }

    public function edit(PollingStation $polling_station)
    {
        $areas = ElectoralArea::orderBy('area_code')->get();
        return view('polling_stations.edit', ['station' => $polling_station, 'areas' => $areas]);
    }

    public function update(Request $request, PollingStation $polling_station)
    {
        $data = $request->validate([
            'electoral_area_id' => ['required','exists:electoral_areas,id'],
            'station_code' => ['required','string','max:15','unique:polling_stations,station_code,'.$polling_station->id],
            'station_name' => ['required','string','max:150'],
            'location' => ['nullable','string','max:150'],
            'agent_name' => ['nullable','string','max:120'],
            'agent_phone' => ['nullable','string','max:20'],
            'voter_population' => ['nullable','integer','min:0'],
        ]);
        $polling_station->update($data);
        return redirect()->route('polling-stations.index')->with('status','Polling station updated');
    }

    public function destroy(PollingStation $polling_station)
    {
        $polling_station->delete();
        return redirect()->route('polling-stations.index')->with('status','Polling station deleted');
    }
}
