@extends('layouts.app')

@section('content')

<section class="slider" id="slider">

    <!-- LEFT ARROW -->
    <button class="slider-arrow left" id="prevSlide">
        ‹
    </button>

    <!-- RIGHT ARROW -->
    <button class="slider-arrow right" id="nextSlide">
        ›
    </button>

    <div class="slide active" style="background-image:url('{{ asset('images/slider1.png') }}')">
        <div class="slide-content">
            <h1 data-depth="0.4"><span> თანამედროვე დიზაინი</span></h1>
            <p data-depth="0.7"><span>კომფორტული და ელეგანტური</span></p>
        </div>
    </div>

    <div class="slide" style="background-image:url('{{ asset('images/slide2.jpg') }}')">
        <div class="slide-content">
         <h1 data-depth="0.4"><span> პრემიუმ ხარისხი</span></h1>
            <p data-depth="0.7"><span>ყოველთვის საიმედო</span></p>
        </div>
    </div>

    <div class="slide" style="background-image:url('{{ asset('images/slide3.jpg') }}')">
        <div class="slide-content">
              <h1 data-depth="0.4"><span>მინიმალიზმი და სიზუსტე</span></h1>
            <p data-depth="0.7"><span>less is more</span></p>
        </div>
    </div>


    <!-- Pagination dots -->
<div class="slider-dots" id="sliderDots"></div>
</section>




<section class="container section">
    <h2 class="section-title decorated-title"><span> ახალი პროდუქცია </span></h2>

    <div class="products-grid">

    <!-- Row 1 -->
@foreach($products as $product)
    <div class="product-card">

        <div class="product-image">
            @php
    $mainImage = $product->images->firstWhere('is_main', 1)
                 ?? $product->images->first();
@endphp

<img
    src="{{ $mainImage
            ? asset('storage/'.$mainImage->image)
            : asset('images/featured.jpg') }}"
    alt="{{ $product->title }}">


            <a href="{{ route('product.full', $product->id) }}"
               class="view-btn">
                <span>დათვალიერება</span>
            </a>
        </div>

        <div class="product-info">
            <h3>
                <span>{{ $product->title }}</span>
            </h3>
            <p class="price">
                ₾ {{ number_format($product->price, 2) }}
            </p>
        </div>

        {{-- clickable whole card --}}
        <a href="{{ route('product.full', $product->id) }}"
           class="product-link"></a>

    </div>
@endforeach


<div class="view-all-wrap">
    <a href="{{ route('products') }}" class="view-all-btn">
        <span>ყველა პროდუქტის ნახვა →</span>
    </a>
</div>


</div>

</section>

@endsection
