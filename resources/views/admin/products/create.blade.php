@extends('admin.layout')

@section('content')
<div class="admin-card">
    <h2>New Product</h2>

    <form method="POST"
          action="{{ route('admin.products.store') }}"
          enctype="multipart/form-data">
        @csrf

        {{-- CATEGORY --}}
        <label>Category</label>
        <select name="category_id">
            @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>

        {{-- TITLE --}}
        <label>Title</label>
        <input name="title">

        {{-- PRICE --}}
        <label>Price</label>
        <input name="price">

        {{-- DESCRIPTION --}}
        <label>Description</label>
        <textarea name="description" rows="5"></textarea>

        <hr style="margin:30px 0;">
        <h3>Images</h3>

        <div id="images-wrapper">

            {{-- FIRST IMAGE --}}
            <div class="image-block admin-card" style="margin-bottom:20px;">
                <label>Image</label>
                <input type="file" name="images[0][file]" required>

                <label>Color name</label>
                <input type="text" name="images[0][color_name]">

                <label>Color picker</label>
                <input type="color" name="images[0][color_hex]">

                <label>
                    <input type="radio"
                           name="main_image_index"
                           value="0"
                           checked>
                    Main image
                </label>
            </div>

        </div>

        <button type="button" class="btn" onclick="addImageBlock()">+ Add image</button>

        <div style="margin-top:20px;">
            <button class="btn btn-dark">Save</button>
        </div>
    </form>
</div>

<script>
let imageIndex = 1;

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
