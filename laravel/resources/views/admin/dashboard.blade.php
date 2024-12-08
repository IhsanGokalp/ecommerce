@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Admin Dashboard</h2>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Products</h5>
                    <p class="card-text display-4">{{ $productCount }}</p>
                    <a href="{{ route('admin.products') }}" class="btn btn-primary">Manage Products</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Orders</h5>
                    <p class="card-text display-4">{{ $orderCount }}</p>
                    <a href="{{ route('admin.orders') }}" class="btn btn-primary">View Orders</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <p class="card-text display-4">{{ $categoryCount }}</p>
                    <a href="{{ route('admin.categories') }}" class="btn btn-primary">Manage Categories</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection