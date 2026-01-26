@extends('layouts.app')

@section('content')

<section class="container section">
<h1>
  <i class="bi bi-bookmark-heart"></i>   <span> 
    @if($currentCategory)
       @if($currentCategory && $currentCategory->parent)
    {{ $currentCategory->parent->name }}
    <i class="bi bi-arrow-right mx-1"></i>
    {{ $currentCategory->name }}
@elseif($currentCategory)
    {{ $currentCategory->name }}
@endif

    @else
        ყველა პროდუქტი
    @endif </span>
</h1>




    @if($products->count() === 0)
        <p style="margin-top:40px;text-align:center;">
            პროდუქცია ვერ მოიძებნა.
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
        </div>

        {{-- PAGINATION --}}
        <div style="margin-top:40px;display:flex;justify-content:center;">
            {{ $products->withQueryString()->links() }}
        </div>
    @endif
</section>

@endsection
