@extends('layouts.app')
@section('title','Edit Zone')
@section('content')
<h1 class="h4 mb-3">Edit Zone</h1>
<form method="POST" action="{{ route('zones.update',$zone) }}" class="card card-body p-3">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="form-label">Zone Code</label>
    <input name="zone_code" class="form-control" value="{{ old('zone_code',$zone->zone_code) }}" required>
    @error('zone_code')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="mb-3">
    <label class="form-label">Zone Name</label>
    <input name="zone_name" class="form-control" value="{{ old('zone_name',$zone->zone_name) }}" required>
    @error('zone_name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <button class="btn btn-primary">Save</button>
  <a href="{{ route('zones.index') }}" class="btn btn-link">Cancel</a>
</form>
@endsection
