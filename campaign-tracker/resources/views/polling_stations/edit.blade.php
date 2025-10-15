@extends('layouts.app')
@section('title','Edit Polling Station')
@section('content')
<h1 class="h4 mb-3">Edit Polling Station</h1>
<form method="POST" action="{{ route('polling-stations.update',$station) }}" class="card card-body p-3">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="form-label">Electoral Area</label>
    <select name="electoral_area_id" class="form-select" required>
      @foreach($areas as $a)
        <option value="{{ $a->id }}" @selected(old('electoral_area_id',$station->electoral_area_id)==$a->id)>{{ $a->area_code }} - {{ $a->area_name }}</option>
      @endforeach
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Station Code</label>
    <input name="station_code" class="form-control" value="{{ old('station_code',$station->station_code) }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Station Name</label>
    <input name="station_name" class="form-control" value="{{ old('station_name',$station->station_name) }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Location</label>
    <input name="location" class="form-control" value="{{ old('location',$station->location) }}">
  </div>
  <div class="mb-3">
    <label class="form-label">Agent Name</label>
    <input name="agent_name" class="form-control" value="{{ old('agent_name',$station->agent_name) }}">
  </div>
  <div class="mb-3">
    <label class="form-label">Agent Phone</label>
    <input name="agent_phone" class="form-control" value="{{ old('agent_phone',$station->agent_phone) }}">
  </div>
  <div class="mb-3">
    <label class="form-label">Voter Population</label>
    <input type="number" min="0" name="voter_population" class="form-control" value="{{ old('voter_population',$station->voter_population) }}">
  </div>
  <button class="btn btn-primary">Save</button>
  <a href="{{ route('polling-stations.index') }}" class="btn btn-link">Cancel</a>
</form>
@endsection
