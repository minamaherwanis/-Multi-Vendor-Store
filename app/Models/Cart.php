<?php

namespace App\Models;
use Illuminate\Support\Facades\Cookie;
use Str;

use App\Observers\CartObserver;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
      use HasFactory;
      public $incrementing=false;
    protected $fillable = [

        'cookie_id',
        'user_id',
        'quantity',
        'option',
        'product_id'
    ];
    protected static function booted(){
        static::observe(CartObserver::class);
        static::addGlobalScope('cookie_id',function(Builder $builder){
            $builder->where('cookie_id', Cart::getCookieId());

        });
    }
        public static function  getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');

        if (!$cookie_id) {
            $cookie_id = (string) Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 60 * 24 * 30); // 30 يوم
        }
        return $cookie_id;
    }
public function users() {
    return $this->belongsTo(User::class, 'user_id', 'id')->withDefault(['name' => 'Anonymouse']);
}

public function products() {
    return $this->belongsTo(Product::class, 'product_id', 'id');
}

}
