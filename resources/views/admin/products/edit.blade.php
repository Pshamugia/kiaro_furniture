@extends('admin.layout')

@section('content')

<style>
    .ck-editor__editable {
    min-height: 220px;
    font-size: 15px;
    line-height: 1.6;
}
/* === WATERMARK TOGGLE FIX === */
.watermark-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 260px;
    padding: 12px 14px;
    margin: 16px 0;
    background: #f5f5f5;
    border-radius: 10px;
}

/* force switch size */
.wm-switch {
    position: relative;
    width: 44px;
    height: 24px;
    flex: 0 0 auto;
}

.wm-switch input {
    display: none;
}

.wm-slider {
    position: absolute;
    inset: 0;
    background: #ccc;
    border-radius: 24px;
    transition: .25s;
}

.wm-slider::before {
    content: "";
    position: absolute;
    width: 18px;
    height: 18px;
    left: 3px;
    top: 3px;
    background: #fff;
    border-radius: 50%;
    transition: .25s;
}

.wm-switch input:checked + .wm-slider {
    background: #111;
}

.wm-switch input:checked + .wm-slider::before {
    transform: translateX(20px);
}



    </style>
<div class="admin-card">
    <h2>Edit Product</h2>

    <form method="POST"
          action="{{ route('admin.products.update', $product) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- CATEGORY --}}
      <label>Category</label>
<select name="category_id" required>
    <option value="">— Select category —</option>

    @foreach($categories as $parent)

        @if($parent->children->count())
            <optgroup label="{{ $parent->name }}">
                @foreach($parent->children as $child)
                    <option value="{{ $child->id }}"
                        @selected(old('category_id', $product->category_id) == $child->id)>
                        ↳ {{ $child->name }}
                    </option>
                @endforeach
            </optgroup>
        @else
            <option value="{{ $parent->id }}"
                @selected(old('category_id', $product->category_id) == $parent->id)>
                {{ $parent->name }}
            </option>
        @endif

    @endforeach
</select>


        {{-- TITLE --}}
        <label>Title</label>
        <input name="title" value="{{ old('title', $product->title) }}">

        {{-- PRICE --}}
        <label>Price</label>
        <input name="price" value="{{ old('price', $product->price) }}">

        <label>Discount price</label>
<input name="discount"
       type="number"
       step="0.01"
       value="{{ old('discount', $product->discount) }}">

       
        {{-- DESCRIPTION --}}
        <label>Description</label>
<textarea
    name="description"
    id="description-editor"
    rows="8"
>{!! old('description', $product->description) !!}</textarea>







        <hr style="margin:30px 0;">



        
<div class="watermark-box">
    <span>Watermark</span>

    <label class="wm-switch">
        <input type="checkbox"
               name="watermark"
               value="1"
               {{ old('watermark', $product->watermark ?? true) ? 'checked' : '' }}>
        <span class="wm-slider"></span>
    </label>
</div>






        <h3>Images</h3>

        

<div id="images-wrapper">

@foreach($product->images as $i => $img)
 
                <div class="image-block admin-card" style="margin-bottom:20px;">

                    <img src="{{ asset('storage/'.$img->image) }}"
                         style="width:120px;border-radius:10px;margin-bottom:10px;">

                    <button type="button"
        class="btn btn-danger btn-sm"
        onclick="deleteImage({{ $img->id }}, this)">
    Delete image
</button>




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
        </div>

        
        <button type="button" class="btn" onclick="addImageBlock()">+ Add image</button>

        <div style="margin-top:20px;">
            <button class="btn btn-dark">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn">Cancel</a>
        </div>
        
    </form>
<form id="delete-image-form"
      method="POST"
      action=""
      data-base-action="{{ url('admin/product-images') }}/"
      style="display:none;">
    @csrf
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


<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
ClassicEditor
    .create(document.querySelector('#description-editor'), {
        toolbar: [
            'heading',
            '|',
            'bold', 'italic', 'underline',
            '|',
            'bulletedList', 'numberedList',
            '|',
            'link', 'blockQuote',
            '|',
            'undo', 'redo'
        ]
    })
    .catch(error => {
        console.error(error);
    });
</script>


<script>
function deleteImage(imageId, btn) {
    if (!confirm('Delete image?')) return;

    const form = document.getElementById('delete-image-form');
    const base = form.dataset.baseAction;

    form.action = base + imageId + '/delete';

    btn.closest('.image-block')?.remove();
    form.submit();
}
</script>



@endsection
