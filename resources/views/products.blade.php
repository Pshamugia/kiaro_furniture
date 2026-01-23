@extends('layouts.app')

@section('content')

<section class="container section">
    <h2 class="section-title decorated-title"><span> ჩვენი პროდუქცია</span></h2>
    <div class="products-grid">
        @for($i = 0; $i < 9; $i++)
            <div class="product-card">
    <div class="product-image">
        <img src="{{ asset('images/featured.jpg') }}" alt="Luxury Sofa">
        <a href="{{ route('products') }}" class="view-btn"><span>დათვალიერება</span></a>
    </div>
    <div class="product-info">
        <h3><span>საცდელი სათაური</span></h3>
        <p class="price">₾ 1,200</p>
    </div>
</div>
        @endfor
    </div>
</section>

@endsection
