<!-- resources/views/emails/payment_success.blade.php -->

<!DOCTYPE html>
<html>
  <head>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
      }
      .email-container {
        max-width: 600px;
        margin: 40px auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      }
      h2 {
        color: #333333;
      }
      p {
        color: #555555;
        line-height: 1.6;
      }
      a {
        color: #007BFF;
        text-decoration: none;
      }
      a:hover {
        text-decoration: underline;
      }
      .domain-link {
        display: inline-block;
        margin-top: 10px;
        background-color: #007BFF;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 4px;
        text-decoration: none;
      }
      .footer {
        margin-top: 30px;
        color: #888888;
        font-size: 14px;
      }
    </style>
  </head>
  <body>
    <div class="email-container">
      <h2>Hi {{ $tenantData['name'] }},</h2>
      <p>Thank you for your payment of rupees <strong>{{ $tenantData['amount'] }}</strong>. Your plan has been activated successfully.</p>
      <p><strong>Your domain:</strong></p>
      <a class="domain-link" href="http://{{ $tenantData['domain'] }}" target="_blank">
        {{ $tenantData['domain'] }}
      </a>
      <p>You can now access your website using this domain.</p>
      <div class="footer">
        <p>Regards,<br>Rentalz</p>
      </div>
    </div>
  </body>
</html>
