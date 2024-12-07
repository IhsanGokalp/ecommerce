@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Products</h5>
                    <p class="card-text">Total: {{ $productCount }}</p>
                    <a href="{{ route('admin.products') }}" class="btn btn-primary">Manage Products</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Orders</h5>
                    <p class="card-text">Total: {{ $orderCount }}</p>
                    <a href="{{ route('admin.orders') }}" class="btn btn-primary">Manage Orders</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Categories</h5>
                    <p class="card-text">Total: {{ $categoryCount }}</p>
                    <a href="{{ route('admin.categories') }}" class="btn btn-primary">Manage Categories</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection