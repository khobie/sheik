@extends('layouts.app')
@section('title','New Survey')
@section('content')
<h1 class="h4 mb-3">New Survey</h1>
<form method="POST" action="{{ route('surveys.store') }}" class="card card-body p-3">
  @csrf
  <div class="mb-3">
    <label class="form-label">Zone</label>
    <select id="zone" class="form-select">
      <option value="">Select...</option>
      @foreach($zones as $z)
        <option value="{{ $z->id }}">{{ $z->zone_code }} - {{ $z->zone_name }}</option>
      @endforeach
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Electoral Area</label>
    <select id="area" class="form-select"></select>
  </div>
  <div class="mb-3">
    <label class="form-label">Polling Station</label>
    <select name="polling_station_id" id="station" class="form-select" required></select>
    @error('polling_station_id')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Support Level</label>
    <select name="support_level" class="form-select" required>
      <option value="KEN">KEN</option>
      <option value="BAWUMIA">BAWUMIA</option>
      <option value="DR_ADU_TWU">DR ADU TWU</option>
      <option value="UNDECIDED">UNDECIDED</option>
      <option value="OTHER">OTHER</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Supporters Count</label>
    <input type="number" name="supporters_count" class="form-control" value="{{ old('supporters_count',0) }}" min="0">
  </div>
  <div class="mb-3">
    <label class="form-label">Key Issues</label>
    <textarea name="key_issues" class="form-control">{{ old('key_issues') }}</textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Specific Concerns</label>
    <textarea name="specific_concerns" class="form-control">{{ old('specific_concerns') }}</textarea>
  </div>
  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="follow_up_required" value="1" id="fur">
    <label class="form-check-label" for="fur">Follow-up required</label>
  </div>
  <div class="mb-3">
    <label class="form-label">Follow-up Action</label>
    <input name="follow_up_action" class="form-control" value="{{ old('follow_up_action') }}">
  </div>
  <div class="mb-3">
    <label class="form-label">Survey Date</label>
    <input type="date" name="survey_date" class="form-control" value="{{ old('survey_date', now()->toDateString()) }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Notes</label>
    <textarea name="survey_notes" class="form-control">{{ old('survey_notes') }}</textarea>
  </div>
  <button class="btn btn-primary">Submit</button>
  <a href="{{ route('surveys.index') }}" class="btn btn-link">Cancel</a>
</form>
<script>
// Minimal client-side dependent selects using inline fetches
const zoneSelect = document.getElementById('zone');
const areaSelect = document.getElementById('area');
const stationSelect = document.getElementById('station');

zoneSelect.addEventListener('change', async () => {
  const zoneId = zoneSelect.value;
  areaSelect.innerHTML = '';
  stationSelect.innerHTML = '';
  if (!zoneId) return;
  const res = await fetch(`/api/zones/${zoneId}/areas`);
  const areas = await res.json();
  areaSelect.innerHTML = '<option value="">Select...</option>' + areas.map(a=>`<option value="${a.id}">${a.area_code} - ${a.area_name}</option>`).join('');
});

areaSelect.addEventListener('change', async () => {
  const areaId = areaSelect.value;
  stationSelect.innerHTML = '';
  if (!areaId) return;
  const res = await fetch(`/api/areas/${areaId}/stations`);
  const stations = await res.json();
  stationSelect.innerHTML = stations.map(s=>`<option value="${s.id}">${s.station_code} - ${s.station_name}</option>`).join('');
});
</script>
@endsection
