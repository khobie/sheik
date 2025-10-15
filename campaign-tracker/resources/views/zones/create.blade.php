@extends('layouts.app')
@section('title','New Zone')
@section('content')
<h1 class="h4 mb-3">New Zone</h1>
<form method="POST" action="{{ route('zones.store') }}" class="card card-body p-3">
  @csrf
  <div class="mb-3">
    <label class="form-label">Zone Code</label>
    <input name="zone_code" class="form-control" value="{{ old('zone_code') }}" required>
    @error('zone_code')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Zone Name</label>
    <input name="zone_name" class="form-control" value="{{ old('zone_name') }}" required>
    @error('zone_name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <button class="btn btn-primary">Create</button>
  <a href="{{ route('zones.index') }}" class="btn btn-link">Cancel</a>
</form>
@endsection
