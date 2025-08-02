<?php

namespace App\Repositories\Cart;

use App\Models\Product;
use Illuminate\Support\Collection;

interface CartRepository
{
    public function get(): Collection;
    public function add(Product $product,$qauntity=1);
    public function update($id,$qauntity);
    public function delete($id) ;
    public function empty() ;
    public function total() ;

}
