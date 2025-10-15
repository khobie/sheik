<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title','Campaign Tracker')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Campaign Tracker</a>
  </div>
</nav>
<div class="container py-4">
  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif
  @yield('content')
</div>
</body>
</html>
