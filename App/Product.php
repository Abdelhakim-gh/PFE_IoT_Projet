<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Product extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }

    protected static function booted()
    {
        // static::saving(function ($Object) {
        //     try {
        //         // foreach(Product::get() as $aaa) $aaa->save();
        //         dd($Object->with('categories')->get());
        //         // $Object['list_categories'] = Category::wherein('id', $Object['categories'] ?? '')->get()->implode('name', ', ');
        //     } catch (\Throwable $th) {
        //     }
        // });

        // static::saved(function ($Object) {
        //     try {
        //         if(empty($Object['list_categories'] ?? '')){
        //             $Object['list_categories'] = $Object->categories->implode('name', ', ');
        //             $Object->save();
        //         }
        //     } catch (\Throwable $th) {
        //     }
        // });
    }
}
