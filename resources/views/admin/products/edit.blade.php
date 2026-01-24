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

        {{-- TITLE --}}
        <label>Title</label>
        <input name="title" value="{{ old('title', $product->title) }}">

        {{-- PRICE --}}
        <label>Price</label>
        <input name="price" value="{{ old('price', $product->price) }}">

        {{-- DESCRIPTION --}}
        <label>Description</label>
        <textarea name="description" rows="5">{{ old('description', $product->description) }}</textarea>

        <hr style="margin:30px 0;">
        <h3>Images</h3>

        <div id="images-wrapper">

            @foreach($product->images as $i => $img)

                <div class="image-block admin-card" style="margin-bottom:20px;">

                    <img src="{{ asset('storage/'.$img->image) }}"
                         style="width:120px;border-radius:10px;margin-bottom:10px;">

                    <input type="hidden" name="images[{{ $i }}][id]" value="{{ $img->id }}">

                    <label>Replace image</label>
                    <input type="file" name="images[{{ $i }}][file]" accept="image/*">

                    <label>Color name</label>
                    <input type="text"
                           name="images[{{ $i }}][color_name]"
                           value="{{ $img->color_name }}">

                    <label>Color picker</label>
                    <input type="color"
                           name="images[{{ $i }}][color_hex]"
                           value="{{ $img->color_hex ?? '#000000' }}">

                    <label>
                        <input type="radio"
                               name="main_image_index"
                               value="{{ $i }}"
                               {{ $img->is_main ? 'checked' : '' }}>
                        Main image
                    </label>

                </div>

            @endforeach

        </div>

        <button type="button" class="btn" onclick="addImageBlock()">+ Add image</button>

        <div style="margin-top:20px;">
            <button class="btn btn-dark">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn">Cancel</a>
        </div>
    </form>
</div>

<script>
let imageIndex = {{ $product->images->count() }};

function addImageBlock() {

    const wrapper = document.getElementById('images-wrapper');

    const div = document.createElement('div');
    div.className = 'image-block admin-card';
    div.style.marginBottom = '20px';

    div.innerHTML = `
        <label>Image</label>
        <input type="file" name="images[${imageIndex}][file]" required>

        <label>Color name</label>
        <input type="text" name="images[${imageIndex}][color_name]">

        <label>Color picker</label>
        <input type="color" name="images[${imageIndex}][color_hex]">

        <label>
            <input type="radio"
                   name="main_image_index"
                   value="${imageIndex}">
            Main image
        </label>

        <button type="button"
                class="btn btn-danger"
                onclick="this.parentNode.remove()">
            Remove
        </button>
    `;

    wrapper.appendChild(div);
    imageIndex++;
}
</script>
@endsection
