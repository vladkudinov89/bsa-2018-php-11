<?php

namespace App\Mail;

use App\Entity\Currency;
use App\Entity\Trade;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TradeCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $trade;
    public $seller;
    public $buyer;
    public $currency;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Trade $trade, User $seller, User $buyer, Currency $currency)
    {
        $this->trade = $trade;
        $this->seller = $seller;
        $this->buyer = $buyer;
        $this->currency = $currency;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.trade_create')
            ->with([
                'amount' => $this->trade->amount,
                'seller' => $this->seller,
                'buyer' => $this->buyer,
                'currency' => $this->currency,
            ]);
    }
}
