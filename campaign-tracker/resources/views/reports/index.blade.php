@extends('layouts.app')
@section('title','Reports')
@section('content')
<h1 class="h4 mb-3">Reports</h1>
<p>Total surveys: <strong>{{ $total }}</strong></p>
<div class="row">
  <div class="col-md-6">
    <h5>By Support Level</h5>
    <table class="table table-sm">
      @foreach($bySupport as $r)
      <tr><td>{{ $r->support_level }}</td><td>{{ $r->cnt }}</td></tr>
      @endforeach
    </table>
  </div>
  <div class="col-md-6">
    <h5>By Zone</h5>
    @foreach($byZone as $zoneId => $rows)
      <div class="mb-2">
        <div class="fw-bold">Zone {{ $zoneId }}</div>
        <table class="table table-sm">
          @foreach($rows as $r)
            <tr><td>{{ $r->support_level }}</td><td>{{ $r->cnt }}</td></tr>
          @endforeach
        </table>
      </div>
    @endforeach
  </div>
</div>
@endsection
