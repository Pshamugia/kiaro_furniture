@extends('admin.layout')

@section('content')
<div class="admin-card">
    <h2>Edit Product</h2>

    <form method="POST"
          action="{{ route('admin.products.update', $product) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- CATEGORY --}}
        <label>Category</label>
        <select name="category_id">
            @foreach($categories as $c)
                <option value="{{ $c->id }}"
                    @selected(old('category_id', $product->category_id) == $c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <div style="color:#c00">{{ $message }}</div> @enderror

        {{-- TITLE --}}
        <label>Title</label>
        <input name="title" value="{{ old('title', $product->title) }}">
        @error('title') <div style="color:#c00">{{ $message }}</div> @enderror

        {{-- PRICE --}}
        <label>Price</label>
        <input name="price" value="{{ old('price', $product->price) }}">
        @error('price') <div style="color:#c00">{{ $message }}</div> @enderror

        {{-- COLOR --}}
        <label>Color</label>
        <input name="color" value="{{ old('color', $product->color) }}">
        @error('color') <div style="color:#c00">{{ $message }}</div> @enderror

        {{-- DESCRIPTION --}}
        <label>Description</label>
        <textarea name="description" rows="5">{{ old('description', $product->description) }}</textarea>
        @error('description') <div style="color:#c00">{{ $message }}</div> @enderror

        <hr style="margin:24px 0;">

        {{-- PHOTOS --}}
        <h3>Photos</h3>

        @for($i = 1; $i <= 6; $i++)
            @php $field = "photo{$i}"; @endphp

            <label>Photo {{ $i }}</label>

            @if($product->$field)
                <div style="margin-bottom:10px;">
                    <img src="{{ asset('storage/'.$product->$field) }}"
                         width="140"
                         style="border-radius:12px;">
                </div>
            @endif

            <input type="file" name="photo{{ $i }}" accept="image/*">

            <br><br>
        @endfor

        <div style="margin-top:20px;">
            <button class="btn btn-dark">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn">Cancel</a>
        </div>

    </form>
</div>
@endsection
