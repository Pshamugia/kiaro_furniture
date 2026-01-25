<h2>🛒 New Order – Kiaro</h2>

<p><strong>Name:</strong> {{ $name }}</p>
<p><strong>Email:</strong> {{ $email ?? 'Not provided' }}</p>
<p><strong>Phone:</strong> {{ $phone }}</p>
<p><strong>Address:</strong><br>{{ $address }}</p>

<hr>

<p><strong>Product link:</strong><br>
<a href="{{ $product_url }}">{{ $product_url }}</a>
</p>

<hr>

<p><strong>Selected Color:</strong></p>

@if($color_name || $color_hex)
    <p>
        Name: {{ $color_name ?? '—' }} <br>
        Hex: {{ $color_hex ?? '—' }}
    </p>

    @if($color_hex)
        <div style="
            width:40px;
            height:40px;
            border-radius:50%;
            background:{{ $color_hex }};
            border:1px solid #ccc;
        "></div>
    @endif
@else
    <p>No color selected</p>
@endif
