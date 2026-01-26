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

                @if(!empty($product->slug))
                <a href="{{ route('product.full', $product->slug) }}"
                    class="view-btn">
                    <span>დათვალიერება</span>
                </a>
                @endif
            </div>

       
   

            <div class="product-info">
                  <span> <b> {{ $product->title }} </b> </span> <br><br>
    @if($product->hasDiscount())
        <span class="price-old">
            {{ number_format($product->price, 2) }} ₾
        </span>
        <span class="price-new">
            {{ number_format($product->discount, 2) }} ₾
        </span>
    @else
        <span class="price-new">
            {{ number_format($product->price, 2) }} ₾
        </span>
    @endif
</div>


            {{-- clickable whole card --}}
            <a href="{{ route('product.full', $product->slug) }}"
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

@foreach($categories as $category)

    {{-- CATEGORY HAS SUBCATEGORIES --}}
    @if($category->children->count())

        @foreach($category->children as $child)
            @if($child->products->count())

            <section class="container section category-section">

                {{-- ✅ ONLY SUBCATEGORY NAME --}}
                <h2 class="section-title decorated-title">
                    <span>{{ $child->name }}</span>
                </h2>

                <div class="products-grid">
                    @foreach($child->products as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="view-all-wrap">
                    <a href="{{ route('products', $child->slug) }}" class="view-all-btn">
                        <span>ყველას ნახვა →</span>
                    </a>
                </div>

            </section>

            @endif
        @endforeach

    {{-- CATEGORY HAS NO SUBCATEGORIES --}}
    @elseif($category->products->count())

        <section class="container section category-section">

            <h2 class="section-title decorated-title">
                <span>{{ $category->name }}</span>
            </h2>

            <div class="products-grid">
                @foreach($category->products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <div class="view-all-wrap">
                <a href="{{ route('products', $category->slug) }}" class="view-all-btn">
                    <span>ყველას ნახვა →</span>
                </a>
            </div>

        </section>

    @endif

@endforeach



@endsection