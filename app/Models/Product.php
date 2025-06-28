<?php
namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\returnCallback;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'store_id','category_id','name','slug','image',
        'description','price','compare_price','rating',
        'option','featured','status',
    ];
    protected static function booted()
    {
        static::addGlobalScope('store', function (Builder $builder) {
            $user = Auth::user();
            if ($user && $user->store_id) {
                $builder->where('store_id', '=', $user->store_id);

            }
        });

    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // الموديل اللي بيربط بيه
            'product_tag',  // اسم الجدول الوسيط
            'product_id',   // مفتاح المنتج في الجدول الوسيط
            'tag_id',       // مفتاح التاج في الجدول الوسيط
            'id',           // المفتاح المحلي في جدول المنتجات (Product)
            'id',           // المفتاح في جدول التاجات (Tag)
        );
    }
}
