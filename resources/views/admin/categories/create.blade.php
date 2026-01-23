@extends('admin.layout')

@section('content')
<div class="admin-card">
    <h2>New Category</h2>

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf
        <label>Name</label>
        <input name="name" value="{{ old('name') }}">
        @error('name') <div style="color:#c00">{{ $message }}</div> @enderror

        <div style="margin-top:16px;">
            <button class="btn btn-dark">Save</button>
        </div>
    </form>
</div>
@endsection
