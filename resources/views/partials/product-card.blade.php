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

        <a href="{{ route('product.full', $product->slug) }}" class="view-btn">
            <span>დათვალიერება</span>
        </a>
    </div>

    <div class="product-info">
        <b>{{ $product->title }}</b><br><br>

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

    <a href="{{ route('product.full', $product->slug) }}" class="product-link"></a>
</div>
