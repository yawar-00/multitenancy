@extends('app.layout-frontend.master')
@vite(['resources/css/app.css', 'resources/js/app.js'])

@section('content')
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
  }

  .containerr {
    display: flex;
    gap: 30px;
    background-color: white;
    padding: 50px 20px;
    border-radius: 10px;
    margin: 50px 20px;
  }

  .left-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 100px;
  }

  .main-image img {
    width: 450px;
    height: 400px;
    border-radius: 10px;
  }

  .right-panel {
    flex: 2;
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin: 50px 10px 0px 10px;
  }

  .title {
    font-size: 20px;
    font-weight: bold;
    line-height: 1.4;
  }

  .ratings {
    color: #4caf50;
    font-size: 14px;
  }

  .assured {
    background-color: #eee;
    padding: 2px 6px;
    margin-left: 8px;
    font-size: 12px;
    border-radius: 4px;
  }

  .price {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
  }

  .current-price {
    font-weight: bold;
    color: rgb(7, 186, 45);
  }

  .offers p {
    font-size: 14px;
    margin: 4px 0;
  }

  .buttons {
    margin: 10px 0;
    display: flex;
    gap: 10px;
  }

  .buy-now {
    padding: 10px 20px;
    background-color: #ff9f00;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
  }

  /* Reviews Section */
  #reviews-section {
    background-color: white;
    margin: 40px 20px;
    padding: 30px;
    border-radius: 10px;
  }

  #reviews-section h3 {
    font-size: 20px;
    margin-bottom: 20px;
    border-bottom: 2px solid #f1f1f1;
    padding-bottom: 10px;
  }

  .review-card {
    border-bottom: 1px solid #ddd;
    padding: 15px 0;
  }

  .review-card strong {
    font-size: 16px;
    display: block;
    margin-bottom: 5px;
  }

  .review-stars {
    color: #f39c12;
    margin-bottom: 5px;
  }

  .review-card p {
    font-size: 14px;
    color: #333;
  }

  .no-comments {
    color: #777;
    font-style: italic;
  }

  /* Review form */
  .review-form-container {
    margin-top: 30px;
    background-color: #fafafa;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
  }

  .review-form-container h4 {
    font-size: 18px;
    margin-bottom: 15px;
  }

  .review-form-container input,
  .review-form-container textarea,
  .review-form-container select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
  }

  .review-form-container button {
    background-color: #007aff;
    color: white;
    border: none;
    padding: 10px 16px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
  }

  .review-form-container button:hover {
    background-color: #005ecc;
  }

  /* Review images styling */
  .review-images {
    display: flex;
    gap: 10px;
    margin-top: 10px;
  }

  .review-images img {
    width: 80px;
    height: 80px;
    border-radius: 6px;
    object-fit: cover;
    border: 1px solid #ccc;
  }
</style>

<body style="background-color: #ECEFCA;">
  <div class="containerr">
    <div class="left-panel">
      <div class="main-image">
        <img src="/Upload/Products/{{ basename($product->image) }}" alt="NO Image" />
      </div>
    </div>

    <div class="right-panel">
      <h2 class="title">{{ $product->name }}</h2>
      <h2 class="title">{{ $product->description }}</h2>
      <div class="ratings">⭐ 4.1 | 1,84,844 Ratings & 10,922 Reviews <span class="assured">✓ Assured</span></div>
      <div class="price">
        <span class="current-price">₹{{ $product->price }}</span>
      </div>
      <div class="offers">
        <p><strong>Bank Offer:</strong> 5% Cashback on Axis Bank Credit Card</p>
        <p><strong>Bank Offer:</strong> 10% off up to ₹1,000 on Axis Bank Credit Card</p>
        <p><strong>Bank Offer:</strong> 10% off on BOBCARD EMI Transactions</p>
        <p><strong>Special Price:</strong> Get extra 9% off</p>
      </div>
      <div class="buttons">
        <a href="/buynow/{{ $product->id }}">
          <button class="buy-now">BUY NOW</button>
        </a>
      </div>
    </div>
  </div>

  <!-- Reviews Section -->
  <div id="reviews-section">
    <h3>Customer Reviews</h3>

    @if($reviews->isEmpty())
      <p class="no-comments">No reviews yet</p>
    @else
      <div id="reviews-list">
        @foreach($reviews as $review)
          <div class="review-card">
            <strong>{{ $review->title }}</strong>
            <div class="review-stars">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</div>
            <p>{{ $review->content }}</p>

            <!-- Display review images -->
            @if($review->images->isNotEmpty())
              <div class="review-images">
                @foreach($review->images as $image)
                  <img src="/Upload/ReviewImages/{{ basename($image->image_path) }}" alt="Review Image">
                @endforeach
              </div>
            @endif
          </div>
        @endforeach
      </div>
    @endif

    @auth
    <div class="review-form-container">
      <h4>Add Your Review</h4>
      <form method="POST" action="{{ url('/reviews/store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="title" value="{{ Auth::user()->name }}">
        <textarea name="content" placeholder="Write your review..." required></textarea>
        <select name="rating" required>
          <option value="">Select Rating</option>
          @for($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}">{{ $i }} Star</option>
          @endfor
        </select>

        <!-- Allow users to upload multiple images -->
        <input type="file" name="review_images[]" multiple accept="image/*">
        
        <button type="submit">Submit Review</button>
      </form>
    </div>
    @endauth
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"></script>
</body>
@endsection
