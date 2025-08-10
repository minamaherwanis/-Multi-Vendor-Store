<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use PhpParser\Node\Stmt\Static_;

class Order extends Model
{
    use HasFactory;
    protected $fillable =
        [
            'user_id',
            'store_id',
            'payment_method',
            'status',
            'payment_status',
        ];
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items',
         'order_id', 'product_id', 'id', 'id')
         ->using(class: OrderItem::class)
         ->withPivot('product_name','price','quantity','options');
    }
    public function addresses(){
        return $this->hasMany(OrderAddress::class);
    }
    public function billingAddress(){
        return $this->hasOne(OrderAddress::class,'order_id','id')
        ->where('type','billing');
    }
    public function shippingAddress(){
        return $this->hasOne(OrderAddress::class,'order_id','id')
        ->where('type','shipping');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = Order::getNextOrderNumber();

        });
    }
    public static function getNextOrderNumber()
    {
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return $number + 1;

        }
        return $year . '0001';

    }
}
