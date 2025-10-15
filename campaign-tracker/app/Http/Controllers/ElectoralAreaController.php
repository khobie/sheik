<?php

namespace App\Http\Controllers;

use App\Models\ElectoralArea;
use App\Models\Zone;
use Illuminate\Http\Request;

class ElectoralAreaController extends Controller
{
    public function index()
    {
        $areas = ElectoralArea::with('zone')->orderBy('area_code')->paginate(20);
        return view('electoral_areas.index', compact('areas'));
    }

    public function create()
    {
        $zones = Zone::orderBy('zone_code')->get();
        return view('electoral_areas.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'zone_id' => ['required','exists:zones,id'],
            'area_name' => ['required','string','max:100'],
            'area_code' => ['required','string','max:10','unique:electoral_areas,area_code'],
        ]);
        ElectoralArea::create($data);
        return redirect()->route('electoral-areas.index')->with('status','Electoral area created');
    }

    public function show(ElectoralArea $electoral_area)
    {
        return view('electoral_areas.show', ['area' => $electoral_area->load('zone','pollingStations')]);
    }

    public function edit(ElectoralArea $electoral_area)
    {
        $zones = Zone::orderBy('zone_code')->get();
        return view('electoral_areas.edit', ['area' => $electoral_area, 'zones' => $zones]);
    }

    public function update(Request $request, ElectoralArea $electoral_area)
    {
        $data = $request->validate([
            'zone_id' => ['required','exists:zones,id'],
            'area_name' => ['required','string','max:100'],
            'area_code' => ['required','string','max:10','unique:electoral_areas,area_code,'.$electoral_area->id],
        ]);
        $electoral_area->update($data);
        return redirect()->route('electoral-areas.index')->with('status','Electoral area updated');
    }

    public function destroy(ElectoralArea $electoral_area)
    {
        $electoral_area->delete();
        return redirect()->route('electoral-areas.index')->with('status','Electoral area deleted');
    }
}
