@extends('layouts.app')
@section('title','New Electoral Area')
@section('content')
<h1 class="h4 mb-3">New Electoral Area</h1>
<form method="POST" action="{{ route('electoral-areas.store') }}" class="card card-body p-3">
  @csrf
  <div class="mb-3">
    <label class="form-label">Zone</label>
    <select name="zone_id" class="form-select" required>
      <option value="">Select...</option>
      @foreach($zones as $z)
        <option value="{{ $z->id }}">{{ $z->zone_code }} - {{ $z->zone_name }}</option>
      @endforeach
    </select>
    @error('zone_id')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Area Code</label>
    <input name="area_code" class="form-control" value="{{ old('area_code') }}" required>
    @error('area_code')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Area Name</label>
    <input name="area_name" class="form-control" value="{{ old('area_name') }}" required>
    @error('area_name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <button class="btn btn-primary">Create</button>
  <a href="{{ route('electoral-areas.index') }}" class="btn btn-link">Cancel</a>
</form>
@endsection
