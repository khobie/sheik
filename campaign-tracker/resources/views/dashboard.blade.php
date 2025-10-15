@extends('layouts.app')
@section('title','Dashboard')
@section('content')
  <main class="container py-2">
    <div class="row g-3">
      <div class="col-md-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Zones</h5>
            <a href="/zones" class="btn btn-primary btn-sm">Manage</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Electoral Areas</h5>
            <a href="/electoral-areas" class="btn btn-primary btn-sm">Manage</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Polling Stations</h5>
            <a href="/polling-stations" class="btn btn-primary btn-sm">Manage</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Surveys</h5>
            <a href="/surveys" class="btn btn-primary btn-sm">View</a>
            <a href="/surveys/create" class="btn btn-outline-secondary btn-sm">New</a>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
