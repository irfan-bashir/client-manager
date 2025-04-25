<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome | AB Consultants</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero-img {
            max-height: 400px;
            width: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">AB Consultants</a>
    </div>
</nav>

<div class="container mt-5 text-center">
    <h1 class="display-4">Welcome to Your Consultancy CRM</h1>
    <p class="lead">Manage clients, track renewals, and stay organized — all in one place.</p>
    <img src="https://images.unsplash.com/photo-1591696205602-2f950c417cb9" alt="Consultancy" class="hero-img mb-4 rounded">
    @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
    @else
        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg me-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Register</a>
    @endauth
</div>

</body>
</html>
