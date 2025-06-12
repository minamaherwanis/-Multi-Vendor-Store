<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;
use function PHPUnit\Framework\returnArgument;

class Category extends Model
{

    protected $fillable = [

        'name',
        'parent_id',
        'description',
        'image',
        'status',
        'slug',
    ];
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
