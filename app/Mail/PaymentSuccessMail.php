<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tenantData;

    public function __construct($tenantData)
    {
        $this->tenantData = $tenantData;
    }

    public function build()
    {
        return $this->subject('✅ Payment Successful - Access Your Site')
                    ->view('payment_success');
    }
}
