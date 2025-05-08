<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductPaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $productName;
    public $amount;
    public $quantity;

    public function __construct($productName, $amount, $quantity)
    {
        $this->productName = $productName;
        $this->amount = $amount;
        $this->quantity = $quantity;
    }

    public function build()
    {
        return $this->subject('Thank You for Your Purchase!')
                    ->view('app.payment_success');
    }
}
