@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Our Products</h1>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('images/placeholder.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                        <p class="card-text"><strong>Price: ${{ number_format($product->price, 2) }}</strong></p>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $products->links() }}
</div>
@endsection