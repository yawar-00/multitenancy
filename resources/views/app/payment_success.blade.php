<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="background-color: #fff; padding: 30px; border-radius: 10px; max-width: 600px; margin: auto;">
        <h2 style="color: #28a745;">Thank You for Your Purchase!</h2>
        <p>Hello,</p>
        <p>We have received your payment successfully.</p>

        <ul>
            <li><strong>Product:</strong> {{ $productName }}</li>
            <li><strong>Quantity:</strong> {{ $quantity }}</li>
            <li><strong>Total Paid:</strong> ₹{{ number_format($amount / 100, 2) }}</li>
        </ul>

        <p>We appreciate your business!</p>
        <p>– The Team</p>
    </div>
</body>
</html>
