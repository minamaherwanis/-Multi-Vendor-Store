<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rules\Unique;
use function PHPUnit\Framework\returnArgument;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [

        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'slug',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');

    }
    public function parent()
    {

        return $this->belongsTo(Category::class, 'parent_id', 'id')
            ->withDefault(
                [
                    'name' => 'Main Category'
                ]
            );

    }
    

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function scopeActive(Builder $builder)
    {

        $builder->where('status', '=', 'active');
    }



    public function scopeFilter(Builder $builder, $filter)
    {
        if ($filter['name'] ?? false) {
            $builder->where('categories.name', 'like', "%{$filter['name']}%");
        }
        if ($filter['status'] ?? false) {
            $builder->where('categories.status', '=', $filter['status']);
        }

    }
    public static function rules($id = 0)
    {

        return [


            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                "Unique:categories,name,$id",

                function ($attribute, $value, $fails) {
                    if ($value == 'laravel') {
                        $fails('this name is forbidden !');

                    };

                }
            ],

            'parent_id' => ['int', 'exists:categories,id', 'nullable'],
            'image' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'status' => 'in:active,archived',
        ];
    }
}
