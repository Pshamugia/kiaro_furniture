@extends('admin.layout')

@section('content')
<div class="admin-card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
        <h2>Categories</h2>
        <a class="btn btn-dark" href="{{ route('admin.categories.create') }}">+ New</a>
    </div>

    <table>
        <thead>
        <tr><th>ID</th><th>Name</th><th></th></tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
<tr>
    <td>{{ $category->id }}</td>
    <td><strong>{{ $category->name }}</strong></td>
    <td>
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn">Edit</a>
        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display:inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </td>
</tr>

{{-- SUBCATEGORIES --}}
@foreach($category->children as $child)
<tr>
    <td>— {{ $child->id }}</td>
    <td style="padding-left:30px;">↳ {{ $child->name }}</td>
    <td>
        <a href="{{ route('admin.categories.edit', $child) }}" class="btn">Edit</a>
        <form method="POST" action="{{ route('admin.categories.destroy', $child) }}" style="display:inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
    </td>
</tr>
@endforeach
@endforeach

        </tbody>
    </table>

 </div>
@endsection
