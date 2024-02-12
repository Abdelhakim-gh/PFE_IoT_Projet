<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;


class Category extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public function products()
    {
        return $this->hasMany(Product::class);
        return $this->belongsToMany(Product::class, 'category_products');
    }
}
