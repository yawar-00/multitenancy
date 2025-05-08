<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Successful</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: #f4f8fb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .thankyou-container {
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
      max-width: 500px;
      width: 90%;
    }

    .thankyou-container h1 {
      font-size: 2.5rem;
      color: #28a745;
      margin-bottom: 20px;
    }

    .thankyou-container p {
      font-size: 1.2rem;
      color: #555;
      margin-bottom: 30px;
    }

    .thankyou-container .btn {
      display: inline-block;
      padding: 12px 24px;
      font-size: 16px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      transition: background 0.3s;
    }

    .thankyou-container .btn:hover {
      background-color: #0056b3;
    }

    .checkmark {
      font-size: 60px;
      color: #28a745;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="thankyou-container">
    <div class="checkmark">✔️</div>
    <h1>Thank You!</h1>
    <p>Your payment was successful.<br>We appreciate your business.</p>
    <a href="{{ url('/') }}" class="btn">Continue Shopping</a>
  </div>
</body>
</html>
