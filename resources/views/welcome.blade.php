<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome | AB Consultants</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-img {
            max-height: 400px;
            width: 100%;
            object-fit: cover;
            border-radius: 1rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .card-style {
            background-color: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .card-style:hover {
            transform: scale(1.02);
        }

        .btn-lg {
            padding: 0.75rem 2rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <i class="bi bi-building me-2"></i>AB Consultants
        </a>
    </div>
</nav>

<div class="container mt-5">
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-10 text-center card-style">
            <h1 class="display-5 fw-bold mb-3">Welcome to AB Consultants CRM</h1>
            <p class="lead mb-4 text-muted">
                A simple yet powerful way to manage clients, track registrations and tasks, and stay ahead of renewals.
            </p>

            <img src="https://images.unsplash.com/photo-1591696205602-2f950c417cb9" alt="Consultancy" class="hero-img mb-4">

            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">
                    <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg me-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-person-plus me-1"></i>Register
                </a>
            @endauth
        </div>
    </div>
</div>

</body>
</html>
