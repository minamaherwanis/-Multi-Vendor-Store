<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\Return_;
use function PHPUnit\Framework\returnCallback;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'image',
        'description',
        'price',
        'compare_price',
        'rating',
        'option',
        'featured',
        'status',
        'quantity'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'image'
    ];
    protected $appends = [
        'image_url'
    ];

    protected static function booted()
    {
        static::addGlobalScope('store', function (Builder $builder) {
            $user = Auth::user();

            if ($user && $user->type === 'admin') {
                if ($user->store_id) {
                    $builder->where('store_id', '=', $user->store_id);
                } else {
                    $builder->whereRaw('1 = 0');
                }
            }
        });

static::creating(function (Product $product) {
    $slug = Str::slug($product->name);

    if (Product::where('slug', $slug)->exists()) {
        $slug .= '-' . uniqid();
    }

    $product->slug = $slug;
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
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }
    public function scopeFrontendFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'name'   => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['name'], function ($builder, $value) {
            $builder->where('products.name', 'like', "%{$value}%");
        });

        $builder->when($options['status'], function ($query, $status) {
            return $query->where('status', $status);
        });
$builder->whereIn('store_id', function ($q) {
    $q->select('store_id')
      ->from('users')
      ->whereNotNull('store_id');
});          $builder->where('quantity', '>', 0);

    }


    //////////////////////////////Accessors//////////////////////
    public function getImageUrlAttribute()
    {
        if (! $this->image) {
            return 'https://www.tiffincurry.ca/wp-content/uploads/2021/02/default-product.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return round(100 - (100 * $this->price / $this->compare_price));
    }
    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
            'name'        => null,

        ], $filters);

        $builder->when($options['status'], function ($query, $status) {
            return $query->where('status', $status);
        });

        $builder->when($options['store_id'], function ($builder, $value) {
            $builder->where('store_id', $value);
        });
        $builder->when($options['category_id'], function ($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['tag_id'], function ($builder, $value) {
            $builder->whereExists(function ($query) use ($value) {
                $query->selectRaw('1')
                    ->from('product_tag')
                    ->whereRaw('product_id = products.id')
                    ->where('tag_id', $value);
            });
            // $builder->whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?)', [$value]);
            // $builder->whereRaw('EXISTS (SELECT 1 FROM product_tag WHERE tag_id = ? AND product_id = products.id)', [$value]);

            // $builder->whereHas('tags', function($builder) use ($value) {
            //     $builder->where('id', $value);
            // });
        });
        $builder->when($options['name'], function ($builder, $value) {
            $builder->where('name', 'LIKE', "%{$value}%");
        });
    }
}
