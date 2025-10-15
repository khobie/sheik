@extends('layouts.app')
@section('title','Zones')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4">Zones</h1>
  <a class="btn btn-primary" href="{{ route('zones.create') }}">New Zone</a>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Code</th>
      <th>Name</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  @foreach($zones as $zone)
    <tr>
      <td>{{ $zone->zone_code }}</td>
      <td>{{ $zone->zone_name }}</td>
      <td class="text-end">
        <a class="btn btn-sm btn-secondary" href="{{ route('zones.edit',$zone) }}">Edit</a>
        <form action="{{ route('zones.destroy',$zone) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $zones->links() }}
@endsection
