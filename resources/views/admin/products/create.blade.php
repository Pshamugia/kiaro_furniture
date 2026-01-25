@extends('admin.layout')

@section('content')
<style>
    .ck-editor__editable {
    min-height: 220px;
    font-size: 15px;
    line-height: 1.6;
}

</style>
<div class="admin-card">
    <h2>New Product</h2>

    <form method="POST"
          action="{{ route('admin.products.store') }}"
          enctype="multipart/form-data">
        @csrf

        {{-- CATEGORY --}}
     <label>Category</label>
<select name="category_id" required>
    <option value="">— Select category —</option>

    @foreach($categories as $parent)

        {{-- CASE 1: parent HAS subcategories (not selectable) --}}
        @if($parent->children->count())
            <optgroup label="{{ $parent->name }}">
                @foreach($parent->children as $child)
                    <option value="{{ $child->id }}">
                        ↳ {{ $child->name }}
                    </option>
                @endforeach
            </optgroup>

        {{-- CASE 2: parent has NO subcategories (selectable) --}}
        @else
            <option value="{{ $parent->id }}">
                {{ $parent->name }}
            </option>
        @endif

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
<textarea
    name="description"
    id="description-editor"
    rows="10"
></textarea>

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


<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
ClassicEditor
    .create(document.querySelector('#description-editor'))
    .catch(error => {
        console.error(error);
    });
</script>

@endsection
