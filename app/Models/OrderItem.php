<?php

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Pivot
{
    use HasFactory;
    protected $table = 'order_items';

public function product()
{
    return $this->belongsTo(Product::class)->withDefault(function () {
        return new Product([
            'name' => $this->product_name,
        ]);
    });
}
public function order()
{
    return $this->belongsTo(Order::class);

}


}
