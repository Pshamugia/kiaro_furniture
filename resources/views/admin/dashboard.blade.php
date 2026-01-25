@extends('admin.layout')

@section('content')

<div class="admin-dashboard">

    {{-- HEADER --}}
    <div class="dashboard-header">
        <div>
            <h1>Dashboard</h1>
            <p class="muted">მიმოხილვა და მართვა</p>
        </div>

        <form method="GET"
              action="{{ route('admin.products.index') }}"
              class="dashboard-search">
            <input type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Search product or category…">
            <button class="btn btn-dark">Search</button>
        </form>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-title">პროდუქცია</div>
            <div class="stat-value">{{ \App\Models\Product::count() }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">კატეგორიები</div>
            <div class="stat-value">{{ \App\Models\Category::count() }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">ბოლო დამატებული</div>
            <div class="stat-value">
                {{ optional(\App\Models\Product::latest()->first())->title ?? '—' }}
            </div>
        </div>

        <div class="stat-card accent">
            <div class="stat-title">სისტემის სტატუსი</div>
            <div class="stat-value">Active</div>
        </div>

    </div>

    {{-- QUICK ACTIONS --}}
    <div class="dashboard-section">
        <h2>Quick actions</h2>

        <div class="actions-grid">
            <a href="{{ route('admin.products.create') }}" class="action-card">
                ➕ Add product
            </a>

            <a href="{{ route('admin.categories.create') }}" class="action-card">
                🗂 Add category
            </a>

            <a href="{{ route('admin.products.index') }}" class="action-card">
                📦 View products
            </a>

            <a href="{{ route('admin.categories.index') }}" class="action-card">
                📁 View categories
            </a>
        </div>
    </div>

</div>

@endsection
