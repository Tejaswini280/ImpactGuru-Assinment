<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-md-6 text-center">
                <i class="bi bi-exclamation-triangle text-warning" style="font-size: 100px;"></i>
                <h1 class="display-1 fw-bold">404</h1>
                <h2 class="mb-4">Page Not Found</h2>
                <p class="lead text-muted mb-4">
                    Sorry, the page you are looking for could not be found.
                </p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left"></i> Go Back
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-house"></i> Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>