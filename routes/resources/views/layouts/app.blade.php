<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kandalayang Library – @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar {
            min-height: 100vh;
            width: 250px;
            background: #1a3c5e;
            position: fixed;
            top: 0; left: 0;
        }
        .sidebar .brand {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .brand h5 { color: #fff; font-weight: 700; margin: 0; font-size: 1rem; }
        .sidebar .brand small { color: rgba(255,255,255,0.5); font-size: 0.75rem; }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 0.75rem 1.25rem;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.9rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .sidebar .nav-section {
            padding: 0.75rem 1.25rem 0.25rem;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.35);
        }
        .main-content { margin-left: 250px; padding: 2rem; }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 0.85rem 2rem;
            margin-left: 250px;
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .badge-role {
            font-size: 0.7rem;
            padding: 0.3em 0.7em;
            border-radius: 20px;
            text-transform: capitalize;
        }
        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,0.07); border-radius: 10px; }
        .stat-card { border-left: 4px solid; }
        .stat-card.blue  { border-color: #0d6efd; }
        .stat-card.green { border-color: #198754; }
        .stat-card.orange{ border-color: #fd7e14; }
        .stat-card.red   { border-color: #dc3545; }
        .page-header { margin-bottom: 1.5rem; }
        .page-header h4 { font-weight: 700; color: #1a3c5e; margin: 0; }
    </style>
    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar d-flex flex-column">
    <div class="brand">
        <h5><i class="bi bi-book-half me-2"></i>Kandalayang</h5>
        <small>Library E-Resource System</small>
    </div>

    <nav class="mt-2 flex-grow-1">
        <div class="nav-section">General</div>

        @auth
            {{-- Dashboard link based on role --}}
            <a href="{{ route(auth()->user()->role . '.dashboard') }}"
               class="nav-link {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            {{-- Search & Access — all roles --}}
            <a href="{{ route('search.index') }}"
               class="nav-link {{ request()->routeIs('search.*') ? 'active' : '' }}">
                <i class="bi bi-search"></i> Search Resources
            </a>

            {{-- Librarian-only links --}}
            @if(auth()->user()->isLibrarian())
                <div class="nav-section">Management</div>

                <a href="{{ route('e-resources.index') }}"
                   class="nav-link {{ request()->routeIs('e-resources.*') ? 'active' : '' }}">
                    <i class="bi bi-journals"></i> E-Resources
                </a>
                <a href="{{ route('users.index') }}"
                   class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Users
                </a>
                                <a href="{{ route('authors.index') }}"
                   class="nav-link {{ request()->routeIs('authors.*') ? 'active' : '' }}">
                    <i class="bi bi-person-lines-fill"></i> Authors
                </a>
                <a href="{{ route('publishers.index') }}"
                   class="nav-link {{ request()->routeIs('publishers.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Publishers
                </a>

                <div class="nav-section">Reports</div>

                <a href="{{ route('reports.index') }}"
                   class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line"></i> Overview
                </a>

                <a href="{{ route('reports.access-logs') }}"
                   class="nav-link {{ request()->routeIs('reports.access-logs') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Access Logs
                </a>
            @endif
        @endauth
    </nav>

    {{-- Logout at bottom --}}
    @auth
    <div class="p-3 border-top border-white border-opacity-10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light w-100">
                <i class="bi bi-box-arrow-left me-1"></i> Logout
            </button>
        </form>
    </div>
    @endauth
</div>

{{-- Top Bar --}}
@auth
<div class="topbar">
    <span class="fw-semibold text-muted" style="font-size:0.9rem;">@yield('title')</span>
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-primary badge-role">{{ auth()->user()->role }}</span>
        <span class="fw-semibold" style="font-size:0.9rem;">{{ auth()->user()->full_name }}</span>
    </div>
</div>
@endauth

{{-- Main Content --}}
<div class="main-content">
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>