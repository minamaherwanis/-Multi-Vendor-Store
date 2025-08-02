<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class CartModelRepository implements CartRepository
{




    public function get(): Collection
    {
        return Cart::with('products')->get();
    }

    public function add(Product $product, $quantity = 1)
    {
        $item= Cart::where('product_id', $product->id)
            ->first();
            if (!$item) {
         return Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $quantity,


        ]);  
            }
          return  $item->increment('quantity',$quantity);

    }

    public function update(Product $product, $quantity)
    {
        return Cart::where('product_id', $product->id)
            ->update(['quantity' => $quantity]);
    }

    public function delete($id)
    {
        return Cart::where('id', $id)
            ->delete();
    }

    public function empty()
    {
        return Cart::query()->delete();
    }

    public function total()
    {
        return (float) Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')
            ->value('total');
    }


}
