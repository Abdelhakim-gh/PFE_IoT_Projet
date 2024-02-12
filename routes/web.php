<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/master', function () {
    return view('master');
});

Route::get('/test', function () {
    return view('test');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::any('image/{path}', function ($path) {
    if (Storage::exists('public/' . $path)) {
        $extension = Storage::mimeType('public/' . $path);
        $image = Image::make(Storage::get('public/' . $path));
        $image->encode($extension, 10);
        return response($image, 200)->header('Content-Type', $extension);
    }
    return response(null, 404);
})->where('path', '^(.*)$');
