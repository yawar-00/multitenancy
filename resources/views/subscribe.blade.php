<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pricing Plans</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">


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
      box-shadow: 0 0 0 rgba(0,0,0,0);
      color:#ffffff;
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
  content: "\f058"; /* Unicode for fa-circle-check */
  font-family: "Font Awesome 6 Free"; /* Important */
  font-weight: 900; /* Solid style */
        margin-right:10px;   
  color: #00ff00; /* Green color */
  font-size: 18px;
}
  </style>
</head>

<body>

<div class="container text-center">
  <h2 class="fw-bold mb-5">Choose your plan</h2>

  <div class="row g-4 justify-content-center">

    <!-- Purchase 1 Report -->
    <div class="col-md-4">
      <div class="card p-4 position-relative">
        <div class="card-body">
          <h5 class="card-title">Basic</h5>
          <div class="price"><i class="fa-solid fa-indian-rupee-sign"></i>999<span class="fs-6">/mo</span></div>
          <h6 class=" mt-4 mb-2">Features/ Benefits</h6>
          <ul class="list-unstyled feature-list">
            <li>1 Websites</li>
            <li>150 Products Listening</li>
            <li>Your own Paymen GateWay</li>
            <li>Basic Services</li>
          </ul>
          <a href="#" class="btn btn-outline-light btn-custom">Purchase</a>
        </div>
      </div>
    </div>

    <!-- Starter Plan -->
    <div class="col-md-4">
      <div class="card p-4 position-relative">
        <div class="badge-popular">Most Popular</div>
        <div class="card-body">
          <h5 class="card-title">Starter Plan</h5>
          
          <div class="price"><i class="fa-solid fa-indian-rupee-sign"></i>1999<span class="fs-6">/mo</span></div>

          <h6 class=" mt-4 mb-2">Features/ Benefits</h6>
          <ul class="list-unstyled feature-list">
            <li>3 Websites</li>
            <li>300 Products Listening</li>
            <li>Your own Paymen GateWay</li>
            <li>Advance Services</li>

          </ul>

          <a href="#" class="btn btn-custom btn-custom-primary">Get Started</a>
        </div>
      </div>
    </div>

    <!-- Agency Plan -->
    <div class="col-md-4">
      <div class="card p-4 position-relative">
        <div class="card-body">
          <h5 class="card-title">Agency Plan</h5>
         
          <div class="price"><i class="fa-solid fa-indian-rupee-sign"></i>2999<span class="fs-6">/mo</span></div>

          <h6 class=" mt-4 mb-2">Features/ Benefits</h6>
          <ul class="list-unstyled feature-list">
            <li>10 Websites</li>
            <li>500+ Products Listening</li>
            <li>Your own Paymen GateWay</li>
            <li>Advance Services</li>
          </ul>

          <a href="#" class="btn btn-outline-light btn-custom">Get Started</a>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
