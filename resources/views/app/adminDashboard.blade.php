@extends('app.layout-backend.master')
@section('content')
<div class="container-fluid mt-4">
    <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card shadow rounded-4 border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-box fa-2x text-primary mb-3"></i>
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text fs-4 fw-bold">{{ $productscount }}</p>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card shadow rounded-4 border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-2x text-success mb-3"></i>
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text fs-4 fw-bold">{{ $userscount }}</p>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card shadow rounded-4 border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line fa-2x text-warning mb-3"></i>
                    <h5 class="card-title">Sales Today</h5>
                    <p class="card-text fs-4 fw-bold">₹5,200</p>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-4">
            <div class="card shadow rounded-4 border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-layer-group fa-2x text-info mb-3"></i>
                    <h5 class="card-title">Categories</h5>
                    <p class="card-text fs-4 fw-bold">{{$categoriescount}}</p>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="col-md-4">
            <div class="card shadow rounded-4 border-0 h-100">
                <div class="card-body text-center">
                    <i class="fas fa-truck fa-2x text-danger mb-3"></i>
                    <h5 class="card-title">Pending Orders</h5>
                    <p class="card-text fs-4 fw-bold">7</p>
                </div>
            </div>
        </div>

        <!-- Card 6 -->
        
    </div>
</div>

@endsection