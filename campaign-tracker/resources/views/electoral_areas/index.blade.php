@extends('layouts.app')
@section('title','Electoral Areas')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4">Electoral Areas</h1>
  <a class="btn btn-primary" href="{{ route('electoral-areas.create') }}">New Area</a>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Code</th>
      <th>Name</th>
      <th>Zone</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  @foreach($areas as $area)
    <tr>
      <td>{{ $area->area_code }}</td>
      <td>{{ $area->area_name }}</td>
      <td>{{ $area->zone->zone_code }}</td>
      <td class="text-end">
        <a class="btn btn-sm btn-secondary" href="{{ route('electoral-areas.edit',$area) }}">Edit</a>
        <form action="{{ route('electoral-areas.destroy',$area) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $areas->links() }}
@endsection
