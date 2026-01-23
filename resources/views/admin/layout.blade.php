<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .admin-wrap { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .admin-top { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
        .admin-card { background:#fff; border-radius:16px; padding:20px; box-shadow:0 10px 30px rgba(0,0,0,.06); }
        table { width:100%; border-collapse: collapse; }
        th, td { padding:12px 10px; border-bottom:1px solid #eee; text-align:left; }
        .btn { padding:10px 14px; border-radius:999px; border:1px solid #111; text-decoration:none; display:inline-block; }
        .btn-dark { background:#111; color:#fff; }
        .btn-danger { border-color:#c00; color:#c00; }
        input, select, textarea { width:100%; padding:12px; border-radius:10px; border:1px solid #ddd; }
        label { display:block; margin:14px 0 6px; }
    </style>
</head>
<body>
<div class="admin-wrap">
 <div class="admin-top">
    <div>
        <a class="btn" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="btn" href="{{ route('admin.categories.index') }}">Categories</a>
        <a class="btn" href="{{ route('admin.products.index') }}">Products</a>
    </div>

    <div style="display:flex; gap:10px; align-items:center;">
        <a class="btn" href="{{ route('home') }}">← Back to site</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger" type="submit">Logout</button>
        </form>
    </div>
</div>


    @if(session('success'))
        <div class="admin-card" style="margin-bottom:16px;">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>
