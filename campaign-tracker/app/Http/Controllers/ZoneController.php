<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::orderBy('zone_code')->paginate(20);
        return view('zones.index', compact('zones'));
    }

    public function create()
    {
        return view('zones.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'zone_name' => ['required','string','max:100'],
            'zone_code' => ['required','string','max:10','unique:zones,zone_code'],
        ]);
        Zone::create($data);
        return redirect()->route('zones.index')->with('status','Zone created');
    }

    public function show(Zone $zone)
    {
        return view('zones.show', compact('zone'));
    }

    public function edit(Zone $zone)
    {
        return view('zones.edit', compact('zone'));
    }

    public function update(Request $request, Zone $zone)
    {
        $data = $request->validate([
            'zone_name' => ['required','string','max:100'],
            'zone_code' => ['required','string','max:10','unique:zones,zone_code,'.$zone->id],
        ]);
        $zone->update($data);
        return redirect()->route('zones.index')->with('status','Zone updated');
    }

    public function destroy(Zone $zone)
    {
        $zone->delete();
        return redirect()->route('zones.index')->with('status','Zone deleted');
    }
}
