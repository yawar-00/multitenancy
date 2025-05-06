<style>
 .card-wrapper {
    display: flex;
    justify-content: center;
    padding: 40px 20px;
}

.card-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 150px;
    /* max-width: 800px; optional: limit total width */
}

.card {
    background-color: #f7f7f7;
    border-radius: 10px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
.custom-card {
    width: 18rem;
    border: none;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    background-color: #fff;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin: 10px;
}

.custom-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
}

.product-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
    cursor: pointer;
}

.no-img {
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #eee;
    color: #666;
    font-weight: bold;
}

.card-body {
    padding: 1rem;
}

.card-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.4rem;
}

.card-price {
    font-size: 1.1rem;
    color: #2d7d46;
    font-weight: 700;
    margin-bottom: 0.8rem;
}

.card-text {
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 1rem;
}

#btn-shop {
    display: inline-block;
    background-color: #007bff;
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

#btn-shop:hover {
    background-color: #0056b3;
}



</style>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<body style="background-color:#ECEFCA">
    @extends('app.layout-frontend.master')
    @section('content')
<div class="card-wrapper">
  <div class="card-grid">
    @foreach($products as $product)
    <div class="card custom-card">
    @if($product->image)
        <img src="/Upload/Products/{{ basename($product->image) }}" class="product-img" alt="Image">
    @else
        <div class="no-img">No Image</div>
    @endif

    <div class="card-body">
        <h5 class="card-title">{{$product->name}}</h5>
        <h4 class="card-price">₹{{$product->price}}</h4>
        <p class="card-text">{{$product->description}}</p>
        <a href="/shopProduct/{{$product->id}}" class="btn" id="btn-shop">Shop now</a>
    </div>
</div>
@endforeach
</div>
</div>
@endsection
</body>
