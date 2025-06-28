<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable=[
        'name',
       'slug',
      
    ];
     public function products()
    {
        return $this->belongsToMany(
            Product::class,     // الموديل اللي بيربط بيه
            'product_tag',  // اسم الجدول الوسيط
            'product_id',   // مفتاح المنتج في الجدول الوسيط
            'tag_id',       // مفتاح التاج في الجدول الوسيط
            'id',           // المفتاح المحلي في جدول المنتجات (Product)
            'id',           // المفتاح في جدول التاجات (Tag)
        );
    }
}
