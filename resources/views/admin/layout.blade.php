<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Main site styles --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Admin styles --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="admin-body">



<div class="admin-shell">

    {{-- SIDEBAR --}}
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <span>KIARO</span>
            <small>Admin</small>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                Categories
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                Products
            </a>
        </nav>
    </aside>

    {{-- MAIN --}}
    <div class="admin-main">

        {{-- TOP BAR --}}
        <header class="admin-topbar">
            <div class="topbar-left">
                <span class="page-title">
                    {{ ucfirst(str_replace('.', ' / ', Route::currentRouteName())) }}
                </span>
            </div>

            <div class="topbar-right">
                <a href="{{ route('home') }}" class="btn">← Back to site</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger" type="submit">Logout</button>
                </form>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="admin-content">

            @if(session('success'))
                <div class="flash-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')

        </main>
    </div>

</div>

</body>
</html>
