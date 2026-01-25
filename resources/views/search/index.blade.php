@extends('layouts.app')

@section('content')

<section class="container section">

    <h2 class="section-title decorated-title">
        <span>
            @if($q)
                ძიების შედეგები: “{{ $q }}”
            @else
                ძიება
            @endif
        </span>
    </h2>

    @if($products->count() === 0)
        <p style="margin-top:40px;text-align:center;">
            შედეგი ვერ მოიძებნა.
        </p>
    @else
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

        <div style="margin-top:40px;display:flex;justify-content:center;">
            {{ $products->links() }}
        </div>
    @endif

</section>

@endsection
