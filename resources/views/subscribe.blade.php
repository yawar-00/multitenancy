<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Pricing Plans</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.bunny.net" />
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

  <style>
    body {
      background: linear-gradient(135deg, #0d0d0d, #1a1a1a);
      color: #fff;
      font-family: 'Poppins', sans-serif;
      padding-top: 50px;
      padding-bottom: 50px;
    }
    .card {
      background: #121212;
      border: 1px solid #2c2c2c;
      border-radius: 20px;
      transition: all 0.4s ease;
      color: #ffffff;
    }
    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 20px rgba(0, 123, 255, 0.4);
      border-color: #007bff;
    }
    .price {
      font-size: 2.8rem;
      font-weight: bold;
      margin: 20px 0;
    }
    .feature-list li {
      margin-bottom: 12px;
    }
    .btn-custom {
      border-radius: 50px;
      font-weight: bold;
      padding: 10px 25px;
      margin-top: 20px;
      transition: all 0.3s;
    }
    .btn-custom-primary {
      background: linear-gradient(90deg, #00c6ff, #0072ff);
      color: white;
      border: none;
    }
    .btn-custom-primary:hover {
      background: linear-gradient(90deg, #0072ff, #00c6ff);
      color: white;
    }
    .badge-popular {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #007bff;
      color: #fff;
      font-size: 0.75rem;
      padding: 5px 10px;
      border-radius: 20px;
    }
    .card-title {
      margin-top: 10px;
      font-size: 1.5rem;
      font-weight: 600;
    }
    .feature-list li::before {
      content: "\f058";
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      margin-right: 10px;
      color: #00ff00;
      font-size: 18px;
    }
    .dropdown{
      border:1px solid grey;
      border-radius:7px;
    }
    .dropdown:hover{
      
      box-shadow: 0 0 20px rgba(0, 123, 255, 0.4);
      border-color: #007bff;
    }
    .dropdown-item{
      color:#fff;
    }
    .dropdown-item:hover{
        background-color:grey
    }
    .dropdown-menu{
      background-color:rgb(32, 36, 32);
      color:#fff;
   
    }
    .dashboard:hover{
      color:rgb(21, 122, 230) !important;
    }
  </style>
</head>

<body>

<div class="d-flex justify-content-center align-items-center bg-light text-dark">
  @if (Route::has('login'))
    <div class="position-absolute d-flex align-items-center top-0 end-0 p-3 text-end z-3">
      @auth
      @if(Auth::user()->type!='user')
        <a href="{{ url('/tanent') }}" class="fw-semibold text-secondary text-decoration-none me-2 dashboard">Dashboard</a>
      @endif
      <div class="d-none d-sm-flex align-items-center ms-3">
  <div class="dropdown">
    <button class="btn btn-white dropdown-toggle d-flex align-items-center text-secondary"
            type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      <span>{{ Auth::user()->name }}</span>
    </button>

    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
      <li>
        <a class="dropdown-item" href="{{ route('profile.edit') }}">
          {{ __('Profile') }}
        </a>
      </li>
      <li>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-item text-start"
                  onclick="event.preventDefault(); this.closest('form').submit();">
            {{ __('Log Out') }}
          </button>
        </form>
      </li>
    </ul>
  </div>
</div>
      @else
        <a href="{{ route('login') }}" class="fw-semibold text-secondary text-decoration-none me-4">Log in</a>
        @if (Route::has('register'))
          <a href="{{ route('register') }}" class="fw-semibold text-secondary text-decoration-none me-3">Register</a>
        @endif
      @endauth
    </div>
  @endif
</div>

<div class="container text-center mt-5">
  <h2 class="fw-bold mb-5">Choose your plan</h2>

  <div class="row g-4  justify-content-center">
    @foreach ($plan as $item)
      <div class="col-md-4">
        <div class="card p-4 position-relative">

          @if ($item->is_popular)
            <div class="badge-popular">Most Popular</div>
          @endif

          <div class="card-body">
            <h5 class="card-title">{{ $item->name }}</h5>
            <div class="price">
              <i class="fa-solid fa-indian-rupee-sign"></i>{{ number_format($item->price) }}
              <span class="fs-6">/mo</span>
            </div>

            <h6 class="mt-4 mb-2">Features / Benefits</h6>
            <ul class="list-unstyled feature-list">
              <li>{{ $item->max_websites }} Websites</li>
              <li>{{ $item->storage_limit }} Products Listening</li>
              @foreach ($item->features as $feature)
                @foreach (explode("\n", $feature->description) as $line)
                  <li>{{ $line }}</li>
                @endforeach
              @endforeach
            </ul>

            <button 
              class="btn {{ $item->is_popular ? 'btn-custom btn-custom-primary' : 'btn-outline-light btn-custom' }}"
              data-bs-toggle="modal"
              data-bs-target="#planModal"
              data-name="{{ $item->name }}"
              data-price="{{ number_format($item->price, 2) }}"
              data-id="{{ $item->id }}">
              Get started
            </button>

          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
 
  <div class="modal-dialog modal-dialog-centered">
    @if(!Auth::user())

    <div class="modal-body d-flex justify-content-between align-items-center px-4 py-3 bg-dark text-white rounded">
  <div class="d-flex align-items-center gap-3">
    <i class="bi bi-exclamation-triangle-fill text-warning fs-4"></i>
    <h5 class="modal-title fw-semibold mb-0" id="planModalLabel">Please log in first</h5>
  </div>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
    @else
    <form method="POST" action="{{ route('planPayment') }}" id="payment-form" class="modal-content bg-dark text-white rounded-4 border border-primary shadow-lg">
      @csrf
      <div class="modal-header border-bottom border-secondary">
        <h5 class="modal-title fw-bold text-white" id="planModalLabel">🚀 Plan Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" name="name" class="form-control bg-dark text-white border-secondary" id="name" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control bg-dark text-white border-secondary" id="email" required>
        </div>

        <div class="mb-3">
          <label for="domain" class="form-label">Domain Name</label>
          <input type="text" name="domain" class="form-control bg-dark text-white border-secondary" id="domain" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control bg-dark text-white border-secondary" id="password" required>
        </div>
        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirm Password</label>
          <input type="password" name="password_confirmation" class="form-control bg-dark text-white border-secondary" id="password_confirmation" required>
        </div>
                           
        <hr class="border-secondary" />

        <input type="hidden" name="plan_id" id="plan-id" />
        <input type="hidden" name="amount" id="form-amount" />
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" />
        <input type="hidden" name="razorpay_signature" id="razorpay_signature" />

        <p><strong>Plan Name:</strong> <span id="modalPlanName" class="text-info"></span></p>
        <p><strong>Price:</strong> ₹<span id="modalPlanPrice" class="text-warning"></span></p>
      </div>

      <div class="modal-footer border-top border-secondary">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="rzp-button">Pay Now</button>
      </div>
    </form>
    @endif
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
  const planModal = document.getElementById('planModal');

  planModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const name = button.getAttribute('data-name');
    const price = button.getAttribute('data-price');
    const id = button.getAttribute('data-id');

    document.getElementById('modalPlanName').textContent = name;
    document.getElementById('modalPlanPrice').textContent = price;
    document.getElementById('form-amount').value = price;
    document.getElementById('plan-id').value = id;
  });

  document.getElementById('rzp-button').onclick = function(e) {
    e.preventDefault();
    let rawAmount = document.getElementById('form-amount').value;
    let cleanAmount = rawAmount.replace(/[^0-9.]/g, '');
    let amountPaise = Math.round(parseFloat(cleanAmount) * 100);

    const options = {
      key: "{{ config('services.razorpay.key') }}",
      amount: amountPaise,
      currency: "INR",
      name: "Rentalz",
      description: "Plan Subscription",
      handler: function (response) {
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
        document.getElementById('razorpay_signature').value = response.razorpay_signature;
        document.getElementById('payment-form').submit();
      },
      prefill: {
        name: "{{ Auth::user()->name ?? 'Guest User' }}",
        email: "{{ Auth::user()->email ?? '' }}"
      },
      theme: {
        color: "#3399cc"
      }
    };

    const rzp = new Razorpay(options);
    rzp.open();
  };
</script>

</body>
</html>
