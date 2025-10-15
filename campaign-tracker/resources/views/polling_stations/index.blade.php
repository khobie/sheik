@extends('layouts.app')
@section('title','Polling Stations')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4">Polling Stations</h1>
  <a class="btn btn-primary" href="{{ route('polling-stations.create') }}">New Station</a>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Code</th>
      <th>Name</th>
      <th>Area</th>
      <th>Zone</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  @foreach($stations as $s)
    <tr>
      <td>{{ $s->station_code }}</td>
      <td>{{ $s->station_name }}</td>
      <td>{{ $s->electoralArea->area_code }}</td>
      <td>{{ $s->electoralArea->zone->zone_code }}</td>
      <td class="text-end">
        <a class="btn btn-sm btn-secondary" href="{{ route('polling-stations.edit',$s) }}">Edit</a>
        <form action="{{ route('polling-stations.destroy',$s) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $stations->links() }}
@endsection
