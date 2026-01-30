@extends('layouts.app')

@section('seo_title', $product->title)

@if(!empty($product->description))
    @section(
        'seo_description',
        \Illuminate\Support\Str::limit(strip_tags($product->description), 160)
    )
@endif

@section(
    'seo_image',
    $product->images->first()
        ? asset('storage/'.$product->images->first()->image)
        : asset('company_logo/kiaro.ge.png')
)


@section('content')
<div class="container" style="position: relative; top:-50px;">

   <div class="product-layout">


        {{-- LEFT: IMAGE --}}

        @php
        $images = $product->images;
        $mainImage = $images->firstWhere('is_main', 1) ?? $images->first();
        @endphp

        <div class="gallery-box">

            <!-- MAIN IMAGE -->
            <div class="gallery-main">
    <img
        id="mainImage"
        src="{{ asset('storage/'.$mainImage->image) }}"
        alt="{{ $product->title }}"
        onclick="openImageLightbox(this.src)"
        style="cursor: zoom-in;"
    >
</div>


{{-- IMAGE LIGHTBOX --}}
<div id="imageLightbox" class="image-lightbox" onclick="closeImageLightbox(event)">
    <span class="lightbox-close" onclick="closeImageLightbox()">×</span>

    <button class="lightbox-arrow left"
            onclick="prevLightboxImage(event)">
        ‹
    </button>

    <img id="lightboxImage">

    <button class="lightbox-arrow right"
            onclick="nextLightboxImage(event)">
        ›
    </button>
</div>


            <!-- COLOR PICKER -->
            @if($images->whereNotNull('color_name')->count())
            <div class="color-picker">
                @foreach($images as $img)
                @if(!empty($img->color_name))
                <button
                    class="color-dot"
                    style="background: {{ $img->color_hex }}"
                    onclick="
        setImageByColor('{{ asset('storage/'.$img->image) }}', this);
        document.getElementById('selectedColorName').value = '{{ $img->color_name }}';
        document.getElementById('selectedColorHex').value = '{{ $img->color_hex }}';
    ">
                </button>

                @endif
                @endforeach
            </div>
            @endif


            @php
            $hasColors = $images->whereNotNull('color_name')->count() > 0;
            @endphp

            <!-- THUMBNAILS (only if NO colors exist) -->
            @if(!$hasColors && $images->count() > 1)
            <div class="gallery-thumbs">
                @foreach($images as $img)
                <img
                    src="{{ asset('storage/'.$img->image) }}"
                    onclick="setMainImage(this)"
                    class="thumb {{ $img->is_main ? 'active' : '' }}">
                @endforeach
            </div>
            @endif


        </div>



        {{-- RIGHT: INFO --}}
        <div>

          <h1 class="product-title">

             <span> {{ $product->title }} </span>
            </h1>

           @if($product->hasDiscount())
    <div class="product-price">
        <span class="price-old">{{ number_format($product->price, 2) }} ₾</span>
        <span class="price-new">{{ number_format($product->discount, 2) }} ₾</span>
    </div>
@else
    <div class="product-price">
        <span class="price-new">{{ number_format($product->price, 2) }} ₾</span>
    </div>
@endif


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
                <br>
               <span> {!!  $product->description !!} </span>
            </p>
            @endif

            <br><br>

            {{-- ORDER BUTTON --}}
            <button
                onclick="openOrderModal()"
                style="
        padding:18px 40px;
        border-radius:999px;
        background:#111;
        color:#fff;
        border:none;
        font-size:14px;
        letter-spacing:.5px;
        cursor:pointer;
    ">
                შეკვეთა
            </button>


        </div>

    </div>
</div>










{{-- ORDER MODAL --}}
<div id="orderModal" class="order-modal">
    <div class="order-modal-content">
        <button class="order-close" onclick="closeOrderModal()">×</button>

        <h3 style="margin-bottom:20px;">შეკვეთის ფორმა</h3>

        <form id="orderForm" action="{{ route('order.send') }}" method="POST">
    @csrf

    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="product_url" value="{{ url()->current() }}">
    <input type="hidden" name="color_name" id="selectedColorName">
    <input type="hidden" name="color_hex" id="selectedColorHex">

    <label>სახელი *</label>
    <input name="name" required>

    <label>Email</label>
    <input name="email" type="email">

    <label>ტელეფონი *</label>
    <input name="phone" required>

    <label>მისამართი *</label>
    <textarea name="address" required></textarea>

<button type="submit" id="orderSubmitBtn">
    <span class="btn-text">გაგზავნა</span>
    <span class="btn-spinner" style="display:none;"></span>
</button>

    <p id="orderSuccess" style="display:none;color:green;margin-top:15px;">
        თქვენი შეკვეთა გაიგზავნა ✔
    </p>
</form>



        
    </div>
</div>




{{-- IMAGE LIGHTBOX --}}
<div id="imageLightbox" class="image-lightbox" onclick="closeImageLightbox(event)">
    <span class="lightbox-close" onclick="closeImageLightbox()">×</span>
    <img id="lightboxImage">
</div>


<script>
    function setMainImage(el) {
        const main = document.getElementById('mainImage');
        main.style.opacity = 0;

        setTimeout(() => {
            main.src = el.src;
            main.style.opacity = 1;
        }, 120);

        document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
        el.classList.add('active');

        document.querySelectorAll('.color-dot').forEach(c => c.classList.remove('active'));
    }

    function setImageByColor(src, btn) {
        const main = document.getElementById('mainImage');
        main.style.opacity = 0;

        setTimeout(() => {
            main.src = src;
            main.style.opacity = 1;
        }, 120);

        document.querySelectorAll('.color-dot').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('.thumb').forEach(t => {
            t.classList.toggle('active', t.src === src);
        });
    }
</script>



<script>
/* ===========================
   ORDER MODAL — GUARANTEED
=========================== */

function openOrderModal() {
    const modal = document.getElementById('orderModal');
    if (!modal) {
        console.error('orderModal not found');
        return;
    }
    modal.style.display = 'flex';
}

function closeOrderModal() {
    const modal = document.getElementById('orderModal');
    if (!modal) return;
    modal.style.display = 'none';
}

// click outside to close
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('orderModal');
    if (!modal) return;

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeOrderModal();
        }
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('orderForm');
    const submitBtn = document.getElementById('orderSubmitBtn');
    const spinner = submitBtn.querySelector('.btn-spinner');
    const text = submitBtn.querySelector('.btn-text');
    const success = document.getElementById('orderSuccess');

    let isSubmitting = false;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        // prevent double submit
        if (isSubmitting) return;
        isSubmitting = true;

        // lock UI
        submitBtn.disabled = true;
        spinner.style.display = 'inline-block';
        text.style.display = 'none';

        try {
            const response = await fetch("{{ route('order.send') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            });

            if (!response.ok) {
                throw new Error('Mail failed');
            }

            // SUCCESS (mail sent)
            success.style.display = 'block';
            form.reset();

            setTimeout(() => {
                success.style.display = 'none';
                closeOrderModal();
            }, 1500);

        } catch (err) {
            alert('შეკვეთის გაგზავნა ვერ მოხერხდა. სცადეთ ხელახლა.');
        } finally {
            // unlock UI
            isSubmitting = false;
            submitBtn.disabled = false;
            spinner.style.display = 'none';
            text.style.display = 'inline';
        }
    });
});
</script>

<script>
document.getElementById('orderModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeOrderModal();
    }
});
</script>


<script>
    window.productImages = @json(
        $images->values()->map(fn($img) => asset('storage/'.$img->image))
    );
</script>

<script>
let currentLightboxIndex = 0;

function openImageLightbox(src) {
    const lightbox = document.getElementById('imageLightbox');
    const img = document.getElementById('lightboxImage');

    currentLightboxIndex = window.productImages.indexOf(src);
    if (currentLightboxIndex === -1) currentLightboxIndex = 0;

    img.src = window.productImages[currentLightboxIndex];
    lightbox.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // hide arrows if only one image
    lightbox.classList.toggle(
        'single',
        window.productImages.length <= 1
    );
}

function closeImageLightbox(e) {
    if (e && e.target.tagName === 'IMG') return;

    const lightbox = document.getElementById('imageLightbox');
    lightbox.style.display = 'none';
    document.body.style.overflow = '';
}

function prevLightboxImage(e) {
    e.stopPropagation();
    currentLightboxIndex =
        (currentLightboxIndex - 1 + window.productImages.length)
        % window.productImages.length;

    document.getElementById('lightboxImage').src =
        window.productImages[currentLightboxIndex];
}

function nextLightboxImage(e) {
    e.stopPropagation();
    currentLightboxIndex =
        (currentLightboxIndex + 1)
        % window.productImages.length;

    document.getElementById('lightboxImage').src =
        window.productImages[currentLightboxIndex];
}

// keyboard navigation
document.addEventListener('keydown', (e) => {
    const lightbox = document.getElementById('imageLightbox');
    if (lightbox.style.display !== 'flex') return;

    if (e.key === 'ArrowLeft') prevLightboxImage(e);
    if (e.key === 'ArrowRight') nextLightboxImage(e);
    if (e.key === 'Escape') closeImageLightbox();
});
</script>




@endsection