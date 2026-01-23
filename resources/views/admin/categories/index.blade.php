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
        @foreach($categories as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td>{{ $cat->name }}</td>
                <td style="text-align:right;">
                    <a class="btn" href="{{ route('admin.categories.edit', $cat) }}">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top:16px;">{{ $categories->links() }}</div>
</div>
@endsection
