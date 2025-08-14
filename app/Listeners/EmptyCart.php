<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmptyCart
{
    /**
     * Create the event listener.
     */
    protected $cart;
    public function __construct(CartModelRepository $cart)
    {
        $this->cart =$cart;
    }

    /**
     * Handle the event.
     */
    public function handle(): void
    {
        $this->cart->empty();
    }
}
