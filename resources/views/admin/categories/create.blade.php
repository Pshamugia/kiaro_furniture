@extends('admin.layout')

@section('content')
<div class="admin-card">
    <h2>New Category</h2>

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf

        {{-- NAME --}}
        <label>Name</label>
        <input name="name" value="{{ old('name') }}">
        @error('name')
            <div style="color:#c00">{{ $message }}</div>
        @enderror

        {{-- PARENT CATEGORY --}}
        <label style="margin-top:14px;">Parent Category</label>
        <select name="parent_id">
            <option value="">— Main category —</option>

            @foreach($categories as $parent)
                <option value="{{ $parent->id }}"
                    {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>

        @error('parent_id')
            <div style="color:#c00">{{ $message }}</div>
        @enderror

        <div style="margin-top:16px;">
            <button class="btn btn-dark">Save</button>
        </div>
    </form>
</div>
@endsection
