@extends('layouts.app')

@section('content')
<div class="container">

    <div style="
        display:grid;
        grid-template-columns: 1.2fr 1fr;
        gap:60px;
        margin-top:60px;
        align-items:start;
    ">

        {{-- LEFT: IMAGE --}}
        @php
    $photos = collect([
        $product->photo1,
        $product->photo2,
        $product->photo3,
        $product->photo4,
        $product->photo5,
        $product->photo6,
    ])->filter();
@endphp

<div class="gallery-box">
    <!-- MAIN IMAGE -->
    <div class="gallery-main">
        <img
            id="mainImage"
            src="{{ asset('storage/' . $photos->first()) }}"
            alt="{{ $product->title }}">
    </div>

    <!-- THUMBNAILS -->
    @if($photos->count() > 1)
        <div class="gallery-thumbs">
            @foreach($photos as $photo)
                <img
                    src="{{ asset('storage/' . $photo) }}"
                    onclick="setMainImage(this)"
                    class="thumb {{ $loop->first ? 'active' : '' }}">
            @endforeach
        </div>
    @endif
</div>


        {{-- RIGHT: INFO --}}
        <div>

            <h1 style="
                font-size:36px;
                margin-bottom:14px;
                line-height:1.2;
            ">
                {{ $product->title }}
            </h1>

            <p style="
                font-size:22px;
                font-weight:600;
                margin-bottom:20px;
            ">
                ₾ {{ number_format($product->price, 2) }}
            </p>

            {{-- SHARE --}}
           <div class="product-share">

 
                <!-- Facebook -->
                <a
                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                    target="_blank"
                    rel="noopener"
                    class="share-btn fb"
                    aria-label="Share on Facebook">
                    <i class="bi bi-facebook"></i>
                </a>

                <!-- Messenger -->
                <a
                    href="https://www.facebook.com/dialog/send?link={{ urlencode(url()->current()) }}&app_id=YOUR_APP_ID&redirect_uri={{ urlencode(url()->current()) }}"
                    target="_blank"
                    rel="noopener"
                    class="share-btn messenger"
                    aria-label="Share on Messenger">
                    <i class="bi bi-messenger"></i>
                </a>

                <!-- WhatsApp -->
                <a
                    href="https://wa.me/?text={{ urlencode($product->title ?? 'პროდუქტი') }}%20{{ urlencode(url()->current()) }}"
                    target="_blank"
                    rel="noopener"
                    class="share-btn whatsapp"
                    aria-label="Share on WhatsApp">
                    <i class="bi bi-whatsapp"></i>
                </a>

                <!-- Copy link -->
                <button
                    class="share-btn copy"
                    onclick="copyProductLink()"
                    aria-label="Copy link">
                    <i class="bi bi-link-45deg"></i>
                </button>

            </div>

            {{-- DESCRIPTION --}}
            @if($product->description)
                <p style="
                    color:#555;
                    line-height:1.7;
                    margin-bottom:30px;
                ">
                    {{ $product->description }}
                </p>
            @endif

            {{-- BUY BUTTON --}}
            <button style="
                padding:18px 40px;
                border-radius:999px;
                background:#111;
                color:#fff;
                border:none;
                font-size:14px;
                letter-spacing:.5px;
                cursor:pointer;
            ">
                შეძენა
            </button>

        </div>

    </div>
</div>

 


<script>
function setMainImage(el) {
    const main = document.getElementById('mainImage');
    main.style.opacity = 0;

    setTimeout(() => {
        main.src = el.src;
        main.style.opacity = 1;
    }, 120);

    document.querySelectorAll('.gallery-thumbs .thumb')
        .forEach(t => t.classList.remove('active'));

    el.classList.add('active');
}
</script>

@endsection
