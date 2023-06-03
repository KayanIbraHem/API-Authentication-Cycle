<?php

namespace App\Listeners;

use App\Events\EmptyCart as EventsEmptyCart;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmptyCart
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EventsEmptyCart $event): void
    {
        $userCart=$event->cart;
        if ($userCart->count() > 0) {
            foreach ($userCart as $cartItem) {
                $cartItem->delete();
            }
        }
    }
}
