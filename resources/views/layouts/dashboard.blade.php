<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gabut — Dashboard</title>

    <!-- Tabler core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet" />
    <!-- Tabler icons -->
    <link href="https://unpkg.com/tabler-icons@latest/iconfont/tabler-icons.min.css" rel="stylesheet" />

    <style>
        .sidebar .nav-link.active, .sidebar .nav-link:hover { color: #206bc4; }
        .small-muted { color: #6c757d; font-size: 0.9rem; }
    </style>
</head>
<body class="antialiased">
<div class="page">
    <header class="navbar navbar-expand-md navbar-light">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href="{{ route('dashboard') }}">Gabut</a>
            </h1>

            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item d-none d-md-flex me-3">
                    <div class="nav-link">@auth{{ auth()->user()->name }}@endauth</div>
                </div>
                <div class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="page-wrapper">
        <div class="container-xl">
            <div class="row g-0">
                <div class="col-12 col-md-3 col-lg-2">
                    <div class="sidebar p-3">
                        <ul class="list-unstyled">
                            <li class="mb-2"><a class="nav-link" href="{{ route('dashboard') }}"><i class="ti ti-home"></i> Home</a></li>

                            @if(auth()->check() && auth()->user()->isAdmin())
                                <li class="mb-2"><a class="nav-link" href="{{ route('admin.polls.index') }}"><i class="ti ti-list-check"></i> Polls</a></li>
                                <li class="mb-2"><a class="nav-link" href="{{ route('admin.users.index') }}"><i class="ti ti-users"></i> Members</a></li>
                                <li class="mb-2"><a class="nav-link" href="{{ route('admin.votes.index') }}"><i class="ti ti-ballot"></i> Votes</a></li>
                            @else
                                <li class="mb-2"><a class="nav-link" href="{{ route('polls.index') }}"><i class="ti ti-list-check"></i> Polls</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-9 col-lg-10">
                    <div class="page-body py-4">
                        @if(session('success'))
                            <div class="toast align-items-center show mb-3" role="alert">
                                <div class="toast-body">
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Delete confirmation modal -->
<div class="modal modal-blur fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center py-4">
        <i class="ti ti-alert-triangle ti-3x text-warning mb-2"></i>
        <h3>Confirm delete</h3>
        <div class="text-muted">Are you sure you want to delete this item?</div>
      </div>
      <div class="modal-footer">
        <div class="w-100">
          <div class="row">
            <div class="col"><a href="#" class="btn btn-link w-100" data-bs-dismiss="modal">Cancel</a></div>
            <div class="col"><button id="deleteConfirmBtn" class="btn btn-danger w-100">Delete</button></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Tabler JS -->
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
<script>
    let deleteFormToSubmit = null;
    function openDeleteModal(form) {
        deleteFormToSubmit = form;
        var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
    document.getElementById('deleteConfirmBtn').addEventListener('click', function () {
        if (deleteFormToSubmit) {
            deleteFormToSubmit.submit();
        }
    });
</script>
</body>
</html>