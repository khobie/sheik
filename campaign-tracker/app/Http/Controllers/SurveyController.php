<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Zone;
use App\Models\ElectoralArea;
use App\Models\PollingStation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $query = Survey::with(['user','pollingStation.electoralArea.zone'])->orderByDesc('survey_date');
        $user = $request->user();
        if ($user->role === 'ZONAL_COORDINATOR') {
            $query->whereHas('pollingStation.electoralArea', function ($q) use ($user) {
                $q->where('zone_id', $user->zone_id);
            });
        } elseif ($user->role === 'AREA_COORDINATOR') {
            $query->whereHas('pollingStation', function ($q) use ($user) {
                $q->where('electoral_area_id', $user->electoral_area_id);
            });
        } elseif ($user->role === 'POLLING_AGENT') {
            $query->where('user_id', $user->id);
        }
        $surveys = $query->paginate(20);
        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        $zones = Zone::orderBy('zone_code')->get();
        return view('surveys.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'polling_station_id' => ['required','exists:polling_stations,id'],
            'support_level' => ['required','in:KEN,BAWUMIA,DR_ADU_TWU,UNDECIDED,OTHER'],
            'supporters_count' => ['nullable','integer','min:0'],
            'key_issues' => ['nullable','string'],
            'specific_concerns' => ['nullable','string'],
            'follow_up_required' => ['sometimes','boolean'],
            'follow_up_action' => ['nullable','string','max:255'],
            'survey_notes' => ['nullable','string'],
            'survey_date' => ['required','date'],
        ]);
        $data['user_id'] = Auth::id();
        $data['follow_up_required'] = (bool)($data['follow_up_required'] ?? false);
        Survey::create($data);
        return redirect()->route('surveys.index')->with('status','Survey submitted');
    }

    public function show(Survey $survey)
    {
        return view('surveys.show', ['survey' => $survey->load('user','pollingStation.electoralArea.zone')]);
    }
}
