<?php
namespace App\Observers;
use App\Models\Cart;
use Str;

class CartObserver
{
    /**
     * Handle the Cart "created" event.
     */
    public function creating(Cart $cart): void
    {
        $cart->id=Str::uuid();
        $cart->cookie_id=Cart::getCookieId();
    }

    /**
     * Handle the Cart "updated" event.
     */
    public function updated(Cart $cart): void
    {
        //
    }

    /**
     * Handle the Cart "deleted" event.
     */
    public function deleted(Cart $cart): void
    {
        //
    }

    /**
     * Handle the Cart "restored" event.
     */
    public function restored(Cart $cart): void
    {
        //
    }

    /**
     * Handle the Cart "force deleted" event.
     */
    public function forceDeleted(Cart $cart): void
    {
        //
    }
}
