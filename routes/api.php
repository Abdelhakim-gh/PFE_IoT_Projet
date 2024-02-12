<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Category;
use App\Config;
use App\Order;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Machine;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// $imagePath = public_path("images/20220405140258.jpg");
// $image = "data:image/png;base64," . base64_encode(file_get_contents($imagePath));


Route::get('/categories_with_products', function () {
    $Categories = Category::orderBy('order_num')->select('id', 'name', 'description')->with('products:id,name,price,image,designation,category_id')->get()->toArray();
    // foreach ($Categories as $Category_index => $Category) {
    //     foreach ($Category['products'] ?? [] as $product_index => $Product) {
    //         if (Storage::exists('public/' . $Product['image'] ?? ''))
    //             $Categories[$Category_index]['products'][$product_index]['image'] = "data:image/png;base64," . base64_encode(file_get_contents(storage_path('app/public/' . $Product['image'] ?? '')));
    //     }
    // }
    // dd($Category->image ?? '');
    return response($Categories);
    // return response($Categories)->json();
    // try {
    // } catch (\Throwable $th) {
    //     $data = [
    //         [
    //             "name" => "main food",
    //             "products" => [
    //                 [
    //                     "name" => "Soba",
    //                     "category" => "main food",
    //                     "url" => "https://i.ibb.co/PM5jk43/soba.jpg"
    //                 ],
    //                 [
    //                     "name" => "Rice",
    //                     "category" => "main food",
    //                     "url" => "https://i.ibb.co/7rXM3qZ/rice.jpg"
    //                 ],
    //                 [
    //                     "name" => "Pizza",
    //                     "category" => "main food",
    //                     "url" => "https://i.ibb.co/YtkrjWH/pizza.jpg"
    //                 ],
    //                 [
    //                     "name" => "Noodle",
    //                     "category" => "main food",
    //                     "url" => "https://i.ibb.co/fDWh9pW/noodle.jpg"
    //                 ],
    //                 [
    //                     "name" => "Sushi",
    //                     "category" => "main food",
    //                     "url" => "https://i.ibb.co/hFtyCBj/sushi.jpg"
    //                 ],
    //                 [
    //                     "name" => "Bread",
    //                     "category" => "main food",
    //                     "url" => "https://i.ibb.co/2gVmNc1/bread.jpg"
    //                 ],
    //                 [
    //                     "name" => "Potato",
    //                     "category" => "main food",
    //                     "url" => "https://i.ibb.co/MsYDVV7/potato.jpg"
    //                 ],
    //                 [
    //                     "name" => "Bean",
    //                     "category" => "main food",
    //                     "url" => "https://i.ibb.co/M7f6Lfh/bean.jpg"
    //                 ],
    //                 [
    //                     "name" => "Corn",
    //                     "category" => "main food",
    //                     "url" => "https://i.ibb.co/qJq5rYq/corn.jpg"
    //                 ]
    //             ]
    //         ],
    //         [
    //             "name" => "meat",
    //             "products" => [
    //                 [
    //                     "name" => "Pork",
    //                     "category" => "meat",
    //                     "url" => "https://i.ibb.co/8sS5kTN/pork.jpg"
    //                 ],
    //                 [
    //                     "name" => "Chicken",
    //                     "category" => "meat",
    //                     "url" => "https://i.ibb.co/bzR2j2K/chicken.jpg"
    //                 ],
    //                 [
    //                     "name" => "Beef",
    //                     "category" => "meat",
    //                     "url" => "https://i.ibb.co/gmGsNm9/beef.jpg"
    //                 ],
    //                 [
    //                     "name" => "Shrimp",
    //                     "category" => "meat",
    //                     "url" => "https://i.ibb.co/GnHnwXS/shrimp.jpg"
    //                 ],
    //                 [
    //                     "name" => "Fish",
    //                     "category" => "meat",
    //                     "url" => "https://i.ibb.co/2gt8r5p/fish.jpg"
    //                 ],
    //                 [
    //                     "name" => "Oyster",
    //                     "category" => "meat",
    //                     "url" => "https://i.ibb.co/jrf47SM/oyster.jpg"
    //                 ],
    //                 [
    //                     "name" => "Duck",
    //                     "category" => "meat",
    //                     "url" => "https://i.ibb.co/dBmsjb3/duck.jpg"
    //                 ],
    //                 [
    //                     "name" => "Goose",
    //                     "category" => "meat",
    //                     "url" => "https://i.ibb.co/b7Nfnmw/goose.jpg"
    //                 ],
    //                 [
    //                     "name" => "Mutton",
    //                     "category" => "meat",
    //                     "url" => "https://i.ibb.co/rZztRJW/mutton.jpg"
    //                 ]
    //             ]
    //         ]
    //     ];
    //     return response()->json($data);
    // }
});

Route::get('/configs', function () {
    try {
        return response()->json(Config::pluck('value', 'key')->toArray());
    } catch (\Throwable $th) {
        return response()->json([]);
    }
});

Route::post('/orders/store', function () {
    try {
        if (Config::firstWhere('key', 'disponibility')->value == false)
            return response()->json(['result' => false, 'message' => 'NOUS SOMMES ACTUELLEMENT FERMÉS.']);

        $Order = Order::create(request()->except('products'));
        $Order->order_details()->createMany(request()->products ?? []);

        try {

            $message = 'Num: ' . ($Order->id ?? '') . "\n";
            $message .= 'Type: ' . ($Order->type == 10 ? 'Livraison' : 'Emporter') . "\n";
            $message .= 'Name: ' . ($Order->name_client ?? '') . "\n";
            $message .= 'Phone: ' . ($Order->phone ?? '') . "\n";
            $message .= 'Adresse: ' . ($Order->adresse ?? '') . "\n";
            $message .= 'Quartie: ' . ($Order->neighborhood->libelle ?? '') . "\n";
            if ($Order->notes ?? false) $message .= 'Notes: ' . ($Order->notes ?? '') . "\n";
            $message .= 'Total: ' . (collect($Order->order_details ?? [])->sum('total') * 1.05) . " DH\n";
            $message .= "\n----------Détail-Commande----------\n";
            foreach ($Order->order_details as $key => $order_detail) {
                $message .= ($key + 1) . ' - ' . ($order_detail->libelle ?? '') . "\n";
            }

            $response = (new \GuzzleHttp\Client(['verify' => false]))
                ->request('POST', 'https://wa.gdn.ma/chats/send-bulk?id=C212L20230101095707', [
                    'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'],
                    'body'    => json_encode([
                        [
                            "receiver" => "212619673092",
                            "message" => [
                                "text" => $message
                            ]
                        ]
                    ])
                ]);
            if ($response->getStatusCode() != 200) Log::error('whatsapp error not 200');
        } catch (\Throwable $th) {
            Log::error('whatsapp error');
        }

        return response()->json(['result' => true, 'message' => 'Votre commande a été effectuée avec succès']);
    } catch (\Throwable $th) {
        return response()->json(['result' => false, 'message' => $th->getMessage()]);
    }
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
    
Route::any('get_device/{mac}', function ($mac = null) {

    return response()->json(
        collect(Machine::whereMac($mac)->firstOrFail() ?? [])->except(['id', 'created_at', 'updated_at'])
    , 200);  

});
