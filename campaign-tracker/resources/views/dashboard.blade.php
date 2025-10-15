<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Campaign Tracker</a>
    </div>
  </nav>
  <main class="container py-4">
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
</body>
</html>
