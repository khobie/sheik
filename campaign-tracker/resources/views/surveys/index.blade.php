@extends('layouts.app')
@section('title','Surveys')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4">Surveys</h1>
  <a class="btn btn-primary" href="{{ route('surveys.create') }}">New Survey</a>
</div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>Date</th>
      <th>Support</th>
      <th>Station</th>
      <th>Area</th>
      <th>Zone</th>
      <th>By</th>
    </tr>
  </thead>
  <tbody>
  @foreach($surveys as $s)
    <tr>
      <td>{{ $s->survey_date->format('Y-m-d') }}</td>
      <td>{{ $s->support_level }} ({{ $s->supporters_count }})</td>
      <td>{{ $s->pollingStation->station_code }}</td>
      <td>{{ $s->pollingStation->electoralArea->area_code }}</td>
      <td>{{ $s->pollingStation->electoralArea->zone->zone_code }}</td>
      <td>{{ $s->user->name }}</td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $surveys->links() }}
@endsection
