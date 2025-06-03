<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="search-panel">
            <div class="search-inner d-flex align-items-center justify-content-center">
                <div class="close-btn">Close <i class="fa fa-close"></i></div>
                <form id="searchForm" action="#">
                    <div class="form-group">
                        <input type="search" name="search" placeholder="What are you searching for...">
                        <button type="submit" class="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
                <!-- Navbar Header--><a href="{{ url('/admin/dashboard') }}" class="navbar-brand">
                    <div class="brand-text brand-big visible text-uppercase"><strong
                            class="text-warning">{{ $center->first_name}}</strong><strong class="text-white">
                            {{ $center->second_name}}</strong></div>
                    <div class="brand-text brand-sm">
                        <strong class="text-warning">{{ Str::substr($center->first_name ?? 'Test', 0, 1) }}</strong>
                        <strong>{{ Str::limit($center->second_name ?? 'Center', 1, '') }}</strong>
                    </div>
                </a>
                <!-- Sidebar Toggle Btn-->
                <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
            </div>

            <!-- Log out -->
            <div class="list-inline-item logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <input type="submit" value="Logout" class="btn btn-warning logout">
                </form>
            </div>

        </div>

        </div>
    </nav>
</header>
<div class="d-flex align-items-stretch">
