<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CategoryProduct extends Model
{
    protected static function booted()
    {
        // static::saving(function ($Object) {
        //     dd($Object);
        //     $Object['list_categories'] = Category::wherein('id', $Object['categories'] ?? '')->get()->implode('name', ', ');
        //     try {
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
