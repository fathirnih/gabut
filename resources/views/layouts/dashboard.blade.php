<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Gabut</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { min-height: 100vh; }
        .sidebar {
            min-width: 220px;
            max-width: 220px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 56px;
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .content-area { margin-left: 220px; padding: 24px; }
        .sidebar .nav-link { color: #333; }
        .sidebar .nav-link.active { font-weight: 600; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Gabut</a>
        <div class="d-flex">
            <span class="me-3">@auth{{ auth()->user()->name }}@endauth</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-secondary btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>

<aside class="sidebar">
    <div class="px-3">
        <nav class="nav flex-column">
            @if(auth()->check() && auth()->user()->isAdmin())
                <a class="nav-link" href="{{ route('admin.polls.index') }}">Polls</a>
                <a class="nav-link" href="{{ route('admin.users.index') }}">Members</a>
                <a class="nav-link" href="{{ route('admin.votes.index') }}">Votes</a>
            @else
                <a class="nav-link" href="{{ route('polls.index') }}">Vote</a>
            @endif
        </nav>
    </div>
</aside>

<main class="content-area">
    <div class="container-fluid">
        @yield('content')
    </div>
</main>

</body>
</html>