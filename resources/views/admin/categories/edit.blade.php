@extends('admin.layout')

@section('content')
<div class="admin-card">
    <h2>Edit Category</h2>

    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf @method('PUT')

        <label>Name</label>
        <input name="name" value="{{ old('name', $category->name) }}">
        @error('name') <div style="color:#c00">{{ $message }}</div> @enderror

        <div style="margin-top:16px;">
            <button class="btn btn-dark">Update</button>
        </div>
    </form>
</div>
@endsection
