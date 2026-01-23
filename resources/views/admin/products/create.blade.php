@extends('admin.layout')

@section('content')
<div class="admin-card">
    <h2>New Product</h2>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf

        <label>Category</label>
        <select name="category_id">
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id')==$c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        @error('category_id') <div style="color:#c00">{{ $message }}</div> @enderror

        <label>Title</label>
        <input name="title" value="{{ old('title') }}">
        @error('title') <div style="color:#c00">{{ $message }}</div> @enderror

        <label>Price</label>
        <input name="price" value="{{ old('price') }}" placeholder="1200">
        @error('price') <div style="color:#c00">{{ $message }}</div> @enderror

        <label>Color</label>
        <input name="color" value="{{ old('color') }}">
        @error('color') <div style="color:#c00">{{ $message }}</div> @enderror

        <label>Description</label>
        <textarea name="description" rows="5">{{ old('description') }}</textarea>
        @error('description') <div style="color:#c00">{{ $message }}</div> @enderror

        <label>Photo 1</label>
        <input type="file" name="photo1" accept="image/*">

        <label>Photo 2</label>
        <input type="file" name="photo2" accept="image/*">

        <label>Photo 3</label>
        <input type="file" name="photo3" accept="image/*">

        <label>Photo 4</label>
        <input type="file" name="photo4" accept="image/*">

        <label>Photo 5</label>
        <input type="file" name="photo5" accept="image/*">

        <label>Photo 6</label>
        <input type="file" name="photo6" accept="image/*">

        <div style="margin-top:16px;">
            <button class="btn btn-dark">Save</button>
        </div>
    </form>
</div>
@endsection
