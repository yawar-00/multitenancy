<style>
    <style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
  }

  .container {
    max-width: 1000px;
    margin: 50px auto;
    background-color: #fff;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
  }

  h2.text-center {
    text-align: center;
    margin-bottom: 30px;
    color: #007bff;
  }

  .row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 20px;
  }

  .col-image, .col-details {
    flex: 1;
    min-width: 280px;
  }

  .col-image img {
    max-width: 100%;
    max-height: 350px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid #ddd;
    box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
  }

  .col-details h2,
  .col-details h4 {
    margin-bottom: 15px;
    color: #333;
  }

  .col-details p {
    color: #666;
    font-size: 16px;
    margin-bottom: 20px;
  }

  .quantity-wrapper {
    display: flex;
    align-items: center;
    margin: 20px 0;
  }

  .quantity-wrapper button {
    font-size: 20px;
    padding: 10px 20px;
    cursor: pointer;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    border-radius: 6px;
    transition: background-color 0.2s ease;
  }

  .quantity-wrapper button:hover {
    background-color: #ddd;
  }

  .quantity-wrapper input {
    width: 60px;
    height: 40px;
    text-align: center;
    font-size: 18px;
    margin: 0 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #fff;
  }

  .total-price {
    font-size: 22px;
    color: green;
    margin-top: 20px;
  }

  #rzp-button {
    background-color: #007bff;
    color: #fff;
    padding: 12px 25px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 30px;
    transition: background-color 0.3s ease;
  }

  #rzp-button:hover {
    background-color: #0056b3;
  }

  @media (max-width: 768px) {
    .row {
      flex-direction: column;
    }
  }
</style>

</style>
<h2 class="text-center">Product Details</h2>

<div class="container">
  <div class="row">
    <div class="col-image">
      <img src="{{ asset($product->image) }}" alt="Product Image">
    </div>
    <div class="col-details">
      <h2>Product Name: {{ $product->name }}</h2>
      <p>Product Details: {{ $product->description }}</p>
      <h4>Price (per item): ₹<span id="unit-price">{{ $product->price }}</span></h4>

      <div class="quantity-wrapper">
        <button onclick="decrementQty()">−</button>
        <input type="text" id="quantity" value="1" readonly>
        <button onclick="incrementQty()">＋</button>
      </div>

      <div class="total-price">
        Total Price: ₹<span id="total-price">{{ $product->price }}</span>
      </div>

      <form action="{{ url('/razorpay')}}" method="POST" id="payment-form">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="quantity" id="form-quantity" value="1">
        <input type="hidden" name="amount" id="form-amount" value="{{ $product->price * 100 }}">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">

        <button type="button" id="rzp-button">Pay Now</button>
      </form>
    </div>
  </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  const qtyInput      = document.getElementById('quantity');
  const totalDisplay  = document.getElementById('total-price');
  const unitPrice     = parseFloat(document.getElementById('unit-price').textContent);
  const btnPay        = document.getElementById('rzp-button');
  const formQuantity  = document.getElementById('form-quantity');
  const formAmount    = document.getElementById('form-amount');

  function updateTotals() {
    const qty   = parseInt(qtyInput.value, 10);
    const total = qty * unitPrice;
    totalDisplay.textContent = total.toFixed(2);
    formQuantity.value = qty;
    formAmount.value   = Math.round(total * 100); // paise, integer
  }

  function incrementQty() {
    qtyInput.value = parseInt(qtyInput.value,10) + 1;
    updateTotals();
  }

  function decrementQty() {
    if (qtyInput.value > 1) {
      qtyInput.value = parseInt(qtyInput.value,10) - 1;
      updateTotals();
    }
  }

  btnPay.onclick = function(e) {
    e.preventDefault();
    const amountPaise = parseInt(formAmount.value, 10);

    const options = {
      key:        "{{ config('services.razorpay.key') }}",
      amount:     amountPaise,
      currency:   "INR",
    name: "XYZ Store",
      description: "Payment for {{ $product->name }}",
      
      handler: function (response) {
        // fill hidden form fields and submit
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpay_order_id').value   = response.razorpay_order_id;
        document.getElementById('razorpay_signature').value  = response.razorpay_signature;
        document.getElementById('payment-form').submit();
      },
      prefill: {
        name: "XYZ STORE",
        email: "{{ Auth::user()->email ?? '' }}",
      },
      theme: {
        color: "#3399cc"
      }
    };
    const rzp = new Razorpay(options);
    rzp.open();
  };
</script>

