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
  margin:50px 20px;
}

.left-panel {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding:0 100px
}

.thumbnails {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 20px;
}

.thumb {
  width: 50px;
  height: 50px;
  border: 2px solid #ccc;
  border-radius: 5px;
  cursor: pointer;
}

.thumb.active {
  border-color: #007aff;
}

.main-image img {
  width: 450px;
  height:400px;
  border-radius: 10px;
}

.right-panel {
  flex: 2;
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin:50px 10px 0px 10px;
  
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
  color:rgb(7, 186, 45);
}

.original-price {
  /* text-decoration: line-through; */
  color:rgb(55, 54, 54);
}

.discount {
  color: #388e3c;
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

.add-to-cart,
.buy-now {
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  font-weight: bold;
  border-radius: 5px;
}

.add-to-cart {
  background-color: #fff;
  border: 1px solid #007aff;
  color: #007aff;
}

.buy-now {
  background-color: #ff9f00;
  color: white;
}

.delivery input {
  padding: 8px;
  width: 200px;
  margin-right: 10px;
}

.delivery button {
  padding: 8px 12px;
}

.stock-status {
  color: red;
  font-size: 14px;
  margin-top: 6px;
}
.quantity-section {
  margin: 15px 0;
  font-size: 16px;
}

.quantity-controls {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-top: 5px;
}

.quantity-controls button {
  width: 32px;
  height: 32px;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
  border: 1px solid #ccc;
  background-color: white;
  border-radius: 4px;
}

.quantity-controls input {
  width: 40px;
  text-align: center;
  font-size: 16px;
  padding: 4px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

</style>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<body style="background-color: #ECEFCA;">
    @extends('app.layout-frontend.master')
    @section('content')
  <div class="containerr">
    <div class="left-panel">
      <!-- <div class="thumbnails">
        <img src="main.png" alt="Boult Image" class="thumb active" />
        <img src="thumb2.png" alt="Thumb 2" class="thumb" />
        <img src="thumb3.png" alt="Thumb 3" class="thumb" />
        <img src="thumb4.png" alt="Thumb 4" class="thumb" />
      </div> -->
      <div class="main-image">
        <img src="/Upload/Products/{{basename($product->image)}}" alt="NO Image" />
      </div>
    </div>

    <div class="right-panel">
      <h2 class="title">{{$product->name}}</h2>
      <h2 class="title">{{$product->description}}</h2>
      <div class="ratings">⭐ 4.1 | 1,84,844 Ratings & 10,922 Reviews <span class="assured">✓ Assured</span></div>
      <div class="price">
        <span class="current-price">{{$product->price}}</span>
        <span class="original-price"></span>
        <span class="discount"></span>
      </div>
      <div class="offers">
        <p><strong>Bank Offer:</strong> 5% Cashback on Axis Bank Credit Card</p>
        <p><strong>Bank Offer:</strong> 10% off up to ₹1,000 on Axis Bank Credit Card</p>
        <p><strong>Bank Offer:</strong> 10% off on BOBCARD EMI Transactions</p>
        <p><strong>Special Price:</strong> Get extra 9% off</p>
      </div>
      
      <div class="buttons">
       <a href="/buynow/{{$product->id}}"><button class="buy-now" >BUY NOW</button></a>
      </div>
      <div class="delivery">
      
      </div>
    </div>
  </div>
  

    @endsection
</body>