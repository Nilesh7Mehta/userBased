<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar bg-dark text-white" style="width: 250px; min-height: 100vh;">
        <h3 class="text-center p-3">Admin Panel</h3>
        <ul class="nav flex-column p-3">
            <li class="nav-item">
                <a href="" class="nav-link text-white">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link text-white">Add Users</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link text-white">Logout</a>
            </li>

            <!-- Add more links for other admin features here -->
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content p-4" style="flex: 1;">
        @yield('content')
    </div>
</div>