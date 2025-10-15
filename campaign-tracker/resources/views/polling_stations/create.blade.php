@extends('layouts.app')
@section('title','New Polling Station')
@section('content')
<h1 class="h4 mb-3">New Polling Station</h1>
<form method="POST" action="{{ route('polling-stations.store') }}" class="card card-body p-3">
  @csrf
  <div class="mb-3">
    <label class="form-label">Electoral Area</label>
    <select name="electoral_area_id" class="form-select" required>
      <option value="">Select...</option>
      @foreach($areas as $a)
        <option value="{{ $a->id }}">{{ $a->area_code }} - {{ $a->area_name }}</option>
      @endforeach
    </select>
    @error('electoral_area_id')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Station Code</label>
    <input name="station_code" class="form-control" value="{{ old('station_code') }}" required>
    @error('station_code')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Station Name</label>
    <input name="station_name" class="form-control" value="{{ old('station_name') }}" required>
    @error('station_name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Location</label>
    <input name="location" class="form-control" value="{{ old('location') }}">
  </div>
  <div class="mb-3">
    <label class="form-label">Agent Name</label>
    <input name="agent_name" class="form-control" value="{{ old('agent_name') }}">
  </div>
  <div class="mb-3">
    <label class="form-label">Agent Phone</label>
    <input name="agent_phone" class="form-control" value="{{ old('agent_phone') }}">
  </div>
  <div class="mb-3">
    <label class="form-label">Voter Population</label>
    <input type="number" min="0" name="voter_population" class="form-control" value="{{ old('voter_population') }}">
  </div>
  <button class="btn btn-primary">Create</button>
  <a href="{{ route('polling-stations.index') }}" class="btn btn-link">Cancel</a>
</form>
@endsection
