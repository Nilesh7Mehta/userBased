<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
</head>
<body>

    @auth
    @if(auth()->user()->user_type === 1) 
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white" style="width: 250px; min-height: 100vh;">
            <h3 class="text-center p-3">Admin Panel</h3>
            <ul class="nav flex-column p-3">
               <!-- Check if the user is an admin -->
                    <!-- Admin Links -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link text-white">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('adminusers') }}" class="nav-link text-white">Users / Admin</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('adminlogout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">Logout</button>
                        </form>
                    </li>
            </ul>
        </div>
        @endif
    
        <!-- Main Content Area -->
        <div class="main-content p-4" style="flex: 1;">
            @yield('content')
        </div>
    </div>
    @endauth
    


@guest
@yield('content') <!-- Show only login page if not authenticated -->
@endguest

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
