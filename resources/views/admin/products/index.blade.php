@extends('admin.layout')

@section('content')
<div class="admin-card">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Products</h2>

        
        <a href="{{ route('admin.products.create') }}" class="btn btn-dark">+ New Product</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>

                <td>
                    @if($product->photo1)
                        <img src="{{ asset('storage/'.$product->photo1) }}" width="60" style="border-radius:8px;">
                    @else
                        —
                    @endif
                </td>

                <td>{{ $product->title }}</td>
                <td>{{ $product->category?->name }}</td>
                <td>₾ {{ number_format($product->price, 2) }}</td>

                <td style="text-align:right;">
                    <a class="btn" href="{{ route('admin.products.edit', $product) }}">Edit</a>

                    <form action="{{ route('admin.products.destroy', $product) }}"
                          method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger"
                                onclick="return confirm('Delete this product?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No products yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:20px;">
        {{ $products->links() }}
    </div>

</div>
@endsection
